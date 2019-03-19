<?php

class Correios_Sigep_CancelarPedidoScol
{

    /**
     * @var string $codAdministrativo
     * @access public
     */
    public $codAdministrativo = null;

    /**
     * @var string $idPostagem
     * @access public
     */
    public $idPostagem = null;

    /**
     * @var string $tipo
     * @access public
     */
    public $tipo = null;

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
     * @param string $codAdministrativo
     * @param string $idPostagem
     * @param string $tipo
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($codAdministrativo, $idPostagem, $tipo, $usuario, $senha)
    {
      $this->codAdministrativo = $codAdministrativo;
      $this->idPostagem = $idPostagem;
      $this->tipo = $tipo;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
