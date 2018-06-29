<?php

include_once('Pessoa.php');

class Correios_Sigep_Remetente extends Correios_Sigep_Pessoa
{

    /**
     * @var string $celular
     * @access public
     */
    public $celular = null;

    /**
     * @var string $ddd_celular
     * @access public
     */
    public $ddd_celular = null;

    /**
     * @var string $identificacao
     * @access public
     */
    public $identificacao = null;

    /**
     * @var string $sms
     * @access public
     */
    public $sms = null;

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
     * @param string $celular
     * @param string $ddd_celular
     * @param string $identificacao
     * @param string $sms
     * @access public
     */
    public function __construct($bairro, $cep, $cidade, $complemento, $ddd, $email, $logradouro, $nome, $numero, $referencia, $telefone, $uf, $celular, $ddd_celular, $identificacao, $sms)
    {
      parent::__construct($bairro, $cep, $cidade, $complemento, $ddd, $email, $logradouro, $nome, $numero, $referencia, $telefone, $uf);
      $this->celular = $celular;
      $this->ddd_celular = $ddd_celular;
      $this->identificacao = $identificacao;
      $this->sms = $sms;
    }

}
