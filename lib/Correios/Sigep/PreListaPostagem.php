<?php

class Correios_Sigep_PreListaPostagem
{

    /**
     * @var cartaoPostagemERP $cartaoPostagem
     * @access public
     */
    public $cartaoPostagem = null;

    /**
     * @var dateTime $dataAtualizacaoCliente
     * @access public
     */
    public $dataAtualizacaoCliente = null;

    /**
     * @var dateTime $dataAtualizacaoSara
     * @access public
     */
    public $dataAtualizacaoSara = null;

    /**
     * @var dateTime $dataFechamento
     * @access public
     */
    public $dataFechamento = null;

    /**
     * @var dateTime $dataPostagem
     * @access public
     */
    public $dataPostagem = null;

    /**
     * @var dateTime $dataPostagemSara
     * @access public
     */
    public $dataPostagemSara = null;

    /**
     * @var objetoPostal[] $objetosPostais
     * @access public
     */
    public $objetosPostais = null;

    /**
     * @var int $plpCliente
     * @access public
     */
    public $plpCliente = null;

    /**
     * @var int $plpNu
     * @access public
     */
    public $plpNu = null;

    /**
     * @var unsignedShort[] $plpXml
     * @access public
     */
    public $plpXml = null;

    /**
     * @var unsignedShort[] $plpXmlRetorno
     * @access public
     */
    public $plpXmlRetorno = null;

    /**
     * @var statusPlp $status
     * @access public
     */
    public $status = null;

    /**
     * @param cartaoPostagemERP $cartaoPostagem
     * @param dateTime $dataAtualizacaoCliente
     * @param dateTime $dataAtualizacaoSara
     * @param dateTime $dataFechamento
     * @param dateTime $dataPostagem
     * @param dateTime $dataPostagemSara
     * @param int $plpCliente
     * @param int $plpNu
     * @param statusPlp $status
     * @access public
     */
    public function __construct($cartaoPostagem, $dataAtualizacaoCliente, $dataAtualizacaoSara, $dataFechamento, $dataPostagem, $dataPostagemSara, $plpCliente, $plpNu, $status)
    {
      $this->cartaoPostagem = $cartaoPostagem;
      $this->dataAtualizacaoCliente = $dataAtualizacaoCliente;
      $this->dataAtualizacaoSara = $dataAtualizacaoSara;
      $this->dataFechamento = $dataFechamento;
      $this->dataPostagem = $dataPostagem;
      $this->dataPostagemSara = $dataPostagemSara;
      $this->plpCliente = $plpCliente;
      $this->plpNu = $plpNu;
      $this->status = $status;
    }

}
