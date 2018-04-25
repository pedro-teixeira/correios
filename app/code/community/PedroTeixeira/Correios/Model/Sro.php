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
 * @method Mage_Sales_Model_Resource_Order_Shipment_Track_Collection getRequestCollection()
 * @method PedroTeixeira_Correios_Model_Sro setRequestCollection(
 *      Mage_Sales_Model_Resource_Order_Shipment_Track_Collection $collection)
 * @method Correios_Rastro_BuscaEventosResponse getResponse()
 * @method PedroTeixeira_Correios_Model_Sro setResponse(Correios_Rastro_BuscaEventosResponse $response)
 * @method Correios_Rastro_BuscaEventos getConfig()
 * @method PedroTeixeira_Correios_Model_Sro setConfig(Correios_Rastro_BuscaEventos $config)
 * @method PedroTeixeira_Correios_Model_Sro_Object[] getResponseCollection()
 * @method PedroTeixeira_Correios_Model_Sro setResponseCollection(
 *      PedroTeixeira_Correios_Model_Sro_Object[] $collection)
 * @method string getLog()
 */
class PedroTeixeira_Correios_Model_Sro extends Varien_Object
{
    const CARRIER_CODE = 'pedroteixeira_correios';
    
    /**
     * Load all opened tracks from database.
     * Filter tracks only with complete order state, and shipped status.
     *
     * @return PedroTeixeira_Correios_Model_Sro
     */
    public function _construct()
    {
        $this->setConfig(
            new Correios_Rastro_BuscaEventos(
                $this->helper()->getConfigData('sro_username'),
                $this->helper()->getConfigData('sro_password'),
                $this->helper()->getConfigData('sro_type'),
                $this->helper()->getConfigData('sro_result'),
                $this->helper()->getConfigData('sro_language'),
                null
            )
        );
    
        $statusAllowed = explode(',', $this->helper()->getConfigData('sro_status_tracking_allowed'));
        $trackTable = 'main_table';
        $orderTable = Mage::getModel('sales/order')->getCollection()->getResource()->getTable('sales/order');
        
        /* @var $collection Mage_Sales_Model_Resource_Order_Shipment_Track_Collection */
        $collection = Mage::getModel('sales/order_shipment_track')->getCollection();
        $collection->getSelect()->join($orderTable, "{$trackTable}.order_id = {$orderTable}.entity_id", array());
        $collection
            ->addFieldToFilter("{$trackTable}.carrier_code", self::CARRIER_CODE)
            ->addFieldToFilter("{$orderTable}.state", Mage_Sales_Model_Order::STATE_COMPLETE)
            ->addFieldToFilter("{$orderTable}.status", array('in' => $statusAllowed));
        
        $this->setLog("{$collection->load()->count()} loaded");
        return $this->setRequestCollection($collection);
    }
    
    /**
     * Load response from Correios to Magento tracking objects
     *
     * @return PedroTeixeira_Correios_Model_Sro
     */
    private function _loadResponse()
    {
        $sroObjects = Mage::getModel('pedroteixeira_correios/sro_object_collection');
        $trackList = $this->getRequestCollection();
        $response = $this->getResponse();
        
        if (isset($response->return) && $response->return->qtd > 0) {
            foreach ((array)$response->return->objeto as $obj) {
                $track = $trackList->getItemByColumnValue('number', $obj->numero);
                if ($track) {
                    $item = Mage::getModel('pedroteixeira_correios/sro_object');
                    $item->setTrack($track)
                        ->setInfo($obj);
                    $sroObjects->addItem($item);
                } else {
                    Mage::log("Cant locate track for {$obj->numero}");
                }
            }
        }
        
        $this->setLog("{$sroObjects->count()} identified of {$this->getLog()}");
        
        return $this->setResponseCollection($sroObjects);
    }
    
    /**
     * Send the tracking list request to Correios
     *
     * @throws Exception
     *
     * @link http://www.correios.com.br/para-voce/correios-de-a-a-z/pdf/rastreamento-de-objetos/
     * Manual_SROXML_28fev14.pdf
     * @link http://www.corporativo.correios.com.br/encomendas/sigepweb/doc/
     * Manual_de_Implementacao_do_Web_Service_SIGEPWEB_Logistica_Reversa.pdf
     *
     * @return PedroTeixeira_Correios_Model_Sro
     */
    private function _loadRequest()
    {
        $trackList = $this->getRequestCollection();
        
        if ($trackList->count()) {
            $config = $this->getConfig();
            $config->objetos = preg_replace('/[^0-9A-Za-z]/', '', implode('', $trackList->getColumnValues('number')));
            Mage::log($config->objetos);
            
            $client = new Correios_Rastro(
                Mage::helper('pedroteixeira_correios')->getStreamContext(),
                $this->helper()->getConfigData('url_sro_correios')
            );
            $response = $client->buscaEventos($config);
            $this->setResponse($response);
        }
        
        $this->setLog("{$trackList->count()} sent of {$this->getLog()}");
        
        return $this;
    }
    
    public function request()
    {
        try {
            $this->_loadRequest();
            $this->_loadResponse();
        } catch (Exception $e) {
            Mage::logException($e);
        }
        
        return $this;
    }
    
    /**
     *
     * @return Pedroteixeira_Correios_Helper_Data
     */
    public function helper()
    {
        return Mage::helper('pedroteixeira_correios');
    }
    
    /**
     * Validates the tracking code
     *
     * @param string $trackNumber Tracking Code
     *
     * @return boolean
     */
    public function validateTrackNumber($trackNumber)
    {
        return preg_match('/^[a-zA-Z]{2}[0-9]{9}[a-zA-Z]{2}$/', $trackNumber);
    }
    
    /**
     * Restricts the collection to not retrieve orders that contains a status in its history
     *
     * @return PedroTeixeira_Correios_Model_Sro
     */
    public function removeHistoryStatusFilter()
    {
        $status = $this->helper()->getConfigData('sro_status_delayed');
        $trackList = $this->getRequestCollection();
        
        foreach ($trackList as $key => $track) {
            foreach ($track->getShipment()->getOrder()->getAllStatusHistory() as $history) {
                if ($status == $history->getData('status')) {
                    Mage::log("{$track->getNumber()}: history found ({$status}) / ignored status");
                    $trackList->removeItemByKey($key);
                    break;
                }
            }
        }
        
        $this->setLog("{$trackList->count()} never-delayed of {$this->getLog()}");
        return $this->setRequestCollection($trackList);
    }
    
    public function removeInvalidItens()
    {
        $tracks = $this->getRequestCollection();
        
        foreach ($tracks as $key => $track) {
            $code = trim($track->getNumber());
            if (!$this->validateTrackNumber($code)) {
                $tracks->removeItemByKey($key);
                Mage::log("{$code}: invalid tracking code");
            } else {
                $track->setNumber($code);
            }
        }
        
        $this->setLog("{$tracks->count()} validated of {$this->getLog()}");
        return $this->setRequestCollection($tracks);
    }
    
    public function setLog($message)
    {
        Mage::log($message);
        return parent::setLog($message);
    }
}
