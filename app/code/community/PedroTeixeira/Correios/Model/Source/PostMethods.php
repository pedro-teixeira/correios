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

class PedroTeixeira_Correios_Model_Source_PostMethods
{

    public function toOptionArray()
    {
        return array(
            array('value' => 0, 'label' => Mage::helper('adminhtml')->__('Sedex Sem Contrato (Correios)')),
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Sedex Com Contrato (Correios/Locaweb)')),
            array('value' => 2, 'label' => Mage::helper('adminhtml')->__('E-Sedex Com Contrato (Correios/Locaweb)')),
            array('value' => 3, 'label' => Mage::helper('adminhtml')->__('PAC Normal (Locaweb)')),
            array('value' => 4, 'label' => Mage::helper('adminhtml')->__('PAC Sem Contrato (Correios)')),
            array('value' => 5, 'label' => Mage::helper('adminhtml')->__('PAC Com Contrato (Correios/Locaweb)')),
            array('value' => 6, 'label' => Mage::helper('adminhtml')->__('Sedex 10 (Correios)')),
            array('value' => 7, 'label' => Mage::helper('adminhtml')->__('Sedex HOJE (Correios)')),
            array('value' => 8, 'label' => Mage::helper('adminhtml')->__('Sedex a Cobrar (Correios)')),
        );
    }
}