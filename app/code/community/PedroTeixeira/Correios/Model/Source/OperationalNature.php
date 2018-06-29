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
class PedroTeixeira_Correios_Model_Source_OperationalNature extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{

    /**
     * Get options for methods
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => '1', 'label' => 'Pessoa f�sica com cobertura cambial'),
            array('value' => '2', 'label' => 'Pessoa f�sica sem cobertura cambial'),
            array('value' => '3', 'label' => 'Pessoa jur�dica com cobertura cambial'),
            array('value' => '4', 'label' => 'Pessoa jur�dica sem cobertura cambial'),
            array('value' => '30', 'label' => 'Doa��o em car�ter de ajuda humanit�ria'),
            array('value' => '31', 'label' => 'Bagagem desacompanhada'),
            array('value' => '41', 'label' => 'Bens de car�ter cultural - Exporta��o tempor�ria'),
            array('value' => '42', 'label' => 'Exporta��o tempor�ria de material para emprego militar'),
            array('value' => '43', 'label' => 'Feiras e exposi��es'),
            array('value' => '44', 'label' => 'Conserto, reparo ou restaura��o'),
            array('value' => '45', 'label' => 'Outras exporta��es tempor�rias'),
            array('value' => '61', 'label' => 'Bens submetidos a regime de admiss�o tempor�ria'),
            array('value' => '71', 'label' => 'Erro de expedi��o'),
            array('value' => '72', 'label' => 'N�o atendimento de exig�ncia de controle extrafiscal'),
            array('value' => '73', 'label' => 'Indeferimento de regime aduaneiro especial'),
            array('value' => '74', 'label' => 'Outros motivos: Portaria MF 306/95'),
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
