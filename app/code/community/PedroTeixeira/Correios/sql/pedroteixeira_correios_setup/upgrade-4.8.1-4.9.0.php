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

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$setup->updateAttribute(
    'catalog_product',
    'volume_altura',
    'apply_to',
    'simple,grouped'
);

$setup->updateAttribute(
    'catalog_product',
    'volume_largura',
    'apply_to',
    'simple,grouped'
);

$setup->updateAttribute(
    'catalog_product',
    'volume_comprimento',
    'apply_to',
    'simple,grouped'
);

$setup->updateAttribute(
    'catalog_product',
    'postmethods',
    'apply_to',
    'simple,grouped'
);

$setup->updateAttribute(
    'catalog_product',
    'fit_size',
    'apply_to',
    'simple,grouped'
);

$setup->updateAttribute(
    'catalog_product',
    'posting_days',
    'apply_to',
    'simple,grouped'
);

$installer->endSetup();
