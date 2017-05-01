<?php

class CaixaRepositorio extends RepositorioAbstrato  {
	
	protected $tabela = 'caixa';
	protected $pdo;
	
	function __construct( $pdo ) {
		if(! isset( $pdo ) ) throw new InvalidArgumentException("Instância de objeto PDO inválida.");
		$this->pdo = $pdo;
	}
	
	function linhaParaObjeto( $linha ) {
		return new Caixa( $linha['id'], $linha['nome'], $linha['numero_serie'] );
	}
	
	function adicionar( $obj ) {
		if( $this->existe( $obj ) )
			throw new RepositorioException( "Caixa com mesmo id já existente no banco de dados.");
		$comando  = "INSERT INTO $this->tabela ( nome, numero_serie ) VALUES ( :nome, :numeroSerie )";
		$valores = array( 'nome' => $obj->getNome(), 'numeroSerie' => $obj->getNumeroSerie() );
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Adição de caixa ao banco mal sucessedida." );
		$obj->setId( $this->pdo->lastInsertId() );
		return $obj;
	}
	
	function atualizar( $obj ) {
		$comando = "UPDATE $this->tabela SET nome = :nome, numero_serie = :numeroSerie WHERE id = :id";
		$valores = array( 'nome' => $obj->getNome(), 'numeroSerie' => $obj->getNumeroSerie(), 'id' => $obj->getId() );
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Atualização de caixa no banco mal sucessedida." );
	}
	
}

?>