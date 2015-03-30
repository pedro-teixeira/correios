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

// Delete unused or edited config data
$installer->deleteConfigData('carriers/pedroteixeira_correios/ignorar_erro');
$installer->deleteConfigData('carriers/pedroteixeira_correios/correioserror');
$installer->deleteConfigData('carriers/pedroteixeira_correios/maxweighterror');
$installer->deleteConfigData('carriers/pedroteixeira_correios/valueerror');
$installer->deleteConfigData('carriers/pedroteixeira_correios/showmethod');

$installer->endSetup();
