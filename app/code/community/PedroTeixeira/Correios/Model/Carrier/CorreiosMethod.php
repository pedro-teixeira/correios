<?php

/**
 * This source file is subject to the MIT License.
 * It is also available through http://opensource.org/licenses/MIT
 *
 * @category  PedroTeixeira
 * @package   PedroTeixeira_Correios
 * @author    Pedro Teixeira <hello@pedroteixeira.io>
 * @copyright 2015 Pedro Teixeira (http://pedroteixeira.io)
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      https://github.com/pedro-teixeira/correios
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
    protected $_isFixed = true;

    /**
     * _result property
     *
     * @var Mage_Shipping_Model_Rate_Result|Mage_Shipping_Model_Tracking_Result
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
    protected $_volumeWeight = null;
    protected $_freeMethodWeight = null;
    protected $_midSize = null;
    protected $_splitUp = 0;
    protected $_postingDays = 0;

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
     * @param Mage_Shipping_Model_Rate_Request $request Mage request
     *
     * @return bool|Mage_Shipping_Model_Rate_Result|Mage_Shipping_Model_Tracking_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        // Do initial check
        if ($this->_inicialCheck($request) === false) {
            return false;
        }

        // Check package value
        if ($this->_packageValue < $this->getConfigData('min_order_value')
            || $this->_packageValue > $this->getConfigData('max_order_value')
        ) {
            $this->_throwError('valueerror', 'Value limits', __LINE__);
            return $this->_result;
        }

        // Check ZIP Code
        if (!preg_match('/^([0-9]{8})$/', $this->_toZip)) {
            $this->_throwError('zipcodeerror', 'Invalid Zip Code', __LINE__);
            return $this->_result;
        }

        if ($this->_packageWeight == 0) {
            $this->_packageWeight = $this->_getNominalWeight();
        }

        if ($this->getConfigData('weight_type') == PedroTeixeira_Correios_Model_Source_WeightType::WEIGHT_GR) {
            $this->_packageWeight = number_format($this->_packageWeight / 1000, 2, '.', '');
        }

        // Check weight zero
        if ($this->_packageWeight <= 0) {
            $this->_throwError('weightzeroerror', 'Weight zero', __LINE__);
            return $this->_result;
        }

        $this->_postMethods        = $this->getConfigData('postmethods');
        $this->_postMethodsFixed   = $this->_postMethods;
        $this->_postMethodsExplode = explode(',', $this->getConfigData('postmethods'));

        // Generate Volume Weight
        if ($this->_generateVolumeWeight() === false || $this->_removeInvalidServices() === false) {
            $this->_throwError('dimensionerror', 'Dimension error', __LINE__);
            return $this->_result;
        }

        $this->_filterMethodByItemRestriction();
        if ($this->_getQuotes()->getError()) {
            return $this->_result;
        }

        // Use descont codes
        $this->_updateFreeMethodQuote($request);

        return $this->_result;
    }
    
    /**
    * Gets Nominal Weight
    *
    * @return number
    */
    protected function _getNominalWeight()
    {
        $weight = 0;
        $quote = Mage::getSingleton('checkout/cart')->getQuote();
        if (count($quote->getAllVisibleItems()) == 0) {
            $quote = Mage::getSingleton('adminhtml/session_quote')->getQuote();
        }
        if ($quote->isNominal()) {
            foreach ($quote->getAllVisibleItems() as $item) {
                $product = Mage::getModel('catalog/product')->load($item->getProductId());
                $weight += $product->getWeight();
            }
        }
        return $weight;
    }

    /**
     * Get shipping quote
     *
     * @return Mage_Shipping_Model_Rate_Result|Mage_Shipping_Model_Tracking_Result
     */
    protected function _getQuotes()
    {
        $softErrors     = explode(',', $this->getConfigData('soft_errors'));
        $correiosReturn = $this->_getCorreiosReturn();

        if ($correiosReturn !== false) {

            $correiosReturn = $this->_addPostMethods($correiosReturn);
            $existReturn    = false;

            foreach ($correiosReturn as $servicos) {

                $errorId = (string) $servicos->Erro;

                if ($errorId != '0' && !in_array($errorId, $softErrors)) {
                    continue;
                }

                $stringPrice   = (string) $servicos->Valor;
                $stringPrice   = str_replace('.', '', $stringPrice);
                $stringPrice   = str_replace(',', '.', $stringPrice);
                $shippingPrice = floatval($stringPrice);
                $shippingPrice *= pow(2, $this->_splitUp);
                $shippingDelivery = (int) $servicos->PrazoEntrega;

                if ($shippingPrice <= 0) {
                    continue;
                }

                $this->_appendShippingReturn((string) $servicos->Codigo, $shippingPrice, $shippingDelivery);
                if ($this->getConfigFlag('show_soft_errors') && !isset($isWarnAppended)) {
                    $isWarnAppended = $this->_appendShippingWarning($servicos);
                }
                $existReturn = true;
            }

            if ($existReturn === false) {
                $this->_throwError('urlerror', 'URL Error, all services return with error', __LINE__);
                return $this->_result;
            }
        } else {
            return $this->_result;
        }

        if ($this->_freeMethodRequest === true) {
            return $this->_freeMethodRequestResult;
        } else {
            return $this->_result;
        }
    }

    /**
     * Make initial checks and iniciate module variables
     *
     * @param Mage_Shipping_Model_Rate_Request $request Mage request
     *
     * @return bool
     */
    protected function _inicialCheck(Mage_Shipping_Model_Rate_Request $request)
    {

        if (!$this->getConfigFlag('active')) {
            // Disabled
            Mage::log('pedroteixeira_correios: Disabled');
            return false;
        }

        $origCountry = Mage::getStoreConfig('shipping/origin/country_id', $this->getStore());
        $destCountry = $request->getDestCountryId();
        if ($origCountry != 'BR' || $destCountry != 'BR') {
            // Out of delivery area
            Mage::log('pedroteixeira_correios: Out of delivery area');
            return false;
        }

        $this->_fromZip = Mage::getStoreConfig('shipping/origin/postcode', $this->getStore());
        $this->_toZip   = $request->getDestPostcode();

        // Fix ZIP code
        $this->_fromZip = str_replace(array('-', '.'), '', trim($this->_fromZip));
        $this->_toZip   = str_replace(array('-', '.'), '', trim($this->_toZip));

        if (!preg_match('/^([0-9]{8})$/', $this->_fromZip)) {
            Mage::log('pedroteixeira_correios: From ZIP Code Error');
            return false;
        }

        $this->_result       = Mage::getModel('shipping/rate_result');
        $this->_packageValue = $request->getBaseCurrency()->convert(
            $request->getPackageValue(),
            $request->getPackageCurrency()
        );

        $this->_packageWeight    = number_format($request->getPackageWeight(), 2, '.', '');
        $this->_freeMethodWeight = number_format($request->getFreeMethodWeight(), 2, '.', '');
    }

    /**
     * Get Correios return
     *
     * @return bool|SimpleXMLElement[]
     *
     * @throws Exception
     */
    protected function _getCorreiosReturn()
    {
        $filename      = $this->getConfigData('url_ws_correios');
        $contratoCodes = explode(',', $this->getConfigData('contrato_codes'));

        try {
            $client = new Zend_Http_Client($filename);
            $client->setConfig(
                array(
                    'timeout' => $this->getConfigData('ws_timeout'),
                    'adapter' => Mage::getModel('pedroteixeira_correios/http_client_adapter_socket')
                )
            );

            $client->setParameterGet('StrRetorno', 'xml');
            $client->setParameterGet('nCdServico', $this->_postMethods);
            $client->setParameterGet('nVlPeso', $this->_packageWeight);
            $client->setParameterGet('sCepOrigem', $this->_fromZip);
            $client->setParameterGet('sCepDestino', $this->_toZip);
            $client->setParameterGet('nCdFormato', 1);
            $client->setParameterGet('nVlComprimento', $this->_midSize);
            $client->setParameterGet('nVlAltura', $this->_midSize);
            $client->setParameterGet('nVlLargura', $this->_midSize);

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

            if ($this->getConfigData('valor_declarado')
                || in_array($this->getConfigData('acobrar_code'), $this->_postMethodsExplode)
            ) {
                $client->setParameterGet('nVlValorDeclarado', number_format($this->_packageValue, 2, ',', ''));
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
                    $this->_throwError('coderror', 'Need correios admin data', __LINE__);
                    return false;
                } else {
                    $client->setParameterGet('nCdEmpresa', $this->getConfigData('cod_admin'));
                    $client->setParameterGet('sDsSenha', $this->getConfigData('senha_admin'));
                }
            }

            $content = $client->request()->getBody();

            if ($content == '') {
                throw new Exception('No XML returned [' . __LINE__ . ']');
            }

            libxml_use_internal_errors(true);
            $sxe = simplexml_load_string($content);
            if (!$sxe) {
                throw new Exception('Bad XML [' . __LINE__ . ']');
            }

            $xml = new SimpleXMLElement($content);

            if (count($xml->cServico) <= 0) {
                throw new Exception('No tag cServico in Correios XML [' . __LINE__ . ']');
            }

            return $xml->cServico;
        } catch (Exception $e) {
            $this->_throwError('urlerror', 'URL Error - ' . $e->getMessage(), __LINE__);
            return false;
        }
    }

    /**
     * Apend shipping value to return
     *
     * @param string $shippingMethod   Method of shipping
     * @param int    $shippingPrice    Price
     * @param int    $correiosDelivery Delivery date
     *
     * @return void
     */
    protected function _appendShippingReturn($shippingMethod, $shippingPrice = 0, $correiosDelivery = 0)
    {

        $method = Mage::getModel('shipping/rate_result_method');
        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));
        $method->setMethod($shippingMethod);

        $shippingCost  = $shippingPrice;
        $shippingPrice = $shippingPrice + $this->getConfigData('handling_fee');

        $shippingData = explode(',', $this->getConfigData('serv_' . $shippingMethod));

        if ($shippingMethod == $this->getConfigData('acobrar_code')) {
            $shippingData[0] = $shippingData[0] . ' ( R$' . number_format($shippingPrice, 2, ',', '.') . ' )';
            $shippingPrice   = 0;
        }

        if ($this->getConfigFlag('prazo_entrega')) {
            if ($correiosDelivery > 0) {
                $method->setMethodTitle(
                    sprintf(
                        $this->getConfigData('msgprazo'),
                        $shippingData[0],
                        (int) ($correiosDelivery + $this->getConfigData('add_prazo') + $this->_postingDays)
                    )
                );
            } else {
                $method->setMethodTitle(
                    sprintf(
                        $this->getConfigData('msgprazo'),
                        $shippingData[0],
                        (int) ($shippingData[1] + $this->getConfigData('add_prazo') + $this->_postingDays)
                    )
                );
            }
        } else {
            $method->setMethodTitle($shippingData[0]);
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
     * @param string     $message Message placeholder
     * @param string     $log     Message
     * @param string|int $line    Line of log
     * @param string     $custom  Custom variables for placeholder
     *
     * @return void
     */
    protected function _throwError($message, $log = null, $line = 'NO LINE', $custom = null)
    {
        $this->_result = null;
        $this->_result = Mage::getModel('shipping/rate_result');

        $error = Mage::getModel('shipping/rate_result_error');
        $error->setCarrier($this->_code);
        $error->setCarrierTitle($this->getConfigData('title'));

        if (is_null($custom) || $this->getConfigData($message) == '') {
            Mage::log($this->_code . ' [' . $line . ']: ' . $log);
            $error->setErrorMessage($this->getConfigData($message));
        } else {
            Mage::log($this->_code . ' [' . $line . ']: ' . $log);
            $error->setErrorMessage(sprintf($this->getConfigData($message), $custom));
        }

        $this->_result->append($error);
    }

    /**
     * Generate Volume weight
     *
     * @return bool
     */
    protected function _generateVolumeWeight()
    {
        $pesoCubicoTotal = 0;

        $items = Mage::getModel('checkout/cart')->getQuote()->getAllVisibleItems();

        if (count($items) == 0) {
            $items = Mage::getSingleton('adminhtml/session_quote')->getQuote()->getAllVisibleItems();
        }

        foreach ($items as $item) {
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

            if ($this->getConfigFlag('check_dimensions')) {
                foreach ($this->_postMethodsExplode as $key => $method) {
                    $sizeMax = max($itemAltura, $itemLargura, $itemComprimento);
                    $sumMax  = ($itemAltura + $itemLargura + $itemComprimento);
                    $isValid = ($sizeMax <= $this->getConfigData("validate/serv_{$method}/max/size"));
                    $isValid &= ($sumMax <= $this->getConfigData("validate/serv_{$method}/max/sum"));

                    if (!$isValid) {
                        unset($this->_postMethodsExplode[$key]);
                    }
                }

                if (count($this->_postMethodsExplode) == 0) {
                    return false;
                }

                $this->_postMethods      = implode(',', $this->_postMethodsExplode);
                $this->_postMethodsFixed = $this->_postMethods;
            }

            $itemAltura = $this->_getFitHeight($item);
            $pesoCubicoTotal += (($itemAltura * $itemLargura * $itemComprimento) *
                    $item->getQty()) / $this->getConfigData('coeficiente_volume');

            $this->_postingDays = max($this->_postingDays, (int) $_product->getData('posting_days'));
        }

        $this->_volumeWeight = number_format($pesoCubicoTotal, 2, '.', '');

        return true;
    }

    /**
     * Generate free shipping for a product
     *
     * @param string $freeMethod Free method
     *
     * @return void
     */
    protected function _setFreeMethodRequest($freeMethod)
    {
        $this->_freeMethodRequest       = true;
        $this->_freeMethodRequestResult = Mage::getModel('shipping/rate_result');

        $this->_postMethods        = $freeMethod;
        $this->_postMethodsExplode = array($freeMethod);

        if ($this->getConfigData('weight_type') == PedroTeixeira_Correios_Model_Source_WeightType::WEIGHT_GR) {
            $this->_freeMethodWeight = number_format($this->_freeMethodWeight / 1000, 2, '.', '');
        }

        $this->_packageWeight = $this->_freeMethodWeight;
        $this->_pacWeight     = $this->_freeMethodWeight;
    }

    /**
     * Check if current carrier offer support to tracking
     *
     * @return bool true
     */
    public function isTrackingAvailable()
    {
        return true;
    }

    /**
     * Get Tracking Info
     *
     * @param mixed $tracking Tracking
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
     * @param array $trackings Trackings
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
     * @param string $code Code
     *
     * @return bool
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
            if (preg_match('/<td rowspan="?2"?/i', $column)
                && preg_match(
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
                    'deliverylocation' => htmlentities($matches[2], ENT_IGNORE, 'ISO-8859-1'),
                    'status'           => htmlentities($matches[3], ENT_IGNORE, 'ISO-8859-1'),
                    'activity'         => htmlentities($matches[3], ENT_IGNORE, 'ISO-8859-1')
                );

                if ($description !== '') {
                    $track['activity'] = $matches[3] . ' - ' . htmlentities($description, ENT_IGNORE, 'ISO-8859-1');
                }

                $progress[] = $track;
            }
        }

        if (!empty($progress)) {
            $track                   = $progress[0];
            $track['progressdetail'] = $progress;

            $tracking = Mage::getModel('shipping/tracking_result_status');
            $tracking->setTracking($code);
            $tracking->setCarrier($this->_code);
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
     * @param string $countryId Country ID
     *
     * @return bool
     */
    public function isZipCodeRequired($countryId = null)
    {
        return true;
    }

    /**
     * Retrieve an average size.
     * For optimization purposes all tree box sizes are converted in one medium dimension.
     * Result cant exceed the minimum transportation limits.
     *
     * @return PedroTeixeira_Correios_Model_Carrier_CorreiosMethod
     */
    protected function _loadMidSize()
    {
        $volumeFactor   = $this->getConfigData('coeficiente_volume');
        $volumeTotal    = $this->_volumeWeight * $volumeFactor;
        $pow            = round(pow((int) $volumeTotal, (1 / 3)));
        $min            = $this->getConfigData('midsize_min');
        $this->_midSize = max($pow, $min);
        return $this;
    }

    /**
     * Validate post methods removing invalid services from quotation.
     *
     * @return boolean|PedroTeixeira_Correios_Model_Carrier_CorreiosMethod
     */
    protected function _removeInvalidServices()
    {
        $tmpMethods = $this->_postMethodsExplode;
        $tmpMethods = $this->_filterMethodByConfigRestriction($tmpMethods);
        $isDivisible = (count($tmpMethods) == 0);
        
        if ($isDivisible) {
            return $this->_splitPack();
        }

        $this->_postMethodsExplode = $tmpMethods;
        $this->_postMethods        = implode(',', $this->_postMethodsExplode);
        $this->_postMethodsFixed   = $this->_postMethods;
        return $this;
    }

    /**
     * Include an additional method to quote content before showing.
     * When requested the new method is added in xml content as specified in config.xml like below:
     *
     *     <add_method_0>
     *         <code>10065</code>
     *         <price>2.45</price>
     *         <days>5</days>
     *         <from>
     *             <zip>00000000</zip>
     *             <weight>0.0</weight>
     *             <size>0</size>
     *         </from>
     *         <to>
     *             <zip>99999999</zip>
     *             <weight>0.1</weight>
     *             <size>150</size>
     *         </to>
     *     </add_method_0>
     *
     * @param SimpleXMLElement $cServico XML Node
     *
     * @see http://www.correios.com.br/para-voce/consultas-e-solicitacoes/precos-e-prazos/servicos-nacionais_pasta/carta
     *
     * @return SimpleXMLElement
     */
    protected function _addPostMethods($cServico)
    {
        $addMethods = $this->getConfigData("add_postmethods");
        foreach ($addMethods as $configData) {
            $isValid = true;
            $isValid &= $this->_packageWeight >= $configData['from']['weight'];
            $isValid &= $this->_packageWeight <= $configData['to']['weight'];
            $isValid &= $this->_midSize >= $configData['from']['size'];
            $isValid &= $this->_midSize <= $configData['to']['size'];
            $isValid &= $this->_toZip >= $configData['from']['zip'];
            $isValid &= $this->_toZip <= $configData['to']['zip'];

            if ($isValid) {
                $price   = $configData['price'];
                $days    = $configData['days'];
                $method  = $configData['code'];
                foreach ($cServico as $servico) {
                    if ($servico->Codigo == $method) {
                        if (!empty($price)) {
                            $servico->Valor = number_format($price, 2, ',', '');
                        }
                        if (!empty($days)) {
                            $servico->PrazoEntrega = $days;
                        }
                        $servico->EntregaDomiciliar = 'S';
                        $servico->EntregaSabado     = 'S';
                        $servico->Erro              = '0';
                        $servico->MsgErro           = '<![CDATA[]]>';
                    }
                }
            }
        }

        return $cServico;
    }

    /**
     * This keeps only postmethods available for all items in cart.
     * In other words you can set post methods by products.
     * Methods not available for all items in cart are removed.
     * Require attribute creation called postmethods.
     * Example:
     *  code:     postmethods
     *  type:     multiselect
     *  label:    [free]
     *  value 1:  41068
     *  value 2:  40096
     *  ...
     *  value 99: 81019
     *
     * @return PedroTeixeira_Correios_Model_Carrier_CorreiosMethod
     */
    protected function _filterMethodByItemRestriction()
    {
        if ($this->getConfigFlag('filter_by_item')) {
            $items = Mage::getSingleton('checkout/cart')->getQuote()->getAllVisibleItems();

            if (count($items) == 0) {
                $items = Mage::getSingleton('adminhtml/session_quote')->getQuote()->getAllVisibleItems();
            }

            $intersection = $this->_postMethodsExplode;
            foreach ($items as $item) {
                $product         = Mage::getModel('catalog/product')->load($item->getProductId());
                $prodPostMethods = explode(',', $product->getData('postmethods'));
                $intersection    = array_intersect($prodPostMethods, $intersection);
            }

            $this->_postMethodsExplode = $intersection;
            $this->_postMethods        = implode(',', $intersection);
            $this->_postMethodsFixed   = $this->_postMethods;
        }

        return $this;
    }

    /**
     * Added a fit size for items in large quantities.
     * Means you can join items like two or more glasses, pots and vases.
     * The calc is applied only for height side.
     * Required attribute fit_size. Example:
     *
     *         code: fit_size
     *         type: varchar
     *
     * After you can set a fit size for all products and improve your sells
     *
     * @param Mage_Eav_Model_Entity_Abstract $item Order Item
     *
     * @return number
     */
    protected function _getFitHeight($item)
    {
        $product = $item->getProduct();
        $height  = $product->getData('volume_altura');
        $height  = ($height > 0) ? $height : (int) $this->getConfigData('altura_padrao');
        $fitSize = (float) $product->getData('fit_size');

        if ($item->getQty() > 1 && is_numeric($fitSize) && $fitSize > 0) {
            $totalSize = $height + ($fitSize * ($item->getQty() - 1));
            $height    = $totalSize / $item->getQty();
        }

        return $height;
    }

    /**
     * Splits the package in two parts.
     * If the package is already splited, each piece will be splited in two equal parts.
     *
     * @return boolean|PedroTeixeira_Correios_Model_Carrier_CorreiosMethod
     */
    protected function _splitPack()
    {
        $isSplitEnabled = $this->getConfigFlag('split_pack');
        $isMethodAvailable = (count($this->_postMethodsExplode) > 0);
        if ($isSplitEnabled && $isMethodAvailable) {
            $this->_splitUp++;
            $this->_volumeWeight /= 2;
            $this->_packageWeight /= 2;
            $this->_packageValue /= 2;
            return $this->_removeInvalidServices();
        }
        return false;
    }

    /**
     * Receive a list of methods, and validate one-by-one using the config settings.
     * Returns a list of valid methods or empty.
     * 
     * @param array $postmethods Services List
     * 
     * @return array
     */
    protected function _filterMethodByConfigRestriction($postmethods)
    {
        $validMethods = array();
        $this->_loadMidSize();
        foreach ($postmethods as $key => $method) {
            $isOverSize = ($this->_midSize > $this->getConfigData("validate/serv_{$method}/max/size"));
            $isOverSize |= ($this->_midSize * 3 > $this->getConfigData("validate/serv_{$method}/max/sum"));
            $isOverWeight = ($this->_packageWeight > $this->getConfigData("validate/serv_{$method}/max/weight"));
            $isOverCubic = ($this->_volumeWeight > $this->getConfigData("validate/serv_{$method}/max/volume_weight"));
            $isZipAllowed = $this->_validateZipRestriction($method);

            if (!$isOverSize && !$isOverWeight && !$isOverCubic && $isZipAllowed) {
                $validMethods[] = $method;
            }
        }
        return $validMethods;
    }

    /**
     * Loads the zip range list.
     * Returns TRUE only if zip target is included in the range.
     * 
     * @param array $method Current Post Method
     * 
     * @return boolean
     */
    protected function _validateZipRestriction($method)
    {
        $zipConfig = $this->getConfigData("validate/serv_{$method}/zips");
        foreach ($zipConfig as $data) {
            $zipRange = explode(',', $data);
            $isBetweenRange = true;
            $isBetweenRange &= ($this->_toZip >= $zipRange[0]);
            $isBetweenRange &= ($this->_toZip <= $zipRange[1]);
            if ($isBetweenRange) {
                return true;
            }
        }
        return false;
    }

    /**
     * Add a warning message at the top of the shipping method list.
     *
     * @param SimpleXMLElement $servico Post Method
     *
     * @return boolean
     */
    protected function _appendShippingWarning(SimpleXMLElement $servico)
    {
        $id = (string) $servico->Erro;
        $ids = explode(',', $this->getConfigData('soft_errors'));
        if (in_array($id, $ids)) {
            $error = Mage::getModel('shipping/rate_result_error');
            $error->setCarrier($this->_code);
            $error->setErrorMessage($servico->MsgErro);
            $this->_result->append($error);
            return true;
        }
        return false;
    }
}
