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
class PedroTeixeira_Correios_Model_Sro extends Varien_Object
{
    const CARRIER_CODE = 'pedroteixeira_correios';
    const ORDER_SHIPPED_STATUS = 'complete_shipped';
    const ORDER_WARNED_STATUS = 'complete_warned';

    /**
     * Request response
     * 
     * @var SimpleXMLElement
     */
    protected $_xml = null;
    
    /**
     * Load all opened tracks from database.
     * Filter tracks only with complete order state, and shipped status.
     * 
     * @return Mage_Sales_Model_Resource_Order_Shipment_Track_Collection
     */
    public function getShippedTracks()
    {
        $trackTable = 'main_table';
        $orderTable = Mage::getModel('sales/order')->getCollection()->getResource()->getTable('sales/order');
        
        /* @var $collection Mage_Sales_Model_Resource_Order_Shipment_Track_Collection */
        $collection = Mage::getModel('sales/order_shipment_track')->getCollection();
        $collection->getSelect()->join($orderTable, "{$trackTable}.order_id = {$orderTable}.entity_id", array());
        $collection
            ->addFieldToFilter("{$trackTable}.carrier_code", self::CARRIER_CODE)
            ->addFieldToFilter("{$orderTable}.state", Mage_Sales_Model_Order::STATE_COMPLETE)
            ->addFieldToFilter("{$orderTable}.status", array('neq' => Mage_Sales_Model_Order::STATE_COMPLETE));
        return $collection;
    }
    
    /**
     * Load XML response from Correios
     * 
     * @param string $trackingCode Tracking Code
     * 
     * @throws Exception
     * 
     * @link http://www.correios.com.br/para-voce/correios-de-a-a-z/pdf/rastreamento-de-objetos/
     * Manual_SROXML_28fev14.pdf
     * @link http://www.corporativo.correios.com.br/encomendas/sigepweb/doc/
     * Manual_de_Implementacao_do_Web_Service_SIGEPWEB_Logistica_Reversa.pdf
     * 
     * @return boolean|PedroTeixeira_Correios_Model_Sro
     */
    public function request($trackingCode)
    {
        $params = array(
            'usuario'   => $this->getConfigData('sro_username'),
            'senha'     => $this->getConfigData('sro_password'),
            'tipo'      => $this->getConfigData('sro_type'),
            'resultado' => $this->getConfigData('sro_result'),
            'lingua'    => $this->getConfigData('sro_language'),
            'objetos'   => $trackingCode,
        );
        
        try {
            $client = new SoapClient($this->getConfigData('url_sro_correios'));
            $response = $client->buscaEventos($params);
            if (empty($response)) {
                throw new Exception("Empty response");
            }
            $this->_xml = $response->return;
        } catch (Exception $e) {
            Mage::log("Soap Error: {$e->getMessage()}");
            return false;
        }
        return $this;
    }
    
    /**
     * Retrieve config value by path
     * 
     * @param string $path Variable Path
     * 
     * @return string
     */
    public function getConfigData($path)
    {
        return Mage::getStoreConfig("carriers/" . self::CARRIER_CODE . "/{$path}");
    }
    
    /**
     * Returns a Shipping comment message
     * 
     * @return string
     */
    public function getComment()
    {
        $code = $this->_xml->objeto->numero;
        $evento = $this->_xml->objeto->evento;
        $msg = array();
        $msg[] = $code;
        $msg[] = "{$evento->cidade}/{$evento->uf}";
        $msg[] = $evento->descricao;
        if (isset($evento->destino) && isset($evento->destino->local)) {
            $last = count($msg) - 1;
            $msg[$last].= " para {$evento->destino->cidade}/{$evento->destino->uf}";
        }
        if (isset($evento->recebedor) && !empty($evento->recebedor)) {
            $msg[] = Mage::helper('pedroteixeira_correios')->__('Recebedor: %s', $evento->recebedor);
        }
        if (isset($evento->comentario) && !empty($evento->comentario)) {
            $msg[] = Mage::helper('pedroteixeira_correios')->__('Comentário: %s', $evento->comentario);
        }
        $msg[] = Mage::helper('pedroteixeira_correios')->__('Evento: %s', "{$evento->tipo}/{$evento->status}");
        return implode(' | ', $msg);
    }
    
    /**
     * Returns an Update Shipping e-mail comment
     * 
     * @return string
     */
    public function getEmailComment()
    {
        $trackUrl = $this->getConfigData('url_tracking');
        $code = $this->_xml->objeto->numero;
        $evento = $this->_xml->objeto->evento;
        $htmlAnchor = "<a href=\"{$trackUrl}?P_LINGUA=001&P_TIPO=001&P_COD_UNI={$code}\">{$code}</a>";
        $msg = array();
        $msg[] = Mage::helper('pedroteixeira_correios')->__('Rastreador: %s', $htmlAnchor);
        $msg[] = Mage::helper('pedroteixeira_correios')->__('Local: %s', "{$evento->cidade}/{$evento->uf}");
        $msg[] = Mage::helper('pedroteixeira_correios')->__('Situação: %s', $evento->descricao);
        if (isset($evento->recebedor) && !empty($evento->recebedor)) {
            $msg[] = Mage::helper('pedroteixeira_correios')->__('Recebedor: %s', $evento->recebedor);
        }
        if (isset($evento->comentario) && !empty($evento->comentario)) {
            $msg[] = Mage::helper('pedroteixeira_correios')->__('Comentário: %s', $evento->comentario);
        }
        if (isset($evento->destino)) {
            $destino = $evento->destino;
            $msg[] = Mage::helper('pedroteixeira_correios')->__('Destino: %s', "{$destino->cidade}/{$destino->uf}");
        }
        return implode('<br />', $msg);
    }
    
    /**
     * Check the event type
     * 
     * @param string $mode Event Type Mode
     * 
     * @return boolean
     */
    public function validate($mode)
    {
        $isValid = false;
        $evento = $this->_xml->objeto->evento;
        $hashTypes = explode(',', $this->getConfigData("sro_event_type_{$mode}"));
        if (in_array($evento->tipo, $hashTypes)) {
            $type = strtolower($evento->tipo);
            $hashStatus = explode(',', $this->getConfigData("sro_event_status_{$mode}_{$type}"));
            $isValid = in_array((int) $evento->status, $hashStatus);
        }
        return $isValid;
    }
    
    /**
     * Track Description field are now being used to save the event id.
     * Event Id is a simple key to identify the last carrier event.
     * 
     * @return string
     */
    public function getEventId()
    {
        $code = $this->_xml->objeto->numero;
        $date = $this->_xml->objeto->evento->data;
        $hour = $this->_xml->objeto->evento->hora;
        $type = $this->_xml->objeto->evento->tipo;
        return "{$code}::{$date}{$hour}::{$type}";
    }
    
    /**
     * Check whether event notify is enabled or not
     * 
     * @return boolean
     */
    public function isNotify()
    {
        return $this->validate('notify');
    }
    
    /**
     * Load order status based on event checking
     * 
     * @return string
     */
    public function getStatus()
    {
        $status = self::ORDER_SHIPPED_STATUS;
        if ($this->validate('warn')) {
            $status = self::ORDER_WARNED_STATUS;
        }
        if ($this->validate('last')) {
            $status = Mage_Sales_Model_Order::STATE_COMPLETE;
        }
        return $status;
    }
}
