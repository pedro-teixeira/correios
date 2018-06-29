<?php

class Correios_Sigep_GetStatusCartaoPostagem
{

    /**
     * @var string $numeroCartaoPostagem
     * @access public
     */
    public $numeroCartaoPostagem = null;

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
     * @param string $numeroCartaoPostagem
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($numeroCartaoPostagem, $usuario, $senha)
    {
      $this->numeroCartaoPostagem = $numeroCartaoPostagem;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
