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

$installer->run(
    "CREATE TABLE IF NOT EXISTS {$this->getTable('pedroteixeira_correios/postmethod')} (
      method_id int(11) unsigned NOT NULL auto_increment,
      method_code varchar(5) NOT NULL default '0',
      method_title varchar(255) NOT NULL default '',
      PRIMARY KEY (method_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$installer->getConnection()->insertForce(
    $this->getTable('pedroteixeira_correios/postmethod'),
    array(
        'method_id'    => '3',
        'method_code'  => '40045',
        'method_title' => 'SEDEX A COBRAR SEM CONTRATO',
    )
);

$installer->getConnection()->insertForce(
    $this->getTable('pedroteixeira_correios/postmethod'),
    array(
        'method_id'    => '4',
        'method_code'  => '40215',
        'method_title' => 'SEDEX 10 SEM CONTRATO',
    )
);

$installer->getConnection()->insertForce(
    $this->getTable('pedroteixeira_correios/postmethod'),
    array(
        'method_id'    => '5',
        'method_code'  => '40290',
        'method_title' => 'SEDEX HOJE SEM CONTRATO',
    )
);

$installer->getConnection()->insertForce(
    $this->getTable('pedroteixeira_correios/postmethod'),
    array(
        'method_id'    => '6',
        'method_code'  => '04510',
        'method_title' => 'PAC SEM CONTRATO',
    )
);

$installer->getConnection()->insertForce(
    $this->getTable('pedroteixeira_correios/postmethod'),
    array(
        'method_id'    => '7',
        'method_code'  => '04014',
        'method_title' => 'SEDEX SEM CONTRATO',
    )
);

$installer->getConnection()->insertForce(
    $this->getTable('pedroteixeira_correios/postmethod'),
    array(
        'method_id'    => '8',
        'method_code'  => '04669',
        'method_title' => 'PAC CONTRATO AGENCIA',
    )
);

$installer->getConnection()->insertForce(
    $this->getTable('pedroteixeira_correios/postmethod'),
    array(
        'method_id'    => '9',
        'method_code'  => '04162',
        'method_title' => 'SEDEX CONTRATO AGENCIA',
    )
);

$installer->endSetup();
