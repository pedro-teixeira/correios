<?php

class Correios_Sigep_ValidarPostagemReversa
{

    /**
     * @var string $codAdministrativo
     * @access public
     */
    public $codAdministrativo = null;

    /**
     * @var string $codigoServico
     * @access public
     */
    public $codigoServico = null;

    /**
     * @var string $cepDestinatario
     * @access public
     */
    public $cepDestinatario = null;

    /**
     * @var string $idCartaoPostagem
     * @access public
     */
    public $idCartaoPostagem = null;

    /**
     * @var coletaReversa $coleta
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
     * @param string $codAdministrativo
     * @param string $codigoServico
     * @param string $cepDestinatario
     * @param string $idCartaoPostagem
     * @param coletaReversa $coleta
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($codAdministrativo, $codigoServico, $cepDestinatario, $idCartaoPostagem, $coleta, $usuario, $senha)
    {
      $this->codAdministrativo = $codAdministrativo;
      $this->codigoServico = $codigoServico;
      $this->cepDestinatario = $cepDestinatario;
      $this->idCartaoPostagem = $idCartaoPostagem;
      $this->coleta = $coleta;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
