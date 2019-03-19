<?php

class Correios_Sigep_SolicitaPLP
{

    /**
     * @var int $idPlpMaster
     * @access public
     */
    public $idPlpMaster = null;

    /**
     * @var string $numEtiqueta
     * @access public
     */
    public $numEtiqueta = null;

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
     * @param int $idPlpMaster
     * @param string $numEtiqueta
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($idPlpMaster, $numEtiqueta, $usuario, $senha)
    {
      $this->idPlpMaster = $idPlpMaster;
      $this->numEtiqueta = $numEtiqueta;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
