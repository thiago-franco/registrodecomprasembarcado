<?php

class LoteTeste {

	private $loteServico = null;

	public function __construct() {
		$pdo = DB::pdo();
		$validator = new LoteValidadora();
		$repository = new LoteRepositorio($pdo);

		$this->loteServico = new LoteServico( $validator, $repository );
	}

	public function testar() {

		echo ("Criando o objeto...");
		$lote = new Lote( 0, 'loteA', new Produto( 5 ), DateTimeUtil::fromBrazilianFormat('15/07/2014'));
		var_dump($lote);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Salvando objeto...");
		$this->loteServico->salvar($lote);
		var_dump($lote);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Buscando objeto...");
		$lote = $this->loteServico->comId($lote->getId());
		var_dump($lote);

		echo ("Alterando objeto...");
		$lote->setValidade(DateTimeUtil::fromBrazilianFormat('16/07/2014')); var_dump($lote);
		$this->loteServico->salvar($lote);
		var_dump($lote);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Buscando objeto...");
		$lote = $this->loteServico->comId($lote->getId());
		var_dump($lote);

		echo ( PHP_EOL . PHP_EOL );
		
		echo ("Buscando com método all...");
		$lote = $this->loteServico->repositorio()->todos();
		var_dump($lote);
		
		echo ( PHP_EOL . PHP_EOL );

		echo ("Contando...");
		echo $this->loteServico->contar();

	}

}
?>