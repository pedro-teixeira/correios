<?php

class Correios_Rastro_EnderecoMobile
{

    /**
     * @var string $codigo
     * @access public
     */
    public $codigo = null;

    /**
     * @var string $cep
     * @access public
     */
    public $cep = null;

    /**
     * @var string $logradouro
     * @access public
     */
    public $logradouro = null;

    /**
     * @var string $complemento
     * @access public
     */
    public $complemento = null;

    /**
     * @var string $numero
     * @access public
     */
    public $numero = null;

    /**
     * @var string $localidade
     * @access public
     */
    public $localidade = null;

    /**
     * @var string $uf
     * @access public
     */
    public $uf = null;

    /**
     * @var string $bairro
     * @access public
     */
    public $bairro = null;

    /**
     * @var string $latitude
     * @access public
     */
    public $latitude = null;

    /**
     * @var string $longitude
     * @access public
     */
    public $longitude = null;

    /**
     * @var string $celular
     * @access public
     */
    public $celular = null;

    /**
     * @param string $codigo
     * @param string $cep
     * @param string $logradouro
     * @param string $complemento
     * @param string $numero
     * @param string $localidade
     * @param string $uf
     * @param string $bairro
     * @param string $latitude
     * @param string $longitude
     * @param string $celular
     * @access public
     */
    public function __construct($codigo, $cep, $logradouro, $complemento, $numero, $localidade, $uf, $bairro, $latitude, $longitude, $celular)
    {
      $this->codigo = $codigo;
      $this->cep = $cep;
      $this->logradouro = $logradouro;
      $this->complemento = $complemento;
      $this->numero = $numero;
      $this->localidade = $localidade;
      $this->uf = $uf;
      $this->bairro = $bairro;
      $this->latitude = $latitude;
      $this->longitude = $longitude;
      $this->celular = $celular;
    }

}
