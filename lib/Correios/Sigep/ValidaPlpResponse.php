<?php

class Correios_Sigep_ValidaPlpResponse
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
