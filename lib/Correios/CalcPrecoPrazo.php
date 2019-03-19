<?php

class Correios_CalcPrecoPrazo extends \SoapClient
{
    
    /**
     * @var array $classmap The defined classes
     * @access private
     */
    private static $classmap = array(
        'CalcPrecoPrazo' => '\Correios_CalcPrecoPrazo_CalcPrecoPrazo',
        'CalcPrecoPrazoResponse' => '\Correios_CalcPrecoPrazo_CalcPrecoPrazoResponse',
        'CResultado' => '\Correios_CalcPrecoPrazo_CResultado',
        'CServico' => '\Correios_CalcPrecoPrazo_CServico',
        'CalcPrecoPrazoData' => '\Correios_CalcPrecoPrazo_CalcPrecoPrazoData',
        'CalcPrecoPrazoDataResponse' => '\Correios_CalcPrecoPrazo_CalcPrecoPrazoDataResponse',
        'CalcPrecoPrazoRestricao' => '\Correios_CalcPrecoPrazo_CalcPrecoPrazoRestricao',
        'CalcPrecoPrazoRestricaoResponse' => '\Correios_CalcPrecoPrazo_CalcPrecoPrazoRestricaoResponse',
        'CalcPreco' => '\Correios_CalcPrecoPrazo_CalcPreco',
        'CalcPrecoResponse' => '\Correios_CalcPrecoPrazo_CalcPrecoResponse',
        'CalcPrecoData' => '\Correios_CalcPrecoPrazo_CalcPrecoData',
        'CalcPrecoDataResponse' => '\Correios_CalcPrecoPrazo_CalcPrecoDataResponse',
        'CalcPrazo' => '\Correios_CalcPrecoPrazo_CalcPrazo',
        'CalcPrazoResponse' => '\Correios_CalcPrecoPrazo_CalcPrazoResponse',
        'CalcPrazoData' => '\Correios_CalcPrecoPrazo_CalcPrazoData',
        'CalcPrazoDataResponse' => '\Correios_CalcPrecoPrazo_CalcPrazoDataResponse',
        'CalcPrazoRestricao' => '\Correios_CalcPrecoPrazo_CalcPrazoRestricao',
        'CalcPrazoRestricaoResponse' => '\Correios_CalcPrecoPrazo_CalcPrazoRestricaoResponse',
        'CalcPrecoFAC' => '\Correios_CalcPrecoPrazo_CalcPrecoFAC',
        'CalcPrecoFACResponse' => '\Correios_CalcPrecoPrazo_CalcPrecoFACResponse',
        'CalcPrazoObjeto' => '\Correios_CalcPrecoPrazo_CalcPrazoObjeto',
        'CalcPrazoObjetoResponse' => '\Correios_CalcPrecoPrazo_CalcPrazoObjetoResponse',
        'CResultadoObjeto' => '\Correios_CalcPrecoPrazo_CResultadoObjeto',
        'CObjeto' => '\Correios_CalcPrecoPrazo_CObjeto',
        'CalcDataMaxima' => '\Correios_CalcPrecoPrazo_CalcDataMaxima',
        'CalcDataMaximaResponse' => '\Correios_CalcPrecoPrazo_CalcDataMaximaResponse',
        'ListaServicos' => '\Correios_CalcPrecoPrazo_ListaServicos',
        'ListaServicosResponse' => '\Correios_CalcPrecoPrazo_ListaServicosResponse',
        'CResultadoServicos' => '\Correios_CalcPrecoPrazo_CResultadoServicos',
        'CServicosCalculo' => '\Correios_CalcPrecoPrazo_CServicosCalculo');
    
    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     * @access public
     */
    public function __construct(array $options = array(), $wsdl = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx')
    {
        foreach (self::$classmap as $key => $value) {
            if (!isset($options['classmap'][$key])) {
                $options['classmap'][$key] = $value;
            }
        }
        
        parent::__construct($wsdl, $options);
    }
    
    /**
     * Calcula o preço e o prazo com a data atual
     *
     * @param Correios_CalcPrecoPrazo_CalcPrecoPrazo $parameters
     * @access public
     * @return Correios_CalcPrecoPrazo_CalcPrecoPrazoResponse
     */
    public function CalcPrecoPrazo($parameters)
    {
        return $this->__soapCall('CalcPrecoPrazo', array($parameters));
    }
    
    /**
     * Calcula o preço e o prazo com uma data especificada
     *
     * @param Correios_CalcPrecoPrazo_CalcPrecoPrazoData $parameters
     * @access public
     * @return Correios_CalcPrecoPrazo_CalcPrecoPrazoDataResponse
     */
    public function CalcPrecoPrazoData($parameters)
    {
        return $this->__soapCall('CalcPrecoPrazoData', array($parameters));
    }
    
    /**
     * Calcula o preço e o prazo considerando as restrições de entrega
     *
     * @param Correios_CalcPrecoPrazo_CalcPrecoPrazoRestricao $parameters
     * @access public
     * @return Correios_CalcPrecoPrazo_CalcPrecoPrazoRestricaoResponse
     */
    public function CalcPrecoPrazoRestricao($parameters)
    {
        return $this->__soapCall('CalcPrecoPrazoRestricao', array($parameters));
    }
    
    /**
     * Calcula somente o preço com a data atual
     *
     * @param Correios_CalcPrecoPrazo_CalcPreco $parameters
     * @access public
     * @return Correios_CalcPrecoPrazo_CalcPrecoResponse
     */
    public function CalcPreco($parameters)
    {
        return $this->__soapCall('CalcPreco', array($parameters));
    }
    
    /**
     * Calcula somente o preço com uma data especificada
     *
     * @param Correios_CalcPrecoPrazo_CalcPrecoData $parameters
     * @access public
     * @return Correios_CalcPrecoPrazo_CalcPrecoDataResponse
     */
    public function CalcPrecoData($parameters)
    {
        return $this->__soapCall('CalcPrecoData', array($parameters));
    }
    
    /**
     * Calcula somente o prazo com a data atual
     *
     * @param Correios_CalcPrecoPrazo_CalcPrazo $parameters
     * @access public
     * @return Correios_CalcPrecoPrazo_CalcPrazoResponse
     */
    public function CalcPrazo($parameters)
    {
        return $this->__soapCall('CalcPrazo', array($parameters));
    }
    
    /**
     * Calcula somente o prazo com uma data especificada
     *
     * @param Correios_CalcPrecoPrazo_CalcPrazoData $parameters
     * @access public
     * @return Correios_CalcPrecoPrazo_CalcPrazoDataResponse
     */
    public function CalcPrazoData($parameters)
    {
        return $this->__soapCall('CalcPrazoData', array($parameters));
    }
    
    /**
     * Calcula o prazo considerando restrição de entrega
     *
     * @param Correios_CalcPrecoPrazo_CalcPrazoRestricao $parameters
     * @access public
     * @return Correios_CalcPrecoPrazo_CalcPrazoRestricaoResponse
     */
    public function CalcPrazoRestricao($parameters)
    {
        return $this->__soapCall('CalcPrazoRestricao', array($parameters));
    }
    
    /**
     * Calcula os preços dos serviços FAC
     *
     * @param Correios_CalcPrecoPrazo_CalcPrecoFAC $parameters
     * @access public
     * @return Correios_CalcPrecoPrazo_CalcPrecoFACResponse
     */
    public function CalcPrecoFAC($parameters)
    {
        return $this->__soapCall('CalcPrecoFAC', array($parameters));
    }
    
    /**
     * Calcula a data máxima de entrega de determinado objeto
     *
     * @param Correios_CalcPrecoPrazo_CalcPrazoObjeto $parameters
     * @access public
     * @return Correios_CalcPrecoPrazo_CalcPrazoObjetoResponse
     */
    public function CalcPrazoObjeto($parameters)
    {
        return $this->__soapCall('CalcPrazoObjeto', array($parameters));
    }
    
    /**
     * Calcula a data máxima de entrega de determinado objeto
     *
     * @param Correios_CalcPrecoPrazo_CalcDataMaxima $parameters
     * @access public
     * @return Correios_CalcPrecoPrazo_CalcDataMaximaResponse
     */
    public function CalcDataMaxima($parameters)
    {
        return $this->__soapCall('CalcDataMaxima', array($parameters));
    }
    
    /**
     * Lista os serviços que estão disponíveis para cálculo de preço e/ou prazo
     *
     * @param Correios_CalcPrecoPrazo_ListaServicos $parameters
     * @access public
     * @return Correios_CalcPrecoPrazo_ListaServicosResponse
     */
    public function ListaServicos($parameters)
    {
        return $this->__soapCall('ListaServicos', array($parameters));
    }
    
}
