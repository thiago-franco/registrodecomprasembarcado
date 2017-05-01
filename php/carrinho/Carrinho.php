<?php

class Carrinho {
	
	private $id = 0;
	private $numeroSerie = 0;
	private $nome = '';
	private $ir = '';
	
	public function __construct( $id = 0, $numeroSerie = 0, $nome = '', $ir = '' ) {
		$this->id = $id;
		$this->numeroSerie = $numeroSerie;
		$this->nome = $nome;
		$this->ir = $ir;
	}
	
	public function getId(){ return $this->id; }
	public function setId($id){ $this->id = $id; }
	
	public function getNumeroSerie(){ return $this->numeroSerie; }
	public function setNumeroSerie($numeroSerie){ $this->numeroSerie = $numeroSerie; }
	
	public function getNome(){ return $this->nome; }
	public function setNome($nome){ $this->nome = $nome; }
	
	public function getIr(){ return $this->ir; }
	public function setIr($ir){ $this->ir = $ir; }
	
}

?>