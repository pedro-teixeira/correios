<?php

class Correios_Rastro_Destinos
{

    /**
     * @var string $local
     * @access public
     */
    public $local = null;

    /**
     * @var string $codigo
     * @access public
     */
    public $codigo = null;

    /**
     * @var string $cidade
     * @access public
     */
    public $cidade = null;

    /**
     * @var string $bairro
     * @access public
     */
    public $bairro = null;

    /**
     * @var string $uf
     * @access public
     */
    public $uf = null;

    /**
     * @param string $local
     * @param string $codigo
     * @param string $cidade
     * @param string $bairro
     * @param string $uf
     * @access public
     */
    public function __construct($local, $codigo, $cidade, $bairro, $uf)
    {
      $this->local = $local;
      $this->codigo = $codigo;
      $this->cidade = $cidade;
      $this->bairro = $bairro;
      $this->uf = $uf;
    }

}
