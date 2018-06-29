<?php

class Correios_CalcPrecoPrazo_CResultadoServicos
{

    /**
     * @var Correios_CalcPrecoPrazo_CServicosCalculo[] $ServicosCalculo
     * @access public
     */
    public $ServicosCalculo = null;

    /**
     * @param Correios_CalcPrecoPrazo_CServicosCalculo[] $ServicosCalculo
     * @access public
     */
    public function __construct($ServicosCalculo)
    {
      $this->ServicosCalculo = $ServicosCalculo;
    }

}
