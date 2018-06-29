<?php

class Correios_CalcPrecoPrazo_CalcPrecoPrazoRestricao
{

    /**
     * @var string $nCdEmpresa
     * @access public
     */
    public $nCdEmpresa = null;

    /**
     * @var string $sDsSenha
     * @access public
     */
    public $sDsSenha = null;

    /**
     * @var string $nCdServico
     * @access public
     */
    public $nCdServico = null;

    /**
     * @var string $sCepOrigem
     * @access public
     */
    public $sCepOrigem = null;

    /**
     * @var string $sCepDestino
     * @access public
     */
    public $sCepDestino = null;

    /**
     * @var string $nVlPeso
     * @access public
     */
    public $nVlPeso = null;

    /**
     * @var int $nCdFormato
     * @access public
     */
    public $nCdFormato = null;

    /**
     * @var float $nVlComprimento
     * @access public
     */
    public $nVlComprimento = null;

    /**
     * @var float $nVlAltura
     * @access public
     */
    public $nVlAltura = null;

    /**
     * @var float $nVlLargura
     * @access public
     */
    public $nVlLargura = null;

    /**
     * @var float $nVlDiametro
     * @access public
     */
    public $nVlDiametro = null;

    /**
     * @var string $sCdMaoPropria
     * @access public
     */
    public $sCdMaoPropria = null;

    /**
     * @var float $nVlValorDeclarado
     * @access public
     */
    public $nVlValorDeclarado = null;

    /**
     * @var string $sCdAvisoRecebimento
     * @access public
     */
    public $sCdAvisoRecebimento = null;

    /**
     * @var string $sDtCalculo
     * @access public
     */
    public $sDtCalculo = null;

    /**
     * @param string $nCdEmpresa
     * @param string $sDsSenha
     * @param string $nCdServico
     * @param string $sCepOrigem
     * @param string $sCepDestino
     * @param string $nVlPeso
     * @param int $nCdFormato
     * @param float $nVlComprimento
     * @param float $nVlAltura
     * @param float $nVlLargura
     * @param float $nVlDiametro
     * @param string $sCdMaoPropria
     * @param float $nVlValorDeclarado
     * @param string $sCdAvisoRecebimento
     * @param string $sDtCalculo
     * @access public
     */
    public function __construct($nCdEmpresa, $sDsSenha, $nCdServico, $sCepOrigem, $sCepDestino, $nVlPeso, $nCdFormato, $nVlComprimento, $nVlAltura, $nVlLargura, $nVlDiametro, $sCdMaoPropria, $nVlValorDeclarado, $sCdAvisoRecebimento, $sDtCalculo)
    {
      $this->nCdEmpresa = $nCdEmpresa;
      $this->sDsSenha = $sDsSenha;
      $this->nCdServico = $nCdServico;
      $this->sCepOrigem = $sCepOrigem;
      $this->sCepDestino = $sCepDestino;
      $this->nVlPeso = $nVlPeso;
      $this->nCdFormato = $nCdFormato;
      $this->nVlComprimento = $nVlComprimento;
      $this->nVlAltura = $nVlAltura;
      $this->nVlLargura = $nVlLargura;
      $this->nVlDiametro = $nVlDiametro;
      $this->sCdMaoPropria = $sCdMaoPropria;
      $this->nVlValorDeclarado = $nVlValorDeclarado;
      $this->sCdAvisoRecebimento = $sCdAvisoRecebimento;
      $this->sDtCalculo = $sDtCalculo;
    }

}
