<?php

class Correios_Sigep_GeraDigitoVerificadorEtiquetasResponse
{

    /**
     * @var int[] $return
     * @access public
     */
    public $return = null;

    /**
     * @param int[] $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
