<?php

class Correios_Sigep_Objeto
{

    /**
     * @var string $desc
     * @access public
     */
    public $desc = null;

    /**
     * @var string $entrega
     * @access public
     */
    public $entrega = null;

    /**
     * @var string $id
     * @access public
     */
    public $id = null;

    /**
     * @var string $item
     * @access public
     */
    public $item = null;

    /**
     * @var string $num
     * @access public
     */
    public $num = null;

    /**
     * @param string $desc
     * @param string $entrega
     * @param string $id
     * @param string $item
     * @param string $num
     * @access public
     */
    public function __construct($desc, $entrega, $id, $item, $num)
    {
      $this->desc = $desc;
      $this->entrega = $entrega;
      $this->id = $id;
      $this->item = $item;
      $this->num = $num;
    }

}
