<?php

/**
 * Possíveis situações para validade.
 * @author Thiago Franco
 */
class Validade {
	
	const VALIDA = '0';
	const VENCIDA = '1';

	/**
	 * Retorna possíveis situações para validade em um array.
	 * @return multitype:string
	 */
	static function valores() {
		return array( self::VALIDA, self::VENCIDA );
	}
	
}

?>