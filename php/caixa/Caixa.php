<?php

class Caixa {
	
	private $id = 0;
	private $nome = '';	
	private $numeroSerie = 0;
	
	public function __construct( $id = 0, $nome = '', $numeroSerie = 0 ) {
		$this->id = $id;
		$this->nome = $nome;
		$this->numeroSerie = $numeroSerie;
	}
	
	public function getId(){ return $this->id; }
	public function setId($id){ $this->id = $id; }
	
	public function getNome(){ return $this->nome; }
	public function setNome($nome){ $this->nome = $nome; }
	
	public function getNumeroSerie(){ return $this->numeroSerie; }
	public function setNumeroSerie($numeroSerie){ $this->numeroSerie = $numeroSerie; }
	
}

?>