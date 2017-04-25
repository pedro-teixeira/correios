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

$installer->run(
    "CREATE TABLE IF NOT EXISTS {$this->getTable('pedroteixeira_correios/postmethod')} (
      method_id int(11) unsigned NOT NULL auto_increment,
      method_code varchar(5) NOT NULL default '0',
      method_title varchar(255) NOT NULL default '',
      PRIMARY KEY (method_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$installer->endSetup();
