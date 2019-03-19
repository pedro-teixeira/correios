<?php

class Correios_Sigep_RetornoCancelamento
{

    /**
     * @var string $cod_erro
     * @access public
     */
    public $cod_erro = null;

    /**
     * @var string $codigo_administrativo
     * @access public
     */
    public $codigo_administrativo = null;

    /**
     * @var string $data
     * @access public
     */
    public $data = null;

    /**
     * @var string $hora
     * @access public
     */
    public $hora = null;

    /**
     * @var string $msg_erro
     * @access public
     */
    public $msg_erro = null;

    /**
     * @var objetoSimplificado $objeto_postal
     * @access public
     */
    public $objeto_postal = null;

    /**
     * @param string $cod_erro
     * @param string $codigo_administrativo
     * @param string $data
     * @param string $hora
     * @param string $msg_erro
     * @param objetoSimplificado $objeto_postal
     * @access public
     */
    public function __construct($cod_erro, $codigo_administrativo, $data, $hora, $msg_erro, $objeto_postal)
    {
      $this->cod_erro = $cod_erro;
      $this->codigo_administrativo = $codigo_administrativo;
      $this->data = $data;
      $this->hora = $hora;
      $this->msg_erro = $msg_erro;
      $this->objeto_postal = $objeto_postal;
    }

}
