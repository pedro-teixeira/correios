<?php

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
     * @param string $versao
     * @param string $qtd
     * @param string $TipoPesquisa
     * @param string $TipoResultado
     * @param Correios_Rastro_Objeto $objeto
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
