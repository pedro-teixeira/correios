<?php

class Correios_CalcPrecoPrazo_CalcDataMaximaResponse
{

    /**
     * @var Correios_CalcPrecoPrazo_Correios_CalcPrecoPrazo_CResultadoObjeto $CalcDataMaximaResult
     * @access public
     */
    public $CalcDataMaximaResult = null;

    /**
     * @param Correios_CalcPrecoPrazo_Correios_CalcPrecoPrazo_CResultadoObjeto $CalcDataMaximaResult
     * @access public
     */
    public function __construct($CalcDataMaximaResult)
    {
      $this->CalcDataMaximaResult = $CalcDataMaximaResult;
    }

}
