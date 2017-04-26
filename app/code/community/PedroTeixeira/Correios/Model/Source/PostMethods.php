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
        $output = array();
        $object = Mage::getSingleton('pedroteixeira_correios/postmethod');
        $collection = $object->getCollection();
        foreach ($collection as $method) {
            $output[] = array(
                'value' => $method->getMethodCode(),
                'label' => "{$method->getMethodCode()} - {$method->getMethodTitle()}",
            );
        }
        return $output;
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
