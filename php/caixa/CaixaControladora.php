<?php

class CaixaControladora {
	
	private $pdo;
	private $caixaServico;
	
	function __construct( ) {
		$this->pdo = BD::pdo();
		$caixaRepositorio = new CaixaRepositorio( $this->pdo );
		$caixaValidadora = new CaixaValidadora( );
		$this->caixaServico = new CaixaServico( $caixaValidadora, $caixaRepositorio );
	}
	
	function salvar( ) {
		$caixa  = new Caixa(ParamUtil::post('id'), ParamUtil::post('nome'), ParamUtil::post('serie'));
		$this->caixaServico->salvar( $caixa );
	}
	
	function excluir() {
		$caixa = new Caixa( ParamUtil::post('id') );
		$this->caixaServico->remover( $caixa->getId() );
	}
	
	function caixas() {
		$limit = 0;
		$offset = 0; 
		$ordenacao = array();
		$filtros = array();
		$total = $this->caixaServico->contar();
		switch ( ParamUtil::request( 'iSortCol_0' ) ) {
			case 0: $ordenacao['id'] = ParamUtil::request( 'sSortDir_0' ); break;
			case 1: $ordenacao['nome'] = ParamUtil::request( 'sSortDir_0' ); break;
			case 2: $ordenacao['numero_serie'] = ParamUtil::request( 'sSortDir_0' ); break;
		}
		if( DataTablesUtil::hasSearch() ) {
			$filtros['id'] = DataTablesUtil::search();
			$filtros['nome'] = DataTablesUtil::search();
			$filtros['numero_serie'] = DataTablesUtil::search();						
		}
		$linhasAExibir = count( $this->caixaServico->repositorio()->todos( $limit, $offset, $ordenacao, $filtros ) );
		if( DataTablesUtil::hasLimit() &&  DataTablesUtil::hasOffset() ) {
			$limit = DataTablesUtil::limit();
			$offset = DataTablesUtil::offset();
		}
		$caixas = $this->caixaServico->repositorio()->todos( $limit, $offset, $ordenacao, $filtros );
		return new DataTablesFormat($total, $linhasAExibir, $caixas );
	}
	
}

?>