<?php
/**
 * This source file is subject to the MIT License.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/MIT
 *
 * @category   PedroTeixeira
 * @package    PedroTeixeira_Correios
 * @copyright  Copyright (c) 2010 Pedro Teixeira (http://www.pteixeira.com.br)
 * @author     Pedro Teixeira <pedro@pteixeira.com.br>
 * @license    http://opensource.org/licenses/MIT
 */

/**
 * PedroTeixeira_Correios_Model_Carrier_CorreiosMethod
 *
 * @category   PedroTeixeira
 * @package    PedroTeixeira_Correios
 * @author     Pedro Teixeira <pedro@pteixeira.com.br>
 */

class PedroTeixeira_Correios_Model_Carrier_CorreiosMethod
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{

    /**
     * _code property
     *
     * @var string
     */
    protected $_code = 'pedroteixeira_correios';

    /**
     * _result property
     *
     * @var Mage_Shipping_Model_Rate_Result / Mage_Shipping_Model_Tracking_Result
     */
    protected $_result = null;

    /**
     * ZIP code vars
     */
    protected $_fromZip = null;
    protected $_toZip = null;

    /**
     * Value and Weight
     */
    protected $_packageValue = null;
    protected $_packageWeight = null;
    protected $_pacWeight = null;
    protected $_freeMethodWeight = null;

    /**
     * Post methods
     */
    protected $_postMethods = null;
    protected $_postMethodsFixed = null;
    protected $_postMethodsExplode = null;

    /**
     * Free method request
     */
    protected $_freeMethodRequest = false;
    protected $_freeMethodRequestResult = null;

    /**
     * Collect Rates
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     *
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        // Do initial check
        if ($this->_inicialCheck($request) === false) {
            return false;
        }

        // Check package value
        if ($this->_packageValue < $this->getConfigData(
                'min_order_value'
            ) || $this->_packageValue > $this->getConfigData('max_order_value')
        ) {
            //Value limits
            $this->_throwError('valueerror', 'Value limits', __LINE__);
            return $this->_result;
        }

        // Check ZIP Code
        if (!preg_match("/^([0-9]{8})$/", $this->_toZip)) {
            //Invalid Zip Code
            $this->_throwError('zipcodeerror', 'Invalid Zip Code', __LINE__);
            return $this->_result;
        }

        // Fix weight
        $weightCompare = $this->getConfigData('maxweight');
        if ($this->getConfigData('weight_type') == 'gr') {
            $this->_packageWeight = number_format($this->_packageWeight / 1000, 2, '.', '');
            $weightCompare        = number_format($weightCompare / 1000, 2, '.', '');
        }

        // Check weght
        if ($this->_packageWeight > $weightCompare) {
            //Weight exceeded limit
            $this->_throwError('maxweighterror', 'Weight exceeded limit', __LINE__);
            return $this->_result;
        }

        // Check weight zero
        if ($this->_packageWeight <= 0) {
            //Weight zero
            $this->_throwError('weightzeroerror', 'Weight zero', __LINE__);
            return $this->_result;
        }

        // Generate PAC Weight
        $this->_generatePacWeight();

        // Get post methods
        $this->_postMethods        = $this->getConfigData('postmethods');
        $this->_postMethodsFixed   = $this->_postMethods;
        $this->_postMethodsExplode = explode(",", $this->getConfigData('postmethods'));

        // Get quotes
        if ($this->_getQuotes()->getError()) {
            return $this->_result;
        }

        // Use descont codes
        $this->_updateFreeMethodQuote($request);

        // Return rates / errors
        return $this->_result;
    }

    /**
     * Get shipping quote
     *
     * @return bool
     */
    protected function _getQuotes()
    {

        $pacCodes      = explode(",", $this->getConfigData('pac_codes'));
        $contratoCodes = explode(",", $this->getConfigData('contrato_codes'));
        $dieErrors     = explode(",", $this->getConfigData('die_errors'));


        //Define URL method
        switch ($this->getConfigData('urlmethod')) {

            //Locaweb
            case 1:

                foreach ($this->_postMethodsExplode as $postmethod) {

                    try {
                        $soap = new SoapClient($this->getConfigData('url_ws_locaweb'), array(
                            'trace'              => true,
                            'exceptions'         => true,
                            'compression'        => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
                            'connection_timeout' => $this->getConfigData('ws_timeout')
                        ));

                        // Postagem dos parâmetros
                        $parms             = new Varien_Object();
                        $parms->cepOrigem  = utf8_encode($this->_fromZip);
                        $parms->cepDestino = utf8_encode($this->_toZip);

                        // If PAC use PAC weight
                        if (in_array($postmethod, $pacCodes) && $this->_pacWeight > $this->_packageWeight) {
                            $parms->peso = utf8_encode(str_replace(".", ",", $this->_pacWeight));
                        } else {
                            $parms->peso = utf8_encode(str_replace(".", ",", $this->_packageWeight));
                        }

                        $parms->volume = utf8_encode(1);
                        $parms->codigo = utf8_encode($postmethod);

                        // Resgata o valor calculado
                        $resposta = $soap->Correios($parms);

                        $shippingPrice = floatval(str_replace(",", ".", $resposta->CorreiosResult));
                    } catch (Exception $e) {
                        //URL Error
                        $this->_throwError('urlerror', 'URL Error - ' . $e->getMessage(), __LINE__);
                        return $this->_result;
                    }

                    //URL Error
                    if ($shippingPrice == 0) {
                        //URL Error
                        $this->_throwError('urlerror', 'URL Error', __LINE__);
                        return $this->_result;
                    }

                    $this->_apendShippingReturn($postmethod, $shippingPrice);
                }
                break;

            //Correios
            case 0:

                $correiosReturn = $this->_getCorreiosReturn();
                if ($correiosReturn !== false) {

                    // Check if exist return from Correios
                    $existReturn = false;

                    foreach ($correiosReturn as $servicos) {

                        // Get Correios error
                        $errorId = $this->_cleanCorreiosError((string) $servicos->Erro);

                        if ($errorId != 0) {
                            // Error, throw error message
                            if (in_array($errorId, $dieErrors)) {
                                $this->_throwError(
                                    'correioserror',
                                    'Correios Error: ' . (string) $servicos->MsgErro . ' [Cod. ' . $errorId . '] [Serv. ' . (string) $servicos->Codigo . ']',
                                    __LINE__,
                                    (string) $servicos->MsgErro . ' (Cod. ' . $errorId . ')'
                                );
                                return $this->_result;
                            } else {
                                continue;
                            }
                        }

                        // If PAC, make a new call to WS
                        if (in_array(
                                (string) $servicos->Codigo,
                                $pacCodes
                            ) && $this->_pacWeight > $this->_packageWeight && !in_array(
                                $this->_postMethodsFixed,
                                $pacCodes
                            )
                        ) {

                            $this->_postMethods        = (string) $servicos->Codigo;
                            $this->_postMethodsExplode = array((string) $servicos->Codigo);

                            $correiosReturnPac = $this->_getCorreiosReturn();
                            if ($correiosReturnPac !== false) {

                                foreach ($correiosReturnPac as $servicosPac) {

                                    // Get Correios error
                                    $errorId = $this->_cleanCorreiosError((string) $servicosPac->Erro);

                                    if ($errorId != 0) {
                                        // Error, throw error message
                                        if (in_array($errorId, $dieErrors)) {
                                            $this->_throwError(
                                                'correioserror',
                                                'Correios Error: ' . (string) $servicosPac->MsgErro . ' (Cod. ' . $errorId . ')',
                                                __LINE__,
                                                (string) $servicosPac->MsgErro . ' (Cod. ' . $errorId . ')'
                                            );
                                            return $this->_result;
                                        } else {
                                            continue;
                                        }
                                    }

                                    $shippingPrice    = floatval(str_replace(",", ".", (string) $servicosPac->Valor));
                                    $shippingDelivery = (int) $servicosPac->PrazoEntrega;
                                }
                            } else {
                                return $this->_result;
                            }
                        } else {

                            $shippingPrice    = floatval(str_replace(",", ".", (string) $servicos->Valor));
                            $shippingDelivery = (int) $servicos->PrazoEntrega;
                        }

                        if ($shippingPrice <= 0) {
                            continue;
                        }

                        // Apend shipping
                        $this->_apendShippingReturn((string) $servicos->Codigo, $shippingPrice, $shippingDelivery);
                        $existReturn = true;
                    }

                    // All services are ignored
                    if ($existReturn === false) {
                        $this->_throwError('urlerror', 'URL Error, all services return with error', __LINE__);
                        return $this->_result;
                    }
                } else {
                    // Error on HTTP Correios
                    return $this->_result;
                }

                break;
        }

        // Success
        if ($this->_freeMethodRequest === true) {
            return $this->_freeMethodRequestResult;
        } else {
            return $this->_result;
        }
    }


    /**
     * Make initial checks and iniciate module variables
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     *
     * @return boolean
     */
    protected function _inicialCheck(Mage_Shipping_Model_Rate_Request $request)
    {

        if (!$this->getConfigFlag('active')) {
            //Disabled
            Mage::log('PedroTeixeira_Correios: Disabled');
            return false;
        }


        $origCountry = Mage::getStoreConfig('shipping/origin/country_id', $this->getStore());
        $destCountry = $request->getDestCountryId();
        if ($origCountry != "BR" || $destCountry != "BR") {
            //Out of delivery area
            Mage::log('PedroTeixeira_Correios: Out of delivery area');
            return false;
        }

        // ZIP Code
        $this->_fromZip = Mage::getStoreConfig('shipping/origin/postcode', $this->getStore());
        $this->_toZip   = $request->getDestPostcode();

        //Fix Zip Code
        $this->_fromZip = str_replace('-', '', trim($this->_fromZip));
        $this->_toZip   = str_replace('-', '', trim($this->_toZip));

        if (!preg_match("/^([0-9]{8})$/", $this->_fromZip)) {
            //From zip code error
            Mage::log('PedroTeixeira_Correios: From ZIP Code Error');
            return false;
        }

        // Result model
        $this->_result = Mage::getModel('shipping/rate_result');

        // Value
        $this->_packageValue = $request->getBaseCurrency()->convert(
            $request->getPackageValue(),
            $request->getPackageCurrency()
        );

        // Weight
        $this->_packageWeight = number_format($request->getPackageWeight(), 2, '.', '');

        // Free method weight
        $this->_freeMethodWeight = number_format($request->getFreeMethodWeight(), 2, '.', '');
    }

    /**
     * Get Correios return
     *
     * @return bool
     */
    protected function _getCorreiosReturn()
    {

        $filename = $this->getConfigData('url_ws_correios');

        $pacCodes      = explode(",", $this->getConfigData('pac_codes'));
        $contratoCodes = explode(",", $this->getConfigData('contrato_codes'));

        try {
            $client = new Zend_Http_Client($filename);
            $client->setConfig(
                array(
                    'timeout' => $this->getConfigData('ws_timeout')
                )
            );

            $client->setParameterGet('StrRetorno', 'xml');
            $client->setParameterGet('nCdServico', $this->_postMethods);

            if (in_array($this->_postMethods, $pacCodes) && $this->_pacWeight > $this->_packageWeight) {
                $client->setParameterGet('nVlPeso', $this->_pacWeight);
            } else {
                $client->setParameterGet('nVlPeso', $this->_packageWeight);
            }

            $client->setParameterGet('sCepOrigem', $this->_fromZip);
            $client->setParameterGet('sCepDestino', $this->_toZip);
            $client->setParameterGet('nCdFormato', 1);
            $client->setParameterGet('nVlComprimento', $this->getConfigData('comprimento_sent'));
            $client->setParameterGet('nVlAltura', $this->getConfigData('altura_sent'));
            $client->setParameterGet('nVlLargura', $this->getConfigData('largura_sent'));

            if ($this->getConfigData('mao_propria')) {
                $client->setParameterGet('sCdMaoPropria', 'S');
            } else {
                $client->setParameterGet('sCdMaoPropria', 'N');
            }

            if ($this->getConfigData('aviso_recebimento')) {
                $client->setParameterGet('sCdAvisoRecebimento', 'S');
            } else {
                $client->setParameterGet('sCdAvisoRecebimento', 'N');
            }

            if ($this->getConfigData('valor_declarado') || in_array(
                    $this->getConfigData('acobrar_code'),
                    $this->_postMethodsExplode
                )
            ) {
                $client->setParameterGet('nVlValorDeclarado', number_format($this->_packageValue, 2, ',', '.'));
            } else {
                $client->setParameterGet('nVlValorDeclarado', 0);
            }

            $contrato = false;
            foreach ($contratoCodes as $contratoEach) {
                if (in_array($contratoEach, $this->_postMethodsExplode)) {
                    $contrato = true;
                }
            }

            if ($contrato) {
                if ($this->getConfigData('cod_admin') == '' || $this->getConfigData('senha_admin') == '') {
                    // Need correios admin data
                    $this->_throwError('coderror', 'Need correios admin data', __LINE__);
                    return false;
                } else {
                    $client->setParameterGet('nCdEmpresa', $this->getConfigData('cod_admin'));
                    $client->setParameterGet('sDsSenha', $this->getConfigData('senha_admin'));
                }
            }

            $content  = $client->request();
            $conteudo = $content->getBody();

            if ($conteudo == "") {
                throw new Exception("No XML returned [" . __LINE__ . "]");
            }

            libxml_use_internal_errors(true);
            $sxe = simplexml_load_string($conteudo);
            if (!$sxe) {
                throw new Exception("Bad XML [" . __LINE__ . "]");
            }

            // Load XML
            $xml = new SimpleXMLElement($conteudo);

            if (count($xml->cServico) <= 0) {
                throw new Exception("No tag cServico in Correios XML [" . __LINE__ . "]");
            }

            return $xml->cServico;
        } catch (Exception $e) {
            //URL Error
            $this->_throwError('urlerror', 'URL Error - ' . $e->getMessage(), __LINE__);
            return false;
        };
    }

    /**
     * Apend shipping value to return
     *
     * @param $shipping_method string
     * @param $shippingPrice   float
     * @param $correiosReturn  array
     */
    protected function _apendShippingReturn($shipping_method, $shippingPrice = 0, $correiosDelivery = 0)
    {

        $method = Mage::getModel('shipping/rate_result_method');
        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));
        $method->setMethod($shipping_method);

        $shippingCost  = $shippingPrice;
        $shippingPrice = $shippingPrice + $this->getConfigData('handling_fee');

        $shipping_data = explode(',', $this->getConfigData('serv_' . $shipping_method));

        if ($shipping_method == $this->getConfigData('acobrar_code')) {
            $shipping_data[0] = $shipping_data[0] . ' ( R$' . number_format($shippingPrice, 2, ',', '.') . ' )';
            $shippingPrice    = 0;
        }


        // Show delivery days
        if ($this->getConfigFlag('prazo_entrega')) {

            // Delivery days from WS
            if ($correiosDelivery > 0) {
                $method->setMethodTitle(
                    sprintf(
                        $this->getConfigData('msgprazo'),
                        $shipping_data[0],
                        (int) ($correiosDelivery + $this->getConfigData('add_prazo'))
                    )
                );
            } else {
                $method->setMethodTitle(
                    sprintf(
                        $this->getConfigData('msgprazo'),
                        $shipping_data[0],
                        (int) ($shipping_data[1] + $this->getConfigData('add_prazo'))
                    )
                );
            }
        } else {
            $method->setMethodTitle($shipping_data[0]);
        }

        $method->setPrice($shippingPrice);
        $method->setCost($shippingCost);

        if ($this->_freeMethodRequest === true) {
            $this->_freeMethodRequestResult->append($method);
        } else {
            $this->_result->append($method);
        }
    }

    /**
     * Throw error
     *
     * @param $message string
     * @param $log     string
     * @param $line    int
     * @param $custom  string
     */
    protected function _throwError($message, $log = null, $line = 'NO LINE', $custom = null)
    {

        $this->_result = null;
        $this->_result = Mage::getModel('shipping/rate_result');

        // Get error model
        $error = Mage::getModel('shipping/rate_result_error');
        $error->setCarrier($this->_code);
        $error->setCarrierTitle($this->getConfigData('title'));

        if (is_null($custom)) {
            //Log error
            Mage::log($this->_code . ' [' . $line . ']: ' . $log);
            $error->setErrorMessage($this->getConfigData($message));
        } else {
            //Log error
            Mage::log($this->_code . ' [' . $line . ']: ' . $log);
            $error->setErrorMessage(sprintf($this->getConfigData($message), $custom));
        }

        // Apend error
        $this->_result->append($error);
    }

    /**
     * Generate PAC weight
     */
    protected function _generatePacWeight()
    {
        //Create PAC weight
        $pesoCubicoTotal = 0;

        // Get all visible itens from quote
        $items = Mage::getModel('checkout/cart')->getQuote()->getAllVisibleItems();

        foreach ($items as $item) {

            $while           = 0;
            $itemAltura      = 0;
            $itemLargura     = 0;
            $itemComprimento = 0;

            $_product = $item->getProduct();

            if ($_product->getData('volume_altura') == '' || (int) $_product->getData('volume_altura') == 0) {
                $itemAltura = $this->getConfigData('altura_padrao');
            } else {
                $itemAltura = $_product->getData('volume_altura');
            }

            if ($_product->getData('volume_largura') == '' || (int) $_product->getData('volume_largura') == 0) {
                $itemLargura = $this->getConfigData('largura_padrao');
            } else {
                $itemLargura = $_product->getData('volume_largura');
            }

            if ($_product->getData('volume_comprimento') == '' || (int) $_product->getData('volume_comprimento') == 0) {
                $itemComprimento = $this->getConfigData('comprimento_padrao');
            } else {
                $itemComprimento = $_product->getData('volume_comprimento');
            }

            while ($while < $item->getQty()) {
                $itemPesoCubico  = 0;
                $itemPesoCubico  = ($itemAltura * $itemLargura * $itemComprimento) / 4800;
                $pesoCubicoTotal = $pesoCubicoTotal + $itemPesoCubico;
                $while++;
            }
        }

        $this->_pacWeight = number_format($pesoCubicoTotal, 2, '.', '');
    }

    /**
     * Generate free shipping for a product
     *
     * @param string $freeMethod
     */
    protected function _setFreeMethodRequest($freeMethod)
    {
        // Set request as free method request
        $this->_freeMethodRequest       = true;
        $this->_freeMethodRequestResult = Mage::getModel('shipping/rate_result');

        $this->_postMethods        = $freeMethod;
        $this->_postMethodsExplode = array($freeMethod);

        // Tranform free shipping weight
        if ($this->getConfigData('weight_type') == 'gr') {
            $this->_freeMethodWeight = number_format($this->_freeMethodWeight / 1000, 2, '.', '');
        }

        $this->_packageWeight = $this->_freeMethodWeight;
        $this->_pacWeight     = $this->_freeMethodWeight;
    }

    /**
     * Clean correios error code, usualy with "-" before the code
     *
     * @param string $error
     *
     * @return int
     */
    protected function _cleanCorreiosError($error)
    {
        $error = str_replace('-', '', $error);
        $error = (int) $error;
        return $error;
    }


    /**
     * Check if current carrier offer support to tracking
     *
     * @return boolean true
     */
    public function isTrackingAvailable()
    {
        return true;
    }

    /**
     * Get Tracking Info
     *
     * @param mixed $tracking
     *
     * @return mixed
     */
    public function getTrackingInfo($tracking)
    {
        $result = $this->getTracking($tracking);
        if ($result instanceof Mage_Shipping_Model_Tracking_Result) {
            if ($trackings = $result->getAllTrackings()) {
                return $trackings[0];
            }
        } elseif (is_string($result) && !empty($result)) {
            return $result;
        }
        return false;
    }

    /**
     * Get Tracking
     *
     * @param array $trackings
     *
     * @return Mage_Shipping_Model_Tracking_Result
     */
    public function getTracking($trackings)
    {
        $this->_result = Mage::getModel('shipping/tracking_result');
        foreach ((array) $trackings as $code) {
            $this->_getTracking($code);
        }
        return $this->_result;
    }

    /**
     * Protected Get Tracking, opens the request to Correios
     *
     * @param string $code
     *
     * @return boolean
     */
    protected function _getTracking($code)
    {
        $error = Mage::getModel('shipping/tracking_result_error');
        $error->setTracking($code);
        $error->setCarrier($this->_code);
        $error->setCarrierTitle($this->getConfigData('title'));
        $error->setErrorMessage($this->getConfigData('urlerror'));

        $url = 'http://websro.correios.com.br/sro_bin/txect01$.QueryList';
        $url .= '?P_LINGUA=001&P_TIPO=001&P_COD_UNI=' . $code;
        try {
            $client = new Zend_Http_Client();
            $client->setUri($url);
            $content = $client->request();
            $body    = $content->getBody();
        } catch (Exception $e) {
            $this->_result->append($error);
            return false;
        }

        if (!preg_match('#<table ([^>]+)>(.*?)</table>#is', $body, $matches)) {
            $this->_result->append($error);
            return false;
        }
        $table = $matches[2];

        if (!preg_match_all('/<tr>(.*)<\/tr>/i', $table, $columns, PREG_SET_ORDER)) {
            $this->_result->append($error);
            return false;
        }

        $progress = array();
        for ($i = 0; $i < count($columns); $i++) {
            $column = $columns[$i][1];

            $description = '';
            $found       = false;
            if (preg_match('/<td rowspan="?2"?/i', $column) && preg_match(
                    '/<td rowspan="?2"?>(.*)<\/td><td>(.*)<\/td><td><font color="[A-Z0-9]{6}">(.*)<\/font><\/td>/i',
                    $column,
                    $matches
                )
            ) {
                if (preg_match('/<td colspan="?2"?>(.*)<\/td>/i', $columns[$i + 1][1], $matchesDescription)) {
                    $description = str_replace('  ', '', $matchesDescription[1]);
                }

                $found = true;
            } elseif (preg_match(
                '/<td rowspan="?1"?>(.*)<\/td><td>(.*)<\/td><td><font color="[A-Z0-9]{6}">(.*)<\/font><\/td>/i',
                $column,
                $matches
            )
            ) {
                $found = true;
            }

            if ($found) {
                $datetime = explode(' ', $matches[1]);
                $locale   = new Zend_Locale('pt_BR');
                $date     = '';
                $date     = new Zend_Date($datetime[0], 'dd/MM/YYYY', $locale);

                $track = array(
                    'deliverydate'     => $date->toString('YYYY-MM-dd'),
                    'deliverytime'     => $datetime[1] . ':00',
                    'deliverylocation' => htmlentities($matches[2]),
                    'status'           => htmlentities($matches[3]),
                    'activity'         => htmlentities($matches[3])
                );

                if ($description !== '') {
                    $track['activity'] = $matches[3] . ' - ' . htmlentities($description);
                }

                $progress[] = $track;
            }
        }

        if (!empty($progress)) {
            $track                   = $progress[0];
            $track['progressdetail'] = $progress;

            $tracking = Mage::getModel('shipping/tracking_result_status');
            $tracking->setTracking($code);
            $tracking->setCarrier('correios');
            $tracking->setCarrierTitle($this->getConfigData('title'));
            $tracking->addData($track);

            $this->_result->append($tracking);
            return true;
        } else {
            $this->_result->append($error);
            return false;
        }
    }

    /**
     * Returns the allowed carrier methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array($this->_code => $this->getConfigData('title'));
    }

    /**
     * Define ZIP Code as required
     *
     * @return boolean
     */
    public function isZipCodeRequired()
    {
        return true;
    }
}