<?php

class Correios_Sigep_BuscaTarifaValeResponse
{

    /**
     * @var valePostal $return
     * @access public
     */
    public $return = null;

    /**
     * @param valePostal $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
