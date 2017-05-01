<?php

class Produto {
	
	private $id = 0;
	private $codigoBarras = '';
	private $descricao = '';
	private $valor = 0.00;
	
	function __construct( $id = 0, $codigoBarras = '', $descricao = '', $valor = 0 ) {
		$this->id = $id;
		$this->codigoBarras = $codigoBarras;
		$this->descricao = $descricao;
		$this->valor = $valor;
	}
	
	function getId(){ return $this->id; }
	function setId($id){ $this->id = $id; }
	
	function getCodigoBarras(){ return $this->codigoBarras; }
	function setCodigoBarras($codigoBarras){ $this->codigoBarras = $codigoBarras; }
	
	function getDescricao(){ return $this->descricao; }
	function setDescricao($descricao){ $this->descricao = $descricao; }
	
	function getValor(){ return $this->valor; }
	function setValor($valor){ $this->valor = $valor; }
	
}

?>