<?php

class Correios_Sigep_EnderecoERP
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
     * @var string $complemento2
     * @access public
     */
    public $complemento2 = null;

    /**
     * @var string $end
     * @access public
     */
    public $end = null;

    /**
     * @var int $id
     * @access public
     */
    public $id = null;

    /**
     * @var string $uf
     * @access public
     */
    public $uf = null;

    /**
     * @var unidadePostagemERP[] $unidadesPostagem
     * @access public
     */
    public $unidadesPostagem = null;

    /**
     * @param string $bairro
     * @param string $cep
     * @param string $cidade
     * @param string $complemento
     * @param string $complemento2
     * @param string $end
     * @param int $id
     * @param string $uf
     * @access public
     */
    public function __construct($bairro, $cep, $cidade, $complemento, $complemento2, $end, $id, $uf)
    {
      $this->bairro = $bairro;
      $this->cep = $cep;
      $this->cidade = $cidade;
      $this->complemento = $complemento;
      $this->complemento2 = $complemento2;
      $this->end = $end;
      $this->id = $id;
      $this->uf = $uf;
    }

}
