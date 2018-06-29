<?php

class Correios_Sigep_ClienteERP
{

    /**
     * @var string $cnpj
     * @access public
     */
    public $cnpj = null;

    /**
     * @var contratoERP[] $contratos
     * @access public
     */
    public $contratos = null;

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
     * @var string $descricaoStatusCliente
     * @access public
     */
    public $descricaoStatusCliente = null;

    /**
     * @var gerenteConta[] $gerenteConta
     * @access public
     */
    public $gerenteConta = null;

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
     * @var string $inscricaoEstadual
     * @access public
     */
    public $inscricaoEstadual = null;

    /**
     * @var string $nome
     * @access public
     */
    public $nome = null;

    /**
     * @var string $statusCodigo
     * @access public
     */
    public $statusCodigo = null;

    /**
     * @param string $cnpj
     * @param dateTime $dataAtualizacao
     * @param int $datajAtualizacao
     * @param string $descricaoStatusCliente
     * @param int $horajAtualizacao
     * @param int $id
     * @param string $inscricaoEstadual
     * @param string $nome
     * @param string $statusCodigo
     * @access public
     */
    public function __construct($cnpj, $dataAtualizacao, $datajAtualizacao, $descricaoStatusCliente, $horajAtualizacao, $id, $inscricaoEstadual, $nome, $statusCodigo)
    {
      $this->cnpj = $cnpj;
      $this->dataAtualizacao = $dataAtualizacao;
      $this->datajAtualizacao = $datajAtualizacao;
      $this->descricaoStatusCliente = $descricaoStatusCliente;
      $this->horajAtualizacao = $horajAtualizacao;
      $this->id = $id;
      $this->inscricaoEstadual = $inscricaoEstadual;
      $this->nome = $nome;
      $this->statusCodigo = $statusCodigo;
    }

}
