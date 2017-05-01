<?php

class ParametroUtil {
	
	private static function valor( array $array, $chave, $tirarEspaco, $codificarTudo ) {
		if ( ! isset( $array[ $chave ] ) ) {
			return null;
		}
		$conteudo = ( $tirarEspaco ) ? trim( $array[ $chave ] ) : $array[ $chave ];
		if ( $codificarTudo ) {
			return htmlentities( $conteudo, ENT_COMPAT, 'UTF-8' );
		}
		return htmlspecialchars( $conteudo, ENT_COMPAT, 'UTF-8' );
	}
	
	static function get( $chave, $tirarEspaco = true, $codificarTudo = false ) {
		return self::valor( $_GET, $chave, $tirarEspaco, $codificarTudo ); 
	}
	
	static function post( $chave, $tirarEspaco = true, $codificarTudo = false ) {
		return self::valor( $_POST, $chave, $tirarEspaco, $codificarTudo );
	}
	
	static function request( $chave, $tirarEspaco = true, $codificarTudo = false ) {
		return self::valor( $_REQUEST, $chave, $tirarEspaco, $codificarTudo );
	}
	
}

?>