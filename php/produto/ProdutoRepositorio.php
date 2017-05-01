<?php

class ProdutoRepositorio extends RepositorioAbstrato {

	protected  $tabela = 'produto';
	protected  $pdo;

	function __construct( $pdo ) {
		if(! isset( $pdo ) ) throw new InvalidArgumentException( "Instância de objeto PDO inválida." );
		$this->pdo = $pdo;
	}

	function linhaParaObjeto( $linha ){
		return new Produto( $linha['id'], $linha['codigo_barras'], $linha['descricao'], TratamentoUtil::decimalComPontoParaVirgula($linha['valor']) );
	}
	
	function adicionar( $obj ) {
		if( $this->existe( $obj ) )
			throw new RepositorioException( "Produto com mesmo id já existente no banco de dados.");
		$comando  = "INSERT INTO $this->tabela (codigo_barras, descricao, valor ) VALUES ( :codigo_barras, :descricao, :valor )";
		$valores = array( 'codigo_barras' => $obj->getCodigoBarras(), 'descricao' => $obj->getDescricao(), 'valor' => $obj->getvalor() );
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Adição de produto ao banco mal sucessedida." );
		$obj->setId( $this->pdo->lastInsertId() );
		return $obj;
	}
	
	function atualizar( $obj ) {
		$comando = "UPDATE $this->tabela SET codigo_barras = :codigo_barras, descricao = :descricao, valor = :valor WHERE id = :id";
		$valores = array( 'codigo_barras' => $obj->getCodigoBarras(), 'descricao' => $obj->getDescricao(), 'valor' => $obj->getvalor(), 'id' => $obj->getId() );
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Atualização de produto no banco mal sucessedida." );
	}
	
}

?>