<?php

class Correios_CalcPrecoPrazo_CObjeto
{

    /**
     * @var string $codigo
     * @access public
     */
    public $codigo = null;

    /**
     * @var string $servico
     * @access public
     */
    public $servico = null;

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
     * @var int $prazoEntrega
     * @access public
     */
    public $prazoEntrega = null;

    /**
     * @var string $dataPostagem
     * @access public
     */
    public $dataPostagem = null;

    /**
     * @var string $dataPostagemCalculo
     * @access public
     */
    public $dataPostagemCalculo = null;

    /**
     * @var string $dataMaxEntrega
     * @access public
     */
    public $dataMaxEntrega = null;

    /**
     * @var string $postagemDH
     * @access public
     */
    public $postagemDH = null;

    /**
     * @var string $dataUltimoEvento
     * @access public
     */
    public $dataUltimoEvento = null;

    /**
     * @var string $codigoUltimoEvento
     * @access public
     */
    public $codigoUltimoEvento = null;

    /**
     * @var string $tipoUltimoEvento
     * @access public
     */
    public $tipoUltimoEvento = null;

    /**
     * @var string $descricaoUltimoEvento
     * @access public
     */
    public $descricaoUltimoEvento = null;

    /**
     * @var string $erro
     * @access public
     */
    public $erro = null;

    /**
     * @var string $msgErro
     * @access public
     */
    public $msgErro = null;

    /**
     * @param string $codigo
     * @param string $servico
     * @param string $cepOrigem
     * @param string $cepDestino
     * @param int $prazoEntrega
     * @param string $dataPostagem
     * @param string $dataPostagemCalculo
     * @param string $dataMaxEntrega
     * @param string $postagemDH
     * @param string $dataUltimoEvento
     * @param string $codigoUltimoEvento
     * @param string $tipoUltimoEvento
     * @param string $descricaoUltimoEvento
     * @param string $erro
     * @param string $msgErro
     * @access public
     */
    public function __construct($codigo, $servico, $cepOrigem, $cepDestino, $prazoEntrega, $dataPostagem, $dataPostagemCalculo, $dataMaxEntrega, $postagemDH, $dataUltimoEvento, $codigoUltimoEvento, $tipoUltimoEvento, $descricaoUltimoEvento, $erro, $msgErro)
    {
      $this->codigo = $codigo;
      $this->servico = $servico;
      $this->cepOrigem = $cepOrigem;
      $this->cepDestino = $cepDestino;
      $this->prazoEntrega = $prazoEntrega;
      $this->dataPostagem = $dataPostagem;
      $this->dataPostagemCalculo = $dataPostagemCalculo;
      $this->dataMaxEntrega = $dataMaxEntrega;
      $this->postagemDH = $postagemDH;
      $this->dataUltimoEvento = $dataUltimoEvento;
      $this->codigoUltimoEvento = $codigoUltimoEvento;
      $this->tipoUltimoEvento = $tipoUltimoEvento;
      $this->descricaoUltimoEvento = $descricaoUltimoEvento;
      $this->erro = $erro;
      $this->msgErro = $msgErro;
    }

}
