<?php

class Correios_Sigep_SQLException
{

    /**
     * @var int $errorCode
     * @access public
     */
    public $errorCode = null;

    /**
     * @var string $sQLState
     * @access public
     */
    public $sQLState = null;

    /**
     * @var string $message
     * @access public
     */
    public $message = null;

    /**
     * @param int $errorCode
     * @param string $sQLState
     * @param string $message
     * @access public
     */
    public function __construct($errorCode, $sQLState, $message)
    {
      $this->errorCode = $errorCode;
      $this->sQLState = $sQLState;
      $this->message = $message;
    }

}
