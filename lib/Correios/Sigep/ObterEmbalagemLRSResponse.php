<?php

class Correios_Sigep_ObterEmbalagemLRSResponse
{

    /**
     * @var embalagemLRSMaster[] $return
     * @access public
     */
    public $return = null;

    /**
     * @param embalagemLRSMaster[] $return
     * @access public
     */
    public function __construct($return)
    {
      $this->return = $return;
    }

}
