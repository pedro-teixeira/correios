<?php

class Correios_CalcPrecoPrazo_CalcPrecoDataResponse
{

    /**
     * @var Correios_CalcPrecoPrazo_CResultado $CalcPrecoDataResult
     * @access public
     */
    public $CalcPrecoDataResult = null;

    /**
     * @param Correios_CalcPrecoPrazo_CResultado $CalcPrecoDataResult
     * @access public
     */
    public function __construct($CalcPrecoDataResult)
    {
      $this->CalcPrecoDataResult = $CalcPrecoDataResult;
    }

}
