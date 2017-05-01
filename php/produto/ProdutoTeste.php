<?php

class ProdutoTeste {
	
	private $produtoServico = null;
	
	public function __construct() {
		$pdo = BD::pdo();
		$validator = new ProdutoValidadora();
		$repository = new ProdutoRepositorio($pdo);
		
		$this->produtoServico = new ProdutoServico( $validator, $repository );		
	}
	
	public function testar() {
		
		echo ("Criando o objeto...");
		$produto = new Produto( 0, 'F21524FSDS41210', 'arduino', 125.99, new Lote(1));
		var_dump($produto);
		
		echo ( PHP_EOL . PHP_EOL );
		
		echo ("Salvando objeto...");
		$this->produtoServico->salvar($produto);
		var_dump($produto);
		
		echo ( PHP_EOL . PHP_EOL );
		
		echo ("Buscando objeto...");
		$produto = $this->produtoServico->comId($produto->getId());
		var_dump($produto);
		
		echo ("Alterando objeto...");
		$produto->setDescricao('Arduíno');
		$produto->setValor(158.65);
		$this->produtoServico->salvar($produto);
		var_dump($produto);
		
		echo ( PHP_EOL . PHP_EOL );
		
		echo ("Buscando objeto...");
		$produto = $this->produtoServico->comId($produto->getId());
		var_dump($produto);
		
		echo ( PHP_EOL . PHP_EOL );
		
		echo ("Buscando com método all...");
		$produto = $this->produtoServico->repositorio()->todos(0,0,array('valor'=>'desc'),array());
		var_dump($produto);
		
		echo ("Contando...");
		echo $this->produtoServico->contar();
		
	}
	
}

?>