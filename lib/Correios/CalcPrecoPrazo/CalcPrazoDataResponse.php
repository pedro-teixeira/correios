<?php

class Correios_CalcPrecoPrazo_CalcPrazoDataResponse
{

    /**
     * @var Correios_CalcPrecoPrazo_CResultado $CalcPrazoDataResult
     * @access public
     */
    public $CalcPrazoDataResult = null;

    /**
     * @param Correios_CalcPrecoPrazo_CResultado $CalcPrazoDataResult
     * @access public
     */
    public function __construct($CalcPrazoDataResult)
    {
      $this->CalcPrazoDataResult = $CalcPrazoDataResult;
    }

}
