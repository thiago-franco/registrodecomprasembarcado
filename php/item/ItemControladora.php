<?php

class ItemControladora {

	private $pdo;
	private $itemServico;

	function __construct( ) {
		$this->pdo = BD::pdo();
		$itemRepositorio = new ItemRepositorio( $this->pdo );
		$itemValidadora = new ItemValidadora( );
		$this->itemServico = new ItemServico( $itemValidadora, $itemRepositorio );
	}

	function salvar( ) {
		$item  = new Item( ParamUtil::post('id'), ParamUtil::post('uid'), new Lote(ParamUtil::post('lote')) );
		$this->itemServico->salvar( $item );
	}
	
	function excluir( ) {
		$item = new Item( ParamUtil::post('id') );
		$this->itemServico->remover( $item->getId() );
	}

    /**
     * TODO Possibilitar busc por descrição de produto
     * @return DataTablesFormat
     */
    function itens() {
		$limit = 0;
		$offset = 0;
		$ordenacao = array();
		$filtros = array();
		$total = $this->itemServico->contar();
		switch ( ParamUtil::request( 'iSortCol_0' ) ) {
			case 0: $ordenacao['id'] = ParamUtil::request( 'sSortDir_0' ); break;
			case 1: $ordenacao['uid'] = ParamUtil::request( 'sSortDir_0' ); break;
			case 2: $ordenacao['lote_id'] = ParamUtil::request( 'sSortDir_0' ); break;
		}
		if( DataTablesUtil::hasSearch() ) {
			$filtros['id'] = DataTablesUtil::search();
			$filtros['uid'] = DataTablesUtil::search();
			$filtros['lote_id'] = DataTablesUtil::search();
		}
		$linhasAExibir = count( $this->itemServico->repositorio()->todos( $limit, $offset, $ordenacao, $filtros ) );
		if( DataTablesUtil::hasLimit() &&  DataTablesUtil::hasOffset() ) {
			$limit = DataTablesUtil::limit();
			$offset = DataTablesUtil::offset();
		}
		$itens = $this->itemServico->repositorio()->todos( $limit, $offset, $ordenacao, $filtros );
		foreach ( $itens as $item ) 
			$item->getLote()->setValidade( DateTimeUtil::toBrazilianFormat( $item->getLote()->getValidade() ) );
		return new DataTablesFormat($total, $linhasAExibir, $itens );
	}

}

?>