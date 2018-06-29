<?php

class Correios_Sigep_BuscaContrato
{

    /**
     * @var string $numero
     * @access public
     */
    public $numero = null;

    /**
     * @var int $diretoria
     * @access public
     */
    public $diretoria = null;

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
     * @param string $numero
     * @param int $diretoria
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($numero, $diretoria, $usuario, $senha)
    {
      $this->numero = $numero;
      $this->diretoria = $diretoria;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
