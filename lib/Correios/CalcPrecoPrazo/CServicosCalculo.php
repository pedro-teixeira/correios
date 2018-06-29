<?php

class Correios_CalcPrecoPrazo_CServicosCalculo
{

    /**
     * @var string $codigo
     * @access public
     */
    public $codigo = null;

    /**
     * @var string $descricao
     * @access public
     */
    public $descricao = null;

    /**
     * @var string $calcula_preco
     * @access public
     */
    public $calcula_preco = null;

    /**
     * @var string $calcula_prazo
     * @access public
     */
    public $calcula_prazo = null;

    /**
     * @var string $erro
     * @access public
     */
    public $erro = null;

    /**
     * @var string $msgErro
     * @access public
     */
    public $msgErro = null;

    /**
     * @param string $codigo
     * @param string $descricao
     * @param string $calcula_preco
     * @param string $calcula_prazo
     * @param string $erro
     * @param string $msgErro
     * @access public
     */
    public function __construct($codigo, $descricao, $calcula_preco, $calcula_prazo, $erro, $msgErro)
    {
      $this->codigo = $codigo;
      $this->descricao = $descricao;
      $this->calcula_preco = $calcula_preco;
      $this->calcula_prazo = $calcula_prazo;
      $this->erro = $erro;
      $this->msgErro = $msgErro;
    }

}
