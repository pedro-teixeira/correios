<?php

class Correios_Sigep_ConsultaCEP
{

    /**
     * @var string $cep
     * @access public
     */
    public $cep = null;

    /**
     * @param string $cep
     * @access public
     */
    public function __construct($cep)
    {
      $this->cep = $cep;
    }

}
