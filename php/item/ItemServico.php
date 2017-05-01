<?php

class ItemServico extends ServicoAbstrato {
	
	protected  $repositorio;
	protected  $validadora;
	
	function __construct( ItemValidadora $validadora, ItemRepositorio $repositorio ) {
		if ( ! isset( $validadora ) ) throw new InvalidArgumentException( 'Validadora inválida.' );
		if ( ! isset( $repositorio ) ) throw new InvalidArgumentException( 'Repositório inválido.' );
		$this->validadora = $validadora;
		$this->repositorio = $repositorio;
	}
	
	function comUid( $uid ) {
		$objs = $this->repositorio->todos(0,0,array(),array('uid' => $uid ),true );
		if( count( $objs ) > 0 )
			return $objs[0];
		return null;
	}
	
}

?>