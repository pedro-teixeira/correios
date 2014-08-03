<?php

/**
 * This source file is subject to the MIT License.
 * It is also available through http://opensource.org/licenses/MIT
 *
 * @category  PedroTeixeira
 * @package   PedroTeixeira_Correios
 * @copyright Copyright (c) 2014 Pedro Teixeira (http://pedroteixeira.io)
 * @author    Pedro Teixeira <hello@pedroteixeira.io>
 * @license   http://opensource.org/licenses/MIT
 */
class PedroTeixeira_Correios_Model_Source_WeightType
{
    /**
     * Constants for weight
     */
    const WEIGHT_GR = 'gr';
    const WEIGHT_KG = 'kg';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::WEIGHT_GR, 'label' => Mage::helper('adminhtml')->__('Gramas')),
            array('value' => self::WEIGHT_KG, 'label' => Mage::helper('adminhtml')->__('Kilos')),
        );
    }
}
