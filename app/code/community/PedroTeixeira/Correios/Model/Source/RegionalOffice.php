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
class PedroTeixeira_Correios_Model_Source_RegionalOffice extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const AC  = '01';
    const ACR = '03';
    const AR  = '04';
    const AM  = '06';
    const AP  = '05';
    const BA  = '08';
    const BSB = '10';
    const CE  = '12';
    const ES  = '14';
    const GO  = '16';
    const MA  = '18';
    const MG  = '20';
    const MS  = '22';
    const MT  = '24';
    const PA  = '28';
    const PB  = '30';
    const PE  = '32';
    const PI  = '34';
    const PR  = '36';
    const RJ  = '50';
    const RN  = '60';
    const RO  = '26';
    const RR  = '65';
    const RS  = '64';
    const SC  = '68';
    const SE  = '70';
    const SPI = '74';
    const SPM = '72';
    const TO  = '75';

    /**
     * Get options for methods
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::AC, 'label' => 'Administração Central'),
            array('value' => self::ACR,'label' => 'DR - Acre'),
            array('value' => self::AR, 'label' => 'DR - Alagoas'),
            array('value' => self::AM, 'label' => 'DR - Amazonas'),
            array('value' => self::AP, 'label' => 'DR - Amapá'),
            array('value' => self::BA, 'label' => 'DR - Bahia'),
            array('value' => self::BSB,'label' => 'DR - Brasília'),
            array('value' => self::CE, 'label' => 'DR - Ceará'),
            array('value' => self::ES, 'label' => 'DR - Espírito Santo'),
            array('value' => self::GO, 'label' => 'DR - Goiás'),
            array('value' => self::MA, 'label' => 'DR - Maranhão'),
            array('value' => self::MG, 'label' => 'DR - Minas Gerais'),
            array('value' => self::MS, 'label' => 'DR - Mato Grosso do Sul'),
            array('value' => self::MT, 'label' => 'DR - Mato Grosso'),
            array('value' => self::PA, 'label' => 'DR - Pará'),
            array('value' => self::PB, 'label' => 'DR - Paraíba'),
            array('value' => self::PE, 'label' => 'DR - Pernambuco'),
            array('value' => self::PI, 'label' => 'DR - Piauí'),
            array('value' => self::PR, 'label' => 'DR - Paraná'),
            array('value' => self::RJ, 'label' => 'DR - Rio de Janeiro'),
            array('value' => self::RN, 'label' => 'DR - Rio Grande do Norte'),
            array('value' => self::RO, 'label' => 'DR - Rondônia'),
            array('value' => self::RR, 'label' => 'DR - Roraima'),
            array('value' => self::RS, 'label' => 'DR - Rio Grande do Sul'),
            array('value' => self::SC, 'label' => 'DR - Santa Catarina'),
            array('value' => self::SE, 'label' => 'DR - Sergipe'),
            array('value' => self::SPI,'label' => 'DR - São Paulo Interior'),
            array('value' => self::SPM,'label' => 'DR - São Paulo'),
            array('value' => self::TO, 'label' => 'DR - Tocantins'),
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
