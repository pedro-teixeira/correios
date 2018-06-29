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
 * @method PedroTeixeira_Correios_Model_Pdf setRequest(Mage_Shipping_Model_Shipment_Request $shipment)
 * @method PedroTeixeira_Correios_Model_Pdf setTracking(string $value)
 * @method Mage_Shipping_Model_Shipment_Request getRequest()
 * @method string getTracking()
 */

class PedroTeixeira_Correios_Model_Pdf extends Varien_Object
{
    const INCH = 2.54;
    const DOTS = 72;
    
    protected $_barcodeFont;
    
    protected $_pdf = null;
    
    public static function cm($value)
    {
        return $value * self::DOTS / self::INCH;
    }
    
    public function _construct()
    {
        setlocale(LC_CTYPE, 'pt_BR');
        $w = 10.4;
        $h = 14.8;
        $this->_pdf = new Zend_Pdf();
        $page = new Zend_Pdf_Page(self::cm($w).':'.self::cm($h).':');
        $this->_pdf->pages[] = $page;
        $this->_barcodeFont = Mage::getBaseDir('skin').'/adminhtml/base/default/fonts/arial.ttf';
        return $this;
    }
    
    public function render()
    {
        $this->insertShippingAddress();
        $this->insertSourceAddress();
        $this->insertDataMatrix();
        $this->insertTracking();
        $this->insertZipBarcode();
        $this->insertLogo();
        $this->insertShippingLogo();
        $this->insertNF();
        $this->insertOrder();
        
        $pdf = new Zend_Pdf();
        $qty = count($this->getRequest()->getPackages());
        for($i=1; $i<=$qty; $i++) {
            $this->insertVolumes($pdf, $i);
        }
        
        $this->_pdf = $pdf;
        
        return $this->_pdf->render();
    }
    
    public function insertDataMatrix()
    {
        $imgResource = Mage::getModel('pedroteixeira_correios/barcode')
            ->setRequest($this->getRequest())
            ->setTracking($this->getTracking())
            ->render();
        $imgPath = Mage::getBaseDir('media') . "/qrcode" . time() . ".png";
        imagepng($imgResource, $imgPath);
        
        if (is_file($imgPath)) {
            $image = Zend_Pdf_Image::imageWithPath($imgPath);
            $w = $this->_pdf->pages[0]->getWidth();
            $h = $this->_pdf->pages[0]->getHeight();
            $x1 = $w * 0.34;
            $y1 = $h * 0.80;
            $x2 = $x1 + $image->getPixelWidth();
            $y2 = $y1 + $image->getPixelHeight();
            $this->_pdf->pages[0]->drawImage($image, $x1, $y1, $x2, $y2);
            unlink($imgPath);
        }
    }
    
    public function insertNF()
    {
        $nf = $this->getRequest()->getNfeNumber();
        
        $textIndent = 20;
        $fontSize = 9;
        $verticalPos = 330;
        
        $this->_pdf->pages[0]->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
        $this->_pdf->pages[0]->drawText(utf8_decode("NF: {$nf}"), $textIndent, $verticalPos);
    }
    
    public function insertOrder()
    {
        $order = $this->getRequest()->getOrderShipment()->getOrderId();
        
        $textIndent = 20;
        $fontSize = 9;
        $verticalPos = 319;
        
        $this->_pdf->pages[0]->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
        $this->_pdf->pages[0]->drawText("Pedido: {$order}", $textIndent, $verticalPos);
    }
    
    public function insertVolumes(&$pdf, $index)
    {
        $qty = count($this->getRequest()->getPackages());
        
        $textIndent = 220;
        $fontSize = 9;
        $verticalPos = 330;
        
        $page = clone $this->_pdf->pages[0];
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
        $page->drawText("Volume: {$index} de {$qty}", $textIndent, $verticalPos);
        
        $pdf->pages[] = $page;
    }
    
    public function insertShippingLogo()
    {
        $w = $this->_pdf->pages[0]->getWidth();
        $h = $this->_pdf->pages[0]->getHeight();
        $x1 = $w * 0.67;
        $y1 = $h * 0.82;
        $x2 = $w * 0.95;
        $y2 = $h * 0.98;
        
        $method = $this->getRequest()->getShippingMethod();
        $method = preg_replace('/\D/', '', $method);
        $image = Mage::getBaseDir('media') . "/correios/{$method}.jpg";
        if (is_file($image)) {
            $image = Zend_Pdf_Image::imageWithPath($image);
            $this->_pdf->pages[0]->drawImage($image, $x1, $y1, $x2, $y2);
        }
    }
    
    public function insertLogo()
    {
        $w = $this->_pdf->pages[0]->getWidth();
        $h = $this->_pdf->pages[0]->getHeight();
        $x1 = $w * 0.05;
        $y1 = $h * 0.88;
        $x2 = $w * 0.33;
        $y2 = $h * 0.98;
        
        $image = Mage::getStoreConfig('sales/identity/logo');
        if ($image) {
            $image = Mage::getBaseDir('media') . '/sales/store/logo/' . $image;
            if (is_file($image)) {
                $image = Zend_Pdf_Image::imageWithPath($image);
                $this->_pdf->pages[0]->drawImage($image, $x1, $y1, $x2, $y2);
            }
        }
    }
    
    private function _getTrackingRenderer($track)
    {
        $rendererOptions = array(
            'leftOffset' => 5,
            'topOffset' => 120,
        );
        $barcodeOptions = array(
            'text' => $track,
            'drawText' => false,
            'barHeight' => 30,
            'factor' => 3.2,
        );
        Zend_Barcode::setBarcodeFont($this->_barcodeFont);
        $renderer = Zend_Barcode::factory(
            'code128', 'pdf', $barcodeOptions, $rendererOptions
        );
        
        return $renderer;
    }
    
    /**
     * 
     * @param string|int $zip
     * @return Zend_Barcode_Renderer_Pdf
     */
    private function _getPostcodeRenderer($zip)
    {
        $h = $this->_pdf->pages[0]->getHeight();
        $barHeight = $h * 0.095;
        
        $rendererOptions = array(
            'leftOffset' => 15,
            'topOffset' => 270,
        );
        
        $barcodeOptions = array(
            'text' => $zip,
            'drawText' => false,
            'barHeight' => $barHeight,
            'factor' => 2.5,
        );
        
        Zend_Barcode::setBarcodeFont($this->_barcodeFont);
        $renderer = Zend_Barcode::factory(
            'code128', 'pdf', $barcodeOptions, $rendererOptions
        );
        
        return $renderer;
    }
    
    protected function insertZipBarcode()
    {
        $zip = $this->getRequest()->getRecipientAddressPostalCode();
        $zip = Mage::helper('pedroteixeira_correios')->formatDigitsOnly($zip);
        
        if ($renderer = $this->_getPostcodeRenderer($zip)) {
            $this->_pdf = $renderer->setResource($this->_pdf, 0)->draw();
        }
    }
    
    protected function insertTracking()
    {
        $track = $this->getTracking();
        
        if ($renderer = $this->_getTrackingRenderer($track)) {
            $this->_pdf = $renderer->setResource($this->_pdf, 0)->draw();
        }
        
        $textIndent = 80;
        $fontSize = 11;
        $verticalPos = 301;
        
        $this->_pdf->pages[0]->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
        $this->_pdf->pages[0]->drawText($track, $textIndent, $verticalPos);
        
        return $this;
    }
    
    public function insertShippingAddress()
    {
        $w = $this->_pdf->pages[0]->getWidth();
        $h = $this->_pdf->pages[0]->getHeight();
        $x = $w * 0.03;
        $barHeight = $h * 0.095;
        $textIndent = $x;
        $fontSize = 11;
        $lineHeight = $fontSize + 2;
        $verticalPos = $h * 0.525;
        
        $y = $verticalPos;
        $this->_pdf->pages[0]->drawLine($x, $y, $w*0.97, $y);
        
        $request = $this->getRequest();
        $name = $request->getRecipientContactPersonName();
        $y-= $lineHeight;
        $this->_pdf->pages[0]->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), $fontSize);
        $this->_pdf->pages[0]->drawText(utf8_decode("Destinatário: {$name}"), $x, $y);
        
        $this->_pdf->pages[0]->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
        
        $y-= $lineHeight;
        $this->_pdf->pages[0]->drawText(utf8_decode($request->getRecipientAddressStreet1()), $x+$textIndent, $y);
        
        $y-= $lineHeight;
        $this->_pdf->pages[0]->drawText(utf8_decode($request->getRecipientAddressStreet2()), $x+$textIndent, $y);
        
        $street4 = $request->getOrderShipment()->getShippingAddress()->getStreet4();
        $y-= $lineHeight;
        $this->_pdf->pages[0]->drawText(utf8_decode($street4), $x+$textIndent, $y);
        
        $y-= $lineHeight;
        $city = $request->getRecipientAddressCity();
        $state = $request->getRecipientAddressStateOrProvinceCode();
        $zip = $request->getRecipientAddressPostalCode();
        $zip = Mage::helper('pedroteixeira_correios')->formatDigitsOnly($zip);
        $zip = substr_replace($zip, '-', 5, 0);
        $zipAndCity = "{$zip}  {$city}/{$state}";
        $this->_pdf->pages[0]->drawText(utf8_decode($zipAndCity), $x+$textIndent, $y);
        
        $street3 = $request->getOrderShipment()->getShippingAddress()->getStreet3();
        if (!empty($street3)) {
            $this->_pdf->pages[0]->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize-1);
            
            $obsY = $y - $lineHeight;
            $obsWrap = wordwrap("Obs.: {$street3}", 30);
            $obsList = explode("\n", $obsWrap);
            foreach ($obsList as $text) {
                $this->_pdf->pages[0]->drawText(utf8_decode($text), $w*0.5, $obsY);
                $obsY-= $lineHeight;
            }
            
            $this->_pdf->pages[0]->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
        }
    }
    
    public function insertSourceAddress()
    {
        $w = $this->_pdf->pages[0]->getWidth();
        $x = $w * 0.03;
        $textIndent = $x;
        $lineHeight = 12;
        $fontSize = 10;
        $verticalPos = 80;
        
        $y = $verticalPos;
        $this->_pdf->pages[0]->drawLine($x, $y, $w*0.97, $y);
        
        $request = $this->getRequest();
        
        $y-= $lineHeight;
        $this->_pdf->pages[0]->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), $fontSize);
        $this->_pdf->pages[0]->drawText(utf8_decode("Remetente: {$request->getShipperContactCompanyName()}"), $x+$textIndent, $y);
        
        $this->_pdf->pages[0]->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
        
        $y-= $lineHeight;
        $this->_pdf->pages[0]->drawText(utf8_decode($request->getShipperAddressStreet1()), $x+$textIndent, $y);
        
        $y-= $lineHeight;
        $this->_pdf->pages[0]->drawText(utf8_decode($request->getShipperAddressStreet2()), $x+$textIndent, $y);
        
        $y-= $lineHeight;
        $city = $request->getShipperAddressCity();
        $state = $request->getShipperAddressStateOrProvinceCode();
        $zip = $request->getShipperAddressPostalCode();
        $zip = Mage::helper('pedroteixeira_correios')->formatDigitsOnly($zip);
        $zip = substr_replace($zip, '-', 5, 0);
        $zipAndCity = "{$zip}  {$city}/{$state}";
        $this->_pdf->pages[0]->drawText(utf8_decode($zipAndCity), $x+$textIndent, $y);
    }
    
    public function renderVoucher()
    {
        $this->_pdf->pages[0] = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
        return $this->_pdf->render();
    }
}
