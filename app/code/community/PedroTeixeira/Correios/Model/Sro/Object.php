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
 * @method Mage_Sales_Model_Order_Shipment_Track getTrack()
 * @method PedroTeixeira_Correios_Model_Sro_Object setTrack(Mage_Sales_Model_Order_Shipment_Track $track)
 * @method Correios_Rastro_Objeto getInfo()
 * @method PedroTeixeira_Correios_Model_Sro_Object setInfo(Correios_Rastro_Objeto $info)
 */
class PedroTeixeira_Correios_Model_Sro_Object extends Varien_Object
{
    const ORDER_SHIPPED_STATUS = 'complete_shipped';
    const ORDER_WARNED_STATUS = 'complete_warned';
    
    /**
     * Check the event type
     *
     * @param string $mode Event Type Mode
     *
     * @return boolean
     */
    private function _isValidEventType($mode)
    {
        $isValid = false;
        $helper = Mage::helper('pedroteixeira_correios');
        $info = $this->getInfo();
        $evento = $info->evento;
        $hashTypes = explode(',', $helper->getConfigData("sro_event_type_{$mode}"));
        if (in_array($evento->tipo, $hashTypes)) {
            $type = strtolower($evento->tipo);
            $hashStatus = explode(',', $helper->getConfigData("sro_event_status_{$mode}_{$type}"));
            $isValid = in_array((int) $evento->status, $hashStatus);
        }
        return $isValid;
    }
    
    /**
     * @param string $type
     *
     * @return Correios_Rastro_Eventos
     */
    private function _getEventByType($type)
    {
        $return = false;
        
        foreach ((array)$this->getInfo()->evento as $evento) {
            if (isset($evento->tipo) && ($evento->tipo == $type)) {
                $return = $evento;
                break;
            }
        }
        
        return $return;
    }
    
    public function isValid()
    {
        $response = true;
        $info = $this->getInfo();
        
        if (isset($info->erro)) {
            $response = false;
            Mage::logException(new Exception("{$info->numero}: {$info->erro}"));
        }
        
        return $response;
    }
    
    /**
     * Track Description field are now being used to save the event id.
     * Event Id is a simple key to identify the last carrier event.
     *
     * @return string
     */
    public function getEventId()
    {
        $info = $this->getInfo();
        if ($code = $info->numero) {
            if ($evt = $info->evento) {
                $date = isset($evt->data) ? $evt->data : '';
                $hour = isset($evt->hora) ? $evt->hora : '';
                $type = isset($evt->tipo) ? $evt->tipo : '';
                return "{$code}::{$date}{$hour}::{$type}";
            }
        }
        return false;
    }
    
    /**
     * Load order status based on event checking
     *
     * @return string
     */
    public function getStatus()
    {
        $info = $this->getInfo();
        $status = self::ORDER_SHIPPED_STATUS;
        
        if ($this->_isValidEventType('warn')) {
            $status = self::ORDER_WARNED_STATUS;
        }
        
        if ($this->_isValidEventType('last')) {
            $status = Mage_Sales_Model_Order::STATE_COMPLETE;
        }
        
        return $status;
    }
    
    /**
     * Check whether event notify is enabled or not
     *
     * @return boolean
     */
    public function isNotifyAllowed()
    {
        return $this->_isValidEventType('notify');
    }
    
    /**
     * Returns a Shipping comment message
     *
     * @return string
     */
    public function getComment()
    {
        $helper = Mage::helper('pedroteixeira_correios');
        $info = $this->getInfo();
        $code = $info->numero;
        $evento = $info->evento;
        $msg = array();
        $msg[] = $code;
        $msg[] = "{$evento->cidade}/{$evento->uf}";
        $msg[] = $evento->descricao;
        if (isset($evento->destino) && isset($evento->destino->local)) {
            $last = count($msg) - 1;
            $msg[$last].= " para {$evento->destino->cidade}/{$evento->destino->uf}";
        }
        if (isset($evento->recebedor) && !empty($evento->recebedor)) {
            $msg[] = $helper->__('Recebedor: %s', $evento->recebedor);
        }
        if (isset($evento->comentario) && !empty($evento->comentario)) {
            $msg[] = $helper->__('Comentário: %s', $evento->comentario);
        }
        $msg[] = $helper->__('Evento: %s', "{$evento->tipo}/{$evento->status}");
        return implode(' | ', $msg);
    }
    
    /**
     * Returns an Update Shipping e-mail comment
     *
     * @return string
     */
    public function getEmailComment()
    {
        $helper = Mage::helper('pedroteixeira_correios');
        $info = $this->getInfo();
        $trackUrl = Mage::helper('shipping')->getTrackingPopupUrlBySalesModel($this->getTrack());
        $code = $info->numero;
        $evento = $info->evento;
        $htmlAnchor = "<a href=\"{$trackUrl}\">{$code}</a>";
        $msg = array();
        $msg[] = $helper->__('Rastreador: %s', $htmlAnchor);
        $msg[] = $helper->__('Local: %s', "{$evento->cidade}/{$evento->uf}");
        $msg[] = $helper->__('Situação: %s', $evento->descricao);
        if (isset($evento->recebedor) && !empty($evento->recebedor)) {
            $msg[] = $helper->__('Recebedor: %s', $evento->recebedor);
        }
        if (isset($evento->comentario) && !empty($evento->comentario)) {
            $msg[] = $helper->__('Comentário: %s', $evento->comentario);
        }
        if (isset($evento->destino)) {
            $destino = $evento->destino;
            $msg[] = $helper->__('Destino: %s', "{$destino->cidade}/{$destino->uf}");
        }
        return implode('<br />', $msg);
    }
    
    public function isMoving()
    {
        $savedId = $this->getTrack()->getDescription();
        $eventId = $this->getEventId();
        $response = ($eventId != $savedId);
        
        if ($response) {
            Mage::log("{$this->getInfo()->numero}: is moving");
        }
        
        return $response;
    }
}
