<?php
/* THIS FILE:
 * a)	BELONGS TO THE 'PHP-UTIL' LIBRARY:
 *		https://github.com/thiagodp/php-util
 *
 * b)	IS DISTRIBUTED UNDER THE CREATIVE COMMONS LICENCE (CC BY 3.0):
 * 		http://creativecommons.org/licenses/by/3.0/
 *
 * USE IT AT YOUR OWN RISK!
 */
 
require_once 'RTTI.php'; // Uses RTTI::getPrivateAttributes

/**
 * JSON utilities.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.2
 */
class JSON {

	/**
	 * Encode a data to JSON format.
	 * 
	 * @param data							the data to be serialized as JSON.
	 * @param getterPrefixForObjectMethods	the prefix for getter methods (defaults to 'get').
	 *										Ignore it for non object data.
	 * @return								a string in JSON format.
	 */
	static function encode( $data, $getterPrefixForObjectMethods = 'get' ) {
		$type = gettype( $data );
		switch ( $type ) {		
			case 'string'	: return '"' . self::correct( $data ) . '"';
			case 'number'	: // continue
			case 'integer'	: // continue
			case 'float'	: // continue			
			case 'double'	: return $data;				
			case 'boolean'	: return ( $data ) ? 'true' : 'false';
			case 'NULL'		: return 'null';
			case 'object'	:
				$data = RTTI::getPrivateAttributes( $data, $getterPrefixForObjectMethods );
				// continue
			case 'array'	:
				$indexCount = 0;
				$outputIndexed = array();
				$outputAssociative = array();
				foreach ( $data as $key => $value ) {
					$encodedValue = self::encode( $value, $getterPrefixForObjectMethods );
					$encodedPairKeyValue = self::encode( $key, $getterPrefixForObjectMethods )
						. ' : ' . $encodedValue;				
					$outputIndexed[] = $encodedValue;
					$outputAssociative[] = $encodedPairKeyValue;
					// If the key is not numbered, nullify the counter
					if ( $indexCount !== NULL && $indexCount++ !== $key ) {
						$indexCount = NULL;
					}
				}
				if ( NULL == $indexCount ) { // NOT numbered key 
					return '{ ' . implode( ', ', $outputAssociative ) . ' }';
				} else {
					return '[ ' . implode( ', ', $outputIndexed ) . ' ]';				
				}		
			default			: return ''; // Not supported type
		}
	}
	
	/**
	 * Correct the string to be returned as JSON. This function is replacing addslashes that fails
	 * in convert \' to '. The javascript fails if a \' is found in a JSON string.
	 *
	 * @param str	the string to be corrected.
	 * @return		a corrected string.
	 */
	private static function correct( $str ) {
		// I know that the parameters in str_replace could be an array but I think it is more
		// readable to use this way.
		$newStr = str_replace( '"', '\"', $str );
		return str_replace( '\\\'', '\'', $newStr );
	}

}

?>