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
 * @method string getTipoObjeto()
 * @method int getDimensaoAltura()
 * @method int getDimensaoLargura()
 * @method int getDimensaoComprimento()
 * @method int getDimensaoDiametro()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_DimensaoObjeto setTipoObjeto(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_DimensaoObjeto setDimensaoAltura(int $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_DimensaoObjeto setDimensaoLargura(int $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_DimensaoObjeto setDimensaoComprimento(int $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_DimensaoObjeto setDimensaoDiametro(int $value)
 */
class PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_DimensaoObjeto extends PedroTeixeira_Correios_Model_Sigepweb_Abstract
{
    
    /**
     * @return PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_DimensaoObjeto
     */
    public function _construct()
    {
        $width = $height = $length = 0;
        $shipment = Mage::getSingleton('sales/order_shipment');
        $packs = $shipment->getPackages();
        $packList = empty($packs) ? array() : unserialize($packs);
        
        foreach ($packList as $packageId => $package) {
            $package = new Varien_Object($package);
            $params = new Varien_Object($package->getParams());
            $width  = $params->getWidth();
            $height = $params->getHeight();
            $length = $params->getLength();
            break;
        }
        
        if (empty($width) || empty($height) || empty($length)) {
            $width  = Mage::helper('pedroteixeira_correios')->getConfigData('largura_padrao');
            $height = Mage::helper('pedroteixeira_correios')->getConfigData('altura_padrao');
            $length = Mage::helper('pedroteixeira_correios')->getConfigData('comprimento_padrao');
        }
        
        $this
            ->setTipoObjeto('002')
            ->setDimensaoAltura($height)
            ->setDimensaoLargura($width)
            ->setDimensaoComprimento($length)
            ->setDimensaoDiametro('0');
        
        return $this;
    }
}
