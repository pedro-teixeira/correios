<?php

class Correios_Sigep_FechaPlp
{

    /**
     * @var string $xml
     * @access public
     */
    public $xml = null;

    /**
     * @var int $idPlpCliente
     * @access public
     */
    public $idPlpCliente = null;

    /**
     * @var string $cartaoPostagem
     * @access public
     */
    public $cartaoPostagem = null;

    /**
     * @var string $faixaEtiquetas
     * @access public
     */
    public $faixaEtiquetas = null;

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
     * @param string $xml
     * @param int $idPlpCliente
     * @param string $cartaoPostagem
     * @param string $faixaEtiquetas
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($xml, $idPlpCliente, $cartaoPostagem, $faixaEtiquetas, $usuario, $senha)
    {
      $this->xml = $xml;
      $this->idPlpCliente = $idPlpCliente;
      $this->cartaoPostagem = $cartaoPostagem;
      $this->faixaEtiquetas = $faixaEtiquetas;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
