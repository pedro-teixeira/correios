<?php

class Correios_Sigep_Pessoa
{

    /**
     * @var string $bairro
     * @access public
     */
    public $bairro = null;

    /**
     * @var string $cep
     * @access public
     */
    public $cep = null;

    /**
     * @var string $cidade
     * @access public
     */
    public $cidade = null;

    /**
     * @var string $complemento
     * @access public
     */
    public $complemento = null;

    /**
     * @var string $ddd
     * @access public
     */
    public $ddd = null;

    /**
     * @var string $email
     * @access public
     */
    public $email = null;

    /**
     * @var string $logradouro
     * @access public
     */
    public $logradouro = null;

    /**
     * @var string $nome
     * @access public
     */
    public $nome = null;

    /**
     * @var string $numero
     * @access public
     */
    public $numero = null;

    /**
     * @var string $referencia
     * @access public
     */
    public $referencia = null;

    /**
     * @var string $telefone
     * @access public
     */
    public $telefone = null;

    /**
     * @var string $uf
     * @access public
     */
    public $uf = null;

    /**
     * @param string $bairro
     * @param string $cep
     * @param string $cidade
     * @param string $complemento
     * @param string $ddd
     * @param string $email
     * @param string $logradouro
     * @param string $nome
     * @param string $numero
     * @param string $referencia
     * @param string $telefone
     * @param string $uf
     * @access public
     */
    public function __construct($bairro, $cep, $cidade, $complemento, $ddd, $email, $logradouro, $nome, $numero, $referencia, $telefone, $uf)
    {
      $this->bairro = $bairro;
      $this->cep = $cep;
      $this->cidade = $cidade;
      $this->complemento = $complemento;
      $this->ddd = $ddd;
      $this->email = $email;
      $this->logradouro = $logradouro;
      $this->nome = $nome;
      $this->numero = $numero;
      $this->referencia = $referencia;
      $this->telefone = $telefone;
      $this->uf = $uf;
    }

}
