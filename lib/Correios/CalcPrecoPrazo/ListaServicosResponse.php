<?php

class Correios_CalcPrecoPrazo_ListaServicosResponse
{

    /**
     * @var Correios_CalcPrecoPrazo_CResultadoServicos $ListaServicosResult
     * @access public
     */
    public $ListaServicosResult = null;

    /**
     * @param Correios_CalcPrecoPrazo_CResultadoServicos $ListaServicosResult
     * @access public
     */
    public function __construct($ListaServicosResult)
    {
      $this->ListaServicosResult = $ListaServicosResult;
    }

}
