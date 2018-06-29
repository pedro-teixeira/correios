<?php

class Correios_CalcPrecoPrazo_CalcPrazoResponse
{

    /**
     * @var Correios_CalcPrecoPrazo_CResultado $CalcPrazoResult
     * @access public
     */
    public $CalcPrazoResult = null;

    /**
     * @param Correios_CalcPrecoPrazo_CResultado $CalcPrazoResult
     * @access public
     */
    public function __construct($CalcPrazoResult)
    {
      $this->CalcPrazoResult = $CalcPrazoResult;
    }

}
