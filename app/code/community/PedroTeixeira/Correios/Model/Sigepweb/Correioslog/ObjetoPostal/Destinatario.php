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
 * @method string getNomeDestinatario()
 * @method string getTelefoneDestinatario()
 * @method string getCelularDestinatario()
 * @method string getEmailDestinatario()
 * @method string getLogradouroDestinatario()
 * @method string getComplementoDestinatario()
 * @method int getNumeroEndDestinatario()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Destinatario setNomeDestinatario(
 *  string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Destinatario setTelefoneDestinatario(
 *  string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Destinatario setCelularDestinatario(
 *  string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Destinatario setEmailDestinatario(
 *  string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Destinatario setLogradouroDestinatario(
 *  string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Destinatario setComplementoDestinatario(
 *  string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Destinatario setNumeroEndDestinatario(
 *  int $value)
 */

class PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Destinatario
    extends PedroTeixeira_Correios_Model_Sigepweb_Abstract
{
    
    const NAME_SIZE_MAX = 50;
    
    const PHONE_SIZE_MAX = 12;
    
    const EMAIL_SIZE_MAX = 50;
    
    const STREET_SIZE_MAX = 50;
    
    const STREETNUMBER_SIZE_MAX = 5;
    
    const STREETADD_SIZE_MAX = 30;
    
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
     * @return PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Destinatario|boolean
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
     * Retrieve name from address
     * Company is appended only if identified taxvat as CNPJ
     *
     * @return string
     */
    protected function _getName()
    {
        $name = $this->_address->getName();
        $name = trim($name);
        $company = $this->_address->getCompany();
        $company = trim($company);
        
        if (!empty($company) && ($order = $this->_address->getOrder())) {
            $filter = new Zend_Filter_Digits();
            $taxvat = $filter->filter($order->getCustomerTaxvat());
            
            if (strlen($taxvat) == 14) {
                $name.= " - {$this->_address->getCompany()}";
            }
        }
        
        $name = substr($name, 0, self::NAME_SIZE_MAX);
        return $name;
    }
    
    /**
     * Retrieve the formatted phone number
     *
     * @return string
     */
    protected function _getPhone()
    {
        $phone = $this->_address->getTelephone();
        $filter = new Zend_Filter_Digits();
        $phone = $filter->filter($phone);
        $phone = substr($phone, 0, self::PHONE_SIZE_MAX);
        
        return $phone;
    }
    
    
    /**
     * Retrieve the formatted cellphone number
     *
     * @return string
     */
    protected function _getCellphone()
    {
        $phone = $this->_address->getFax();
        $filter = new Zend_Filter_Digits();
        $phone = $filter->filter($phone);
        $phone = substr($phone, 0, self::PHONE_SIZE_MAX);
        
        return $phone;
    }
    
    /**
     * Retrieve a valid and formatted customer e-mail or empty
     *
     * @return string
     */
    protected function _getEmail()
    {
        $email = '';
        $order = $this->_address->getOrder();
        
        if ($order->getId()) {
            $email = $order->getCustomerEmail();
            $email = trim($email);
            
            $validator = new Zend_Validate_EmailAddress();
            if (!$validator->isValid($email)) {
                $email = '';
            }
            
            $email = substr($email, 0, self::EMAIL_SIZE_MAX);
        }
        
        return $email;
    }
    
    /**
     * Retrieve the formatted street
     *
     * @return string
     */
    protected function _getStreet1()
    {
        $street = $this->_address->getStreet1();
        $street = trim($street);
        $street = substr($street, 0, self::STREET_SIZE_MAX);
        
        return $street;
    }
    
    /**
     * Retrieve the formatted street number
     *
     * @return string
     */
    protected function _getStreet2()
    {
        $filter = new Zend_Filter_Digits();
        $street = $this->_address->getStreet2();
        $street = $filter->filter($street);
        $street = substr($street, 0, self::STREETNUMBER_SIZE_MAX);
        
        return $street;
    }
    
    /**
     * Retrieve the formatted street additional
     *
     * @return string
     */
    protected function _getStreet3()
    {
        $street = $this->_address->getStreet3();
        $street = trim($street);
        $street = substr($street, 0, self::STREETADD_SIZE_MAX);
        
        return $street;
    }
    
    /**
     *
     * @return PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Destinatario
     */
    public function _construct()
    {
        $shipment = Mage::getSingleton('sales/order_shipment');
        
        if ($this->_setAddress($shipment->getShippingAddress())) {
            $this
                ->setNomeDestinatario($this->_getName())
                ->setTelefoneDestinatario($this->_getPhone())
                ->setCelularDestinatario($this->_getCellphone())
                ->setEmailDestinatario($this->_getEmail())
                ->setLogradouroDestinatario($this->_getStreet1())
                ->setComplementoDestinatario($this->_getStreet3())
                ->setNumeroEndDestinatario($this->_getStreet2());
        }
        return $this;
    }
}
