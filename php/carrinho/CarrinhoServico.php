<?php

class CarrinhoServico extends ServicoAbstrato {
	
	protected  $repositorio;
	protected  $validadora;
	
	function __construct( CarrinhoValidadora $validadora, CarrinhoRepositorio $repositorio ) {
		if ( ! isset( $validadora ) ) throw new InvalidArgumentException( 'Validadora inválida.' );
		if ( ! isset( $repositorio ) ) throw new InvalidArgumentException( 'Repositório inválido.' );
		$this->validadora = $validadora;
		$this->repositorio = $repositorio;
	}
	
	function comIr( $ir ) {
		$objs = $this->repositorio->todos( 0, 0, array(), array('ir' => $ir), true );
		if( count( $objs ) > 0 )
			return $objs[0];
		return null;
	}
	
	function comNumeroSerie( $numeroSerie ) {
		$objs = $this->repositorio->todos( 0, 0, array(), array('numero_serie' => $numeroSerie) );
		if( count( $objs ) > 0 )
			return $objs[0];
		return null;
	}
	
}

?>