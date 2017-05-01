<?php

class CompraTeste {

	private $compraServico = null; 

	public function __construct() {
		$pdo = BD::pdo();
		$validator = new CompraValidadora();
		$repository = new CompraRepositorio($pdo);

		$this->compraServico = new CompraServico( $validator, $repository );
	}

	public function testar() {

		echo ("Criando o objeto...");
		$itens = array(new Item(0, 'UID1'), new Item(0, 'UID2'), new Item(0, 'UID3'), new Item(0, 'UID4'), new Item(0, 'UID5'));
		//$itens = array(new Item(0, 'UID6'), new Item(0, 'UID7'), new Item(0, 'UID8'), new Item(0, 'UID9'), new Item(0, 'UID10'));
		$compra = new Compra( 0, new Carrinho(2) );
		$compra->setItens($itens);
		var_dump($compra);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Salvando objeto...");
		$compra->setOperacao(1);
		$this->compraServico->salvar($compra);
		$this->compraServico->adicionarItens($compra);
		var_dump($compra);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Buscando objeto...");
		$compra->setOperacao(2);
		$compra = $this->compraServico->comCarrinhoId($compra->getCarrinho()->getId());
		var_dump($compra); var_dump($compra->getItens());

		echo ("Alterando objeto...");
		$compra->setOperacao(3);
		$compra->getCarrinho()->setId(10);
		$compra->setCaixa(new Caixa(10));
		$compra->setTotal(100);
		$this->compraServico->salvar($compra);
		var_dump($compra);
		
		echo ( PHP_EOL . PHP_EOL );
		
		echo ("Removendo itens de compra...");
		
		$this->compraServico->removerItens($compra->getItens());

		echo ( PHP_EOL . PHP_EOL );

		echo ("Buscando objeto...");
		$compra = $this->compraServico->comId($compra->getId());
		var_dump($compra);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Contando...");
		echo $this->compraServico->contar();

	}

}

?>