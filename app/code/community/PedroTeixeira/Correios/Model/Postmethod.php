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
 *
 * @method string getMethodId()
 * @method string getMethodCode()
 * @method string getMethodTitle()
 * @method PedroTeixeira_Correios_Model_Postmethod setMethodId(string|int $id)
 * @method PedroTeixeira_Correios_Model_Postmethod setMethodCode(string $code)
 * @method PedroTeixeira_Correios_Model_Postmethod setMethodTitle(string $title)
 * @method PedroTeixeira_Correios_Model_Postmethod[] getCollection()
 */
class PedroTeixeira_Correios_Model_Postmethod extends Mage_Core_Model_Abstract
{
    /**
     * Internal constructor
     *
     * @see Varien_Object::_construct()
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('pedroteixeira_correios/postmethod');
    }
}
