<?php

class Correios_CalcPrecoPrazo_CalcPrazoObjetoResponse
{

    /**
     * @var Correios_CalcPrecoPrazo_Correios_CalcPrecoPrazo_CResultadoObjeto $CalcPrazoObjetoResult
     * @access public
     */
    public $CalcPrazoObjetoResult = null;

    /**
     * @param Correios_CalcPrecoPrazo_Correios_CalcPrecoPrazo_CResultadoObjeto $CalcPrazoObjetoResult
     * @access public
     */
    public function __construct($CalcPrazoObjetoResult)
    {
      $this->CalcPrazoObjetoResult = $CalcPrazoObjetoResult;
    }

}
