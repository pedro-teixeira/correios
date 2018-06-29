<?php

class Correios_Sigep_EmbalagemLRSMaster
{

    /**
     * @var string $codigo
     * @access public
     */
    public $codigo = null;

    /**
     * @var string $nome
     * @access public
     */
    public $nome = null;

    /**
     * @var string $tipo
     * @access public
     */
    public $tipo = null;

    /**
     * @param string $codigo
     * @param string $nome
     * @param string $tipo
     * @access public
     */
    public function __construct($codigo, $nome, $tipo)
    {
      $this->codigo = $codigo;
      $this->nome = $nome;
      $this->tipo = $tipo;
    }

}
