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
    
    protected $_trackList = array();
    
    /**
     * Retrieves all valid tracking codes
     *
     * @return PedroTeixeira_Correios_Model_Sro
     */
    public function init()
    {
        $collection = $this->getShippedTracks();
        foreach ($collection as $track) {
            if ($this->validateTrackNumber($track->getNumber())) {
                $this->_trackList[$track->getNumber()] = $track;
                continue;
            }
            Mage::log("{$track->getNumber()}: invalid tracking code");
        }
        return $this;
    }

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
     * @throws Exception
     *
     * @link http://www.correios.com.br/para-voce/correios-de-a-a-z/pdf/rastreamento-de-objetos/
     * Manual_SROXML_28fev14.pdf
     * @link http://www.corporativo.correios.com.br/encomendas/sigepweb/doc/
     * Manual_de_Implementacao_do_Web_Service_SIGEPWEB_Logistica_Reversa.pdf
     *
     * @return boolean|Correios_Rastro_BuscaEventosResponse
     */
    public function request()
    {
        $response = false;
        if (count($this->_trackList)) {
            $trackingCodes = implode('', array_keys($this->_trackList));
            $params = new Correios_Rastro_BuscaEventos(
                $this->getConfigData('sro_username'),
                $this->getConfigData('sro_password'),
                $this->getConfigData('sro_type'),
                $this->getConfigData('sro_result'),
                $this->getConfigData('sro_language'),
                $trackingCodes
            );
            Mage::log(print_r($params, true));
            
            try {
                $client = new Correios_Rastro(
                    Mage::helper('pedroteixeira_correios')->getStreamContext(),
                    $this->getConfigData('url_sro_correios')
                );
                $response = $client->buscaEventos($params);
                if (empty($response)) {
                    throw new Exception("Empty response");
                }
            } catch (Exception $e) {
                Mage::log("Soap Error: {$e->getMessage()}");
            }
        }
        return $response;
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
     * @param Correios_Rastro_Objeto $obj Response Object
     *
     * @return string
     */
    public function getComment($obj)
    {
        $code = $obj->numero;
        $evento = $obj->evento;
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
     * @param Correios_Rastro_Objeto                $obj   Response Object
     * @param Mage_Sales_Model_Order_Shipment_Track $track Tracking instance
     *
     * @return string
     */
    public function getEmailComment($obj, $track)
    {
        $trackUrl = Mage::helper('shipping')->getTrackingPopupUrlBySalesModel($track);
        $code = $obj->numero;
        $evento = $obj->evento;
        $htmlAnchor = "<a href=\"{$trackUrl}\">{$code}</a>";
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
     * @param Correios_Rastro_Objeto $obj  Response Object
     * @param string                 $mode Event Type Mode
     *
     * @return boolean
     */
    public function validate($obj, $mode)
    {
        $isValid = false;
        $evento = $obj->evento;
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
     * @param Correios_Rastro_Objeto $obj Response Object
     *
     * @return string
     */
    public function getEventId($obj)
    {
        if ($obj->numero && $obj->evento) {
            $code = $obj->numero;
            $date = $obj->evento->data;
            $hour = $obj->evento->hora;
            $type = $obj->evento->tipo;
            return "{$code}::{$date}{$hour}::{$type}";
        }
        return false;
    }
    
    /**
     * Check whether event notify is enabled or not
     *
     * @param Correios_Rastro_Objeto $obj Response Object
     *
     * @return boolean
     */
    public function isNotify($obj)
    {
        return $this->validate($obj, 'notify');
    }
    
    /**
     * Load order status based on event checking
     *
     * @param Correios_Rastro_Objeto $obj Response Object
     *
     * @return string
     */
    public function getStatus($obj)
    {
        $status = self::ORDER_SHIPPED_STATUS;
        if ($this->validate($obj, 'warn')) {
            $status = self::ORDER_WARNED_STATUS;
        }
        if ($this->validate($obj, 'last')) {
            $status = Mage_Sales_Model_Order::STATE_COMPLETE;
        }
        return $status;
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
     * Retrieves the tracking instance
     *
     * @param Correios_Rastro_Objeto $obj Return Object
     *
     * @throws Exception
     *
     * @return Mage_Sales_Model_Order_Shipment_Track
     */
    public function getTrack($obj)
    {
        $track = $this->_trackList[$obj->numero];
        if (!($desc = $track->getDescription())) {
            Mage::log("{$obj->numero}: tracking instance missed. Trying to reload");
            try {
                $track = Mage::getModel('sales/order_shipment_track')->load($obj->numero, 'track_number');
            } catch (Exception $e) {
                Mage::log("{$obj->numero}: {$e->getMessage()}");
            }
        }
        return $track;
    }
}
