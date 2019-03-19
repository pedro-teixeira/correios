<?php

class Correios_Sigep_CancelarPedidoScolResponse
{

    /**
     * @var retornoCancelamento $return
     * @access public
     */
    public $return = null;

    /**
     * @param retornoCancelamento $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
