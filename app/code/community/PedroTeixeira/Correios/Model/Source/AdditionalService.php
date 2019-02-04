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
class PedroTeixeira_Correios_Model_Source_AdditionalService extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const AR = '001';
    const MP = '002';
    const EL = '017';
    const VD = '019';
    const RG = '025';
    const VDCR = '035';
    const RD = '037';
    const GF = '047';
    const DF = '049';
    const TD = '057';
    const LD = '067';
    const LA = '069';
    const VDNS = '064';

    /**
     * Get options for methods
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::AR, 'label' => 'Aviso de Recebimento'),
            array('value' => self::MP, 'label' => 'Mão Própria'),
            array('value' => self::EL, 'label' => 'Eleições - art. 239 da lei 4.737/65'),
            array('value' => self::VD, 'label' => 'Valor Declarado'),
            array('value' => self::RG, 'label' => 'Registro'),
            array('value' => self::VDCR, 'label' => 'Carta Registrada com Valor Declarado'),
            array('value' => self::RD, 'label' => 'Aviso de Recebimento Digital'),
            array('value' => self::GF, 'label' => 'Grandes Formatos'),
            array('value' => self::DF, 'label' => 'Devolução de Nota Fiscal - SEDEX'),
            array('value' => self::TD, 'label' => 'Taxa de Entrega de Encomenda Despadronizada'),
            array('value' => self::VDNS, 'label' => 'Valor Declarado Nacional Standard'),
            array('value' => self::LD, 'label' => 'Logística Reversa Simultânea Domiciliária'),
            array('value' => self::LA, 'label' => 'Logística Reversa Simultânea em Agência'),
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
