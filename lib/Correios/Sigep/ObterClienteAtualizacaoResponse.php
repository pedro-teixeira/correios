<?php

class Correios_Sigep_ObterClienteAtualizacaoResponse
{

    /**
     * @var dateTime $return
     * @access public
     */
    public $return = null;

    /**
     * @param dateTime $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
