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
    
    public function sroDelayedDeliveryJob()
    {
        $message = "SRO Delayed Delivery Job disabled.";
        
        if (Mage::helper('pedroteixeira_correios')->getConfigData('sro_delayed_job') == 1) {
            $delayedObjects = Mage::getModel('pedroteixeira_correios/sro_object_collection');
            $sro = Mage::getModel('pedroteixeira_correios/sro');
            $config = $sro->getConfig();
            $config->resultado = 'T';
            
            $sro->setConfig($config)
                ->removeInvalidItens()
                ->removeHistoryStatusFilter()
                ->request();
            
            foreach ($sro->getResponseCollection() as $item) {
                if ($item->isValid() && $item->isDeliveryDelayed()) {
                    $delayedObjects->addItem($item);
                }
            }
            
            if ($delayedObjects->saveDelayed()) {
                $sro->setLog("{$delayedObjects->count()} saved of {$sro->getLog()}");
            }
            
            $message = "{$sro->getLog()}. See logs for details.";
        }
        
        return $message;
    }
    
    /**
     * Look for shipped trackings, and send notifications if available and enabled
     *
     * @return string
     */
    public function sroTrackingJob()
    {
        $message = "SRO Tracking Job disabled.";
        if (Mage::helper('pedroteixeira_correios')->getConfigData('sro_tracking_job') == 1) {
            $movedObjects = Mage::getModel('pedroteixeira_correios/sro_object_collection');
            $sro = Mage::getModel('pedroteixeira_correios/sro');
            $sro->removeInvalidItens()
                ->request();
            
            foreach ($sro->getResponseCollection() as $item) {
                if ($item->isValid() && $item->isMoving()) {
                    $movedObjects->addItem($item);
                }
            }
            
            if ($movedObjects->save()) {
                $sro->setLog("{$movedObjects->count()} saved of {$sro->getLog()}");
                if ($movedObjects->sendEmail()) {
                    $sro->setLog("{$movedObjects->count()} notified of {$sro->getLog()}");
                }
            }
            
            $message = "{$sro->getLog()}. See logs for details.";
        }
        
        return $message;
    }
    
    public function exportPlpOption(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
        $isSaleGrid = ($block instanceof Mage_Adminhtml_Block_Widget_Grid_Massaction);
        $isSaleGrid&= ($block->getRequest()->getControllerName() == 'sales_shipment');
        
        if ($isSaleGrid) {
            $block->addItem('request_plp', array(
                'label' => 'Enviar PLP (Correios)',
                'url' => $block->getUrl('*/sigepweb/requestPlp')
            ));
        }
    }
}
