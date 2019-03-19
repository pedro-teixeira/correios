<?php

class Correios_CalcPrecoPrazo_CalcPrecoPrazoResponse
{

    /**
     * @var Correios_CalcPrecoPrazo_CResultado $CalcPrecoPrazoResult
     * @access public
     */
    public $CalcPrecoPrazoResult = null;

    /**
     * @param Correios_CalcPrecoPrazo_CResultado $CalcPrecoPrazoResult
     * @access public
     */
    public function __construct($CalcPrecoPrazoResult)
    {
      $this->CalcPrecoPrazoResult = $CalcPrecoPrazoResult;
    }

}
