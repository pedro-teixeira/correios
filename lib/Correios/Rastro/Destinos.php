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
class Correios_Rastro_Destinos
{

    /**
     * @var string $local
     * @access public
     */
    public $local = null;

    /**
     * @var string $codigo
     * @access public
     */
    public $codigo = null;

    /**
     * @var string $cidade
     * @access public
     */
    public $cidade = null;

    /**
     * @var string $bairro
     * @access public
     */
    public $bairro = null;

    /**
     * @var string $uf
     * @access public
     */
    public $uf = null;

    /**
     * Class constructor method
     *
     * @param string $local  Local
     * @param string $codigo Code
     * @param string $cidade City
     * @param string $bairro Address
     * @param string $uf     Region Code
     *
     * @access public
     */
    public function __construct($local, $codigo, $cidade, $bairro, $uf)
    {
        $this->local = $local;
        $this->codigo = $codigo;
        $this->cidade = $cidade;
        $this->bairro = $bairro;
        $this->uf = $uf;
    }
}
