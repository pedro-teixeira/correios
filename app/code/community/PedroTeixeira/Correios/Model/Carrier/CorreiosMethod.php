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
 * PedroTeixeira_Correios_Model_Carrier_CorreioMethod
 *
 * @category   PedroTeixeira
 * @package    PedroTeixeira_Correios
 * @author     Pedro Teixeira <pedro@pteixeira.com.br>
 */

class ParametersLocaweb
{
}

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
     * Check if current carrier offer support to tracking
     *
     * @return boolean true
     */
    public function isTrackingAvailable()
    {
        return true;
    }

    /**
     * Collect Rates
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     *
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
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



        $result = Mage::getModel('shipping/rate_result');
        $error  = Mage::getModel('shipping/rate_result_error');

        $error->setCarrier($this->_code);
        $error->setCarrierTitle($this->getConfigData('title'));


        $packagevalue = $request->getBaseCurrency()->convert(
            $request->getPackageValue(),
            $request->getPackageCurrency()
        );
        $minorderval  = $this->getConfigData('min_order_value');
        $maxorderval  = $this->getConfigData('max_order_value');
        if ($packagevalue <= $minorderval || $packagevalue >= $maxorderval) {
            //Value limits
            Mage::log('PedroTeixeira_Correios: Value limits');
            $error->setErrorMessage($this->getConfigData('valueerror'));
            $result->append($error);
            return $result;
        }

        $frompcode = Mage::getStoreConfig('shipping/origin/postcode', $this->getStore());
        $topcode   = $request->getDestPostcode();

        //Fix Zip Code
        $frompcode = str_replace('-', '', trim($frompcode));
        $topcode   = str_replace('-', '', trim($topcode));

        if (!preg_match("/^([0-9]{8})$/", $topcode)) {
            //Invalid Zip Code
            Mage::log('PedroTeixeira_Correios: Invalid Zip Code');
            $error->setErrorMessage($this->getConfigData('zipcodeerror'));
            $result->append($error);
            Mage::helper('customer')->__('Invalid ZIP CODE');
            return $result;
        }


        $sweight       = $request->getPackageWeight();
        $weightCompare = $this->getConfigData('maxweight');

        if ($this->getConfigData('weight_type') == 'gr') {
            $sweight       = number_format($sweight / 1000, 2, '.', '');
            $weightCompare = number_format($weightCompare / 1000, 2, '.', '');
        }


        if ($sweight > $weightCompare) {
            //Weight exceeded limit
            Mage::log('PedroTeixeira_Correios: Weight exceeded limit');
            $error->setErrorMessage($this->getConfigData('maxweighterror'));
            $result->append($error);
            return $result;
        }


        if ($sweight == 0) {
            //Weight zero
            Mage::log('PedroTeixeira_Correios: Weight zero');
            $error->setErrorMessage($this->getConfigData('weightzeroerror'));
            $result->append($error);
            return $result;
        }


        //Create the volume of the cart

        $pesoCubicoTotal = 0;
        $volumeTotal     = 0;

        $items = Mage::getModel('checkout/cart')->getQuote()->getAllItems();

        foreach ($items as $item) {

            $while    = 0;
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
                $itemPesoCubico  = ($itemAltura * $itemLargura * $itemComprimento) / 4800;
                $pesoCubicoTotal = $pesoCubicoTotal + $itemPesoCubico;
                $volumeTotal     = $volumeTotal + ($itemPesoCubico * 4800);

                $while++;
            }
        }

        if ($pesoCubicoTotal > $sweight) {
            $mediaMedidas      = round(pow((int) $volumeTotal, (1 / 3)));
            $volumeComprimento = (($mediaMedidas < 16) ? 16 : $mediaMedidas);
            $volumeAltura      = (($mediaMedidas < 2) ? 2 : $mediaMedidas);
            $volumeLargura     = (($mediaMedidas < 11) ? 11 : $mediaMedidas);
        } else {
            $volumeComprimento = 16;
            $volumeAltura      = 2;
            $volumeLargura     = 11;
        }

        //Define post method
        $shipping_methods = array();

        $postmethods = explode(",", $this->getConfigData('postmethods'));

        foreach ($postmethods as $methods) {

            switch ($methods) {
                case 0:
                    $shipping_methods["40010"] = array("Sedex", "3");
                    break;
                case 1:
                    $shipping_methods["40096"] = array("Sedex", "3");
                    break;
                case 2:
                    $shipping_methods["81019"] = array("E-Sedex", "3");
                    break;
                case 3:
                    $shipping_methods["41025"] = array("PAC", "3");
                    break;
                case 4:
                    $shipping_methods["41106"] = array("PAC", "3");
                    break;
                case 5:
                    $shipping_methods["41068"] = array("PAC", "3");
                    break;
                case 6:
                    $shipping_methods["40215"] = array("Sedex 10", "1");
                    break;
                case 7:
                    $shipping_methods["40290"] = array("Sedex HOJE", "1");
                    break;
                case 8:
                    $shipping_methods["40045"] = array("Sedex a Cobrar", "5");
                    break;
            }
        }

        foreach ($shipping_methods as $shipping_method => $shipping_values) {

            //Define URL method
            switch ($this->getConfigData('urlmethod')) {

                case 1:

                    $correiosWSLocaWeb = "http://comercio.locaweb.com.br/correios/frete.asmx?WSDL";

                    $soap = @new SoapClient($correiosWSLocaWeb, array(
                        'trace'              => true,
                        'exceptions'         => true,
                        'compression'        => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
                        'connection_timeout' => 1000
                    ));

                    // Postagem dos parâmetros
                    $parms             = new ParametersLocaweb();
                    $parms->cepOrigem  = utf8_encode($frompcode);
                    $parms->cepDestino = utf8_encode($topcode);
                    $parms->peso       = utf8_encode(str_replace(".", ",", $sweight));
                    $parms->volume     = utf8_encode($volumeTotal);
                    $parms->codigo     = utf8_encode($shipping_method);

                    // Resgata o valor calculado
                    $resposta = $soap->Correios($parms);

                    $shippingPrice = floatval(str_replace(",", ".", $resposta->CorreiosResult));

                    break;

                case 0:

                    $filename = "http://shopping.correios.com.br/wbm/shopping/script/CalcPrecoPrazo.aspx";

                    try {
                        $client = new Zend_Http_Client($filename);

                        $client->setParameterGet('StrRetorno', 'xml');
                        $client->setParameterGet('nCdServico', $shipping_method);
                        $client->setParameterGet('nVlPeso', $sweight);
                        $client->setParameterGet('sCepOrigem', $frompcode);
                        $client->setParameterGet('sCepDestino', $topcode);
                        $client->setParameterGet('nCdFormato', 1);
                        $client->setParameterGet('nVlComprimento', $volumeComprimento);
                        $client->setParameterGet('nVlAltura', $volumeAltura);
                        $client->setParameterGet('nVlLargura', $volumeLargura);
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

                        if ($this->getConfigData('valor_declarado') || $shipping_method == 40045) {
                            $client->setParameterGet('nVlValorDeclarado', number_format($packagevalue, 2, ',', '.'));
                        } else {
                            $client->setParameterGet('nVlValorDeclarado', 0);
                        }



                        if ($shipping_method == 40096 || $shipping_method == 81019 || $shipping_method == 41068) {
                            if ($this->getConfigData('cod_admin') == '' || $this->getConfigData('senha_admin') == '') {
                                // Need correios admin data
                                Mage::log('PedroTeixeira_Correios: Need correios admin data');
                                $error->setErrorMessage($this->getConfigData('coderror'));
                                $result->append($error);
                                return $result;
                            } else {
                                $client->setParameterGet('nCdEmpresa', $this->getConfigData('cod_admin'));
                                $client->setParameterGet('sDsSenha', $this->getConfigData('senha_admin'));
                            }
                        }

                        $content  = $client->request();
                        $conteudo = $content->getBody();

                        if (!stristr($conteudo, "<?xml")) {
                            throw new Exception("Not XML returned.");
                        }
                    } catch (Exception $e) {
                        //URL Error
                        Mage::log('PedroTeixeira_Correios: URL Error');
                        $error = Mage::getModel('shipping/rate_result_error');
                        $error->setCarrier($this->_code);
                        $error->setCarrierTitle($this->getConfigData('title'));
                        $error->setMethod($shipping_method);
                        $error->setErrorMessage($this->getConfigData('urlerror'));
                        $result->append($error);
                        $shippingPrice = 0;

                        continue;
                    };

                    preg_match_all("/<Codigo>(.+)<\/Codigo>/", $conteudo, $xml_servico);
                    preg_match_all("/<Valor>(.+)<\/Valor>/", $conteudo, $preco_postal);
                    preg_match_all("/<PrazoEntrega>(.+)<\/PrazoEntrega>/", $conteudo, $prazo_postal);
                    preg_match_all("/<Erro>(.+)<\/Erro>/", $conteudo, $err_id);
                    $err_id = str_replace('-', '', $err_id[1][0]);
                    $err_id = (int) $err_id;
                    preg_match_all("/<MsgErro>(.+)<\/MsgErro>/", $conteudo, $err_msg);


                    $correiosReturn = array(
                        "prazo" => $prazo_postal[1][0]
                    );

                    if (trim($err_id) == "0") {
                        $shippingPrice = floatval(str_replace(",", ".", $preco_postal[1][0]));
                    } else {

                        $ignorar = explode(',', $this->getConfigData('ignorar_erro'));
                        $ignorar = array_flip($ignorar);
                        if (!array_key_exists($err_id, $ignorar)) {
                            //Error
                            $error = Mage::getModel('shipping/rate_result_error');
                            $error->setCarrier($this->_code);
                            $error->setCarrierTitle($this->getConfigData('title'));
                            $error->setMethod($shipping_method);

                            // Correios Error
                            Mage::log('PedroTeixeira_Correios: Correios Error');
                            $error->setErrorMessage(
                                sprintf(
                                    $this->getConfigData('correioserror'),
                                    $shipping_values[0],
                                    $err_msg[1][0],
                                    $err_id
                                )
                            );
                            $result->append($error);
                            $shippingPrice = 0;
                        } else {
                            $shippingPrice = 0;
                        }
                    }


                    break;
                default:
                    //URL method undefined
                    Mage::log('PedroTeixeira_Correios: URL method undefined');
                    $error->setErrorMessage($this->getConfigData('urlerror'));
                    $result->append($error);
                    return $result;
            }

            if ($shippingPrice <= 0) {
                continue;
            }

            $method = Mage::getModel('shipping/rate_result_method');

            $method->setCarrier($this->_code);
            $method->setCarrierTitle($this->getConfigData('title'));

            $method->setMethod($shipping_method);

            if ($this->getConfigFlag('prazo_entrega')) {

                if (isset($correiosReturn)) {
                    if ($correiosReturn['prazo'] > 0) {
                        $method->setMethodTitle(
                            sprintf(
                                $this->getConfigData('msgprazo'),
                                $shipping_values[0],
                                (int) $correiosReturn['prazo'] + $this->getConfigData('add_prazo')
                            )
                        );
                    } else {
                        $method->setMethodTitle(
                            sprintf(
                                $this->getConfigData('msgprazo'),
                                $shipping_values[0],
                                $shipping_values[1] + $this->getConfigData('add_prazo')
                            )
                        );
                    }
                } else {
                    $method->setMethodTitle(
                        sprintf(
                            $this->getConfigData('msgprazo'),
                            $shipping_values[0],
                            $shipping_values[1] + $this->getConfigData('add_prazo')
                        )
                    );
                }
            } else {
                $method->setMethodTitle($shipping_values[0]);
            }

            $method->setPrice($shippingPrice + $this->getConfigData('handling_fee'));

            $method->setCost($shippingPrice);

            $result->append($method);

            $shippingPrice = null;
        }

        $this->_result = $result;

        $this->_updateFreeMethodQuote($request);

        return $this->_result;
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
                $datetime = split(' ', $matches[1]);

                $locale = new Zend_Locale('pt_BR');
                $date   = '';
                $date   = new Zend_Date($datetime[0], 'dd/MM/YYYY', $locale);

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
