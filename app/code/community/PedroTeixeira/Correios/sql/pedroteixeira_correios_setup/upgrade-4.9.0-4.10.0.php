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

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

Mage::log('Correios Extension Upgrade started..', null, '', true);

$db = $installer->getConnection();
$table = $installer->getTable('sales/order');
$replaceExpr = $db->quoteInto('REPLACE(shipping_method, ?', 'pedroteixeira_correios');
$replaceExpr.= $db->quoteInto(', ?)', 'correios');
$bind  = array('shipping_method' => new Zend_Db_Expr($replaceExpr));
$where = array('shipping_method LIKE ?' => '%pedroteixeira_correios%');
$count = $db->update($table, $bind, $where);

if (empty($count)) {
    Mage::log('No matched orders found', null, '', true);
} else {
    Mage::log($count . ' orders updated with success', null, '', true);
}

/* @var $collection Mage_Sales_Model_Resource_Order_Shipment_Track_Collection */
$trackCollection = Mage::getModel('sales/order_shipment_track')->getCollection();
$trackCollection->addFieldToFilter('carrier_code', 'pedroteixeira_correios');
$count = 0;
/* @var $track Mage_Sales_Model_Order_Shipment_Track */
foreach ($trackCollection as $track) {
    $track->setCarrierCode('correios');
    try {
        $track->save();
        $count++;
    } catch (Exception $e) {
        Mage::log('Cant update track ' . $track->getId() . ': ' . $e->getMessage(), null, '', true);
    }
}
Mage::log($count . ' tracking codes updated with success', null, '', true);

$count = 0;
$ruleCollection = Mage::getModel('salesrule/rule')->getCollection();
$ruleCollection->addFieldToFilter('conditions_serialized', array('like' => '%pedroteixeira_correios%'));
foreach ($ruleCollection as $rule) {
    $value = $rule->getConditionsSerialized();
    $value = str_replace('pedroteixeira_correios', 'correios', $value);
    $rule->setConditionsSerialized($value);
    try {
        $rule->save();
    } catch (Exception $e) {
        Mage::log('Cant update cart rule ' . $rule->getId() . ': ' . $e->getMessage(), null, '', true);
    }
}
Mage::log($count . ' cart rules updated with success', null, '', true);

Mage::log('Correios Extension Upgrade ended', null, '', true);

$installer->endSetup();
