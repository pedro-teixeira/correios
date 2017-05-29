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
class Correios_Rastro_Sroxml
{

    /**
     * @var string $versao
     * @access public
     */
    public $versao = null;

    /**
     * @var string $qtd
     * @access public
     */
    public $qtd = null;

    /**
     * @var string $TipoPesquisa
     * @access public
     */
    public $TipoPesquisa = null;

    /**
     * @var string $TipoResultado
     * @access public
     */
    public $TipoResultado = null;

    /**
     * @var Correios_Rastro_Objeto $objeto
     * @access public
     */
    public $objeto = null;

    /**
     * Class constructor method
     *
     * @param string                 $versao        Release
     * @param string                 $qtd           Quantity
     * @param string                 $TipoPesquisa  Search Type
     * @param string                 $TipoResultado Result Type
     * @param Correios_Rastro_Objeto $objeto        Object
     *
     * @access public
     */
    public function __construct($versao, $qtd, $TipoPesquisa, $TipoResultado, $objeto)
    {
        $this->versao = $versao;
        $this->qtd = $qtd;
        $this->TipoPesquisa = $TipoPesquisa;
        $this->TipoResultado = $TipoResultado;
        $this->objeto = $objeto;
    }
}
