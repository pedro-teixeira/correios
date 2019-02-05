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
class Correios_Rastro_BuscaEventosListaResponse
{

    /**
     * @var Correios_Rastro_Sroxml $return
     * @access public
     */
    public $return = null;

    /**
     * Class constructor method
     *
     * @param Correios_Rastro_Sroxml $return Sroxml Object
     *
     * @access public
     */
    public function __construct($return)
    {
        $this->return = $return;
    }
}
