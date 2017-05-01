<?php

class ItemTeste {

	private $itemServico = null;

	public function __construct() {
		$pdo = BD::pdo();
		$validator = new ItemValidadora();
		$repository = new ItemRepositorio($pdo);

		$this->itemServico = new ItemServico( $validator, $repository );
	}

	public function testar() {

		echo ("Criando o objeto...");
		$item = new Item( 0, 'UID5', new Lote(20) );
		var_dump($item);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Salvando objeto...");
		$this->itemServico->salvar($item);
		var_dump($item);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Buscando objeto...");
		$item = $this->itemServico->comUid($item->getUid());
		var_dump($item);

		echo ("Alterando objeto...");
		$item->setLote(new Lote(27));
		$this->itemServico->salvar($item);
		var_dump($item);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Buscando objeto...");
		$item = $this->itemServico->comUid('UID11');
		var_dump($item);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Contando...");
		echo $this->itemServico->contar();

	}

}

?>