<?php

class Correios_Sigep_ValePostal
{

    /**
     * @var string $cidNoCidade
     * @access public
     */
    public $cidNoCidade = null;

    /**
     * @var string $ctcCoAadministrativo
     * @access public
     */
    public $ctcCoAadministrativo = null;

    /**
     * @var int $ctcNuContrato
     * @access public
     */
    public $ctcNuContrato = null;

    /**
     * @var int $ctcNuContratoEct
     * @access public
     */
    public $ctcNuContratoEct = null;

    /**
     * @var string $cvpEdBairro
     * @access public
     */
    public $cvpEdBairro = null;

    /**
     * @var string $cvpEdCliente
     * @access public
     */
    public $cvpEdCliente = null;

    /**
     * @var string $cvpEdComplemento
     * @access public
     */
    public $cvpEdComplemento = null;

    /**
     * @var string $cvpEdNumero
     * @access public
     */
    public $cvpEdNumero = null;

    /**
     * @var string $cvpNoCliente
     * @access public
     */
    public $cvpNoCliente = null;

    /**
     * @var int $cvpNuCep
     * @access public
     */
    public $cvpNuCep = null;

    /**
     * @var string $descricaoErro
     * @access public
     */
    public $descricaoErro = null;

    /**
     * @var string $estSgEstado
     * @access public
     */
    public $estSgEstado = null;

    /**
     * @var int $monVarTarifaAdicional
     * @access public
     */
    public $monVarTarifaAdicional = null;

    /**
     * @var int $monVarTarifaServico
     * @access public
     */
    public $monVarTarifaServico = null;

    /**
     * @var int $monVarValorDescontos
     * @access public
     */
    public $monVarValorDescontos = null;

    /**
     * @var int $monVarValorImposto
     * @access public
     */
    public $monVarValorImposto = null;

    /**
     * @var int $prsCoProdutoServico
     * @access public
     */
    public $prsCoProdutoServico = null;

    /**
     * @var int $pveNu
     * @access public
     */
    public $pveNu = null;

    /**
     * @var int $pveOrgNuAgencia
     * @access public
     */
    public $pveOrgNuAgencia = null;

    /**
     * @var int $pveOrgNuAgenciaDes
     * @access public
     */
    public $pveOrgNuAgenciaDes = null;

    /**
     * @var int $pveOrgNuAgenciaOri
     * @access public
     */
    public $pveOrgNuAgenciaOri = null;

    /**
     * @var int $retornaCodErro
     * @access public
     */
    public $retornaCodErro = null;

    /**
     * @var string $sitNoSituacao
     * @access public
     */
    public $sitNoSituacao = null;

    /**
     * @var string $tlgTxDescricao
     * @access public
     */
    public $tlgTxDescricao = null;

    /**
     * @var dateTime $vapDhTransacao
     * @access public
     */
    public $vapDhTransacao = null;

    /**
     * @var string $vapNuEtiquetaEncomenda
     * @access public
     */
    public $vapNuEtiquetaEncomenda = null;

    /**
     * @var float $vapVrCobradoEct
     * @access public
     */
    public $vapVrCobradoEct = null;

    /**
     * @var float $vapVrNominal
     * @access public
     */
    public $vapVrNominal = null;

    /**
     * @param string $cidNoCidade
     * @param string $ctcCoAadministrativo
     * @param int $ctcNuContrato
     * @param int $ctcNuContratoEct
     * @param string $cvpEdBairro
     * @param string $cvpEdCliente
     * @param string $cvpEdComplemento
     * @param string $cvpEdNumero
     * @param string $cvpNoCliente
     * @param int $cvpNuCep
     * @param string $descricaoErro
     * @param string $estSgEstado
     * @param int $monVarTarifaAdicional
     * @param int $monVarTarifaServico
     * @param int $monVarValorDescontos
     * @param int $monVarValorImposto
     * @param int $prsCoProdutoServico
     * @param int $pveNu
     * @param int $pveOrgNuAgencia
     * @param int $pveOrgNuAgenciaDes
     * @param int $pveOrgNuAgenciaOri
     * @param int $retornaCodErro
     * @param string $sitNoSituacao
     * @param string $tlgTxDescricao
     * @param dateTime $vapDhTransacao
     * @param string $vapNuEtiquetaEncomenda
     * @param float $vapVrCobradoEct
     * @param float $vapVrNominal
     * @access public
     */
    public function __construct($cidNoCidade, $ctcCoAadministrativo, $ctcNuContrato, $ctcNuContratoEct, $cvpEdBairro, $cvpEdCliente, $cvpEdComplemento, $cvpEdNumero, $cvpNoCliente, $cvpNuCep, $descricaoErro, $estSgEstado, $monVarTarifaAdicional, $monVarTarifaServico, $monVarValorDescontos, $monVarValorImposto, $prsCoProdutoServico, $pveNu, $pveOrgNuAgencia, $pveOrgNuAgenciaDes, $pveOrgNuAgenciaOri, $retornaCodErro, $sitNoSituacao, $tlgTxDescricao, $vapDhTransacao, $vapNuEtiquetaEncomenda, $vapVrCobradoEct, $vapVrNominal)
    {
      $this->cidNoCidade = $cidNoCidade;
      $this->ctcCoAadministrativo = $ctcCoAadministrativo;
      $this->ctcNuContrato = $ctcNuContrato;
      $this->ctcNuContratoEct = $ctcNuContratoEct;
      $this->cvpEdBairro = $cvpEdBairro;
      $this->cvpEdCliente = $cvpEdCliente;
      $this->cvpEdComplemento = $cvpEdComplemento;
      $this->cvpEdNumero = $cvpEdNumero;
      $this->cvpNoCliente = $cvpNoCliente;
      $this->cvpNuCep = $cvpNuCep;
      $this->descricaoErro = $descricaoErro;
      $this->estSgEstado = $estSgEstado;
      $this->monVarTarifaAdicional = $monVarTarifaAdicional;
      $this->monVarTarifaServico = $monVarTarifaServico;
      $this->monVarValorDescontos = $monVarValorDescontos;
      $this->monVarValorImposto = $monVarValorImposto;
      $this->prsCoProdutoServico = $prsCoProdutoServico;
      $this->pveNu = $pveNu;
      $this->pveOrgNuAgencia = $pveOrgNuAgencia;
      $this->pveOrgNuAgenciaDes = $pveOrgNuAgenciaDes;
      $this->pveOrgNuAgenciaOri = $pveOrgNuAgenciaOri;
      $this->retornaCodErro = $retornaCodErro;
      $this->sitNoSituacao = $sitNoSituacao;
      $this->tlgTxDescricao = $tlgTxDescricao;
      $this->vapDhTransacao = $vapDhTransacao;
      $this->vapNuEtiquetaEncomenda = $vapNuEtiquetaEncomenda;
      $this->vapVrCobradoEct = $vapVrCobradoEct;
      $this->vapVrNominal = $vapVrNominal;
    }

}
