<?php

class Correios_Sigep_ValidaPlp
{

    /**
     * @var int $cliente
     * @access public
     */
    public $cliente = null;

    /**
     * @var string $numero
     * @access public
     */
    public $numero = null;

    /**
     * @var int $diretoria
     * @access public
     */
    public $diretoria = null;

    /**
     * @var string $cartao
     * @access public
     */
    public $cartao = null;

    /**
     * @var string $unidadePostagem
     * @access public
     */
    public $unidadePostagem = null;

    /**
     * @var int $servico
     * @access public
     */
    public $servico = null;

    /**
     * @var string[] $servicosAdicionais
     * @access public
     */
    public $servicosAdicionais = null;

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
     * @param int $cliente
     * @param string $numero
     * @param int $diretoria
     * @param string $cartao
     * @param string $unidadePostagem
     * @param int $servico
     * @param string[] $servicosAdicionais
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($cliente, $numero, $diretoria, $cartao, $unidadePostagem, $servico, $servicosAdicionais, $usuario, $senha)
    {
      $this->cliente = $cliente;
      $this->numero = $numero;
      $this->diretoria = $diretoria;
      $this->cartao = $cartao;
      $this->unidadePostagem = $unidadePostagem;
      $this->servico = $servico;
      $this->servicosAdicionais = $servicosAdicionais;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
