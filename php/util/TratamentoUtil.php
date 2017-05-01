<?php

/**
 * Classe de utilidades para tratamento de dados em geral.
 * @author Thiago Franco
 *
 */
class TratamentoUtil {
	
	/**
	 * Substitui o ponto de números decimais por vírgula.
	 * @param unknown $decimalComPonto
	 */
	static function decimalComPontoParaVirgula( $decimalComPonto ) {
		return str_replace( '.', ',', $decimalComPonto );
	}
	
	/**
	 * Substitui a vírgula de números decimais por ponto.
	 * @param unknown $decimalComVirgula
	 */
	static function decimalComVirgulaParaPonto( $decimalComVirgula ) {
		return str_replace( ',', '.', $decimalComVirgula );
	}
	
	/**
	 * Substitui caracteres acentuados por caracteres não acentuados.
	 * @param String $string
	 */
	static function removeAcento( $string ) {
		$acentuadas = array('à','á','â','ã','è','é','ê','ì','í','î','ò','ó','ô','õ','ù','ú','û','ç', 'À','Á','Â','Ã','È','É','Ê','Ì','Í','Î','Ò','Ó','Ô','Õ','Ù','Ú','Û','Ç');
		$naoAcentuadas = array('a','a','a','a','e','e','e','i','i','i','o','o','o','o','u','u','u','c', 'A','A','A','A','E','E','E','I','I','I','O','O','O','O','U','U','U','C');
		return str_replace($acentuadas, $naoAcentuadas, $string);
	}
	
}

?>