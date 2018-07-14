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
 * @method string getNumeroEtiqueta()
 * Código do objeto a ser postado.
 *
 * @method string getCodigoObjetoCliente()
 * Código de controle do cliente
 *
 * @method string getCodigoServicoPostagem()
 * Código do serviço a ser utilizado na postagem do objeto.
 *
 * @method string getCubagem()
 * Cubagem do Objeto (em centímetros cúbicos)
 *
 * @method string getPeso()
 * Peso do objeto (em gramas)
 *
 * @method string getRt1()
 * Reservado para observação do cliente
 *
 * @method string getRt2()
 * Reservado para observação do cliente
 *
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Destinatario getDestinatario()
 * Dados do destinatário
 *
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional getNacional()
 * Dados relevantes a postagem
 *
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_ServicoAdicional[] getServicoAdicional()
 * Identifica os serviços adicionais do objeto
 *
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_DimensaoObjeto getDimensaoObjeto()
 * Deve conter as dimensões do objeto (altura, largura, comprimento e diâmetro)
 * e o tipo do objeto (embalagem)
 *
 * @method string getDataPostagemSara()
 * Data de efetivação da postagem.
 *
 * @method string getStatusProcessamento()
 * Situação do processamento do objeto
 *
 * @method string getNumeroComprovantePostagem()
 * Número de comprovante da postagem
 *
 * @method string getValorCobrado()
 * Valor que foi tarifado no Sistema de Atendimento dos Correios
 *
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setNumeroEtiqueta(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setCodigoObjetoCliente(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setCodigoServicoPostagem(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setCubagem(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setPeso(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setRt1(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setRt2(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setDestinatario(
 *  PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Destinatario $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setNacional(
 *  PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_Nacional $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setServicoAdicional(
 *  PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_ServicoAdicional[] $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setDimensaoObjeto(
 *  PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal_DimensaoObjeto $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setDataPostagemSara(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setStatusProcessamento(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setNumeroComprovantePostagem(string $value)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal setValorCobrado(string $value)
 */

class PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal
    extends PedroTeixeira_Correios_Model_Sigepweb_Abstract
{
    
    /**
     * @return PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal
     */
    public function _construct()
    {
        $shipment = Mage::getSingleton('sales/order_shipment');
        $track = $shipment->getTracksCollection()->getFirstItem();
        $method = $shipment->getOrder()->getShippingMethod(true)->getMethod();
        $method = preg_replace('/\D/', '', $method);
        
        $packs = $shipment->getPackages();
        $packList = empty($packs) ? array() : unserialize($packs);
        $weight = 0;
        
        foreach ($packList as $packageId => $package) {
            $package = new Varien_Object($package);
            $params = new Varien_Object($package->getParams());
            $weight += $params->getWeight();
        }
        
        $this
            ->setNumeroEtiqueta($track->getNumber())
            ->setCodigoObjetoCliente()
            ->setCodigoServicoPostagem($method)
            ->setCubagem('0,00')
            ->setPeso($weight*1000)
            ->setRt1()
            ->setRt2();
        
        $customer = Mage::getModel('pedroteixeira_correios/sigepweb_correioslog_objetoPostal_destinatario');
        $address = Mage::getModel('pedroteixeira_correios/sigepweb_correioslog_objetoPostal_nacional');
        $packAttr = Mage::getModel('pedroteixeira_correios/sigepweb_correioslog_objetoPostal_dimensaoObjeto');
        $addService = Mage::getModel('pedroteixeira_correios/sigepweb_correioslog_objetoPostal_servicoAdicional');
        $additionalServiceXml = $addService->toXml(array(), null);
        $dimensaoObjetoXml = $packAttr->toXml(array(), null);
        $destinatarioXml = $customer->toXml(array(), null, false, true);
        $nacionalXml = $address->toXml(array(), null, false, true);
        
        $this
            ->setDestinatario($destinatarioXml)
            ->setNacional($nacionalXml)
            ->setServicoAdicional($additionalServiceXml)
            ->setDimensaoObjeto($dimensaoObjetoXml)
            ->setDataPostagemSara()
            ->setStatusProcessamento(PedroTeixeira_Correios_Model_Source_PlpStatus::OPEN)
            ->setNumeroComprovantePostagem()
            ->setValorCobrado();
        
        return $this;
    }
}
