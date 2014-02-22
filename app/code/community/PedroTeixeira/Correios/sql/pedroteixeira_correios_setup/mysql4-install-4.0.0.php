<?php
/**
 * This source file is subject to the MIT License.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/MIT
 *
 * @category   PedroTeixeira
 * @package    PedroTeixeira_Correios
 * @copyright  Copyright (c) 2010 Pedro Teixeira (http://www.pteixeira.com.br)
 * @author     Pedro Teixeira <pedro@pteixeira.com.br>
 * @license    http://opensource.org/licenses/MIT
 */

$installer = $this;

/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$installer->startSetup();

// Adiciona o volume como atributo do produto
$codigo = 'volume_comprimento';
$config = array(
    'position' => 1,
    'required' => 0,
    'label'    => 'Comprimento (cm)',
    'type'     => 'int',
    'input'    => 'text',
    'apply_to' => 'simple,bundle,grouped,configurable',
    'note'     => 'Comprimento da embalagem do produto (Para cálculo de PAC, mínimo de 16)'
);

$setup->addAttribute('catalog_product', $codigo, $config);

// Adiciona o volume como atributo do produto
$codigo = 'volume_altura';
$config = array(
    'position' => 1,
    'required' => 0,
    'label'    => 'Altura (cm)',
    'type'     => 'int',
    'input'    => 'text',
    'apply_to' => 'simple,bundle,grouped,configurable',
    'note'     => 'Altura da embalagem do produto (Para cálculo de PAC, mínimo de 2)'
);

$setup->addAttribute('catalog_product', $codigo, $config);

// Adiciona o volume como atributo do produto
$codigo = 'volume_largura';
$config = array(
    'position' => 1,
    'required' => 0,
    'label'    => 'Largura (cm)',
    'type'     => 'int',
    'input'    => 'text',
    'apply_to' => 'simple,bundle,grouped,configurable',
    'note'     => 'Largura da embalagem do produto (Para cálculo de PAC, mínimo de 11)'
);

$setup->addAttribute('catalog_product', $codigo, $config);

$installer->endSetup();
?>