<?php

class CarrinhoTeste {

	private $carrinhoServico = null;

	public function __construct() {
		$pdo = BD::pdo();
		$validadora = new CarrinhoValidadora();
		$repositorio = new CarrinhoRepositorio($pdo);
		$this->carrinhoServico = new CarrinhoServico($validadora, $repositorio);;
	}

	public function testar() {
			
		$nome = "carrinho";
		$ir = "00000";

		echo ("Criando o objeto...");
		$carrinho = new Carrinho( 0, 'carrinho1', 'FEDA01B' );
		var_dump($carrinho);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Salvando objeto...");
		$this->carrinhoServico->salvar($carrinho);
		var_dump($carrinho);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Buscando objeto...");
		$carrinho = $this->carrinhoServico->comId($carrinho->getId());
		var_dump($carrinho);

		echo ("Alterando objeto...");
		$carrinho->setNome($nome);
		$carrinho->setIr($ir);
		$this->carrinhoServico->salvar($carrinho);
		var_dump($carrinho);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Buscando objeto...");
		$carrinho = $this->carrinhoServico->comIr($carrinho->getIr());
		var_dump($carrinho);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Buscando com método all...");
		$carrinho = $this->carrinhoServico->repositorio()->todos(0,0,array('nome'=>'desc'),array('ir'=>$ir, 'nome'=>$nome), true);
		var_dump($carrinho);
		
	}
	
}

?>