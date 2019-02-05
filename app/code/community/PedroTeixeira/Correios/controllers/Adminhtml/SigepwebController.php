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
                $object->setMethodCode($servico->codigo);
                $object->setMethodTitle(trim($servico->descricao));
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
