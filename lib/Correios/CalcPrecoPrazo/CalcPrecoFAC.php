<?php

class Correios_CalcPrecoPrazo_CalcPrecoFAC
{

    /**
     * @var string $nCdServico
     * @access public
     */
    public $nCdServico = null;

    /**
     * @var string $nVlPeso
     * @access public
     */
    public $nVlPeso = null;

    /**
     * @var string $strDataCalculo
     * @access public
     */
    public $strDataCalculo = null;

    /**
     * @param string $nCdServico
     * @param string $nVlPeso
     * @param string $strDataCalculo
     * @access public
     */
    public function __construct($nCdServico, $nVlPeso, $strDataCalculo)
    {
      $this->nCdServico = $nCdServico;
      $this->nVlPeso = $nVlPeso;
      $this->strDataCalculo = $strDataCalculo;
    }

}
