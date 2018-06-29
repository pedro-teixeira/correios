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
class PedroTeixeira_Correios_Model_Source_CommercialUnit extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const CENTIMETER      = '8';
    const GRAMS           = '2';
    const MILLIMETERS     = '9';
    const MINUTES         = '5';
    const NOT_SIGNIFICANT = '6';
    const PAGE            = '4';
    const WORD            = '3';
    const QTY             = '10';
    const KILOGRAM        = '1';
    const CURRENCY        = '7';

    /**
     * Get options for methods
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::CENTIMETER, 'label' => 'Centímetros'),
            array('value' => self::GRAMS, 'label' => 'Gramas'),
            array('value' => self::MILLIMETERS, 'label' => 'Milímetros'),
            array('value' => self::MINUTES, 'label' => 'Minutos'),
            array('value' => self::NOT_SIGNIFICANT, 'label' => 'Não Significativo'),
            array('value' => self::PAGE, 'label' => 'Página'),
            array('value' => self::WORD, 'label' => 'Palavra'),
            array('value' => self::QTY, 'label' => 'Quantidade'),
            array('value' => self::KILOGRAM, 'label' => 'Quilograma'),
            array('value' => self::CURRENCY, 'label' => 'R$-Valor'),
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
