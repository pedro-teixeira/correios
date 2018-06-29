<?php

class Correios_CalcPrecoPrazo_CalcPrazo
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
     * @param string $nCdServico
     * @param string $sCepOrigem
     * @param string $sCepDestino
     * @access public
     */
    public function __construct($nCdServico, $sCepOrigem, $sCepDestino)
    {
      $this->nCdServico = $nCdServico;
      $this->sCepOrigem = $sCepOrigem;
      $this->sCepDestino = $sCepDestino;
    }

}
