<?php

class Correios_Sigep_VigenciaERP
{

    /**
     * @var dateTime $dataFinal
     * @access public
     */
    public $dataFinal = null;

    /**
     * @var dateTime $dataInicial
     * @access public
     */
    public $dataInicial = null;

    /**
     * @var int $datajFim
     * @access public
     */
    public $datajFim = null;

    /**
     * @var int $datajIni
     * @access public
     */
    public $datajIni = null;

    /**
     * @var int $id
     * @access public
     */
    public $id = null;

    /**
     * @param dateTime $dataFinal
     * @param dateTime $dataInicial
     * @param int $datajFim
     * @param int $datajIni
     * @param int $id
     * @access public
     */
    public function __construct($dataFinal, $dataInicial, $datajFim, $datajIni, $id)
    {
      $this->dataFinal = $dataFinal;
      $this->dataInicial = $dataInicial;
      $this->datajFim = $datajFim;
      $this->datajIni = $datajIni;
      $this->id = $id;
    }

}
