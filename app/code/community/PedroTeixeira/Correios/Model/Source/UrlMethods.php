<?php
/**
 * This source file is subject to the MIT License.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/MIT
 *
 * @category   PedroTeixeira
 * @package    PedroTeixeira_Correios
 * @copyright  Copyright (c) 2010 Pedro Teixeira (http://www.pteixeira.com.br)
 * @author     Pedro Teixeira <pedro@pteixeira.com.br>
 * @license    http://opensource.org/licenses/MIT
 */

class PedroTeixeira_Correios_Model_Source_UrlMethods
{

    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Locaweb')),
            array('value' => 0, 'label' => Mage::helper('adminhtml')->__('Correios')),
        );
    }
}