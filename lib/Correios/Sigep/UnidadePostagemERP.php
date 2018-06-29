<?php

class Correios_Sigep_UnidadePostagemERP
{

    /**
     * @var string $diretoriaRegional
     * @access public
     */
    public $diretoriaRegional = null;

    /**
     * @var enderecoERP $endereco
     * @access public
     */
    public $endereco = null;

    /**
     * @var string $id
     * @access public
     */
    public $id = null;

    /**
     * @var string $nome
     * @access public
     */
    public $nome = null;

    /**
     * @var string $status
     * @access public
     */
    public $status = null;

    /**
     * @var string $tipo
     * @access public
     */
    public $tipo = null;

    /**
     * @param string $diretoriaRegional
     * @param enderecoERP $endereco
     * @param string $id
     * @param string $nome
     * @param string $status
     * @param string $tipo
     * @access public
     */
    public function __construct($diretoriaRegional, $endereco, $id, $nome, $status, $tipo)
    {
      $this->diretoriaRegional = $diretoriaRegional;
      $this->endereco = $endereco;
      $this->id = $id;
      $this->nome = $nome;
      $this->status = $status;
      $this->tipo = $tipo;
    }

}
