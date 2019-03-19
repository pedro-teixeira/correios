<?php

class Correios_CalcPrecoPrazo_CalcPrecoFACResponse
{

    /**
     * @var Correios_CalcPrecoPrazo_CResultado $CalcPrecoFACResult
     * @access public
     */
    public $CalcPrecoFACResult = null;

    /**
     * @param Correios_CalcPrecoPrazo_CResultado $CalcPrecoFACResult
     * @access public
     */
    public function __construct($CalcPrecoFACResult)
    {
      $this->CalcPrecoFACResult = $CalcPrecoFACResult;
    }

}
