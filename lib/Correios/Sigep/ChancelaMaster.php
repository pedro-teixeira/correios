<?php

class Correios_Sigep_ChancelaMaster
{

    /**
     * @var base64Binary $chancela
     * @access public
     */
    public $chancela = null;

    /**
     * @var dateTime $dataAtualizacao
     * @access public
     */
    public $dataAtualizacao = null;

    /**
     * @var string $descricao
     * @access public
     */
    public $descricao = null;

    /**
     * @var int $id
     * @access public
     */
    public $id = null;

    /**
     * @var servicoSigep[] $servicosSigep
     * @access public
     */
    public $servicosSigep = null;

    /**
     * @param base64Binary $chancela
     * @param dateTime $dataAtualizacao
     * @param string $descricao
     * @param int $id
     * @access public
     */
    public function __construct($chancela, $dataAtualizacao, $descricao, $id)
    {
      $this->chancela = $chancela;
      $this->dataAtualizacao = $dataAtualizacao;
      $this->descricao = $descricao;
      $this->id = $id;
    }

}
