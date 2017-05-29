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

/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

// Add volume to prduct attribute set
$codigo = 'volume_comprimento';
$config = array(
    'position' => 1,
    'required' => 0,
    'label'    => 'Comprimento (cm)',
    'type'     => 'int',
    'input'    => 'text',
    'apply_to' => 'simple,grouped',
    'note'     => 'Comprimento da embalagem do produto (Para cálculo dos Correios)'
);

$setup->addAttribute('catalog_product', $codigo, $config);

// Add volume to prduct attribute set
$codigo = 'volume_altura';
$config = array(
    'position' => 1,
    'required' => 0,
    'label'    => 'Altura (cm)',
    'type'     => 'int',
    'input'    => 'text',
    'apply_to' => 'simple,grouped',
    'note'     => 'Altura da embalagem do produto (Para cálculo dos Correios)'
);

$setup->addAttribute('catalog_product', $codigo, $config);

// Add volume to prduct attribute set
$codigo = 'volume_largura';
$config = array(
    'position' => 1,
    'required' => 0,
    'label'    => 'Largura (cm)',
    'type'     => 'int',
    'input'    => 'text',
    'apply_to' => 'simple,grouped',
    'note'     => 'Largura da embalagem do produto (Para cálculo dos Correios)'
);

$setup->addAttribute('catalog_product', $codigo, $config);

$codigo = 'postmethods';
$config = array(
    'position' => 1,
    'required' => 0,
    'label'    => 'Serviços de Entrega',
    'type'     => 'text',
    'input'    => 'multiselect',
    'source'   => 'pedroteixeira_correios/source_postMethods',
    'backend'  => 'eav/entity_attribute_backend_array',
    'apply_to' => 'simple,grouped',
    'note'     => 'Selecione os serviços apropriados para o produto.'
);

$setup->addAttribute('catalog_product', $codigo, $config);

$codigo = 'fit_size';
$config = array(
    'position' => 1,
    'required' => 0,
    'label'    => 'Diferença do Encaixe (cm)',
    'type'     => 'varchar',
    'input'    => 'text',
    'apply_to' => 'simple,grouped',
    'note'     => 'Exemplo: Se 1 item mede 10cm de altura, e 2 itens encaixados medem 11cm. A diferença é de 1cm.'
);

$setup->addAttribute('catalog_product', $codigo, $config);

$codigo = 'posting_days';
$config = array(
    'position' => 1,
    'required' => 0,
    'label'    => 'Prazo de Postagem',
    'type'     => 'int',
    'input'    => 'text',
    'apply_to' => 'simple,grouped',
    'note'     => 'O prazo total é o Prazo dos Correios acrescido do maior Prazo de Postagem dos produtos no carrinho.'
);

$setup->addAttribute('catalog_product', $codigo, $config);

// Add Correios Tab
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

$tableName = $this->getTable('pedroteixeira_correios/postmethod');
$table = $installer->getConnection()
    ->newTable($tableName)
    ->addColumn(
        'method_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'ID'
    )->addColumn(
        'method_code',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        5,
        array(
            'nullable'  => false,
            'default'   => '0'
        ),
        'Code'
    )->addColumn(
        'method_title',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        255,
        array(
            'nullable'  => false,
            'default'   => ''
        ),
        'Title'
    )->addIndex(
        $installer->getIdxName(
            $tableName,
            array('method_code'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('method_code'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    );
$installer->getConnection()->createTable($table);

$services = array(
    array(
        'method_code'  => '40045',
        'method_title' => 'SEDEX A COBRAR SEM CONTRATO',
    ),
    array(
        'method_code'  => '40215',
        'method_title' => 'SEDEX 10 SEM CONTRATO',
    ),
    array(
        'method_code'  => '40290',
        'method_title' => 'SEDEX HOJE SEM CONTRATO',
    ),
    array(
        'method_code'  => '04510',
        'method_title' => 'PAC SEM CONTRATO',
    ),
    array(
        'method_code'  => '04014',
        'method_title' => 'SEDEX SEM CONTRATO',
    ),
    array(
        'method_code'  => '04669',
        'method_title' => 'PAC CONTRATO AGENCIA',
    ),
    array(
        'method_code'  => '04162',
        'method_title' => 'SEDEX CONTRATO AGENCIA',
    ),
    array(
        'method_code'  => '04693',
        'method_title' => 'PAC CONTRATO GRANDES FORMATOS',
    ),
    array(
        'method_code'  => '10065',
        'method_title' => 'CARTA COMERCIAL A FATURAR',
    )
);

foreach ($services as $service) {
    $installer->getConnection()->insertOnDuplicate($tableName, $service, array('method_code'));
}

$installer->endSetup();
