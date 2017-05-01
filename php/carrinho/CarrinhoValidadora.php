<?php

class CarrinhoValidadora {

	function validar( Carrinho $carrinho ) {

		$msg = array();

		if(! isset( $carrinho ) )
			throw new ValidadoraException("Carrinho não deve ser um objeto nulo");

		if( $carrinho->getId( ) < 0 )
			$msg[] = "Id de carrinho deve ser um numero positivo";

		if( strlen( $carrinho->getNumeroSerie() ) < 0 )
			$msg[] = "Número de série do carrinho deve ser um número positivo";
		
	/*	if( $carrinho->getIr() === '' )
			$msg[] = "Ir de carrinho não pode ser nulo"; */

		if( count($msg) > 0 ){
			throw new ValidadoraException(implode(PHP_EOL, $msg));}

	}

}

?>