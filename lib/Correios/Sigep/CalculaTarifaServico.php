<?php

class Correios_Sigep_CalculaTarifaServico
{

    /**
     * @var string $codAdministrativo
     * @access public
     */
    public $codAdministrativo = null;

    /**
     * @var string $usuario
     * @access public
     */
    public $usuario = null;

    /**
     * @var string $senha
     * @access public
     */
    public $senha = null;

    /**
     * @var string $codServico
     * @access public
     */
    public $codServico = null;

    /**
     * @var string $cepOrigem
     * @access public
     */
    public $cepOrigem = null;

    /**
     * @var string $cepDestino
     * @access public
     */
    public $cepDestino = null;

    /**
     * @var string $peso
     * @access public
     */
    public $peso = null;

    /**
     * @var int $codFormato
     * @access public
     */
    public $codFormato = null;

    /**
     * @var float $comprimento
     * @access public
     */
    public $comprimento = null;

    /**
     * @var float $altura
     * @access public
     */
    public $altura = null;

    /**
     * @var float $largura
     * @access public
     */
    public $largura = null;

    /**
     * @var float $diametro
     * @access public
     */
    public $diametro = null;

    /**
     * @var string $codMaoPropria
     * @access public
     */
    public $codMaoPropria = null;

    /**
     * @var float $valorDeclarado
     * @access public
     */
    public $valorDeclarado = null;

    /**
     * @var string $codAvisoRecebimento
     * @access public
     */
    public $codAvisoRecebimento = null;

    /**
     * @param string $codAdministrativo
     * @param string $usuario
     * @param string $senha
     * @param string $codServico
     * @param string $cepOrigem
     * @param string $cepDestino
     * @param string $peso
     * @param int $codFormato
     * @param float $comprimento
     * @param float $altura
     * @param float $largura
     * @param float $diametro
     * @param string $codMaoPropria
     * @param float $valorDeclarado
     * @param string $codAvisoRecebimento
     * @access public
     */
    public function __construct($codAdministrativo, $usuario, $senha, $codServico, $cepOrigem, $cepDestino, $peso, $codFormato, $comprimento, $altura, $largura, $diametro, $codMaoPropria, $valorDeclarado, $codAvisoRecebimento)
    {
      $this->codAdministrativo = $codAdministrativo;
      $this->usuario = $usuario;
      $this->senha = $senha;
      $this->codServico = $codServico;
      $this->cepOrigem = $cepOrigem;
      $this->cepDestino = $cepDestino;
      $this->peso = $peso;
      $this->codFormato = $codFormato;
      $this->comprimento = $comprimento;
      $this->altura = $altura;
      $this->largura = $largura;
      $this->diametro = $diametro;
      $this->codMaoPropria = $codMaoPropria;
      $this->valorDeclarado = $valorDeclarado;
      $this->codAvisoRecebimento = $codAvisoRecebimento;
    }

}
