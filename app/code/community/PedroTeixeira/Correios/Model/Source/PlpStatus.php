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
class PedroTeixeira_Correios_Model_Source_PlpStatus extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    
    const OPEN = 0;
    const CLOSED = 1;
    const SENT = 2;
    
    /**
     * @return string[]
     */
    public function toOptionHash()
    {
        $output = array();
        foreach (self::toOptionArray() as $option) {
            $output[$option['value']] = $option['label'];
        }
        return $output;
    }
    
    /**
     *
     * @return array[]
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::OPEN, 'label' => Mage::helper('pedroteixeira_correios')->__('Open')),
            array('value' => self::CLOSED,  'label' => Mage::helper('pedroteixeira_correios')->__('Closed')),
            array('value' => self::SENT,  'label' => Mage::helper('pedroteixeira_correios')->__('Sent')),
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
