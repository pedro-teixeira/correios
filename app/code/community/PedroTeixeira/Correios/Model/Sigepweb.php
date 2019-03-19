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
 *
 * @method PedroTeixeira_Correios_Model_Sigepweb setRequest(Mage_Shipping_Model_Shipment_Request $request)
 * @method PedroTeixeira_Correios_Model_Sigepweb setUsername(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb setPassword(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb setContract(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb setCard(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb setVatNumber(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb setUrl(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb setMethodId(int $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb setQty(int $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb setAdminCode(string $value)
 * @method Mage_Shipping_Model_Shipment_Request getRequest()
 * @method string getUsername()
 * @method string getPassword()
 * @method string getContract()
 * @method string getCard()
 * @method string getVatNumber()
 * @method string getUrl()
 * @method int getMethodId()
 * @method int getQty()
 * @method string getAdminCode()
 */
class PedroTeixeira_Correios_Model_Sigepweb extends Mage_Core_Model_Abstract
{

    /**
     * {@inheritDoc}
     * @see Varien_Object::_construct()
     */
    public function _construct()
    {
        $timeout = (int)$this->helper()->getConfigData('ws_timeout');
        $defaultTimeout = (int)ini_get('default_socket_timeout');
        ini_set('default_socket_timeout', max($timeout, $defaultTimeout));
        
        $vat = Mage::getStoreConfig('general/store_information/merchant_vat_number');
        $vat = preg_replace('/\D/', '', $vat);
        $this->setVatNumber($vat)
            ->setUsername($this->helper()->getConfigData('sigepweb_username'))
            ->setPassword($this->helper()->getConfigData('sigepweb_password'))
            ->setContract($this->helper()->getConfigData('sigepweb_contract_code'))
            ->setCard($this->helper()->getConfigData('sigepweb_card_code'))
            ->setAdminCode($this->helper()->getConfigData('cod_admin'))
            ->setUrl($this->helper()->getConfigData('url_sigepweb'));
        
        return $this;
    }
    
    private function _loadParams()
    {
        if ($request = $this->getRequest()) {
            if ($shipMethod = $request->getShippingMethod()) {
                $methodCode = preg_replace('/\D/', '', $shipMethod);
                $postmethod = Mage::getModel('pedroteixeira_correios/postmethod')->load($methodCode, 'method_code');
                $this->setMethodId($postmethod->getMethodId());
            }
            if ($packages = $request->getPackages()) {
                $this->setQty(count($packages));
            }
        }
        
        return $this;
    }
    
    /**
     * Retrieve the module helper
     *
     * @return Pedroteixeira_Correios_Helper_Data
     */
    public function helper()
    {
        return Mage::helper('pedroteixeira_correios');
    }
    
    /**
     * Request Correios service codes using configuration fields
     *
     * @return SimpleXMLElement
     */
    public function getBuscaCliente()
    {
        $params = array(
            'idContrato'       => $this->getContract(),
            'idCartaoPostagem' => $this->getCard(),
            'usuario'          => $this->getUsername(),
            'senha'            => $this->getPassword(),
        );
        $client = new SoapClient($this->getUrl(), $this->helper()->getStreamContext());
        return $client->buscaCliente($params);
    }
    
    /**
     * @return Correios_Sigep_SolicitaEtiquetasResponse
     */
    public function requestLabel()
    {
        $this->_loadParams();
        $params = new Correios_Sigep_SolicitaEtiquetas(
            'C',
            $this->getVatNumber(),
            $this->getMethodId(),
            $this->getQty(),
            $this->getUsername(),
            $this->getPassword()
        );
        Mage::log(print_r($params, true));
        $client = new Correios_Sigep_AtendeClienteService($this->helper()->getStreamContext(), $this->getUrl());
        return $client->solicitaEtiquetas($params);
    }
    
    /**
     * @return Varien_Object
     */
    public function requestShipment()
    {
        $info = new Varien_Object();
        $params = new Correios_Sigep_FechaPlpVariosServicos(
            $this->getXml(),
            $this->getIdPlpCliente(),
            $this->getCard(),
            $this->getListaEtiquetas(),
            $this->getUsername(),
            $this->getPassword()
        );
        
        try {
            $client = new Correios_Sigep_AtendeClienteService($this->helper()->getStreamContext(), $this->getUrl());
            $response = $client->fechaPlpVariosServicos($params);
            if (isset($response->return)) {
                $info->setPlpId((string)$response->return);
            } else {
                $info->setError(print_r($response, true));
            }
        } catch (Exception $e) {
            $info->setError($e->getMessage());
        }
        
        return $info;
    }
    
    /**
     * @return Varien_Object
     */
    public function requestXml()
    {
        $info = new Varien_Object();
        $params = new Correios_Sigep_SolicitaXmlPlp(
            $this->getPlpId(),
            $this->getUsername(),
            $this->getPassword()
        );
        
        try {
            $client = new Correios_Sigep_AtendeClienteService($this->helper()->getStreamContext(), $this->getUrl());
            $response = $client->solicitaXmlPlp($params);
            if (isset($response->return)) {
                $info->setXml((string)$response->return);
            } else {
                $info->setError(print_r($response, true));
            }
        } catch (Exception $e) {
            $info->setError($e->getMessage());
        }
        
        return $info;
    }
    
    public function requestShippingRate()
    {
        $info = new Varien_Object();
        $parameters = new Correios_Sigep_CalculaTarifaServico(
            $this->getAdminCode(),
            $this->getUsername(),
            $this->getPassword(),
            $this->getData('codServico'),
            $this->getData('cepOrigem'),
            $this->getData('cepDestino'),
            $this->getData('peso'),
            $this->getData('codFormato'),
            $this->getData('comprimento'),
            $this->getData('altura'),
            $this->getData('largura'),
            $this->getData('diametro'),
            $this->getData('codMaoPropria'),
            $this->getData('valorDeclarado'),
            $this->getData('codAvisoRecebimento')
        );
        
        try {
            $client = new Correios_Sigep_AtendeClienteService($this->helper()->getStreamContext(), $this->getUrl());
            $response = $client->calculaTarifaServico($parameters);
            if (isset($response->return)) {
                $info->setRate((string)$response->return);
            } else {
                $info->setError(print_r($response, true));
            }
        } catch (Exception $e) {
            $info->setError($e->getMessage());
        }
        
        return $info;
    }
}
