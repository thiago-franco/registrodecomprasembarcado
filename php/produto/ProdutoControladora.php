<?php

class ProdutoControladora {

	private $pdo;
	private $produtoServico;

	function __construct( ) {
		$this->pdo = BD::pdo();
		$produtoRepositorio = new ProdutoRepositorio( $this->pdo );
		$produtoValidadora = new ProdutoValidadora( );
		$this->produtoServico = new ProdutoServico( $produtoValidadora, $produtoRepositorio );
	}

	function salvar( ) {
		$valor = TratamentoUtil::decimalComVirgulaParaPonto( ParamUtil::post('valor') );
		$produto  = new Produto(ParamUtil::post('id'), ParamUtil::post('codigo_barras'), ParamUtil::post('descricao'), $valor);
		$this->produtoServico->salvar( $produto );
	}
	
	function excluir( ) {
		$produto = new Produto( ParamUtil::post('id') );
		$this->produtoServico->remover( $produto->getId() ); 
	}

	function produtos() {
		$limit = 0;
		$offset = 0; 
		$ordenacao = array();
		$filtros = array();
		$total = $this->produtoServico->contar();
		switch ( ParamUtil::request( 'iSortCol_0' ) ) {
			case 0: $ordenacao['id'] = ParamUtil::request( 'sSortDir_0' ); break;
			case 1: $ordenacao['codigo_barras'] = ParamUtil::request( 'sSortDir_0' ); break;
			case 2: $ordenacao['descricao'] = ParamUtil::request( 'sSortDir_0' ); break;
			case 3: $ordenacao['valor'] = ParamUtil::request( 'sSortDir_0' ); break;
		}
		if( DataTablesUtil::hasSearch() ) {
			$filtros['id'] = DataTablesUtil::search();
			$filtros['codigo_barras'] = DataTablesUtil::search();
			$filtros['descricao'] = DataTablesUtil::search();
			$filtros['valor'] = DataTablesUtil::search();			
		}
		$linhasAExibir = count( $this->produtoServico->repositorio()->todos( $limit, $offset, $ordenacao, $filtros ) );
		if( DataTablesUtil::hasLimit() &&  DataTablesUtil::hasOffset() ) {
			$limit = DataTablesUtil::limit();
			$offset = DataTablesUtil::offset();
		}
		$produtos = $this->produtoServico->repositorio()->todos( $limit, $offset, $ordenacao, $filtros );
		return new DataTablesFormat($total, $linhasAExibir, $produtos );
	}
	
}

?>