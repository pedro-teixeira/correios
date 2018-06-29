<?php

class Correios_Sigep_VerificaSeTodosObjetosCancelados
{

    /**
     * @var objetoPostal[] $arg0
     * @access public
     */
    public $arg0 = null;

    /**
     * @param objetoPostal[] $arg0
     * @access public
     */
    public function __construct($arg0)
    {
      $this->arg0 = $arg0;
    }

}
