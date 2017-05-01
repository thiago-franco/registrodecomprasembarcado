<?php

class CaixaServico extends ServicoAbstrato {
	
	protected  $repositorio;
	protected  $validadora;
	
	function __construct( CaixaValidadora $validadora, CaixaRepositorio $repositorio ) {
		if ( ! isset( $validadora ) ) throw new InvalidArgumentException( 'Validadora inválida.' );
		if ( ! isset( $repositorio ) ) throw new InvalidArgumentException( 'Repositório inválido.' );
		$this->validadora = $validadora;
		$this->repositorio = $repositorio;
	}
	
}

?>