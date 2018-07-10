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
 * 
 * @method string getNumeroContrato()
 * @method string getNumeroDiretoria()
 * @method string getCodigoAdministrativo()
 * @method string getNomeRemetente()
 * @method string getLogradouroRemetente()
 * @method string getNumeroRemetente()
 * @method string getComplementoRemetente()
 * @method string getBairroRemetente()
 * @method string getCepRemetente()
 * @method string getCidadeRemetente()
 * @method string getUfRemetente()
 * @method string getTelefoneRemetente()
 * @method string getFaxRemetente()
 * @method string getEmailRemetente()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setNumeroContrato()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setNumeroDiretoria()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setCodigoAdministrativo()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setNomeRemetente()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setLogradouroRemetente()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setNumeroRemetente()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setComplementoRemetente()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setBairroRemetente()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setCepRemetente()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setCidadeRemetente()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setUfRemetente()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setTelefoneRemetente()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setFaxRemetente()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente setEmailRemetente()
 */
class PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente extends PedroTeixeira_Correios_Model_Sigepweb_Abstract
{
    
    /**
     * @return PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente
     */
    public function _construct()
    {
        list($street, $number) = explode(',', Mage::getStoreConfig('shipping/origin/street_line1'));
        $region = Mage::getModel('directory/region')->load(Mage::getStoreConfig('shipping/origin/region_id'));
        
        $this
            ->setNumeroContrato(Mage::helper('pedroteixeira_correios')->getConfigData('sigepweb_contract_code'))
            ->setNumeroDiretoria(Mage::helper('pedroteixeira_correios')->getConfigData('sigepweb_regional_office'))
            ->setCodigoAdministrativo(Mage::helper('pedroteixeira_correios')->getConfigData('cod_admin'))
            ->setNomeRemetente(Mage::getStoreConfig('general/store_information/name'))
            ->setLogradouroRemetente($street)
            ->setNumeroRemetente($number)
            ->setComplementoRemetente()
            ->setBairroRemetente(Mage::getStoreConfig('shipping/origin/street_line2'))
            ->setCepRemetente(Mage::getStoreConfig('shipping/origin/postcode'))
            ->setCidadeRemetente(Mage::getStoreConfig('shipping/origin/city'))
            ->setUfRemetente($region->getCode())
            ->setTelefoneRemetente(Mage::getStoreConfig('general/store_information/phone'))
            ->setFaxRemetente()
            ->setEmailRemetente(Mage::getStoreConfig('trans_email/ident_general/email'));
        
        return $this;
    }
}
