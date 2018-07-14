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
 * @method array getCodigoServicoAdicional()
 * Código do serviço adicional
 *
 * @method string getValorDeclarado()
 * Valor do seguro adicional declarado  pelo cliente
 *
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_ServicoAdicional setCodigoServicoAdicional(
 *  array $value)
 * Preenchimento obrigatório
 * O serviço adicional "025", referente ao registro, deve sempre ser informado.
 *
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_ServicoAdicional setValorDeclarado(
 *  string $value)
 * Se o código do serviço adicional for igual a "019" o campo é obrigatório, observando-se os limites tarifários.
 */

class PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_ServicoAdicional
    extends PedroTeixeira_Correios_Model_Sigepweb_Abstract
{
    public function _construct()
    {
        $shipment = Mage::getSingleton('sales/order_shipment');
        
        $addServices = array();
        $addServicesConfig = explode(',', Mage::helper('pedroteixeira_correios')->getConfigData('additional_services'));
        foreach ($addServicesConfig as $serviceCode) {
            $add = new Varien_Object();
            $add->setCodigoServicoAdicional($serviceCode);
            if ($serviceCode == PedroTeixeira_Correios_Model_Source_AdditionalService::VD) {
                $vdFlag = true;
            }
            $addServices[] = $add->toXml(array(), null, false, false);
        }
        
        $this->setCodigoServicoAdicional($addServices);
        if (isset($vdFlag)) {
            $this->setValorDeclarado(number_format($shipment->getOrder()->getGrandTotal(), 2, ',', ''));
        }
        return $this;
    }
}
