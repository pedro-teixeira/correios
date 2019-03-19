<?php

class Correios_Sigep_GeraDigitoVerificadorEtiquetas
{

    /**
     * @var string[] $etiquetas
     * @access public
     */
    public $etiquetas = null;

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
     * @param string[] $etiquetas
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($etiquetas, $usuario, $senha)
    {
      $this->etiquetas = $etiquetas;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
