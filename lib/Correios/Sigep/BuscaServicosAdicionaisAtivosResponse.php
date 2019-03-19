<?php

class Correios_Sigep_BuscaServicosAdicionaisAtivosResponse
{

    /**
     * @var servicoAdicionalXML[] $return
     * @access public
     */
    public $return = null;

    /**
     * @param servicoAdicionalXML[] $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
