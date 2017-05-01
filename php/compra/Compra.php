<?php

class Compra {
	
	private $id = 0;
	private $carrinho = null;
	private $caixa = null;
	private $itens = array();
	private $total = 0.0;
	
	public function __construct( $id = 0, $carrinho = null, $caixa = null, $itens = array(), $total = 0.0 ){
		$this->id = $id;
		$this->carrinho = $carrinho;
		$this->caixa = $caixa;
		$this->itens = $itens;
		$this->total = $total;
	}
	
	public function getId(){ return $this->id; }
	public function setId($id){ $this->id = $id; }
	
	public function getCarrinho(){ return $this->carrinho; }
	public function setCarrinho($carrinho){ $this->carrinho = $carrinho; }
	
	public function getCaixa(){ return $this->caixa; }
	public function setCaixa($caixa){ $this->caixa = $caixa; }
	
	public function getItens(){ return $this->itens; }
	public function setItens($itens){ $this->itens = $itens; }
	
	public function getTotal(){ return $this->total; }
	public function setTotal($total){ $this->total = $total; }
	
}

?>