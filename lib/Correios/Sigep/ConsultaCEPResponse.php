<?php

class Correios_Sigep_ConsultaCEPResponse
{

    /**
     * @var enderecoERP $return
     * @access public
     */
    public $return = null;

    /**
     * @param enderecoERP $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
