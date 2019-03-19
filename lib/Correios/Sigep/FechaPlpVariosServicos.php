<?php

class Correios_Sigep_FechaPlpVariosServicos
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
     * @var string[] $listaEtiquetas
     * @access public
     */
    public $listaEtiquetas = null;

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
     * @param string[] $listaEtiquetas
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($xml, $idPlpCliente, $cartaoPostagem, $listaEtiquetas, $usuario, $senha)
    {
      $this->xml = $xml;
      $this->idPlpCliente = $idPlpCliente;
      $this->cartaoPostagem = $cartaoPostagem;
      $this->listaEtiquetas = $listaEtiquetas;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
