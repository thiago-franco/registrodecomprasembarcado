<?php
/**
 * Funções para datas.
 * @author Reydson Barros
 */
class DateTimeUtil {
	
	/**
	 * Recebe um objeto do tipo DateTime e retorna uma string aceita pelo MySQL.
	 *
	 * @param unknown $date
	 */
	static function toDBFormat( $date ){
		return $date->format('Y-m-d');
	}
	
	/**
	 * Recebe uma string aceita pelo MySQL e retorna um objeto do tipo DateTime.
	 *
	 * @param unknown $date
	 * @return DateTime
	 */
	static function fromDBFormat( $date ){
		$campos = explode('-', $date);
		$retorno = new DateTime();
		$retorno->setDate($campos[0], $campos[1], $campos[2]);
		return $retorno;
	}

    /**
     * Recebe objeto do tipo DateTime e retorna uma string a ser aceita como do tipo DateTime pelo MySQL.
     * @param unknown $date
     */
    static function toDateTimeFormat( $date ) {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Recebe uma string contendo data e hora e retorna um objeto DateTime.
     * @param $date
     */
    static function fromDateTimeFormat( $date ) {
        $dataHora = explode(' ', $date);
        $data = $dataHora[0];
        $hora = $dataHora[1];
        //$date = new DateTime()
    }

	/**
	 * Recebe objeto do tipo DateTime e retorna uma string a ser aceita como do tipo TIME pelo MySQL.
	 * @param unknown $date
	 */
	static function toTimeFormat( $date ){ 
		return $date->format('H:i');
	}
	
	/**
	 * Recebe uma string contendo uma hora, no formato TIME do MySQL, e a retorna como um objeto DateTime.
	 * @param unknown $time
	 */
	static function fromTimeFormat( $time ){
		$date = new DateTime();
		$time = explode(':', $time);
		$date->setTime($time[0], $time[1]);
		return $date;
	}
	
	/**
	 * Recebe um objeto do tipo DateTime e retorna uma string no formato de data brasileiro.
	 *
	 * @param unknown $date
	 */
	static function toBrazilianFormat( $date ){
		return $date->format('d/m/Y');
	}
	
	/**
	 * Recebe uma string no formato de data brasileiro e retorna um objeto do tipo DateTime.
	 *
	 * @param unknown $date
	 * @return DateTime
	 */
	static function fromBrazilianFormat( $date ){
		$campos = explode('/', $date );
		$retorno = new DateTime();
		$retorno->setDate($campos[2], $campos[1], $campos[0]);
		return $retorno;
	}
	
	/**
	 * Verifica se uma data no formao DateTime Ã© vÃ¡lido
	 * @param unknown $value
	 * @param unknown $msg
	 * @return boolean
	 */
	static function checkDate( $value ) {
		if ( checkdate($value->format('m'), $value->format('d'), $value->format('Y')) ) return true;
	}
	
	/**
	 * Retorna true se uma data e hora Ã© vÃ¡lida, de acordo com o formato indicado.
	 * @author	Thiago Delgado Pinto
	 *
	 * @param dateTime	a data ou hora a ser verificada.
	 * @param format	o formato a ser usado para verificaÃ§Ã£o.
	 * @return			true se for vÃ¡lida, false caso contrÃ¡rio.
	 */
	static function valid( DateTime $dateTime, $format = 'Y-m-d H:i:s' ) {
		$dt = DateTime::createFromFormat( $format, $dateTime );
		return $dt && $dt->format( $format ) == $dateTime;
	}
	
	/**
	 * Retorna true se uma data no formato brasileiro Ã© vÃ¡lida.
	 * @author	Thiago Delgado Pinto
	 *
	 * @param date		a data a ser verificada.
	 * @return			true se for vÃ¡lida, false caso contrÃ¡rio.
	 */
	static function validBrazilianDate( DateTime $date ) {
		return self::valid( $date, 'd/m/Y' );
	}	
}
?>