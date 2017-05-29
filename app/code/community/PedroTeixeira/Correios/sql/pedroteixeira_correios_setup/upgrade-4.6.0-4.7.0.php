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

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setIds = $setup->getAllAttributeSetIds('catalog_product');

$attributes = array(
    'volume_comprimento',
    'volume_altura',
    'volume_largura',
    'postmethods',
    'fit_size',
    'posting_days'
);

foreach ($setIds as $setId) {
    $setup->addAttributeGroup('catalog_product', $setId, 'Correios', 2);
    $groupId = $setup->getAttributeGroupId('catalog_product', $setId, 'Correios');

    foreach ($attributes as $attribute) {
        $attributeId = $setup->getAttributeId('catalog_product', $attribute);
        $setup->addAttributeToGroup('catalog_product', $setId, $groupId, $attributeId);
    }
}

$installer->endSetup();
