<?php

class Correios_Sigep_SolicitaEtiquetas
{

    /**
     * @var string $tipoDestinatario
     * @access public
     */
    public $tipoDestinatario = null;

    /**
     * @var string $identificador
     * @access public
     */
    public $identificador = null;

    /**
     * @var int $idServico
     * @access public
     */
    public $idServico = null;

    /**
     * @var int $qtdEtiquetas
     * @access public
     */
    public $qtdEtiquetas = null;

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
     * @param string $tipoDestinatario
     * @param string $identificador
     * @param int $idServico
     * @param int $qtdEtiquetas
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($tipoDestinatario, $identificador, $idServico, $qtdEtiquetas, $usuario, $senha)
    {
      $this->tipoDestinatario = $tipoDestinatario;
      $this->identificador = $identificador;
      $this->idServico = $idServico;
      $this->qtdEtiquetas = $qtdEtiquetas;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
