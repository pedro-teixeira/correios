<?php

class Correios_Sigep_AtualizaPagamentoNaEntrega
{

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
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($usuario, $senha)
    {
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
