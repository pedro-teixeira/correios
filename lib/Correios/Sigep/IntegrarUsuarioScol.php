<?php

class Correios_Sigep_IntegrarUsuarioScol
{

    /**
     * @var int $codAdministrativo
     * @access public
     */
    public $codAdministrativo = null;

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
     * @param int $codAdministrativo
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($codAdministrativo, $usuario, $senha)
    {
      $this->codAdministrativo = $codAdministrativo;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
