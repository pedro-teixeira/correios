<?php

class Correios_Sigep_SolicitaXmlPlp
{

    /**
     * @var int $idPlpMaster
     * @access public
     */
    public $idPlpMaster = null;

    /**
     * @var string $usuario
     * @access public
     */
    public $usuario = null;

    /**
     * @var string $senha
     * @access public
     */
    public $senha = null;

    /**
     * @param int $idPlpMaster
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($idPlpMaster, $usuario, $senha)
    {
      $this->idPlpMaster = $idPlpMaster;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
