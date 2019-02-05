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
            $this->_packageWeight = $this->_getNominalWeight($request);
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
        if ($this->_generateVolumeWeight($request) === false || $this->_removeInvalidServices() === false) {
            $this->_throwError('dimensionerror', 'Dimension error', __LINE__);
            return $this->_result;
        }

        $this->_filterMethodByItemRestriction($request);

        if (empty($this->_postMethods)) {
            return false;
        }
        //Show Quotes
        $this->_getQuotes();

        // Use descont codes
        $this->_updateFreeMethodQuote($request);

        return $this->_result;
    }

    /**
     * Retrieve all visible items from request
     *
     * @param Mage_Shipping_Model_Rate_Request $request Mage request
     *
     * @return array
     */
    protected function _getRequestItems($request)
    {

        $allItems = $request->getAllItems();
        $items = array();

        foreach ($allItems as $item) {
            if (!$item->getParentItemId()) {
                $items[] = $item;
            }
        }

        $items = $this->_loadBundleChildren($items);

        return $items;
    }

    /**
    * Gets Nominal Weight
    *
    * @param Mage_Shipping_Model_Rate_Request $request Mage request
    *
    * @return number
    */
    protected function _getNominalWeight($request)
    {
        $weight = 0;
        $items = $this->_getRequestItems($request);

        foreach ($items as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $weight += $product->getWeight();
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
            $errorList = array();
            $correiosReturn = $this->_addPostMethods($correiosReturn);

            foreach ($correiosReturn as $servicos) {
                $errorId = (string) $servicos->Erro;
                $errorList[$errorId] = $servicos->MsgErro;

                if ($errorId != '0' && !in_array($errorId, $softErrors)) {
                    continue;
                }

                $servicos->Valor = $this->_getFormatPrice((string) $servicos->Valor);
                $this->_appendShippingReturn($servicos);
            }
            $this->_appendShippingErrors($errorList);
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

        if (!trim($this->_toZip)) {
            return false;
        }

        $uniqueCityZip = $this->getConfigData('unique_city_zip');
        if ($uniqueCityZip && !strcmp ($this->_fromZip, $this->_toZip)) {
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

            $nCdEmpresa = $this->getConfigData('cod_admin');
            $sDsSenha = $this->getConfigData('senha_admin');
            if (!empty($nCdEmpresa) && !empty($sDsSenha)) {
                $client->setParameterGet('nCdEmpresa', $nCdEmpresa);
                $client->setParameterGet('sDsSenha', $sDsSenha);
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
     * @param SimpleXMLElement $servico Service Data
     *
     * @return void
     */
    protected function _appendShippingReturn(SimpleXMLElement $servico)
    {
        $correiosDelivery = (int) $servico->PrazoEntrega;
        $shippingMethod   = (string) $servico->Codigo;
        $shippingPrice    = (float) $servico->Valor;
        if ($shippingPrice <= 0) {
            return;
        }

        $errorMsg = $this->_getSoftErrorMsg((string) $servico->Erro);
        $method = Mage::getModel('shipping/rate_result_method');
        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title') . $this->_getSplitUpMsg() . $errorMsg);
        $method->setMethod($shippingMethod);

        $shippingCost  = $shippingPrice;
        $shippingPrice = $shippingPrice + $this->getConfigData('handling_fee');

        $shippingData = Mage::helper('pedroteixeira_correios')->getShippingLabel($shippingMethod);
        $shippingData = Mage::helper('pedroteixeira_correios')->__($shippingData);

        if ($shippingMethod == $this->getConfigData('acobrar_code')) {
            $shippingData = $shippingData . ' ( R$' . number_format($shippingPrice, 2, ',', '.') . ' )';
            $shippingPrice   = 0;
        }

        if ($this->getConfigFlag('prazo_entrega')) {
            if ($correiosDelivery > 0) {
                $method->setMethodTitle(
                    sprintf(
                        $this->getConfigData('msgprazo'),
                        $shippingData,
                        (int) ($correiosDelivery + $this->getConfigData('add_prazo') + $this->_postingDays)
                    )
                );
            }
        } else {
            $method->setMethodTitle($shippingData);
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
     * Retrieves a simple product
     *
     * @param Mage_Catalog_Model_Product $product Catalog Product
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _getSimpleProduct($product)
    {
        $type = $product->getTypeInstance(true);
        if ($type->getProduct($product)->hasCustomOptions()
            && ($simpleProductOption = $type->getProduct($product)->getCustomOption('simple_product'))
        ) {
            $simpleProduct = $simpleProductOption->getProduct($product);
            if ($simpleProduct) {
                return $this->_getSimpleProduct($simpleProduct);
            }
        }
        return $type->getProduct($product);
    }

    /**
     * Generate Volume weight
     *
     * @param Mage_Shipping_Model_Rate_Request $request Mage request
     *
     * @return bool
     */
    protected function _generateVolumeWeight($request)
    {
        $pesoCubicoTotal = 0;

        $items = $this->_getRequestItems($request);

        foreach ($items as $item) {
            $_product = $this->_getSimpleProduct($item->getProduct());

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
                    $item->getTotalQty()) / $this->getConfigData('coeficiente_volume');

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
     * Loads the parameters and calls the webservice using SOAP
     *
     * @param string $code Code
     *
     * @return bool|array
     *
     * @throws Exception
     */
    protected function _getTrackingRequest($code)
    {
        $response = false;
        $params = array(
            'usuario'   => $this->getConfigData('sro_username'),
            'senha'     => $this->getConfigData('sro_password'),
            'tipo'      => $this->getConfigData('sro_type'),
            'resultado' => 'T',
            'lingua'    => $this->getConfigData('sro_language'),
            'objetos'   => $code,
        );

        try {
            $client = new SoapClient(
                $this->getConfigData('url_sro_correios'), Mage::helper('pedroteixeira_correios')->getStreamContext()
            );
            $response = $client->buscaEventos($params);
            if (empty($response)) {
                throw new Exception("Empty response");
            }
        } catch (Exception $e) {
            Mage::log("Soap Error: {$e->getMessage()}");
        }
        return $response;
    }

    /**
     * Loads tracking progress details
     *
     * @param SimpleXMLElement $evento      XML Element Node
     * @param bool             $isDelivered Delivery Flag
     *
     * @return array
     */
    protected function _getTrackingProgressDetails($evento, $isDelivered = false)
    {
        $date = new Zend_Date($evento->data, 'dd/MM/YYYY', new Zend_Locale('pt_BR'));
        $track = array(
            'deliverydate'  => $date->toString('YYYY-MM-dd'),
            'deliverytime'  => $evento->hora . ':00',
            'status'        => $evento->descricao,
        );
        if (!$isDelivered) {
            $msg = array($evento->descricao);
            if (isset($evento->destino) && isset($evento->destino->local)) {
                $msg = array("{$evento->descricao} para {$evento->destino->local}");
            }
            $track['activity'] = implode(' | ', $msg);
            $track['deliverylocation'] = "{$evento->local} - {$evento->cidade}/{$evento->uf}";
        }
        return $track;
    }

    /**
     * Loads progress data using the WSDL response
     *
     * @param string $request Request response
     *
     * @return array
     */
    protected function _getTrackingProgress($request)
    {
        $track = array();
        $progress = array();
        $eventTypes = explode(',', $this->getConfigData("sro_event_type_last"));

        if (count($request->return->objeto->evento) == 1) {
            $progress[] = $this->_getTrackingProgressDetails($request->return->objeto->evento);
        } else {
            foreach ($request->return->objeto->evento as $evento) {
                $progress[] = $this->_getTrackingProgressDetails($evento);
                $isDelivered = ((int) $evento->status < 2 && in_array($evento->tipo, $eventTypes));
                if ($isDelivered) {
                    $track = $this->_getTrackingProgressDetails($evento, $isDelivered);
                }
            }
        }

        $progress[] = $track;
        return $progress;
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
        
        $request = $this->_getTrackingRequest($code);
        if (!isset($request->return)) {
            $this->_result->append($error);
            return false;
        }

        $progress = $this->_getTrackingProgress($request);
        if (!empty($progress)) {
            $track = array_pop($progress);
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
        $output = array($this->_code => $this->getConfigData('title'));
        $serviceObject = Mage::getSingleton('pedroteixeira_correios/postmethod');
        foreach ($serviceObject->getCollection() as $service) {
            $output[ $service->getMethodCode() ] = "{$service->getMethodCode()} - {$service->getMethodTitle()}";
        }
        return $output;
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
        if (empty($addMethods) || !is_array($addMethods)) {
            return $cServico;
        }
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
     * @param Mage_Shipping_Model_Rate_Request $request Mage request
     *
     * @return PedroTeixeira_Correios_Model_Carrier_CorreiosMethod
     */
    protected function _filterMethodByItemRestriction($request)
    {
        if ($this->getConfigFlag('filter_by_item')) {
            $items = $this->_getRequestItems($request);
            $intersection = $this->_postMethodsExplode;
            foreach ($items as $item) {
                $product         = $this->_getSimpleProduct($item->getProduct());
                $prodPostMethods = explode(
                    ',', $product->getResource()->getAttributeRawValue(
                        $product->getId(), 'postmethods', $request->getStoreId()
                    )
                );
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
        $product = $this->_getSimpleProduct($item->getProduct());
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
     * Some special errors must be sent to users.
     * If not applicable, the default error will be sent.
     *
     * @param array $errorList Error List
     *
     * @return boolean
     */
    protected function _appendShippingErrors($errorList)
    {
        $output = false;
        $successCode = '0';
        $hasValidQuote = array_key_exists($successCode, $errorList);
        if (!$hasValidQuote) {
            $displayErrorList = explode(',', $this->getConfigData('hard_errors'));
            if ($this->getConfigFlag('show_soft_errors')) {
                $softErrorList = explode(',', $this->getConfigData('soft_errors'));
                $displayErrorList = array_merge($displayErrorList, $softErrorList);
            }
            foreach ($errorList as $errorCode => $errorMsg) {
                $isDisplayError = in_array($errorCode, $displayErrorList);
                if ($isDisplayError) {
                    $error = Mage::getModel('shipping/rate_result_error');
                    $error->setCarrier($this->_code);
                    $error->setErrorMessage($errorMsg);
                    $this->_result->append($error);
                    $output = true;
                }
            }
            if (!$output) {
                $logMsg = implode(',', $errorList);
                Mage::log("{$this->_code}: Warning! There is no valid quotes, and no one error was throwed: {$logMsg}");
            }
        }
        return $output;
    }

    /**
     * Returns a short message showing the number of the packs that will be needed.
     *
     * @return string
     */
    protected function _getSplitUpMsg()
    {
        $msg = "";
        if ($this->_splitUp > 0) {
            $qty = pow(2, $this->_splitUp);
            $msg.= " / {$qty} volumes";
        }
        return $msg;
    }

    /**
     * Returns a short warning message.
     *
     * @param string $error Error Id
     *
     * @return string
     */
    protected function _getSoftErrorMsg($error)
    {
        $msg = "";
        if ($this->getConfigFlag('show_soft_errors')) {
            $softErrorList = explode(',', $this->getConfigData('soft_errors'));
            $isSoftError = in_array($error, $softErrorList);
            if ($isSoftError) {
                $msg.= " / Área de Risco";
            }
        }
        return $msg;
    }

    /**
     * Returns the price as float, and fixed by pack division.
     *
     * @param string $price Price String
     *
     * @return float
     */
    protected function _getFormatPrice($price)
    {
        $stringPrice = str_replace('.', '', $price);
        $stringPrice = str_replace(',', '.', $stringPrice);
        $shippingPrice = floatval($stringPrice);
        $shippingPrice *= pow(2, $this->_splitUp);
        return $shippingPrice;
    }

    /**
     * Filter visible and bundle children products.
     *
     * @param array $items Product Items
     *
     * @return array
     */
    protected function _loadBundleChildren($items)
    {
        $visibleAndBundleChildren = array();
        /* @var $item Mage_Sales_Model_Quote_Item */
        foreach ($items as $item) {
            $product = $item->getProduct();
            $isBundle = ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE);
            if ($isBundle) {
                /* @var $child Mage_Sales_Model_Quote_Item */
                foreach ($item->getChildren() as $child) {
                    $visibleAndBundleChildren[] = $child;
                }
            } else {
                $visibleAndBundleChildren[] = $item;
            }
        }
        return $visibleAndBundleChildren;
    }
}
