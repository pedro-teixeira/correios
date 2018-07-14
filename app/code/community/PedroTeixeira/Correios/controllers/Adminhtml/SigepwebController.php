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
class PedroTeixeira_Correios_Adminhtml_SigepwebController
    extends Mage_Adminhtml_Controller_Action
{
    /**
     * This updates the available service codes from Correios
     *
     * @return void
     */
    public function postmethodsUpdateAction()
    {
        $sigep = Mage::getModel('pedroteixeira_correios/sigepweb');
        
        try {
            $request = $sigep->getBuscaCliente();
            $postmethods = $request->return->contratos->cartoesPostagem->servicos;
        } catch (Exception $e) {
            $this->_getSession()->addError("Cant receive postmethods! {$e->getMessage()}");
        }
        
        if ($postmethods && !empty($postmethods)) {
            $collection = Mage::getModel('pedroteixeira_correios/postmethod')->getCollection();
            foreach ($collection as $element) {
                $element->delete();
            }
            
            $transaction = Mage::getModel('core/resource_transaction');
            foreach ($postmethods as $servico) {
                $object = Mage::getModel('pedroteixeira_correios/postmethod');
                $object->setMethodId($servico->id);
                $object->setMethodCode($servico->codigo);
                $object->setMethodTitle(trim($servico->descricao));
                $object->setChancela($servico->servicoSigep->chancela->chancela);
                $transaction->addObject($object);
            }
            
            try {
                $transaction->save();
                $this->_getSession()->addSuccess("Postmethods updated successfully!");
            } catch (Exception $e) {
                $this->_getSession()->addError("Cant update postmethods! {$e->getMessage()}");
            }
        }
        
        $this->_redirect('*/system_config/edit', array('section'=>'carriers'));
    }

    public function requestXmlAction()
    {
        $plpId = $this->getRequest()->getParam('plp_id');
        $shipmentId = $this->getRequest()->getParam('shipment_id');
        if ($plpId && $shipmentId) {
            $shipment = Mage::getModel('sales/order_shipment')->load($shipmentId);
            $labels = $shipment->getTracksCollection()->getColumnValues('track_number');
            $sigep = Mage::getModel('pedroteixeira_correios/sigepweb');
            $sigep->setPlpId($plpId);
            $response = $sigep->requestXml();
            if ($response->hasError()) {
                $this->_getSession()->addError($this->__('Error: <pre>%s</pre>', $response->getError()));
            } else {
                libxml_use_internal_errors(true);
                $correioslog = simplexml_load_string($response->getXml());
                foreach ($correioslog->objeto_postal as $objetoPostal) {
                    $label = (string)$objetoPostal->numero_etiqueta;
                    if (in_array($label, $labels)) {
                        $status = (int)$objetoPostal->status_processamento;
                        if ($status > 0) {
                            $this->_getSession()->addSuccess('Encomenda localizada com sucesso!');
                            $plp = (string)$correioslog->plp->id_plp;
                            $amount = (string)$objetoPostal->valor_cobrado;
                            $weight = (string)$objetoPostal->peso;
                            $cubic  = (string)$objetoPostal->cubagem;
                            $size = $objetoPostal->dimensao_objeto;
                            $height = (string)$size->dimensao_altura;
                            $width  = (string)$size->dimensao_largura;
                            $length = (string)$size->dimensao_comprimento;
                            $info = new stdClass();
                            $info->label = $label;
                            $info->plpId = $plp;
                            $info->amount = "R\${$amount}";
                            $info->weight = "{$weight}gr ({$cubic}/³)";
                            $info->size = "{$height}x{$width}x{$length}cm";
                            $comment = implode("\n", (array)$info);
                            $shipment->addComment($comment)->save();
                        } else {
                            $this->_getSession()->addNotice('Encomenda ainda não processada :(');
                        }
                    }
                }
            }
        }
        
        $this->_redirect('*/sales_shipment/view', array('shipment_id'=>$shipmentId));
    }
    
    public function requestPlpAction()
    {
        $shipmentIds = $this->getRequest()->getPost('shipment_ids');
        if (!empty($shipmentIds)) {
            $collection = new Varien_Data_Collection();
            $labels = array();
            $packages = array();
            
            foreach ($shipmentIds as $id) {
                Mage::unregister('_singleton/sales/order_shipment');
                $shipment = Mage::getSingleton('sales/order_shipment')->load($id);
                $label = $shipment->getTracksCollection()->getFirstItem()->getNumber();
                
                if (!empty($label)) {
                    $labels[] = $label;
                    $objetoPostal = Mage::getModel('pedroteixeira_correios/sigepweb_correioslog_objetoPostal');
                    $packages[] = $objetoPostal->toXml(array(), 'objeto_postal');
                    $collection->addItem($shipment);
                } else {
                    $incrementId = $shipment->getOrder()->getIncrementId();
                    $this->_getSession()->addNotice("Invalid tracking code! order:{$incrementId} code:{$label}");
                }
            }
            
            if ($collection->getSize() > 0) {
                $correioslog = Mage::getModel('pedroteixeira_correios/sigepweb_correioslog');
                $correioslog->setObjetoPostal($packages);
                $xml = $correioslog->toXml(array(), 'correioslog', true);
                Mage::log($xml);
                libxml_use_internal_errors(true);
                $dom = new DOMDocument();
                $dom->loadXML($xml);
                if (!$dom->schemaValidate($correioslog->getXsdSchema())) {
                    $errors = libxml_get_errors();
                    $this->_getSession()->addError($this->__("Schema error: <pre>%s</pre>", print_r($errors, true)));
                } else {
                    $xml = trim(preg_replace('/[\r\n]/', '', $xml));
                    $labels = Mage::helper('pedroteixeira_correios')->getLabelsWithNoDigit($labels);
                    $sigep = Mage::getModel('pedroteixeira_correios/sigepweb');
                    $sigep->setXml($xml)
                        ->setIdPlpCliente(time())
                        ->setListaEtiquetas($labels);
                    $response = $sigep->requestShipment();
                    $idPlp = $response->getPlpId();
                    if (is_numeric($idPlp)) {
                        $this->_getSession()->addSuccess("Success! PLP id: {$idPlp}");
                        // Register the PLP number to shipment comments
                        $txn = Mage::getModel('core/resource_transaction');
                        foreach ($collection as $shipment) {
                            $shipment->addComment($this->__('PLP: %s', (string)$idPlp));
                            $txn->addObject($shipment);
                        }
                        $txn->save();
                    } else {
                        $this->_getSession()->addError($this->__("Error: %s", $response->getError()));
                    }
                }
            }
        }
        
        $this->_redirect('*/sales_shipment/index');
    }
    
    /**
     * ACL allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}
