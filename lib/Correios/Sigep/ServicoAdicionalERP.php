<?php

class Correios_Sigep_ServicoAdicionalERP
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
     * @var string $sigla
     * @access public
     */
    public $sigla = null;

    /**
     * @param string $codigo
     * @param dateTime $dataAtualizacao
     * @param int $datajAtualizacao
     * @param string $descricao
     * @param int $horajAtualizacao
     * @param int $id
     * @param string $sigla
     * @access public
     */
    public function __construct($codigo, $dataAtualizacao, $datajAtualizacao, $descricao, $horajAtualizacao, $id, $sigla)
    {
      $this->codigo = $codigo;
      $this->dataAtualizacao = $dataAtualizacao;
      $this->datajAtualizacao = $datajAtualizacao;
      $this->descricao = $descricao;
      $this->horajAtualizacao = $horajAtualizacao;
      $this->id = $id;
      $this->sigla = $sigla;
    }

}
