<?php

include_once('Coleta.php');

class Correios_Sigep_ColetaSimultanea extends Correios_Sigep_Coleta
{

    /**
     * @var string $obj
     * @access public
     */
    public $obj = null;

    /**
     * @var string $obs
     * @access public
     */
    public $obs = null;

    /**
     * @param string $cklist
     * @param string $descricao
     * @param string $id_cliente
     * @param remetente $remetente
     * @param string $tipo
     * @param string $valor_declarado
     * @param string $obj
     * @param string $obs
     * @access public
     */
    public function __construct($cklist, $descricao, $id_cliente, $remetente, $tipo, $valor_declarado, $obj, $obs)
    {
      parent::__construct($cklist, $descricao, $id_cliente, $remetente, $tipo, $valor_declarado);
      $this->obj = $obj;
      $this->obs = $obs;
    }

}
