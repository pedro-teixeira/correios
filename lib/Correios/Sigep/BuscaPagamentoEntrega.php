<?php

class Correios_Sigep_BuscaPagamentoEntrega
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
     * @var string $contrato
     * @access public
     */
    public $contrato = null;

    /**
     * @var string $dataInicio
     * @access public
     */
    public $dataInicio = null;

    /**
     * @var string $dataFim
     * @access public
     */
    public $dataFim = null;

    /**
     * @var string $etiqueta
     * @access public
     */
    public $etiqueta = null;

    /**
     * @param string $usuario
     * @param string $senha
     * @param string $contrato
     * @param string $dataInicio
     * @param string $dataFim
     * @param string $etiqueta
     * @access public
     */
    public function __construct($usuario, $senha, $contrato, $dataInicio, $dataFim, $etiqueta)
    {
      $this->usuario = $usuario;
      $this->senha = $senha;
      $this->contrato = $contrato;
      $this->dataInicio = $dataInicio;
      $this->dataFim = $dataFim;
      $this->etiqueta = $etiqueta;
    }

}
