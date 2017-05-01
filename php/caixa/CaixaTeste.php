<?php

class CaixaTeste {

	private $caixaServico = null;

	public function __construct() {
		$pdo = BD::pdo();
		$validadora = new CaixaValidadora();
		$repositorio = new CaixaRepositorio($pdo);
		$this->caixaServico = new CaixaServico($validadora, $repositorio);;
	}

	public function testar() {

		echo ("Criando o objeto...");
		$caixa = new Caixa( 0, 'caixa03', 3 );
		var_dump($caixa);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Salvando objeto...");
		$this->caixaServico->salvar($caixa);
		var_dump($caixa);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Buscando objeto...");
		$caixa = $this->caixaServico->comId($caixa->getId());
		var_dump($caixa);

		echo ("Alterando objeto...");
		$caixa->setNome('caixa10');
		$this->caixaServico->salvar($caixa);
		var_dump($caixa);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Buscando objeto...");
		$caixa = $this->caixaServico->comId($caixa->getId());
		var_dump($caixa);

		echo ( PHP_EOL . PHP_EOL );

		echo ("Buscando com método all...");
		$caixa = $this->caixaServico->repositorio()->todos(0,0,array('id'=>'desc'),array('nome'=>'caixa2'), true);
		var_dump($caixa);

	}

}

?>