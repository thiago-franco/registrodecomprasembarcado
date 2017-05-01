<?php

class LoteControladora {

	private $pdo;
	private $loteServico;

	function __construct( ) {
		$this->pdo = BD::pdo();
		$loteRepositorio = new LoteRepositorio( $this->pdo );
		$loteValidadora = new LoteValidadora( );
		$this->loteServico = new LoteServico( $loteValidadora, $loteRepositorio );
	}

	function salvar( ) {
		$validade = DateTimeUtil::fromBrazilianFormat(ParamUtil::post('validade'));
		$lote  = new Lote( ParamUtil::post('id'), ParametroUtil::post('nome'), new Produto(ParametroUtil::post('produto')),  $validade );
		$this->loteServico->salvar( $lote );
	}
	
	function excluir( ) {
		$lote = new Lote( ParamUtil::post('id' ) );
		$this->loteServico->remover( $lote->getId() );
	}

    /**
     * TODO Possibilitar busca por descrição de produto.
     * @return DataTablesFormat
     */
    function lotes() {
		$limit = 0;
		$offset = 0;
		$ordenacao = array();
		$filtros = array();
		$total = $this->loteServico->contar();
		switch ( ParamUtil::request( 'iSortCol_0' ) ) {
			case 0: $ordenacao['id'] = ParamUtil::request( 'sSortDir_0' ); break;
			case 1: $ordenacao['nome'] = ParamUtil::request('sSortDir_0' ); break;
			case 3: $ordenacao['validade'] = ParamUtil::request( 'sSortDir_0' ); break;
			
		}
		if( DataTablesUtil::hasSearch() ) {
			$filtros['id'] = DataTablesUtil::search();
			$filtros['nome'] = DataTablesUtil::search();
			$filtros['validade'] = DataTablesUtil::search();
			
		}
		$linhasAExibir = count( $this->loteServico->repositorio()->todos( $limit, $offset, $ordenacao, $filtros ) );
		if( DataTablesUtil::hasLimit() &&  DataTablesUtil::hasOffset() ) {
			$limit = DataTablesUtil::limit();
			$offset = DataTablesUtil::offset();
		}
		$lotes = $this->loteServico->repositorio()->todos( $limit, $offset, $ordenacao, $filtros );
		foreach ( $lotes as $lote ) 
			$lote->setValidade( DateTimeUtil::toBrazilianFormat( $lote->getValidade() ) );
		return new DataTablesFormat($total, $linhasAExibir, $lotes );
	}

}

?>