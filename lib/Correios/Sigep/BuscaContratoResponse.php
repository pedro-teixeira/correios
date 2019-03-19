<?php

class Correios_Sigep_BuscaContratoResponse
{

    /**
     * @var contratoERP $return
     * @access public
     */
    public $return = null;

    /**
     * @param contratoERP $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
