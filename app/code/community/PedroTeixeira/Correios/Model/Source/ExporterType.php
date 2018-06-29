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
class PedroTeixeira_Correios_Model_Source_ExporterType extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const PJ                     = '1';
    const PF                     = '11';
    const PF_WITHOUT_DOC_OUTSIDE = '12';
    const PF_WITHOUT_DOC         = '13';

    /**
     * Get options for methods
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::PJ, 'label' => 'Pessoa Jur�dica'),
            array('value' => self::PF, 'label' => 'Pessoa F�sica'),
            array('value' => self::PF_WITHOUT_DOC_OUTSIDE, 'label' => 'Pessoa F�sica domiciliada no exterior sem CPF'),
            array('value' => self::PF_WITHOUT_DOC, 'label' => 'Pessoa F�sica residente no pa�s sem CPF'),
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
