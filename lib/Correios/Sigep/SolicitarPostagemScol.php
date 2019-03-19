<?php

class Correios_Sigep_SolicitarPostagemScol
{

    /**
     * @var int $codAdministrativo
     * @access public
     */
    public $codAdministrativo = null;

    /**
     * @var string $xml
     * @access public
     */
    public $xml = null;

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
     * @param string $xml
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($codAdministrativo, $xml, $usuario, $senha)
    {
      $this->codAdministrativo = $codAdministrativo;
      $this->xml = $xml;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
