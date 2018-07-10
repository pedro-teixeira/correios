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
 * @method string getTipoArquivo()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog setTipoArquivo(string $tipoArquivo)
 * @method string getVersaoArquivo()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog setVersaoArquivo(string $versaoArquivo)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Plp getPlp()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog setPlp(PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Plp $plp)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente getRemetente()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog setRemetente(PedroTeixeira_Correios_Model_Sigepweb_Correioslog_Remetente $remetente)
 * @method int getFormaPagamento()
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog setFormaPagamento(int $formaPagamento)
 * @method PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal[] getObjetoPostal()
 * @method setObjetoPostal(PedroTeixeira_Correios_Model_Sigepweb_Correioslog_ObjetoPostal[] $objetoPostal)
 */
class PedroTeixeira_Correios_Model_Sigepweb_Correioslog extends PedroTeixeira_Correios_Model_Sigepweb_Abstract
{

    public function getXsdSchema()
    {
        $path = Mage::getModuleDir('etc', 'pedroteixeira_correios');
        $path = str_replace('Pedroteixeira', 'community/PedroTeixeira', $path);
        return "{$path}/sigep.xsd";
    }
    
    /**
     * @return PedroTeixeira_Correios_Model_Sigepweb_Correioslog
     */
    public function _construct()
    {
        $sender = Mage::getSingleton('pedroteixeira_correios/sigepweb_correioslog_remetente');
        $plp = Mage::getSingleton('pedroteixeira_correios/sigepweb_correioslog_plp');
        
        $this
            ->setTipoArquivo('Postagem')
            ->setVersaoArquivo('2.3')
            ->setPlp($plp->toXml(array(), null))
            ->setRemetente($sender->toXml(array(), null, false, true))
            ->setFormaPagamento();
        
        return $this;
    }
}
