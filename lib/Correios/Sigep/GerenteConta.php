<?php

class Correios_Sigep_GerenteConta
{

    /**
     * @var clienteERP[] $clientesVisiveis
     * @access public
     */
    public $clientesVisiveis = null;

    /**
     * @var dateTime $dataAtualizacao
     * @access public
     */
    public $dataAtualizacao = null;

    /**
     * @var dateTime $dataInclusao
     * @access public
     */
    public $dataInclusao = null;

    /**
     * @var dateTime $dataSenha
     * @access public
     */
    public $dataSenha = null;

    /**
     * @var string $login
     * @access public
     */
    public $login = null;

    /**
     * @var string $matricula
     * @access public
     */
    public $matricula = null;

    /**
     * @var string $senha
     * @access public
     */
    public $senha = null;

    /**
     * @var statusGerente $status
     * @access public
     */
    public $status = null;

    /**
     * @var tipoGerente $tipoGerente
     * @access public
     */
    public $tipoGerente = null;

    /**
     * @var usuarioInstalacao[] $usuariosInstalacao
     * @access public
     */
    public $usuariosInstalacao = null;

    /**
     * @var string $validade
     * @access public
     */
    public $validade = null;

    /**
     * @param dateTime $dataAtualizacao
     * @param dateTime $dataInclusao
     * @param dateTime $dataSenha
     * @param string $login
     * @param string $matricula
     * @param string $senha
     * @param statusGerente $status
     * @param tipoGerente $tipoGerente
     * @param string $validade
     * @access public
     */
    public function __construct($dataAtualizacao, $dataInclusao, $dataSenha, $login, $matricula, $senha, $status, $tipoGerente, $validade)
    {
      $this->dataAtualizacao = $dataAtualizacao;
      $this->dataInclusao = $dataInclusao;
      $this->dataSenha = $dataSenha;
      $this->login = $login;
      $this->matricula = $matricula;
      $this->senha = $senha;
      $this->status = $status;
      $this->tipoGerente = $tipoGerente;
      $this->validade = $validade;
    }

}
