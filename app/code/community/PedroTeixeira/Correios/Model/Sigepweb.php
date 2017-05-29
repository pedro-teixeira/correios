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
class PedroTeixeira_Correios_Model_Sigepweb extends Mage_Core_Model_Abstract
{

    /**
     * Retrieve the module helper
     *
     * @return Pedroteixeira_Correios_Helper_Data
     */
    public function helper()
    {
        return Mage::helper('pedroteixeira_correios');
    }
    
    /**
     * Request Correios service codes using configuration fields
     *
     * @return SimpleXMLElement
     */
    public function getBuscaCliente()
    {
        $params = array(
            'idContrato'       => $this->helper()->getConfigData('sigepweb_contract_code'),
            'idCartaoPostagem' => $this->helper()->getConfigData('sigepweb_card_code'),
            'usuario'          => $this->helper()->getConfigData('sigepweb_username'),
            'senha'            => $this->helper()->getConfigData('sigepweb_password'),
        );
        $client = new SoapClient($this->helper()->getConfigData('url_sigepweb'), $this->helper()->getStreamContext());
        return $client->buscaCliente($params);
    }
}
