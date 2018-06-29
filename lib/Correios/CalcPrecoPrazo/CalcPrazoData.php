<?php

class Correios_CalcPrecoPrazo_CalcPrazoData
{

    /**
     * @var string $nCdServico
     * @access public
     */
    public $nCdServico = null;

    /**
     * @var string $sCepOrigem
     * @access public
     */
    public $sCepOrigem = null;

    /**
     * @var string $sCepDestino
     * @access public
     */
    public $sCepDestino = null;

    /**
     * @var string $sDtCalculo
     * @access public
     */
    public $sDtCalculo = null;

    /**
     * @param string $nCdServico
     * @param string $sCepOrigem
     * @param string $sCepDestino
     * @param string $sDtCalculo
     * @access public
     */
    public function __construct($nCdServico, $sCepOrigem, $sCepDestino, $sDtCalculo)
    {
      $this->nCdServico = $nCdServico;
      $this->sCepOrigem = $sCepOrigem;
      $this->sCepDestino = $sCepDestino;
      $this->sDtCalculo = $sDtCalculo;
    }

}
