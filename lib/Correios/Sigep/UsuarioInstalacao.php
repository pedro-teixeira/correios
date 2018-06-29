<?php

class Correios_Sigep_UsuarioInstalacao
{

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
     * @var gerenteConta $gerenteMaster
     * @access public
     */
    public $gerenteMaster = null;

    /**
     * @var string $hashSenha
     * @access public
     */
    public $hashSenha = null;

    /**
     * @var int $id
     * @access public
     */
    public $id = null;

    /**
     * @var string $login
     * @access public
     */
    public $login = null;

    /**
     * @var string $nome
     * @access public
     */
    public $nome = null;

    /**
     * @var parametroMaster[] $parametros
     * @access public
     */
    public $parametros = null;

    /**
     * @var string $senha
     * @access public
     */
    public $senha = null;

    /**
     * @var statusUsuario $status
     * @access public
     */
    public $status = null;

    /**
     * @var string $validade
     * @access public
     */
    public $validade = null;

    /**
     * @param dateTime $dataAtualizacao
     * @param dateTime $dataInclusao
     * @param dateTime $dataSenha
     * @param gerenteConta $gerenteMaster
     * @param string $hashSenha
     * @param int $id
     * @param string $login
     * @param string $nome
     * @param string $senha
     * @param statusUsuario $status
     * @param string $validade
     * @access public
     */
    public function __construct($dataAtualizacao, $dataInclusao, $dataSenha, $gerenteMaster, $hashSenha, $id, $login, $nome, $senha, $status, $validade)
    {
      $this->dataAtualizacao = $dataAtualizacao;
      $this->dataInclusao = $dataInclusao;
      $this->dataSenha = $dataSenha;
      $this->gerenteMaster = $gerenteMaster;
      $this->hashSenha = $hashSenha;
      $this->id = $id;
      $this->login = $login;
      $this->nome = $nome;
      $this->senha = $senha;
      $this->status = $status;
      $this->validade = $validade;
    }

}
