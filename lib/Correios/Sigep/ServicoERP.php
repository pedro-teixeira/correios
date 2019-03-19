<?php

class Correios_Sigep_ServicoERP
{

    /**
     * @var string $codigo
     * @access public
     */
    public $codigo = null;

    /**
     * @var dateTime $dataAtualizacao
     * @access public
     */
    public $dataAtualizacao = null;

    /**
     * @var int $datajAtualizacao
     * @access public
     */
    public $datajAtualizacao = null;

    /**
     * @var string $descricao
     * @access public
     */
    public $descricao = null;

    /**
     * @var int $horajAtualizacao
     * @access public
     */
    public $horajAtualizacao = null;

    /**
     * @var int $id
     * @access public
     */
    public $id = null;

    /**
     * @var servicoSigep $servicoSigep
     * @access public
     */
    public $servicoSigep = null;

    /**
     * @var servicoAdicionalERP[] $servicosAdicionais
     * @access public
     */
    public $servicosAdicionais = null;

    /**
     * @var string $tipo1Codigo
     * @access public
     */
    public $tipo1Codigo = null;

    /**
     * @var string $tipo1Descricao
     * @access public
     */
    public $tipo1Descricao = null;

    /**
     * @var string $tipo2Codigo
     * @access public
     */
    public $tipo2Codigo = null;

    /**
     * @var string $tipo2Descricao
     * @access public
     */
    public $tipo2Descricao = null;

    /**
     * @var vigenciaERP $vigencia
     * @access public
     */
    public $vigencia = null;

    /**
     * @param string $codigo
     * @param dateTime $dataAtualizacao
     * @param int $datajAtualizacao
     * @param string $descricao
     * @param int $horajAtualizacao
     * @param int $id
     * @param servicoSigep $servicoSigep
     * @param string $tipo1Codigo
     * @param string $tipo1Descricao
     * @param string $tipo2Codigo
     * @param string $tipo2Descricao
     * @param vigenciaERP $vigencia
     * @access public
     */
    public function __construct($codigo, $dataAtualizacao, $datajAtualizacao, $descricao, $horajAtualizacao, $id, $servicoSigep, $tipo1Codigo, $tipo1Descricao, $tipo2Codigo, $tipo2Descricao, $vigencia)
    {
      $this->codigo = $codigo;
      $this->dataAtualizacao = $dataAtualizacao;
      $this->datajAtualizacao = $datajAtualizacao;
      $this->descricao = $descricao;
      $this->horajAtualizacao = $horajAtualizacao;
      $this->id = $id;
      $this->servicoSigep = $servicoSigep;
      $this->tipo1Codigo = $tipo1Codigo;
      $this->tipo1Descricao = $tipo1Descricao;
      $this->tipo2Codigo = $tipo2Codigo;
      $this->tipo2Descricao = $tipo2Descricao;
      $this->vigencia = $vigencia;
    }

}
