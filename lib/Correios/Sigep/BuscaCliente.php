<?php

class Correios_Sigep_BuscaCliente
{

    /**
     * @var string $idContrato
     * @access public
     */
    public $idContrato = null;

    /**
     * @var string $idCartaoPostagem
     * @access public
     */
    public $idCartaoPostagem = null;

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
     * @param string $idContrato
     * @param string $idCartaoPostagem
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($idContrato, $idCartaoPostagem, $usuario, $senha)
    {
      $this->idContrato = $idContrato;
      $this->idCartaoPostagem = $idCartaoPostagem;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
