<?php

class LoteRepositorio extends RepositorioAbstrato {
	
	protected $tabela = 'lote';
	protected $pdo;
	private $produtoRepositorio;
	
	function __construct( $pdo ) {
		if(! isset( $pdo ) ) throw new InvalidArgumentException("Instância de objeto PDO inválida.");
		$this->pdo = $pdo;
		$this->produtoRepositorio = new ProdutoRepositorio( $this->pdo );
	}
	
	function linhaParaObjeto( $linha ) {
		$produto = null;
		if( isset( $linha['produto_id'] ) )
			$produto = $this->produtoRepositorio->comId( $linha['produto_id'] );
		return new Lote( $linha['id'], $linha['nome'], $produto, DateTimeUtil::fromDBFormat( $linha['validade'] ) );
	}
	
	function adicionar( $obj ) {
		if( $this->existe( $obj ) )
			throw new RepositorioException( "Lote com mesmo id já existente no banco de dados.");
		$comando  = "INSERT INTO $this->tabela ( nome, produto_id, validade ) VALUES ( :nome, :produto_id, :validade )";
		$valores = array('nome' => $obj->getNome(), 'produto_id' => $obj->getProduto()->getId(), 'validade' => DateTimeUtil::toDBFormat( $obj->getValidade() ) );
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Adição de lote ao banco mal sucessedida." );
		$obj->setId( $this->pdo->lastInsertId() );
		return $obj;
	}
	
	function atualizar( $obj ) {
		$comando = "UPDATE $this->tabela SET nome = :nome, validade = :validade, produto_id = :produto_id WHERE id = :id";
		$valores = array( 'nome' => $obj->getNome(), 'validade' => DateTimeUtil::toDBFormat( $obj->getValidade() ), 'produto_id' => $obj->getProduto()->getId(), 'id' => $obj->getId() );
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Atualização de lote no banco mal sucessedida." );
	}
}

?>