<?php

class Correios_Sigep_GetStatusCartaoPostagemResponse
{

    /**
     * @var statusCartao $return
     * @access public
     */
    public $return = null;

    /**
     * @param statusCartao $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
