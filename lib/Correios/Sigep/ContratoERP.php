<?php

class Correios_Sigep_ContratoERP
{

    /**
     * @var cartaoPostagemERP[] $cartoesPostagem
     * @access public
     */
    public $cartoesPostagem = null;

    /**
     * @var clienteERP $cliente
     * @access public
     */
    public $cliente = null;

    /**
     * @var int $codigoCliente
     * @access public
     */
    public $codigoCliente = null;

    /**
     * @var string $codigoDiretoria
     * @access public
     */
    public $codigoDiretoria = null;

    /**
     * @var contratoERPPK $contratoPK
     * @access public
     */
    public $contratoPK = null;

    /**
     * @var dateTime $dataAtualizacao
     * @access public
     */
    public $dataAtualizacao = null;

    /**
     * @var string $dataAtualizacaoDDMMYYYY
     * @access public
     */
    public $dataAtualizacaoDDMMYYYY = null;

    /**
     * @var dateTime $dataVigenciaFim
     * @access public
     */
    public $dataVigenciaFim = null;

    /**
     * @var string $dataVigenciaFimDDMMYYYY
     * @access public
     */
    public $dataVigenciaFimDDMMYYYY = null;

    /**
     * @var dateTime $dataVigenciaInicio
     * @access public
     */
    public $dataVigenciaInicio = null;

    /**
     * @var string $dataVigenciaInicioDDMMYYYY
     * @access public
     */
    public $dataVigenciaInicioDDMMYYYY = null;

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
     * @var string $descricaoDiretoriaRegional
     * @access public
     */
    public $descricaoDiretoriaRegional = null;

    /**
     * @var string $descricaoStatus
     * @access public
     */
    public $descricaoStatus = null;

    /**
     * @var unidadePostagemERP $diretoriaRegional
     * @access public
     */
    public $diretoriaRegional = null;

    /**
     * @var int $horajAtualizacao
     * @access public
     */
    public $horajAtualizacao = null;

    /**
     * @var string $statusCodigo
     * @access public
     */
    public $statusCodigo = null;

    /**
     * @param clienteERP $cliente
     * @param int $codigoCliente
     * @param string $codigoDiretoria
     * @param contratoERPPK $contratoPK
     * @param dateTime $dataAtualizacao
     * @param string $dataAtualizacaoDDMMYYYY
     * @param dateTime $dataVigenciaFim
     * @param string $dataVigenciaFimDDMMYYYY
     * @param dateTime $dataVigenciaInicio
     * @param string $dataVigenciaInicioDDMMYYYY
     * @param int $datajAtualizacao
     * @param int $datajVigenciaFim
     * @param int $datajVigenciaInicio
     * @param string $descricaoDiretoriaRegional
     * @param string $descricaoStatus
     * @param unidadePostagemERP $diretoriaRegional
     * @param int $horajAtualizacao
     * @param string $statusCodigo
     * @access public
     */
    public function __construct($cliente, $codigoCliente, $codigoDiretoria, $contratoPK, $dataAtualizacao, $dataAtualizacaoDDMMYYYY, $dataVigenciaFim, $dataVigenciaFimDDMMYYYY, $dataVigenciaInicio, $dataVigenciaInicioDDMMYYYY, $datajAtualizacao, $datajVigenciaFim, $datajVigenciaInicio, $descricaoDiretoriaRegional, $descricaoStatus, $diretoriaRegional, $horajAtualizacao, $statusCodigo)
    {
      $this->cliente = $cliente;
      $this->codigoCliente = $codigoCliente;
      $this->codigoDiretoria = $codigoDiretoria;
      $this->contratoPK = $contratoPK;
      $this->dataAtualizacao = $dataAtualizacao;
      $this->dataAtualizacaoDDMMYYYY = $dataAtualizacaoDDMMYYYY;
      $this->dataVigenciaFim = $dataVigenciaFim;
      $this->dataVigenciaFimDDMMYYYY = $dataVigenciaFimDDMMYYYY;
      $this->dataVigenciaInicio = $dataVigenciaInicio;
      $this->dataVigenciaInicioDDMMYYYY = $dataVigenciaInicioDDMMYYYY;
      $this->datajAtualizacao = $datajAtualizacao;
      $this->datajVigenciaFim = $datajVigenciaFim;
      $this->datajVigenciaInicio = $datajVigenciaInicio;
      $this->descricaoDiretoriaRegional = $descricaoDiretoriaRegional;
      $this->descricaoStatus = $descricaoStatus;
      $this->diretoriaRegional = $diretoriaRegional;
      $this->horajAtualizacao = $horajAtualizacao;
      $this->statusCodigo = $statusCodigo;
    }

}
