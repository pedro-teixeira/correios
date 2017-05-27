<?php

class Correios_Rastro_BuscaEventosResponse
{

    /**
     * @var Correios_Rastro_Sroxml $return
     * @access public
     */
    public $return = null;

    /**
     * @param Correios_Rastro_Sroxml $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
