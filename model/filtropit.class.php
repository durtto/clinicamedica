<?php
class FiltroPit{

	private $id;
	private $datainicio;
	private $datafim;
	private $datacriacao;
	private $titulo;	
	private $codcliente;
	private $codcategoria;
	private $codstatus;
	private $usardata;
	
	function __construct()
	{
		$this->set('usardata', 1);
	}
	function set($prop, $value)
	{
		$this->$prop = $value;
	}
	function get($prop)
	{
		return $this->$prop;
	}
}