<?php

class Correios_CalcPrecoPrazo_CalcPrazoRestricaoResponse
{

    /**
     * @var Correios_CalcPrecoPrazo_CResultado $CalcPrazoRestricaoResult
     * @access public
     */
    public $CalcPrazoRestricaoResult = null;

    /**
     * @param Correios_CalcPrecoPrazo_CResultado $CalcPrazoRestricaoResult
     * @access public
     */
    public function __construct($CalcPrazoRestricaoResult)
    {
      $this->CalcPrazoRestricaoResult = $CalcPrazoRestricaoResult;
    }

}
