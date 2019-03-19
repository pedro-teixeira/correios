<?php

class Correios_CalcPrecoPrazo_CalcPrecoResponse
{

    /**
     * @var Correios_CalcPrecoPrazo_CResultado $CalcPrecoResult
     * @access public
     */
    public $CalcPrecoResult = null;

    /**
     * @param Correios_CalcPrecoPrazo_CResultado $CalcPrecoResult
     * @access public
     */
    public function __construct($CalcPrecoResult)
    {
      $this->CalcPrecoResult = $CalcPrecoResult;
    }

}
