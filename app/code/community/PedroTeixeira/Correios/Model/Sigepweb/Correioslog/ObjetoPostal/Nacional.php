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
 * @method string getBairroDestinatario()
 * @method string getCidadeDestinatario()
 * @method string getUfDestinatario()
 * @method string getCepDestinatario()
 * @method string getCodigoUsuarioPostal()
 * @method string getCentroCustoCliente()
 * @method string getNumeroNotaFiscal()
 * @method string getSerieNotaFiscal()
 * @method string getValorNotaFiscal()
 * @method string getNaturezaNotaFiscal()
 * @method string getDescricaoObjeto()
 * @method string getValorACobrar()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional setBairroDestinatario(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional setCidadeDestinatario(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional setUfDestinatario(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional setCepDestinatario(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional setCodigoUsuarioPostal(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional setCentroCustoCliente(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional setNumeroNotaFiscal(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional setSerieNotaFiscal(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional setValorNotaFiscal(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional setNaturezaNotaFiscal(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional setDescricaoObjeto(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional setValorACobrar(string $value)
 */

class PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional
    extends PedroTeixeira_Correios_Model_Sigepweb_Abstract
{
    
    const POSTCODE_SIZE_MAX = 8;
    
    const DISTRICT_SIZE_MAX = 30;
    
    const CITY_SIZE_MAX = 30;
    
    /**
     * Order Address
     *
     * @var Mage_Sales_Model_Order_Address
     */
    protected $_address;
    
    /**
     * Setup the order address
     *
     * @param Mage_Sales_Model_Order_Address $addr
     * @return PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional|boolean
     */
    protected function _setAddress(Mage_Sales_Model_Order_Address $addr)
    {
        if ($addr instanceof Mage_Sales_Model_Order_Address) {
            $this->_address = $addr;
            return $this;
        }
        
        return false;
    }
    
    /**
     * Retrieve the formatted zip code
     *
     * @return string
     */
    protected function _getPostcode()
    {
        $postcode = $this->_address->getPostcode();
        $postcode = (new Zend_Filter_Digits())->filter($postcode);
        $postcode = substr($postcode, 0, self::POSTCODE_SIZE_MAX);
        
        return $postcode;
    }
    
    /**
     * Retrieve the formatted district
     *
     * @return string
     */
    protected function _getStreet4()
    {
        $street = $this->_address->getStreet4();
        $street = trim($street);
        $street = substr($street, 0, self::DISTRICT_SIZE_MAX);
        
        return $street;
    }
    
    /**
     * Retrieve the formatted city
     *
     * @return string
     */
    protected function _getCity()
    {
        $city = $this->_address->getCity();
        $city = trim($city);
        $city = substr($city, 0, self::CITY_SIZE_MAX);
        return $city;
    }
    
    /**
     * Retrieve the region code
     *
     * @return string
     */
    protected function _getRegionCode()
    {
        $code = $this->_address->getRegionCode();
        
        return $code;
    }
    
    /**
     * Retrieve the formatted order total
     *
     * @return NULL|string
     */
    protected function _getNFeAmount()
    {
        $amount = $this->_address->getOrder()->getGrandTotal();
        
        if ($amount > 0) {
            $amount = number_format($amount, 2, ',', '');
        } else {
            $amount = null;
        }
        
        return $amount;
    }
    
    /**
     * @return PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional
     */
    public function _construct()
    {
        $shipment = Mage::getSingleton('sales/order_shipment');
        
        if ($this->_setAddress($shipment->getShippingAddress())) {
            $this->setBairroDestinatario($this->_getStreet4())
                ->setCidadeDestinatario($this->_getCity())
                ->setUfDestinatario($this->_getRegionCode())
                ->setCepDestinatario($this->_getPostcode());
        }
        
        list(, $nfeSerie, $nfeNumber) = Mage::helper('pedroteixeira_correios')->getNfeByOrder($shipment->getOrder());
        $this->setCodigoUsuarioPostal(Mage::getSingleton('admin/session')->getUser()->getUsername())
            ->setCentroCustoCliente()
            ->setNumeroNotaFiscal($nfeNumber)
            ->setSerieNotaFiscal($nfeSerie)
            ->setValorNotaFiscal($this->_getNFeAmount())
            ->setNaturezaNotaFiscal()
            ->setDescricaoObjeto()
            ->setData('valor_a_cobrar', null);
        
        return $this;
    }
}
