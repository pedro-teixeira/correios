<?php

class Correios_Sigep_ValidarPostagemSimultaneaResponse
{

    /**
     * @var boolean $return
     * @access public
     */
    public $return = null;

    /**
     * @param boolean $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
