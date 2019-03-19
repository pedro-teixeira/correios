<?php

class Correios_Sigep_Coleta
{

    /**
     * @var string $cklist
     * @access public
     */
    public $cklist = null;

    /**
     * @var string $descricao
     * @access public
     */
    public $descricao = null;

    /**
     * @var string[] $documento
     * @access public
     */
    public $documento = null;

    /**
     * @var string $id_cliente
     * @access public
     */
    public $id_cliente = null;

    /**
     * @var produto[] $produto
     * @access public
     */
    public $produto = null;

    /**
     * @var remetente $remetente
     * @access public
     */
    public $remetente = null;

    /**
     * @var string $tipo
     * @access public
     */
    public $tipo = null;

    /**
     * @var string $valor_declarado
     * @access public
     */
    public $valor_declarado = null;

    /**
     * @param string $cklist
     * @param string $descricao
     * @param string $id_cliente
     * @param remetente $remetente
     * @param string $tipo
     * @param string $valor_declarado
     * @access public
     */
    public function __construct($cklist, $descricao, $id_cliente, $remetente, $tipo, $valor_declarado)
    {
      $this->cklist = $cklist;
      $this->descricao = $descricao;
      $this->id_cliente = $id_cliente;
      $this->remetente = $remetente;
      $this->tipo = $tipo;
      $this->valor_declarado = $valor_declarado;
    }

}
