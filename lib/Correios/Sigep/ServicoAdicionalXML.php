<?php

class Correios_Sigep_ServicoAdicionalXML
{

    /**
     * @var string $codigo
     * @access public
     */
    public $codigo = null;

    /**
     * @var string $descricao
     * @access public
     */
    public $descricao = null;

    /**
     * @var string $sigla
     * @access public
     */
    public $sigla = null;

    /**
     * @param string $codigo
     * @param string $descricao
     * @param string $sigla
     * @access public
     */
    public function __construct($codigo, $descricao, $sigla)
    {
      $this->codigo = $codigo;
      $this->descricao = $descricao;
      $this->sigla = $sigla;
    }

}
