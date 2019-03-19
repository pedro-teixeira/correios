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
 * @method Mage_Shipping_Model_Shipment_Request getRequest()
 * @method PedroTeixeira_Correios_Model_Barcode setRequest(Mage_Shipping_Model_Shipment_Request $request)
 * @method string getTracking()
 * @method PedroTeixeira_Correios_Model_Barcode setTracking(string $tracking)
 */
class PedroTeixeira_Correios_Model_Barcode extends Varien_Object
{
    /**
     * Gets the configuration value by path
     *
     * @param string $path System Config Path
     *
     * @return mixed
     */
    public function getConfig($path)
    {
        return Mage::getStoreConfig("carriers/correios/{$path}");
    }
    
    public function getDataMatrix()
    {
        $request = $this->getRequest();
        
        $recipientPostalCode  = $request->getRecipientAddressPostalCode();
        $recipientPostalCode  = preg_replace('/\D/', '', $recipientPostalCode);
        
        $shipperPostalCode    = $request->getShipperAddressPostalCode();
        $shipperPostalCode    = preg_replace('/\D/', '', $shipperPostalCode);
        
        $recipientPostalDigit = array_sum(str_split($recipientPostalCode));
        $recipientPostalDigit = (ceil($recipientPostalDigit/10)*10) - $recipientPostalDigit;
        
        $methodCode = $request->getShippingMethod();
        $methodCode = preg_replace('/\D/', '', $methodCode);
        
        $configPath = "options_{$methodCode}/additional_services";
        $configServices = self::getConfig($configPath);
        if (empty($configServices)) {
            $configPath = 'additional_services';
            $configServices = self::getConfig($configPath);
        }
        preg_match_all('/\d([\d]{2})/', $configServices, $matches);
        $addServices = implode('', $matches[1]);
        $addServices = self::padR($addServices, 12);
        
        $addrNumber = $request->getRecipientAddressStreet2();
        $addrNumber = preg_replace('/\D/', '', $addrNumber);
        $addrNumber = self::padL($addrNumber);
        
        $addrAdditional = $request->getRecipientAddressStreet1();
        $addrAdditional = str_pad($addrAdditional, 20, ' ', STR_PAD_RIGHT);
        
        $amount = $request->getOrderShipment()->getOrder()->getGrandTotal();
        $amount = number_format($amount, '0', '', '');
        $amount = self::padL($amount);
        
        $phone = $request->getRecipientContactPhoneNumber();
        $phone = preg_replace('/\D/', '', $phone);
        $phone = self::padL($phone, 12);
        
        $std = new stdClass();
        $std->recipientPostalCode = $recipientPostalCode;
        $std->recipientDneCode = '00000';
        $std->shipperPostalCode = $shipperPostalCode;
        $std->shipperDneCode = '00000';
        $std->recipientPostalDigit = (string)$recipientPostalDigit;
        $std->idv = '51';
        $std->label = $this->getTracking();
        $std->addService = $addServices;
        $std->card = self::getConfig('sigepweb_card_code');
        $std->methodCode = $methodCode;
        $std->group = '00';
        $std->addressNumber = $addrNumber;
        $std->addressAdditional = $addrAdditional;
        $std->amount = $amount;
        $std->phone = $phone;
        $std->latitude = '-00.000000';
        $std->longitude = '-00.000000';
        $std->endFlag = '|';
        $data = implode('', (array)$std);
        
        return $data;
    }
    
    public function render()
    {
        $renderer = new Kreativecorp_Barcode_Generator();
        $imgResource = $renderer->render_image('dmtx', $this->getDataMatrix(), array('w'=>90,'h'=>90));
        return $imgResource;
    }
    
    public function padL($value = '', $length = 5)
    {
        return str_pad($value, $length, '0', STR_PAD_LEFT);
    }
    
    public function padR($value = '', $length = 5)
    {
        return str_pad($value, $length, '0', STR_PAD_RIGHT);
    }
}
