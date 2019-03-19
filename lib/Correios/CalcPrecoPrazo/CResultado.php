<?php

class Correios_CalcPrecoPrazo_CResultado
{

    /**
     * @var Correios_CalcPrecoPrazo_CServico[] $Servicos
     * @access public
     */
    public $Servicos = null;

    /**
     * @param Correios_CalcPrecoPrazo_CServico[] $Servicos
     * @access public
     */
    public function __construct($Servicos)
    {
      $this->Servicos = $Servicos;
    }

}
