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
class PedroTeixeira_Correios_Model_Source_PostMethods extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * Get options for methods
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 40010, 'label' => Mage::helper('adminhtml')->__('Sedex Sem Contrato (40010)')),
            array('value' => 40096, 'label' => Mage::helper('adminhtml')->__('Sedex Com Contrato (40096)')),
            array('value' => 81019, 'label' => Mage::helper('adminhtml')->__('E-Sedex Com Contrato (81019)')),
            array('value' => 41106, 'label' => Mage::helper('adminhtml')->__('PAC Sem Contrato (41106)')),
            array('value' => 41068, 'label' => Mage::helper('adminhtml')->__('PAC Com Contrato (41068)')),
            array('value' => 40215, 'label' => Mage::helper('adminhtml')->__('Sedex 10 (40215)')),
            array('value' => 40290, 'label' => Mage::helper('adminhtml')->__('Sedex HOJE (40290)')),
            array('value' => 40045, 'label' => Mage::helper('adminhtml')->__('Sedex a Cobrar (40045)')),
            array('value' => 41300, 'label' => Mage::helper('adminhtml')->__('PAC GF (41300)')),
            array('value' => 10065, 'label' => Mage::helper('adminhtml')->__('Carta Comercial (10065)')),
            array('value' => 10138, 'label' => Mage::helper('adminhtml')->__('Carta Comercial Registrada (10138)')),
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
