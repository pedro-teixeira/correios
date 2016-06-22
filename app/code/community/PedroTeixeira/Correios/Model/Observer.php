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
class PedroTeixeira_Correios_Model_Observer
{
    /**
     * Look for shipped trackings, and send notifications if available and enabled
     * 
     * @return string
     */
    public function sroTrackingJob()
    {
        $count = 0;
        /* @var $sro PedroTeixeira_Correios_Model_Sro */
        $sro = Mage::getModel('pedroteixeira_correios/sro');
        if ($sro->getConfigData('sro_tracking_job') == 0) {
            return "SRO Tracking Job disabled.";
        }
        
        $collection = $sro->getShippedTracks();
        foreach ($collection as $track) {
            /* @var $track Mage_Sales_Model_Order_Shipment_Track */
            if ($sro->request($track->getNumber())) {
                $savedId = $track->getDescription();
                $eventId = $sro->getEventId();
                if ($eventId != $savedId) {
                    $track->setDescription($eventId)->save();
                    $track->getShipment()->getOrder()
                        ->setStatus($sro->getStatus())
                        ->save();
                    $track->getShipment()
                        ->addComment($sro->getComment(), $sro->isNotify(), true)
                        ->sendUpdateEmail($sro->isNotify(), $sro->getEmailComment())
                        ->save();
                    $count++;
                }
            }
        }
        return "Tracked {$count} objects of {$collection->getSize()}.";
    }
}
