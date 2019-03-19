<?php

class Correios_CalcPrecoPrazo_CalcPrecoPrazoDataResponse
{

    /**
     * @var Correios_CalcPrecoPrazo_CResultado $CalcPrecoPrazoDataResult
     * @access public
     */
    public $CalcPrecoPrazoDataResult = null;

    /**
     * @param Correios_CalcPrecoPrazo_CResultado $CalcPrecoPrazoDataResult
     * @access public
     */
    public function __construct($CalcPrecoPrazoDataResult)
    {
      $this->CalcPrecoPrazoDataResult = $CalcPrecoPrazoDataResult;
    }

}
