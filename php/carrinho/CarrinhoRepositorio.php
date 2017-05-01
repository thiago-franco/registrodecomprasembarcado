<?php

class CarrinhoRepositorio extends RepositorioAbstrato {
	
	protected $tabela = 'carrinho';
	protected $pdo;
	
	function __construct( $pdo ) {
		if(! isset( $pdo ) ) throw new InvalidArgumentException("Instância de objeto PDO inválida.");
		$this->pdo = $pdo;
	}
	
	function linhaParaObjeto( $linha ) {
		return new Carrinho( $linha['id'], $linha['numero_serie'], $linha['nome'], $linha['ir'] );		
	}
	
	function adicionar( $obj ) {
		if( $this->existe( $obj ) )		
			throw new RepositorioException( "Carrinho com mesmo id já existente no banco de dados." );
		$comando  = "INSERT INTO $this->tabela ( numero_serie, nome, ir ) VALUES ( :numero_serie, :nome, :ir )";
		$valores = array( 'numero_serie' => $obj->getNumeroSerie(), 'nome' => $obj->getNome(), 'ir' =>  $obj->getIr() );
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Adição de carrinho ao banco mal sucessedida." );
		$obj->setId( $this->pdo->lastInsertId() );
		return $obj;
	}
	
	function atualizar( $obj ) {
		$comando = "UPDATE $this->tabela SET numero_serie = :numero_serie, nome = :nome, ir = :ir WHERE id = :id";
		$valores = array( 'numero_serie' => $obj->getNumeroSerie(), 'nome' => $obj->getNome(), 'ir' => $obj->getIr(), 'id' => $obj->getId() );
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Atualização de carrinho no banco mal sucessedida." );
	}
}

?>