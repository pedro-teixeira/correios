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
class Correios_Rastro_EnderecoMobile
{

    /**
     * @var string $codigo
     * @access public
     */
    public $codigo = null;

    /**
     * @var string $cep
     * @access public
     */
    public $cep = null;

    /**
     * @var string $logradouro
     * @access public
     */
    public $logradouro = null;

    /**
     * @var string $complemento
     * @access public
     */
    public $complemento = null;

    /**
     * @var string $numero
     * @access public
     */
    public $numero = null;

    /**
     * @var string $localidade
     * @access public
     */
    public $localidade = null;

    /**
     * @var string $uf
     * @access public
     */
    public $uf = null;

    /**
     * @var string $bairro
     * @access public
     */
    public $bairro = null;

    /**
     * @var string $latitude
     * @access public
     */
    public $latitude = null;

    /**
     * @var string $longitude
     * @access public
     */
    public $longitude = null;

    /**
     * @var string $celular
     * @access public
     */
    public $celular = null;

    /**
     * Class constructor method
     *
     * @param string $codigo      Code
     * @param string $cep         Zip
     * @param string $logradouro  Street
     * @param string $complemento Street 2
     * @param string $numero      Number
     * @param string $localidade  Region
     * @param string $uf          Region Code
     * @param string $bairro      Address
     * @param string $latitude    Latitude
     * @param string $longitude   Longitude
     * @param string $celular     Cellphone
     *
     * @access public
     */
    public function __construct(
        $codigo,
        $cep,
        $logradouro,
        $complemento,
        $numero,
        $localidade,
        $uf,
        $bairro,
        $latitude,
        $longitude,
        $celular
    ) {
    
        $this->codigo = $codigo;
        $this->cep = $cep;
        $this->logradouro = $logradouro;
        $this->complemento = $complemento;
        $this->numero = $numero;
        $this->localidade = $localidade;
        $this->uf = $uf;
        $this->bairro = $bairro;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->celular = $celular;
    }
}
