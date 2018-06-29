<?php

class Correios_Sigep_ObjetoSimplificado
{

    /**
     * @var string $datahora_cancelamento
     * @access public
     */
    public $datahora_cancelamento = null;

    /**
     * @var int $numero_pedido
     * @access public
     */
    public $numero_pedido = null;

    /**
     * @var string $status_pedido
     * @access public
     */
    public $status_pedido = null;

    /**
     * @param string $datahora_cancelamento
     * @param int $numero_pedido
     * @param string $status_pedido
     * @access public
     */
    public function __construct($datahora_cancelamento, $numero_pedido, $status_pedido)
    {
      $this->datahora_cancelamento = $datahora_cancelamento;
      $this->numero_pedido = $numero_pedido;
      $this->status_pedido = $status_pedido;
    }

}
