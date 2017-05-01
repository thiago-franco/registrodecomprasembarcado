<?php

class ItemRepositorio extends RepositorioAbstrato {
	
	protected $tabela = 'item';
	protected $pdo;
	private $loteRepositorio;
	private $compraId;
	
	function __construct( $pdo ) {
		if(! isset( $pdo ) ) throw new InvalidArgumentException( "Instância de objeto PDO inválida." );
		$this->pdo = $pdo;
		$this->loteRepositorio = new LoteRepositorio( $this->pdo );
	}
	
	function getCompraId() { return $this->compraId; }
	function setCompraId( $compraId ) { $this->compraId = $compraId; }
	
	function linhaParaObjeto( $linha ) {
		$lote = null;
		if( isset( $linha['lote_id']) )
			$lote = $this->loteRepositorio->comId( $linha['lote_id'] );
		return new Item( $linha['id'], $linha['uid'], $lote );
	}
	
	function adicionar( $obj ) {
		if( $this->existe( $obj ) )
			throw new RepositorioException( "Item com mesmo id já existente no banco de dados.");
		$comando  = "INSERT INTO $this->tabela ( uid, lote_id ) VALUES ( :uid, :lote_id )";
		$valores = array( 'uid' => $obj->getUid(), 'lote_id' => $obj->getLote()->getId() );
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Adição de item ao banco mal sucessedida." );
		$obj->setId( $this->pdo->lastInsertId() );
		return $obj;
	}
	
	function atualizar( $obj ) {
		$comando = "UPDATE $this->tabela SET lote_id = :lote_id WHERE id = :id AND uid = :uid";
		$valores = array( 'lote_id' => $obj->getLote()->getId(), 'id' => $obj->getId(), 'uid' => $obj->getUid() );
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Atualização de item no banco mal sucessedida." );
	}
	
	function atualizarCompraId( $obj ) { 
		$comando = "UPDATE $this->tabela SET compra_id = :compra_id WHERE uid = :uid";
		$valores = array( 'compra_id' => $this->getCompraId(), 'uid' => $obj->getUid() );
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Atualização de item no banco mal sucessedida." );
	}
	
}

?>