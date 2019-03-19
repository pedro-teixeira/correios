<?php

class Correios_CalcPrecoPrazo_CServico
{

    /**
     * @var int $Codigo
     * @access public
     */
    public $Codigo = null;

    /**
     * @var string $Valor
     * @access public
     */
    public $Valor = null;

    /**
     * @var string $PrazoEntrega
     * @access public
     */
    public $PrazoEntrega = null;

    /**
     * @var string $ValorMaoPropria
     * @access public
     */
    public $ValorMaoPropria = null;

    /**
     * @var string $ValorAvisoRecebimento
     * @access public
     */
    public $ValorAvisoRecebimento = null;

    /**
     * @var string $ValorValorDeclarado
     * @access public
     */
    public $ValorValorDeclarado = null;

    /**
     * @var string $EntregaDomiciliar
     * @access public
     */
    public $EntregaDomiciliar = null;

    /**
     * @var string $EntregaSabado
     * @access public
     */
    public $EntregaSabado = null;

    /**
     * @var string $Erro
     * @access public
     */
    public $Erro = null;

    /**
     * @var string $MsgErro
     * @access public
     */
    public $MsgErro = null;

    /**
     * @var string $ValorSemAdicionais
     * @access public
     */
    public $ValorSemAdicionais = null;

    /**
     * @var string $obsFim
     * @access public
     */
    public $obsFim = null;

    /**
     * @var string $DataMaxEntrega
     * @access public
     */
    public $DataMaxEntrega = null;

    /**
     * @var string $HoraMaxEntrega
     * @access public
     */
    public $HoraMaxEntrega = null;

    /**
     * @param int $Codigo
     * @param string $Valor
     * @param string $PrazoEntrega
     * @param string $ValorMaoPropria
     * @param string $ValorAvisoRecebimento
     * @param string $ValorValorDeclarado
     * @param string $EntregaDomiciliar
     * @param string $EntregaSabado
     * @param string $Erro
     * @param string $MsgErro
     * @param string $ValorSemAdicionais
     * @param string $obsFim
     * @param string $DataMaxEntrega
     * @param string $HoraMaxEntrega
     * @access public
     */
    public function __construct($Codigo, $Valor, $PrazoEntrega, $ValorMaoPropria, $ValorAvisoRecebimento, $ValorValorDeclarado, $EntregaDomiciliar, $EntregaSabado, $Erro, $MsgErro, $ValorSemAdicionais, $obsFim, $DataMaxEntrega, $HoraMaxEntrega)
    {
      $this->Codigo = $Codigo;
      $this->Valor = $Valor;
      $this->PrazoEntrega = $PrazoEntrega;
      $this->ValorMaoPropria = $ValorMaoPropria;
      $this->ValorAvisoRecebimento = $ValorAvisoRecebimento;
      $this->ValorValorDeclarado = $ValorValorDeclarado;
      $this->EntregaDomiciliar = $EntregaDomiciliar;
      $this->EntregaSabado = $EntregaSabado;
      $this->Erro = $Erro;
      $this->MsgErro = $MsgErro;
      $this->ValorSemAdicionais = $ValorSemAdicionais;
      $this->obsFim = $obsFim;
      $this->DataMaxEntrega = $DataMaxEntrega;
      $this->HoraMaxEntrega = $HoraMaxEntrega;
    }

}
