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
class PedroTeixeira_Correios_Model_Source_PaymentType extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const MONEY_ORDER      = '1';
    const REFUND           = '2';
    const FOREIGN_EXCHANGE = '3';
    const CREDIT_CARD      = '4';
    const OTHER            = '5';

    /**
     * Get options for methods
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::MONEY_ORDER, 'label' => 'Vale Postal'),
            array('value' => self::REFUND, 'label' => 'Reembolso Postal'),
            array('value' => self::FOREIGN_EXCHANGE, 'label' => 'Contrato de Câmbio'),
            array('value' => self::CREDIT_CARD, 'label' => 'Cartão de Crédito'),
            array('value' => self::OTHER, 'label' => 'Outros'),
        );
    }

    /**
     * Get options for input fields
     *
     * @see Mage_Eav_Model_Entity_Attribute_Source_Interface::getAllOptions()
     *
     * @return array
     */
    public function getAllOptions()
    {
        return self::toOptionArray();
    }
}
