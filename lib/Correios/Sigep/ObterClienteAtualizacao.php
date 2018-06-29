<?php

class Correios_Sigep_ObterClienteAtualizacao
{

    /**
     * @var string $cnpjCliente
     * @access public
     */
    public $cnpjCliente = null;

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
     * @param string $cnpjCliente
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($cnpjCliente, $usuario, $senha)
    {
      $this->cnpjCliente = $cnpjCliente;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
