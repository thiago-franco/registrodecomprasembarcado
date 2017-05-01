<?php

class CompraServico extends ServicoAbstrato {
	
	protected  $repositorio;
	protected  $validadora;
	
	function __construct( CompraValidadora $validadora, CompraRepositorio $repositorio ) {
		if ( ! isset( $validadora ) ) throw new InvalidArgumentException( 'Validadora inválida.' );
		if ( ! isset( $repositorio ) ) throw new InvalidArgumentException( 'Repositório inválido.' );
		$this->validadora = $validadora;
		$this->repositorio = $repositorio;
	}
	
	function comCarrinhoId( $carrinhoId ) {
		$objs = $this->repositorio->todos(0, 0, array(), array('carrinho_id' => $carrinhoId), true);
		if( count( $objs ) > 0 ){
			return $objs[0];}
		return null;
	}

    function comprasSimplificadas() {
        return $this->repositorio->buscarComprasSimples();
    }
	
	function atualizarCaixa( $compra ) {
		$this->repositorio->atualizarCaixa( $compra );
	}
	
	function adicionarItens( $compra ) {
		try{
			$this->validadora->validar( $compra );
		} catch ( ValidadoraExcpetion $e ) {
			throw new ServicoException( $e->getMessage(), $e->getCode() );
		}
		try{
			foreach ( $compra->getItens() as $item )
				$this->repositorio->adicionarItem( $compra, $item );
		} catch ( RepositorioException $e ) {
			throw new ServicoException( $e->getMessage() );
		}
	}
	
	function removerItens( $compra ) {
		$itens = $compra->getItens();
		foreach ( $itens as $item ) { 
			if( $item->getId() !== null )
				$this->repositorio->removerItem( $item );
			else throw new InvalidArgumentException("Instancia de item inválida");
		}
			
	}
	
	function checarItem( $compra, $item ) {
		if( $compra->getID() !== null && $item->getUid() !== null )
			return $this->repositorio->checarItem( $compra, $item );
		else throw new InvalidArgumentException("Instancia de compra ou item inválidas");
	}

    function contarItens( $compra ) {
        return $this->repositorio()->contarItens( $compra );
    }
	
}

?>