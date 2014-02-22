<?php
/**
 * This source file is subject to the MIT License.
 * It is also available through http://opensource.org/licenses/MIT
 *
 * @category   PedroTeixeira
 * @package    PedroTeixeira_Correios
 * @copyright  Copyright (c) 2014 Pedro Teixeira (http://www.pteixeira.com.br)
 * @author     Pedro Teixeira <pedro@pteixeira.com.br>
 * @license    http://opensource.org/licenses/MIT
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