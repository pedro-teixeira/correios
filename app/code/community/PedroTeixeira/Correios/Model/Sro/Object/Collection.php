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
class PedroTeixeira_Correios_Model_Sro_Object_Collection extends Varien_Data_Collection
{
    
    /**
     * Saves a tracking collection
     *
     * @return int
     */
    public function save()
    {
        Mage::log("PedroTeixeira_Correios_Model_Sro_Object_Collection::save");
        $tracksTxn = Mage::getModel('core/resource_transaction');
        $ordersTxn = Mage::getModel('core/resource_transaction');
        $shipmentsTxn = Mage::getModel('core/resource_transaction');
        
        foreach ($this->load() as $item) {
            /* @var $item PedroTeixeira_Correios_Model_Sro_Object */
            $track = $item->getTrack();
            $tracksTxn->addObject($track->setDescription($item->getEventId()));
            $ordersTxn->addObject(
                $track->getShipment()->getOrder()->addStatusToHistory($item->getStatus())
            );
            $shipmentsTxn->addObject($track->getShipment());
        }
        
        if ($this->count()) {
            try {
                $tracksTxn->save();
                $ordersTxn->save();
                $shipmentsTxn->save();
            } catch (Exception $e) {
                Mage::logException($e);
                return new Varien_Data_Collection();
            }
        }
        
        return $this;
    }
    
    /**
     * Send tracking information by e-mail
     *
     * @return boolean
     */
    public function sendEmail()
    {
        foreach ($this->load() as $item) {
            /* @var $item PedroTeixeira_Correios_Model_Sro_Object */
            try {
                $shipment = $item->getTrack()->getShipment();
                $shipment->addComment($item->getComment(), $item->isNotifyAllowed(), true)
                    ->save();
                $shipment->sendUpdateEmail($item->isNotifyAllowed(), $item->getEmailComment());
            } catch (Exception $e) {
                Mage::logException($e);
                return new Varien_Data_Collection();
            }
        }
        
        return $this;
    }
}
