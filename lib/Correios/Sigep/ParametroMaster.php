<?php

class Correios_Sigep_ParametroMaster
{

    /**
     * @var int $prmCoParametro
     * @access public
     */
    public $prmCoParametro = null;

    /**
     * @var string $prmTxParametro
     * @access public
     */
    public $prmTxParametro = null;

    /**
     * @var string $prmTxValor
     * @access public
     */
    public $prmTxValor = null;

    /**
     * @param int $prmCoParametro
     * @param string $prmTxParametro
     * @param string $prmTxValor
     * @access public
     */
    public function __construct($prmCoParametro, $prmTxParametro, $prmTxValor)
    {
      $this->prmCoParametro = $prmCoParametro;
      $this->prmTxParametro = $prmTxParametro;
      $this->prmTxValor = $prmTxValor;
    }

}
