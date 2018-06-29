<?php

class Correios_Sigep_BuscaServicosResponse
{

    /**
     * @var servicoERP[] $return
     * @access public
     */
    public $return = null;

    /**
     * @param servicoERP[] $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
