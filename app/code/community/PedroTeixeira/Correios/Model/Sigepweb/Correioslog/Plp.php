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
 * @method string getIdPlp()
 * @method string getValorGlobal()
 * @method string getMcuUnidadePostagem()
 * @method string getNomeUnidadePostagem()
 * @method string getCartaoPostagem()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Plp setIdPlp(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Plp setValorGlobal(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Plp setMcuUnidadePostagem(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Plp setNomeUnidadePostagem(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Plp setCartaoPostagem(string $value)
 */
class PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Plp extends PedroTeixeira_Correios_Model_Sigepweb_Abstract
{
    
    /**
     * @return PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Plp
     */
    public function _construct()
    {
        return $this->setIdPlp()
            ->setValorGlobal()
            ->setMcuUnidadePostagem()
            ->setNomeUnidadePostagem()
            ->setCartaoPostagem(Mage::helper('pedroteixeira_correios')->getConfigData('sigepweb_card_code'));
    }
}
