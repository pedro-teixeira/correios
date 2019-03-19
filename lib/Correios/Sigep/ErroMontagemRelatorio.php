<?php

class Correios_Sigep_ErroMontagemRelatorio
{

    /**
     * @var string $message
     * @access public
     */
    public $message = null;

    /**
     * @param string $message
     * @access public
     */
    public function __construct($message)
    {
      $this->message = $message;
    }

}
