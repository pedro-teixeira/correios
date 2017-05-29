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
        $message = "SRO Tracking Job disabled.";
        if (Mage::helper('pedroteixeira_correios')->getConfigData('sro_tracking_job') == 0) {
            return $message;
        }
        
        $message = "No tracking updates";
        $count = 0;
        $countTrack = 0;
        $trackList = array();
        $sro = Mage::getModel('pedroteixeira_correios/sro')->init();
        $response = $sro->request();
        
        if ($response && $response->return->qtd > 0) {
            $tracksTxn = Mage::getModel('core/resource_transaction');
            $ordersTxn = Mage::getModel('core/resource_transaction');
            $shipmentsTxn = Mage::getModel('core/resource_transaction');
            foreach ($response->return->objeto as $obj) {
                if (isset($obj->erro)) {
                    Mage::log("{$obj->numero}: {$obj->erro}");
                    continue;
                }
                
                if ($track = $sro->getTrack($obj)) {
                    $savedId = $track->getDescription();
                    $eventId = $sro->getEventId($obj);
                    if ($eventId != $savedId) {
                        $status = $sro->getStatus($obj);
                        $notify = $sro->isNotify($obj);
                        $comment = $sro->getComment($obj);
                        $mailComment = $sro->getEmailComment($obj, $track);
                        $tracksTxn->addObject(
                            $track->setDescription($eventId)
                        );
                        $ordersTxn->addObject(
                            $track->getShipment()->getOrder()->setStatus($status)
                        );
                        $shipmentsTxn->addObject(
                            $track->getShipment()
                                ->addComment($comment, $notify, true)
                                ->sendUpdateEmail($notify, $mailComment)
                        );
                        Mage::log("{$obj->numero}: saving scheduled");
                        $count++;
                    }
                }
                $countTrack++;
            }
            
            if ($count) {
                try {
                    $tracksTxn->save();
                    $ordersTxn->save();
                    $shipmentsTxn->save();
                    $message = "Updated {$count} objects of {$countTrack} tracked.";
                } catch (Exception $e) {
                    $message = $e->getMessage();
                }
            }
        }
        
        Mage::log($message);
        return $message;
    }
}
