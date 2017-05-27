<?php

class Correios_Rastro_Eventos
{

    /**
     * @var string $tipo
     * @access public
     */
    public $tipo = null;

    /**
     * @var string $status
     * @access public
     */
    public $status = null;

    /**
     * @var string $data
     * @access public
     */
    public $data = null;

    /**
     * @var string $hora
     * @access public
     */
    public $hora = null;

    /**
     * @var string $descricao
     * @access public
     */
    public $descricao = null;

    /**
     * @var string $detalhe
     * @access public
     */
    public $detalhe = null;

    /**
     * @var string $recebedor
     * @access public
     */
    public $recebedor = null;

    /**
     * @var string $documento
     * @access public
     */
    public $documento = null;

    /**
     * @var string $comentario
     * @access public
     */
    public $comentario = null;

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
     * @var string $uf
     * @access public
     */
    public $uf = null;

    /**
     * @var string $sto
     * @access public
     */
    public $sto = null;

    /**
     * @var string $amazoncode
     * @access public
     */
    public $amazoncode = null;

    /**
     * @var string $amazontimezone
     * @access public
     */
    public $amazontimezone = null;

    /**
     * @var Correios_Rastro_Destinos $destino
     * @access public
     */
    public $destino = null;

    /**
     * @var Correios_Rastro_EnderecoMobile $endereco
     * @access public
     */
    public $endereco = null;

    /**
     * @param string $tipo
     * @param string $status
     * @param string $data
     * @param string $hora
     * @param string $descricao
     * @param string $detalhe
     * @param string $recebedor
     * @param string $documento
     * @param string $comentario
     * @param string $local
     * @param string $codigo
     * @param string $cidade
     * @param string $uf
     * @param string $sto
     * @param string $amazoncode
     * @param string $amazontimezone
     * @param Correios_Rastro_Destinos $destino
     * @param Correios_Rastro_EnderecoMobile $endereco
     * @access public
     */
    public function __construct($tipo, $status, $data, $hora, $descricao, $detalhe, $recebedor, $documento, $comentario, $local, $codigo, $cidade, $uf, $sto, $amazoncode, $amazontimezone, $destino, $endereco)
    {
      $this->tipo = $tipo;
      $this->status = $status;
      $this->data = $data;
      $this->hora = $hora;
      $this->descricao = $descricao;
      $this->detalhe = $detalhe;
      $this->recebedor = $recebedor;
      $this->documento = $documento;
      $this->comentario = $comentario;
      $this->local = $local;
      $this->codigo = $codigo;
      $this->cidade = $cidade;
      $this->uf = $uf;
      $this->sto = $sto;
      $this->amazoncode = $amazoncode;
      $this->amazontimezone = $amazontimezone;
      $this->destino = $destino;
      $this->endereco = $endereco;
    }

}
