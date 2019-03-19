<?php

class Correios_Sigep_ConsultaSRO
{

    /**
     * @var string[] $listaObjetos
     * @access public
     */
    public $listaObjetos = null;

    /**
     * @var string $tipoConsulta
     * @access public
     */
    public $tipoConsulta = null;

    /**
     * @var string $tipoResultado
     * @access public
     */
    public $tipoResultado = null;

    /**
     * @var string $usuarioSro
     * @access public
     */
    public $usuarioSro = null;

    /**
     * @var string $senhaSro
     * @access public
     */
    public $senhaSro = null;

    /**
     * @param string[] $listaObjetos
     * @param string $tipoConsulta
     * @param string $tipoResultado
     * @param string $usuarioSro
     * @param string $senhaSro
     * @access public
     */
    public function __construct($listaObjetos, $tipoConsulta, $tipoResultado, $usuarioSro, $senhaSro)
    {
      $this->listaObjetos = $listaObjetos;
      $this->tipoConsulta = $tipoConsulta;
      $this->tipoResultado = $tipoResultado;
      $this->usuarioSro = $usuarioSro;
      $this->senhaSro = $senhaSro;
    }

}
