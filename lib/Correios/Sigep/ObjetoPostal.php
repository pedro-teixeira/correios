<?php

class Correios_Sigep_ObjetoPostal
{

    /**
     * @var string $codigoEtiqueta
     * @access public
     */
    public $codigoEtiqueta = null;

    /**
     * @var dateTime $dataAtualizacaoCliente
     * @access public
     */
    public $dataAtualizacaoCliente = null;

    /**
     * @var dateTime $dataBloqueioObjeto
     * @access public
     */
    public $dataBloqueioObjeto = null;

    /**
     * @var dateTime $dataCancelamentoEtiqueta
     * @access public
     */
    public $dataCancelamentoEtiqueta = null;

    /**
     * @var dateTime $dataInclusao
     * @access public
     */
    public $dataInclusao = null;

    /**
     * @var objetoPostalPK $objetoPostalPK
     * @access public
     */
    public $objetoPostalPK = null;

    /**
     * @var int $plpNu
     * @access public
     */
    public $plpNu = null;

    /**
     * @var preListaPostagem $preListaPostagem
     * @access public
     */
    public $preListaPostagem = null;

    /**
     * @var string $statusBloqueio
     * @access public
     */
    public $statusBloqueio = null;

    /**
     * @var statusObjetoPostal $statusEtiqueta
     * @access public
     */
    public $statusEtiqueta = null;

    /**
     * @param string $codigoEtiqueta
     * @param dateTime $dataAtualizacaoCliente
     * @param dateTime $dataBloqueioObjeto
     * @param dateTime $dataCancelamentoEtiqueta
     * @param dateTime $dataInclusao
     * @param objetoPostalPK $objetoPostalPK
     * @param int $plpNu
     * @param preListaPostagem $preListaPostagem
     * @param string $statusBloqueio
     * @param statusObjetoPostal $statusEtiqueta
     * @access public
     */
    public function __construct($codigoEtiqueta, $dataAtualizacaoCliente, $dataBloqueioObjeto, $dataCancelamentoEtiqueta, $dataInclusao, $objetoPostalPK, $plpNu, $preListaPostagem, $statusBloqueio, $statusEtiqueta)
    {
      $this->codigoEtiqueta = $codigoEtiqueta;
      $this->dataAtualizacaoCliente = $dataAtualizacaoCliente;
      $this->dataBloqueioObjeto = $dataBloqueioObjeto;
      $this->dataCancelamentoEtiqueta = $dataCancelamentoEtiqueta;
      $this->dataInclusao = $dataInclusao;
      $this->objetoPostalPK = $objetoPostalPK;
      $this->plpNu = $plpNu;
      $this->preListaPostagem = $preListaPostagem;
      $this->statusBloqueio = $statusBloqueio;
      $this->statusEtiqueta = $statusEtiqueta;
    }

}
