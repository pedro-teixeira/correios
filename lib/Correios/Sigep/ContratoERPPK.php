<?php

class Correios_Sigep_ContratoERPPK
{

    /**
     * @var int $diretoria
     * @access public
     */
    public $diretoria = null;

    /**
     * @var string $numero
     * @access public
     */
    public $numero = null;

    /**
     * @param int $diretoria
     * @param string $numero
     * @access public
     */
    public function __construct($diretoria, $numero)
    {
      $this->diretoria = $diretoria;
      $this->numero = $numero;
    }

}
