<?php

class CaixaValidadora {
	
	function validar( Caixa $caixa ) {
		
		$msg = array();
		
		if(! isset( $caixa ) ) 	
			throw new ValidadoraException("Caixa não deve ser um objeto nulo");
		
		if( $caixa->getId( ) < 0 ) 
			$msg[] = "Id de caixa deve ser um numero positivo";
		
		if( strlen( $caixa->getNome( ) > 45 ) )
			$msg[] = "Nome do caixa deve ter até 45 caracteres";
		
		if( count($msg) > 0 )
			throw new ValidadoraException(implode(PHP_EOL, $msg));
		
	}
	
}

?>