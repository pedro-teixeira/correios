<?php

class Correios_CalcPrecoPrazo_CResultadoObjeto
{

    /**
     * @var Correios_CalcPrecoPrazo_CObjeto[] $Objetos
     * @access public
     */
    public $Objetos = null;

    /**
     * @param Correios_CalcPrecoPrazo_CObjeto[] $Objetos
     * @access public
     */
    public function __construct($Objetos)
    {
      $this->Objetos = $Objetos;
    }

}
