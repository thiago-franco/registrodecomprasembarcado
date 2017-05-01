<?php

class Lote {
	
	private $id = 0;
	private $nome = '';
	private $produto = null;
	private $validade = null;
	
	function __construct( $id = 0, $nome = '', $produto = null, $validade = null ) {
		$this->id = $id;
		$this->nome = $nome;
		$this->produto = $produto;
		$this->validade = $validade;
	}
	
	function getId() { return $this->id; }
	function setId($id) { $this->id = $id; }
	
	function getNome() {return $this->nome; }
	function setNome( $nome ) { $this->nome = $nome; } 
	
	function getProduto() { return $this->produto; }
	function setProduto($produto) { $this->produto = $produto; }
	
	function getValidade() { return $this->validade; }
	function setValidade($validade) { $this->validade = $validade; }
	
}

?>