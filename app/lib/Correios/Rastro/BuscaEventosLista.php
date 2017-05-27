<?php

class Correios_Rastro_BuscaEventosLista
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
     * @var string $tipo
     * @access public
     */
    public $tipo = null;

    /**
     * @var string $resultado
     * @access public
     */
    public $resultado = null;

    /**
     * @var string $lingua
     * @access public
     */
    public $lingua = null;

    /**
     * @var string[] $objetos
     * @access public
     */
    public $objetos = null;

    /**
     * @param string $usuario
     * @param string $senha
     * @param string $tipo
     * @param string $resultado
     * @param string $lingua
     * @param string[] $objetos
     * @access public
     */
    public function __construct($usuario, $senha, $tipo, $resultado, $lingua, $objetos)
    {
      $this->usuario = $usuario;
      $this->senha = $senha;
      $this->tipo = $tipo;
      $this->resultado = $resultado;
      $this->lingua = $lingua;
      $this->objetos = $objetos;
    }

}
