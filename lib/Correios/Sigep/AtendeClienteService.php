<?php

class Correios_Sigep_AtendeClienteService extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     * @access private
     */
    private static $classmap = array(
      'buscaServicosAdicionaisAtivos' => 'Correios_Sigep_BuscaServicosAdicionaisAtivos',
      'buscaServicosAdicionaisAtivosResponse' => 'Correios_Sigep_BuscaServicosAdicionaisAtivosResponse',
      'servicoAdicionalXML' => 'Correios_Sigep_ServicoAdicionalXML',
      'fechaPlp' => 'Correios_Sigep_FechaPlp',
      'fechaPlpResponse' => 'Correios_Sigep_FechaPlpResponse',
      'consultaSRO' => 'Correios_Sigep_ConsultaSRO',
      'consultaSROResponse' => 'Correios_Sigep_ConsultaSROResponse',
      'calculaTarifaServico' => 'Correios_Sigep_CalculaTarifaServico',
      'calculaTarifaServicoResponse' => 'Correios_Sigep_CalculaTarifaServicoResponse',
      'validaPlp' => 'Correios_Sigep_ValidaPlp',
      'validaPlpResponse' => 'Correios_Sigep_ValidaPlpResponse',
      'VerificaSeTodosObjetosCancelados' => 'Correios_Sigep_VerificaSeTodosObjetosCancelados',
      'objetoPostal' => 'Correios_Sigep_ObjetoPostal',
      'objetoPostalPK' => 'Correios_Sigep_ObjetoPostalPK',
      'preListaPostagem' => 'Correios_Sigep_PreListaPostagem',
      'cartaoPostagemERP' => 'Correios_Sigep_CartaoPostagemERP',
      'contratoERP' => 'Correios_Sigep_ContratoERP',
      'clienteERP' => 'Correios_Sigep_ClienteERP',
      'gerenteConta' => 'Correios_Sigep_GerenteConta',
      'usuarioInstalacao' => 'Correios_Sigep_UsuarioInstalacao',
      'parametroMaster' => 'Correios_Sigep_ParametroMaster',
      'contratoERPPK' => 'Correios_Sigep_ContratoERPPK',
      'unidadePostagemERP' => 'Correios_Sigep_UnidadePostagemERP',
      'enderecoERP' => 'Correios_Sigep_EnderecoERP',
      'servicoERP' => 'Correios_Sigep_ServicoERP',
      'servicoSigep' => 'Correios_Sigep_ServicoSigep',
      'chancelaMaster' => 'Correios_Sigep_ChancelaMaster',
      'servicoAdicionalERP' => 'Correios_Sigep_ServicoAdicionalERP',
      'vigenciaERP' => 'Correios_Sigep_VigenciaERP',
      'VerificaSeTodosObjetosCanceladosResponse' => 'Correios_Sigep_VerificaSeTodosObjetosCanceladosResponse',
      'cancelarObjeto' => 'Correios_Sigep_CancelarObjeto',
      'cancelarObjetoResponse' => 'Correios_Sigep_CancelarObjetoResponse',
      'atualizaPagamentoNaEntrega' => 'Correios_Sigep_AtualizaPagamentoNaEntrega',
      'atualizaPagamentoNaEntregaResponse' => 'Correios_Sigep_AtualizaPagamentoNaEntregaResponse',
      'obterClienteAtualizacao' => 'Correios_Sigep_ObterClienteAtualizacao',
      'obterClienteAtualizacaoResponse' => 'Correios_Sigep_ObterClienteAtualizacaoResponse',
      'verificaDisponibilidadeServico' => 'Correios_Sigep_VerificaDisponibilidadeServico',
      'verificaDisponibilidadeServicoResponse' => 'Correios_Sigep_VerificaDisponibilidadeServicoResponse',
      'fechaPlpVariosServicos' => 'Correios_Sigep_FechaPlpVariosServicos',
      'fechaPlpVariosServicosResponse' => 'Correios_Sigep_FechaPlpVariosServicosResponse',
      'geraDigitoVerificadorEtiquetas' => 'Correios_Sigep_GeraDigitoVerificadorEtiquetas',
      'geraDigitoVerificadorEtiquetasResponse' => 'Correios_Sigep_GeraDigitoVerificadorEtiquetasResponse',
      'obterEmbalagemLRS' => 'Correios_Sigep_ObterEmbalagemLRS',
      'obterEmbalagemLRSResponse' => 'Correios_Sigep_ObterEmbalagemLRSResponse',
      'embalagemLRSMaster' => 'Correios_Sigep_EmbalagemLRSMaster',
      'validaEtiquetaPLP' => 'Correios_Sigep_ValidaEtiquetaPLP',
      'validaEtiquetaPLPResponse' => 'Correios_Sigep_ValidaEtiquetaPLPResponse',
      'buscaServicosValorDeclarado' => 'Correios_Sigep_BuscaServicosValorDeclarado',
      'buscaServicosValorDeclaradoResponse' => 'Correios_Sigep_BuscaServicosValorDeclaradoResponse',
      'consultaCEP' => 'Correios_Sigep_ConsultaCEP',
      'consultaCEPResponse' => 'Correios_Sigep_ConsultaCEPResponse',
      'integrarUsuarioScol' => 'Correios_Sigep_IntegrarUsuarioScol',
      'integrarUsuarioScolResponse' => 'Correios_Sigep_IntegrarUsuarioScolResponse',
      'atualizaRemessaAgrupada' => 'Correios_Sigep_AtualizaRemessaAgrupada',
      'atualizaRemessaAgrupadaResponse' => 'Correios_Sigep_AtualizaRemessaAgrupadaResponse',
      'solicitaPLP' => 'Correios_Sigep_SolicitaPLP',
      'solicitaPLPResponse' => 'Correios_Sigep_SolicitaPLPResponse',
      'getStatusCartaoPostagem' => 'Correios_Sigep_GetStatusCartaoPostagem',
      'getStatusCartaoPostagemResponse' => 'Correios_Sigep_GetStatusCartaoPostagemResponse',
      'buscaTarifaVale' => 'Correios_Sigep_BuscaTarifaVale',
      'buscaTarifaValeResponse' => 'Correios_Sigep_BuscaTarifaValeResponse',
      'valePostal' => 'Correios_Sigep_ValePostal',
      'validarPostagemSimultanea' => 'Correios_Sigep_ValidarPostagemSimultanea',
      'coletaSimultanea' => 'Correios_Sigep_ColetaSimultanea',
      'coleta' => 'Correios_Sigep_Coleta',
      'produto' => 'Correios_Sigep_Produto',
      'remetente' => 'Correios_Sigep_Remetente',
      'pessoa' => 'Correios_Sigep_Pessoa',
      'validarPostagemSimultaneaResponse' => 'Correios_Sigep_ValidarPostagemSimultaneaResponse',
      'getStatusPLP' => 'Correios_Sigep_GetStatusPLP',
      'getStatusPLPResponse' => 'Correios_Sigep_GetStatusPLPResponse',
      'buscaServicosXServicosAdicionais' => 'Correios_Sigep_BuscaServicosXServicosAdicionais',
      'buscaServicosXServicosAdicionaisResponse' => 'Correios_Sigep_BuscaServicosXServicosAdicionaisResponse',
      'cancelarPedidoScol' => 'Correios_Sigep_CancelarPedidoScol',
      'cancelarPedidoScolResponse' => 'Correios_Sigep_CancelarPedidoScolResponse',
      'retornoCancelamento' => 'Correios_Sigep_RetornoCancelamento',
      'objetoSimplificado' => 'Correios_Sigep_ObjetoSimplificado',
      'bloquearObjeto' => 'Correios_Sigep_BloquearObjeto',
      'bloquearObjetoResponse' => 'Correios_Sigep_BloquearObjetoResponse',
      'buscaContrato' => 'Correios_Sigep_BuscaContrato',
      'buscaContratoResponse' => 'Correios_Sigep_BuscaContratoResponse',
      'solicitaEtiquetas' => 'Correios_Sigep_SolicitaEtiquetas',
      'solicitaEtiquetasResponse' => 'Correios_Sigep_SolicitaEtiquetasResponse',
      'solicitaXmlPlp' => 'Correios_Sigep_SolicitaXmlPlp',
      'solicitaXmlPlpResponse' => 'Correios_Sigep_SolicitaXmlPlpResponse',
      'validarPostagemReversa' => 'Correios_Sigep_ValidarPostagemReversa',
      'coletaReversa' => 'Correios_Sigep_ColetaReversa',
      'objeto' => 'Correios_Sigep_Objeto',
      'validarPostagemReversaResponse' => 'Correios_Sigep_ValidarPostagemReversaResponse',
      'buscaCliente' => 'Correios_Sigep_BuscaCliente',
      'buscaClienteResponse' => 'Correios_Sigep_BuscaClienteResponse',
      'buscaPagamentoEntrega' => 'Correios_Sigep_BuscaPagamentoEntrega',
      'buscaPagamentoEntregaResponse' => 'Correios_Sigep_BuscaPagamentoEntregaResponse',
      'solicitarPostagemScol' => 'Correios_Sigep_SolicitarPostagemScol',
      'solicitarPostagemScolResponse' => 'Correios_Sigep_SolicitarPostagemScolResponse',
      'buscaServicos' => 'Correios_Sigep_BuscaServicos',
      'buscaServicosResponse' => 'Correios_Sigep_BuscaServicosResponse',
      'SQLException' => 'Correios_Sigep_SQLException',
      'Exception' => 'Correios_Sigep_Exception',
      'ErroMontagemRelatorio' => 'Correios_Sigep_ErroMontagemRelatorio');

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     * @access public
     */
    public function __construct(array $options = array(), $wsdl = 'AtendeCliente.wsdl')
    {
      foreach (self::$classmap as $key => $value) {
        if (!isset($options['classmap'][$key])) {
          $options['classmap'][$key] = $value;
        }
      }
      
      parent::__construct($wsdl, $options);
    }

    /**
     * @param Correios_Sigep_BuscaServicosAdicionaisAtivos $parameters
     * @access public
     * @return Correios_Sigep_BuscaServicosAdicionaisAtivosResponse
     */
    public function buscaServicosAdicionaisAtivos($parameters)
    {
      return $this->__soapCall('buscaServicosAdicionaisAtivos', array($parameters));
    }

    /**
     * @param Correios_Sigep_FechaPlp $parameters
     * @access public
     * @return Correios_Sigep_FechaPlpResponse
     */
    public function fechaPlp($parameters)
    {
      return $this->__soapCall('fechaPlp', array($parameters));
    }

    /**
     * @param Correios_Sigep_ConsultaSRO $parameters
     * @access public
     * @return Correios_Sigep_consultaSROResponse
     */
    public function consultaSRO($parameters)
    {
      return $this->__soapCall('consultaSRO', array($parameters));
    }

    /**
     * @param Correios_Sigep_ValidaPlp $parameters
     * @access public
     * @return Correios_Sigep_ValidaPlpResponse
     */
    public function validaPlp($parameters)
    {
      return $this->__soapCall('validaPlp', array($parameters));
    }

    /**
     * @param Correios_Sigep_CalculaTarifaServico $parameters
     * @access public
     * @return Correios_Sigep_calculaTarifaServicoResponse
     */
    public function calculaTarifaServico($parameters)
    {
      return $this->__soapCall('calculaTarifaServico', array($parameters));
    }

    /**
     * @param Correios_Sigep_VerificaSeTodosObjetosCancelados $parameters
     * @access public
     * @return Correios_Sigep_VerificaSeTodosObjetosCanceladosResponse
     */
    public function VerificaSeTodosObjetosCancelados($parameters)
    {
      return $this->__soapCall('VerificaSeTodosObjetosCancelados', array($parameters));
    }

    /**
     * @param Correios_Sigep_CancelarObjeto $parameters
     * @access public
     * @return Correios_Sigep_cancelarObjetoResponse
     */
    public function cancelarObjeto($parameters)
    {
      return $this->__soapCall('cancelarObjeto', array($parameters));
    }

    /**
     * @param Correios_Sigep_AtualizaPagamentoNaEntrega $parameters
     * @access public
     * @return Correios_Sigep_AtualizaPagamentoNaEntregaResponse
     */
    public function atualizaPagamentoNaEntrega($parameters)
    {
      return $this->__soapCall('atualizaPagamentoNaEntrega', array($parameters));
    }

    /**
     * @param Correios_Sigep_ObterClienteAtualizacao $parameters
     * @access public
     * @return Correios_Sigep_ObterClienteAtualizacaoResponse
     */
    public function obterClienteAtualizacao($parameters)
    {
      return $this->__soapCall('obterClienteAtualizacao', array($parameters));
    }

    /**
     * @param Correios_Sigep_VerificaDisponibilidadeServico $parameters
     * @access public
     * @return Correios_Sigep_VerificaDisponibilidadeServicoResponse
     */
    public function verificaDisponibilidadeServico($parameters)
    {
      return $this->__soapCall('verificaDisponibilidadeServico', array($parameters));
    }

    /**
     * @param Correios_Sigep_FechaPlpVariosServicos $parameters
     * @access public
     * @return Correios_Sigep_FechaPlpVariosServicosResponse
     */
    public function fechaPlpVariosServicos($parameters)
    {
      return $this->__soapCall('fechaPlpVariosServicos', array($parameters));
    }

    /**
     * @param Correios_Sigep_GeraDigitoVerificadorEtiquetas $parameters
     * @access public
     * @return Correios_Sigep_GeraDigitoVerificadorEtiquetasResponse
     */
    public function geraDigitoVerificadorEtiquetas($parameters)
    {
      return $this->__soapCall('geraDigitoVerificadorEtiquetas', array($parameters));
    }

    /**
     * @param Correios_Sigep_ObterEmbalagemLRS $parameters
     * @access public
     * @return Correios_Sigep_ObterEmbalagemLRSResponse
     */
    public function obterEmbalagemLRS($parameters)
    {
      return $this->__soapCall('obterEmbalagemLRS', array($parameters));
    }

    /**
     * @param Correios_Sigep_ValidaEtiquetaPLP $parameters
     * @access public
     * @return Correios_Sigep_ValidaEtiquetaPLPResponse
     */
    public function validaEtiquetaPLP($parameters)
    {
      return $this->__soapCall('validaEtiquetaPLP', array($parameters));
    }

    /**
     * @param Correios_Sigep_BuscaServicosValorDeclarado $parameters
     * @access public
     * @return Correios_Sigep_BuscaServicosValorDeclaradoResponse
     */
    public function buscaServicosValorDeclarado($parameters)
    {
      return $this->__soapCall('buscaServicosValorDeclarado', array($parameters));
    }

    /**
     * @param Correios_Sigep_ConsultaCEP $parameters
     * @access public
     * @return Correios_Sigep_ConsultaCEPResponse
     */
    public function consultaCEP($parameters)
    {
      return $this->__soapCall('consultaCEP', array($parameters));
    }

    /**
     * @param Correios_Sigep_IntegrarUsuarioScol $parameters
     * @access public
     * @return Correios_Sigep_IntegrarUsuarioScolResponse
     */
    public function integrarUsuarioScol($parameters)
    {
      return $this->__soapCall('integrarUsuarioScol', array($parameters));
    }

    /**
     * @param Correios_Sigep_AtualizaRemessaAgrupada $parameters
     * @access public
     * @return Correios_Sigep_AtualizaRemessaAgrupadaResponse
     */
    public function atualizaRemessaAgrupada($parameters)
    {
      return $this->__soapCall('atualizaRemessaAgrupada', array($parameters));
    }

    /**
     * @param Correios_Sigep_SolicitaPLP $parameters
     * @access public
     * @return Correios_Sigep_SolicitaPLPResponse
     */
    public function solicitaPLP($parameters)
    {
      return $this->__soapCall('solicitaPLP', array($parameters));
    }

    /**
     * @param Correios_Sigep_GetStatusCartaoPostagem $parameters
     * @access public
     * @return Correios_Sigep_GetStatusCartaoPostagemResponse
     */
    public function getStatusCartaoPostagem($parameters)
    {
      return $this->__soapCall('getStatusCartaoPostagem', array($parameters));
    }

    /**
     * @param Correios_Sigep_BuscaTarifaVale $parameters
     * @access public
     * @return Correios_Sigep_BuscaTarifaValeResponse
     */
    public function buscaTarifaVale($parameters)
    {
      return $this->__soapCall('buscaTarifaVale', array($parameters));
    }

    /**
     * @param Correios_Sigep_ValidarPostagemSimultanea $parameters
     * @access public
     * @return Correios_Sigep_ValidarPostagemSimultaneaResponse
     */
    public function validarPostagemSimultanea($parameters)
    {
      return $this->__soapCall('validarPostagemSimultanea', array($parameters));
    }

    /**
     * @param Correios_Sigep_GetStatusPLP $parameters
     * @access public
     * @return Correios_Sigep_GetStatusPLPResponse
     */
    public function getStatusPLP($parameters)
    {
      return $this->__soapCall('getStatusPLP', array($parameters));
    }

    /**
     * @param Correios_Sigep_BuscaServicosXServicosAdicionais $parameters
     * @access public
     * @return Correios_Sigep_BuscaServicosXServicosAdicionaisResponse
     */
    public function buscaServicosXServicosAdicionais($parameters)
    {
      return $this->__soapCall('buscaServicosXServicosAdicionais', array($parameters));
    }

    /**
     * @param Correios_Sigep_CancelarPedidoScol $parameters
     * @access public
     * @return Correios_Sigep_CancelarPedidoScolResponse
     */
    public function cancelarPedidoScol($parameters)
    {
      return $this->__soapCall('cancelarPedidoScol', array($parameters));
    }

    /**
     * @param Correios_Sigep_BloquearObjeto $parameters
     * @access public
     * @return Correios_Sigep_BloquearObjetoResponse
     */
    public function bloquearObjeto($parameters)
    {
      return $this->__soapCall('bloquearObjeto', array($parameters));
    }

    /**
     * @param Correios_Sigep_BuscaContrato $parameters
     * @access public
     * @return Correios_Sigep_BuscaContratoResponse
     */
    public function buscaContrato($parameters)
    {
      return $this->__soapCall('buscaContrato', array($parameters));
    }

    /**
     * @param Correios_Sigep_SolicitaEtiquetas $parameters
     * @access public
     * @return Correios_Sigep_SolicitaEtiquetasResponse
     */
    public function solicitaEtiquetas($parameters)
    {
      return $this->__soapCall('solicitaEtiquetas', array($parameters));
    }

    /**
     * @param Correios_Sigep_SolicitaXmlPlp $parameters
     * @access public
     * @return Correios_Sigep_SolicitaXmlPlpResponse
     */
    public function solicitaXmlPlp($parameters)
    {
      return $this->__soapCall('solicitaXmlPlp', array($parameters));
    }

    /**
     * @param Correios_Sigep_ValidarPostagemReversa $parameters
     * @access public
     * @return Correios_Sigep_ValidarPostagemReversaResponse
     */
    public function validarPostagemReversa($parameters)
    {
      return $this->__soapCall('validarPostagemReversa', array($parameters));
    }

    /**
     * @param Correios_Sigep_BuscaCliente $parameters
     * @access public
     * @return Correios_Sigep_BuscaClienteResponse
     */
    public function buscaCliente($parameters)
    {
      return $this->__soapCall('buscaCliente', array($parameters));
    }

    /**
     * @param Correios_Sigep_BuscaPagamentoEntrega $parameters
     * @access public
     * @return Correios_Sigep_BuscaPagamentoEntregaResponse
     */
    public function buscaPagamentoEntrega($parameters)
    {
      return $this->__soapCall('buscaPagamentoEntrega', array($parameters));
    }

    /**
     * @param Correios_Sigep_SolicitarPostagemScol $parameters
     * @access public
     * @return Correios_Sigep_SolicitarPostagemScolResponse
     */
    public function solicitarPostagemScol($parameters)
    {
      return $this->__soapCall('solicitarPostagemScol', array($parameters));
    }

    /**
     * @param Correios_Sigep_BuscaServicos $parameters
     * @access public
     * @return Correios_Sigep_BuscaServicosResponse
     */
    public function buscaServicos($parameters)
    {
      return $this->__soapCall('buscaServicos', array($parameters));
    }

}
