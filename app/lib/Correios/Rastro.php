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
class Correios_Rastro extends SoapClient
{

    /**
     * @var array $classmap The defined classes
     * @access private
     */
    private static $classmap = array(
        'BuscaEventosLista' => 'Correios_Rastro_BuscaEventosLista',
        'BuscaEventosListaResponse' => 'Correios_Rastro_BuscaEventosListaResponse',
        'Sroxml' => 'Correios_Rastro_Sroxml',
        'Objeto' => 'Correios_Rastro_Objeto',
        'Eventos' => 'Correios_Rastro_Eventos',
        'Destinos' => 'Correios_Rastro_Destinos',
        'EnderecoMobile' => 'Correios_Rastro_EnderecoMobile',
        'BuscaEventos' => 'Correios_Rastro_BuscaEventos',
        'BuscaEventosResponse' => 'Correios_Rastro_BuscaEventosResponse'
    );

    /**
     * Class constructor method
     *
     * @param array  $options An array of config values
     * @param string $wsdl    The wsdl file to use
     *
     * @access public
     */
    public function __construct(array $options = array(), $wsdl = 'Rastro.wsdl')
    {
        foreach (self::$classmap as $key => $value) {
            if (!isset($options['classmap'][$key])) {
                $options['classmap'][$key] = $value;
            }
        }

        parent::__construct($wsdl, $options);
    }

    /**
     * Request method for buscaEventos
     *
     * @param Correios_Rastro_BuscaEventos $parameters Parameters
     *
     * @access public
     *
     * @return Correios_Rastro_BuscaEventosResponse
     */
    public function buscaEventos(Correios_Rastro_BuscaEventos $parameters)
    {
        return $this->__soapCall('buscaEventos', array($parameters));
    }

    /**
     * Request method for buscaEventosLista
     *
     * @param Correios_Rastro_BuscaEventosLista $parameters Parameters
     *
     * @access public
     *
     * @return Correios_Rastro_BuscaEventosListaResponse
     */
    public function buscaEventosLista(Correios_Rastro_BuscaEventosLista $parameters)
    {
        return $this->__soapCall('buscaEventosLista', array($parameters));
    }
}
