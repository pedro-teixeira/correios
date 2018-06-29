<?php

include_once('Coleta.php');

class Correios_Sigep_ColetaReversa extends Correios_Sigep_Coleta
{

    /**
     * @var string $ag
     * @access public
     */
    public $ag = null;

    /**
     * @var int $ar
     * @access public
     */
    public $ar = null;

    /**
     * @var string $cartao
     * @access public
     */
    public $cartao = null;

    /**
     * @var int $numero
     * @access public
     */
    public $numero = null;

    /**
     * @var objeto[] $obj_col
     * @access public
     */
    public $obj_col = null;

    /**
     * @var string $servico_adicional
     * @access public
     */
    public $servico_adicional = null;

    /**
     * @param string $cklist
     * @param string $descricao
     * @param string $id_cliente
     * @param remetente $remetente
     * @param string $tipo
     * @param string $valor_declarado
     * @param string $ag
     * @param int $ar
     * @param string $cartao
     * @param int $numero
     * @param string $servico_adicional
     * @access public
     */
    public function __construct($cklist, $descricao, $id_cliente, $remetente, $tipo, $valor_declarado, $ag, $ar, $cartao, $numero, $servico_adicional)
    {
      parent::__construct($cklist, $descricao, $id_cliente, $remetente, $tipo, $valor_declarado);
      $this->ag = $ag;
      $this->ar = $ar;
      $this->cartao = $cartao;
      $this->numero = $numero;
      $this->servico_adicional = $servico_adicional;
    }

}
