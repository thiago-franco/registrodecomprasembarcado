<?php

class CarrinhoControladora {

	private $pdo;
	private $carrinhoServico;

	function __construct( ) {
		$this->pdo = BD::pdo();
		$carrinhoRepositorio = new CarrinhoRepositorio( $this->pdo );
		$carrinhoValidadora = new CarrinhoValidadora( );
		$this->carrinhoServico = new CarrinhoServico( $carrinhoValidadora, $carrinhoRepositorio );
	}

	function salvar( ) {
		$carrinho  = new Carrinho(ParametroUtil::post('id'), ParametroUtil::post('serie'), ParametroUtil::post('nome'), ParametroUtil::post('ir')); 
		$this->carrinhoServico->salvar( $carrinho );
	}
	
	function excluir() {
		$carrinho = new Carrinho( ParamUtil::post('id') );
		$this->carrinhoServico->remover( $carrinho->getId() );
	}

	function carrinhos() {
		$limit = 0;
		$offset = 0; 
		$ordenacao = array();
		$filtros = array();
		$total = $this->carrinhoServico->contar();
		switch ( ParametroUtil::request( 'iSortCol_0' ) ) {
			case 0: $ordenacao['id'] = ParametroUtil::request( 'sSortDir_0' ); break;
			case 1: $ordenacao['numero_serie'] = ParametroUtil::request( 'sSortDir_0' ); break;
			case 2: $ordenacao['nome'] = ParametroUtil::request( 'sSortDir_0' ); break;
			case 3: $ordenacao['ir'] = ParametroUtil::request( 'sSortDir_0' ); break;
		}
		if( DataTablesUtil::hasSearch() ) {
			$filtros['id'] = DataTablesUtil::search();
			$filtros['numero_serie'] = DataTablesUtil::search();
			$filtros['nome'] = DataTablesUtil::search();	
			$filtros['ir'] = DataTablesUtil::search();
		}
		$linhasAExibir = count( $this->carrinhoServico->repositorio()->todos( $limit, $offset, $ordenacao, $filtros ) );
		if( DataTablesUtil::hasLimit() &&  DataTablesUtil::hasOffset() ) {
			$limit = DataTablesUtil::limit();
			$offset = DataTablesUtil::offset();
		}
		$carrinhos = $this->carrinhoServico->repositorio()->todos( $limit, $offset, $ordenacao, $filtros );  
		return new DataTablesFormat($total, $linhasAExibir, $carrinhos );
	}

}

?>