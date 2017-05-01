<?php

/**
 * Tipos de operações realizados em uma compra
 * @author Thiago Franco
 *
 */
class Operacao {
	
	const ADICAO = '1';
	const REMOCAO = '2';
	const ERRO = '3';

	/**
	 * Retorna tipos de operação em um array.
	 * @return multitype:string
	 */
	static function valores() {
		return array(
				self::ADICAO,
				self::REMOCAO,
				self::ERRO
		);
	}
	
}

?>