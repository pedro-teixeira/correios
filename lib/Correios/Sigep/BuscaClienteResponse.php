<?php

class Correios_Sigep_BuscaClienteResponse
{

    /**
     * @var clienteERP $return
     * @access public
     */
    public $return = null;

    /**
     * @param clienteERP $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
