<?php

class Correios_Sigep_ServicoSigep
{

    /**
     * @var categoriaServico $categoriaServico
     * @access public
     */
    public $categoriaServico = null;

    /**
     * @var chancelaMaster $chancela
     * @access public
     */
    public $chancela = null;

    /**
     * @var boolean $exigeDimensoes
     * @access public
     */
    public $exigeDimensoes = null;

    /**
     * @var boolean $exigeValorCobrar
     * @access public
     */
    public $exigeValorCobrar = null;

    /**
     * @var int $imitm
     * @access public
     */
    public $imitm = null;

    /**
     * @var string $pagamentoEntrega
     * @access public
     */
    public $pagamentoEntrega = null;

    /**
     * @var string $remessaAgrupada
     * @access public
     */
    public $remessaAgrupada = null;

    /**
     * @var int $servico
     * @access public
     */
    public $servico = null;

    /**
     * @var servicoERP $servicoERP
     * @access public
     */
    public $servicoERP = null;

    /**
     * @var string $ssiCoCodigoPostal
     * @access public
     */
    public $ssiCoCodigoPostal = null;

    /**
     * @param categoriaServico $categoriaServico
     * @param chancelaMaster $chancela
     * @param boolean $exigeDimensoes
     * @param boolean $exigeValorCobrar
     * @param int $imitm
     * @param string $pagamentoEntrega
     * @param string $remessaAgrupada
     * @param int $servico
     * @param servicoERP $servicoERP
     * @param string $ssiCoCodigoPostal
     * @access public
     */
    public function __construct($categoriaServico, $chancela, $exigeDimensoes, $exigeValorCobrar, $imitm, $pagamentoEntrega, $remessaAgrupada, $servico, $servicoERP, $ssiCoCodigoPostal)
    {
      $this->categoriaServico = $categoriaServico;
      $this->chancela = $chancela;
      $this->exigeDimensoes = $exigeDimensoes;
      $this->exigeValorCobrar = $exigeValorCobrar;
      $this->imitm = $imitm;
      $this->pagamentoEntrega = $pagamentoEntrega;
      $this->remessaAgrupada = $remessaAgrupada;
      $this->servico = $servico;
      $this->servicoERP = $servicoERP;
      $this->ssiCoCodigoPostal = $ssiCoCodigoPostal;
    }

}
