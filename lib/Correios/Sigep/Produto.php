<?php

class Correios_Sigep_Produto
{

    /**
     * @var string $codigo
     * @access public
     */
    public $codigo = null;

    /**
     * @var string $qtd
     * @access public
     */
    public $qtd = null;

    /**
     * @var string $tipo
     * @access public
     */
    public $tipo = null;

    /**
     * @param string $codigo
     * @param string $qtd
     * @param string $tipo
     * @access public
     */
    public function __construct($codigo, $qtd, $tipo)
    {
      $this->codigo = $codigo;
      $this->qtd = $qtd;
      $this->tipo = $tipo;
    }

}
