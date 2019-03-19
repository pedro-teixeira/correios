<?php

class Correios_Sigep_ValidaEtiquetaPLP
{

    /**
     * @var string $numeroEtiqueta
     * @access public
     */
    public $numeroEtiqueta = null;

    /**
     * @var int $idPlp
     * @access public
     */
    public $idPlp = null;

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
     * @param string $numeroEtiqueta
     * @param int $idPlp
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($numeroEtiqueta, $idPlp, $usuario, $senha)
    {
      $this->numeroEtiqueta = $numeroEtiqueta;
      $this->idPlp = $idPlp;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
