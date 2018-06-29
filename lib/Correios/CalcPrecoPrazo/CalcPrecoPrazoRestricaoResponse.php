<?php

class Correios_CalcPrecoPrazo_CalcPrecoPrazoRestricaoResponse
{

    /**
     * @var Correios_CalcPrecoPrazo_CResultado $CalcPrecoPrazoRestricaoResult
     * @access public
     */
    public $CalcPrecoPrazoRestricaoResult = null;

    /**
     * @param Correios_CalcPrecoPrazo_CResultado $CalcPrecoPrazoRestricaoResult
     * @access public
     */
    public function __construct($CalcPrecoPrazoRestricaoResult)
    {
      $this->CalcPrecoPrazoRestricaoResult = $CalcPrecoPrazoRestricaoResult;
    }

}
