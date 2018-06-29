<?php

class Correios_Sigep_BloquearObjeto
{

    /**
     * @var string $numeroEtiqueta
     * @access public
     */
    public $numeroEtiqueta = null;

    /**
     * @var int $idPlp
     * @access public
     */
    public $idPlp = null;

    /**
     * @var tipoBloqueio $tipoBloqueio
     * @access public
     */
    public $tipoBloqueio = null;

    /**
     * @var acao $acao
     * @access public
     */
    public $acao = null;

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
     * @param string $numeroEtiqueta
     * @param int $idPlp
     * @param tipoBloqueio $tipoBloqueio
     * @param acao $acao
     * @param string $usuario
     * @param string $senha
     * @access public
     */
    public function __construct($numeroEtiqueta, $idPlp, $tipoBloqueio, $acao, $usuario, $senha)
    {
      $this->numeroEtiqueta = $numeroEtiqueta;
      $this->idPlp = $idPlp;
      $this->tipoBloqueio = $tipoBloqueio;
      $this->acao = $acao;
      $this->usuario = $usuario;
      $this->senha = $senha;
    }

}
