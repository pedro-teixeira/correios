<?php

class Correios_CalcPrecoPrazo_CalcDataMaxima
{

    /**
     * @var string $codigoObjeto
     * @access public
     */
    public $codigoObjeto = null;

    /**
     * @param string $codigoObjeto
     * @access public
     */
    public function __construct($codigoObjeto)
    {
      $this->codigoObjeto = $codigoObjeto;
    }

}
