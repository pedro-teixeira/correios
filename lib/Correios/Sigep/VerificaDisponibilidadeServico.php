<?php

class Correios_Sigep_VerificaDisponibilidadeServico
{

    /**
     * @var int $codAdministrativo
     * @access public
     */
    public $codAdministrativo = null;

    /**
     * @var string $numeroServico
     * @access public
     */
    public $numeroServico = null;

    /**
     * @var string $cepOrigem
     * @access public
     */
    public $cepOrigem = null;

    /**
     * @var string $cepDestino
     * @access public
     */
    public $cepDestino = null;

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
     * @param int $codAdministrativo
     * @param string $numeroServico
     * @param string $cepOrigem
     * @param string $cepDestino
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($codAdministrativo, $numeroServico, $cepOrigem, $cepDestino, $usuario, $senha)
    {
      $this->codAdministrativo = $codAdministrativo;
      $this->numeroServico = $numeroServico;
      $this->cepOrigem = $cepOrigem;
      $this->cepDestino = $cepDestino;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
