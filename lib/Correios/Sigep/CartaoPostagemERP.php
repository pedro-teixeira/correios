<?php

class Correios_Sigep_CartaoPostagemERP
{

    /**
     * @var string $codigoAdministrativo
     * @access public
     */
    public $codigoAdministrativo = null;

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
     * @var dateTime $dataVigenciaFim
     * @access public
     */
    public $dataVigenciaFim = null;

    /**
     * @var dateTime $dataVigenciaInicio
     * @access public
     */
    public $dataVigenciaInicio = null;

    /**
     * @var int $datajAtualizacao
     * @access public
     */
    public $datajAtualizacao = null;

    /**
     * @var int $datajVigenciaFim
     * @access public
     */
    public $datajVigenciaFim = null;

    /**
     * @var int $datajVigenciaInicio
     * @access public
     */
    public $datajVigenciaInicio = null;

    /**
     * @var string $descricaoStatusCartao
     * @access public
     */
    public $descricaoStatusCartao = null;

    /**
     * @var string $descricaoUnidadePostagemGenerica
     * @access public
     */
    public $descricaoUnidadePostagemGenerica = null;

    /**
     * @var int $horajAtualizacao
     * @access public
     */
    public $horajAtualizacao = null;

    /**
     * @var string $numero
     * @access public
     */
    public $numero = null;

    /**
     * @var servicoERP[] $servicos
     * @access public
     */
    public $servicos = null;

    /**
     * @var string $statusCartaoPostagem
     * @access public
     */
    public $statusCartaoPostagem = null;

    /**
     * @var string $statusCodigo
     * @access public
     */
    public $statusCodigo = null;

    /**
     * @var string $unidadeGenerica
     * @access public
     */
    public $unidadeGenerica = null;

    /**
     * @var unidadePostagemERP[] $unidadesPostagem
     * @access public
     */
    public $unidadesPostagem = null;

    /**
     * @param string $codigoAdministrativo
     * @param dateTime $dataAtualizacao
     * @param dateTime $dataVigenciaFim
     * @param dateTime $dataVigenciaInicio
     * @param int $datajAtualizacao
     * @param int $datajVigenciaFim
     * @param int $datajVigenciaInicio
     * @param string $descricaoStatusCartao
     * @param string $descricaoUnidadePostagemGenerica
     * @param int $horajAtualizacao
     * @param string $numero
     * @param string $statusCartaoPostagem
     * @param string $statusCodigo
     * @param string $unidadeGenerica
     * @access public
     */
    public function __construct($codigoAdministrativo, $dataAtualizacao, $dataVigenciaFim, $dataVigenciaInicio, $datajAtualizacao, $datajVigenciaFim, $datajVigenciaInicio, $descricaoStatusCartao, $descricaoUnidadePostagemGenerica, $horajAtualizacao, $numero, $statusCartaoPostagem, $statusCodigo, $unidadeGenerica)
    {
      $this->codigoAdministrativo = $codigoAdministrativo;
      $this->dataAtualizacao = $dataAtualizacao;
      $this->dataVigenciaFim = $dataVigenciaFim;
      $this->dataVigenciaInicio = $dataVigenciaInicio;
      $this->datajAtualizacao = $datajAtualizacao;
      $this->datajVigenciaFim = $datajVigenciaFim;
      $this->datajVigenciaInicio = $datajVigenciaInicio;
      $this->descricaoStatusCartao = $descricaoStatusCartao;
      $this->descricaoUnidadePostagemGenerica = $descricaoUnidadePostagemGenerica;
      $this->horajAtualizacao = $horajAtualizacao;
      $this->numero = $numero;
      $this->statusCartaoPostagem = $statusCartaoPostagem;
      $this->statusCodigo = $statusCodigo;
      $this->unidadeGenerica = $unidadeGenerica;
    }

}
