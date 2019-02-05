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
class PedroTeixeira_Correios_Model_Resource_Postmethod
    extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Resource initialization
     *
     * @see Mage_Core_Model_Resource_Abstract::_construct()
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('pedroteixeira_correios/postmethod', 'method_id');
    }
}
