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

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$status = Mage::getModel('sales/order_status');
$status->setStatus(PedroTeixeira_Correios_Model_Sro::ORDER_SHIPPED_STATUS)
    ->setLabel('Pedido em Transporte')
    ->assignState(Mage_Sales_Model_Order::STATE_COMPLETE)
    ->save();

$status = Mage::getModel('sales/order_status');
$status->setStatus(PedroTeixeira_Correios_Model_Sro::ORDER_WARNED_STATUS)
    ->setLabel('Dificuldade de Entrega')
    ->assignState(Mage_Sales_Model_Order::STATE_COMPLETE)
    ->save();

$installer->endSetup();
