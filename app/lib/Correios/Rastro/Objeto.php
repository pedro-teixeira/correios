<?php

class Correios_Rastro_Objeto
{

    /**
     * @var string $numero
     * @access public
     */
    public $numero = null;

    /**
     * @var string $sigla
     * @access public
     */
    public $sigla = null;

    /**
     * @var string $nome
     * @access public
     */
    public $nome = null;

    /**
     * @var string $categoria
     * @access public
     */
    public $categoria = null;

    /**
     * @var string $erro
     * @access public
     */
    public $erro = null;

    /**
     * @var Correios_Rastro_Eventos $evento
     * @access public
     */
    public $evento = null;

    /**
     * @param string $numero
     * @param string $sigla
     * @param string $nome
     * @param string $categoria
     * @param string $erro
     * @param Correios_Rastro_Eventos $evento
     * @access public
     */
    public function __construct($numero, $sigla, $nome, $categoria, $erro, $evento)
    {
      $this->numero = $numero;
      $this->sigla = $sigla;
      $this->nome = $nome;
      $this->categoria = $categoria;
      $this->erro = $erro;
      $this->evento = $evento;
    }

}
