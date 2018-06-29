<?php

class Correios_Sigep_ValidarPostagemSimultanea
{

    /**
     * @var int $codAdministrativo
     * @access public
     */
    public $codAdministrativo = null;

    /**
     * @var int $codigoServico
     * @access public
     */
    public $codigoServico = null;

    /**
     * @var string $idCartaoPostagem
     * @access public
     */
    public $idCartaoPostagem = null;

    /**
     * @var string $cepDestinatario
     * @access public
     */
    public $cepDestinatario = null;

    /**
     * @var coletaSimultanea $coleta
     * @access public
     */
    public $coleta = null;

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
     * @param int $codigoServico
     * @param string $idCartaoPostagem
     * @param string $cepDestinatario
     * @param coletaSimultanea $coleta
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($codAdministrativo, $codigoServico, $idCartaoPostagem, $cepDestinatario, $coleta, $usuario, $senha)
    {
      $this->codAdministrativo = $codAdministrativo;
      $this->codigoServico = $codigoServico;
      $this->idCartaoPostagem = $idCartaoPostagem;
      $this->cepDestinatario = $cepDestinatario;
      $this->coleta = $coleta;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
