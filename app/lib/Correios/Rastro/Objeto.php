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
     * Class constructor method
     *
     * @param string                  $numero    Number
     * @param string                  $sigla     Initials
     * @param string                  $nome      Name
     * @param string                  $categoria Category
     * @param string                  $erro      Error
     * @param Correios_Rastro_Eventos $evento    Event
     *
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
