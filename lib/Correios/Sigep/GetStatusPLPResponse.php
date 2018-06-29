<?php

class Correios_Sigep_GetStatusPLPResponse
{

    /**
     * @var statusPlp $return
     * @access public
     */
    public $return = null;

    /**
     * @param statusPlp $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
