<?php

class Correios_Sigep_ObjetoPostalPK
{

    /**
     * @var string $codigoEtiqueta
     * @access public
     */
    public $codigoEtiqueta = null;

    /**
     * @var int $plpNu
     * @access public
     */
    public $plpNu = null;

    /**
     * @param string $codigoEtiqueta
     * @param int $plpNu
     * @access public
     */
    public function __construct($codigoEtiqueta, $plpNu)
    {
      $this->codigoEtiqueta = $codigoEtiqueta;
      $this->plpNu = $plpNu;
    }

}
