<?php

/** 
 * Singleton para acesso ao banco de dados.
 */
class BD {

	private static $pdo;
	
	const HOST = 'localhost'; // TODO: Mudar para o ip do servidor no futuro
	
	static function pdo() {
		if ( ! isset( self::$pdo ) ) {			
			$dsn = 'mysql:dbname=RegistroEmbarcado;host=' . self::HOST . ';charset=utf8';
			$usuario = 'root';
			$senha = '';
			// TODO: Mudar o usuário e senha no futuro
			self::$pdo = new PDO( $dsn, $usuario, $senha, array(PDO::ATTR_PERSISTENT => true) );
		}
		return self::$pdo;
	}
	
}
?>