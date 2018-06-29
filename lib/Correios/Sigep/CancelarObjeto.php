<?php

class Correios_Sigep_CancelarObjeto
{

    /**
     * @var int $idPlp
     * @access public
     */
    public $idPlp = null;

    /**
     * @var string $numeroEtiqueta
     * @access public
     */
    public $numeroEtiqueta = null;

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
     * @param int $idPlp
     * @param string $numeroEtiqueta
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($idPlp, $numeroEtiqueta, $usuario, $senha)
    {
      $this->idPlp = $idPlp;
      $this->numeroEtiqueta = $numeroEtiqueta;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
