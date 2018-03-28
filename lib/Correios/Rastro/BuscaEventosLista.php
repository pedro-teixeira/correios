<?php

/**
 * This source file is subject to the MIT License.
 * It is also available through http://opensource.org/licenses/MIT
 *
 * @category  PedroTeixeira
 * @package   PedroTeixeira_Correios
 * @author    Pedro Teixeira <hello@pedroteixeira.io>
 * @copyright 2015 Pedro Teixeira (http://pedroteixeira.io)
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      https://github.com/pedro-teixeira/correios
 */
class Correios_Rastro_BuscaEventosLista
{

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
     * @var string $tipo
     * @access public
     */
    public $tipo = null;

    /**
     * @var string $resultado
     * @access public
     */
    public $resultado = null;

    /**
     * @var string $lingua
     * @access public
     */
    public $lingua = null;

    /**
     * @var string[] $objetos
     * @access public
     */
    public $objetos = null;

    /**
     * Class constructor method
     *
     * @param string   $usuario   Username
     * @param string   $senha     Password
     * @param string   $tipo      Type
     * @param string   $resultado Result
     * @param string   $lingua    Language
     * @param string[] $objetos   Object List
     *
     * @access public
     */
    public function __construct($usuario, $senha, $tipo, $resultado, $lingua, $objetos)
    {
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->tipo = $tipo;
        $this->resultado = $resultado;
        $this->lingua = $lingua;
        $this->objetos = $objetos;
    }
}
