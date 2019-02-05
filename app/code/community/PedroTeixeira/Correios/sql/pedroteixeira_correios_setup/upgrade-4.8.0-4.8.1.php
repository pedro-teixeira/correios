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

$tableName = $this->getTable('pedroteixeira_correios/postmethod');

if ($installer->getConnection()->isTableExists($tableName)) {
    // Fix old migration to 4.8.0
    // See https://github.com/pedro-teixeira/correios/pull/252
    $installer->getConnection()->addIndex(
        $tableName,
        $installer->getIdxName(
            $tableName,
            array('method_code'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('method_code'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    );
} else {
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
}

$installer->endSetup();
