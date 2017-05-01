<?php

/**
 * Possíveis configurações de separadores utilizados no retorno de códigos de barras para o Arduino.
 * @author Thiago Franco
 */
class Separador {

    const ENTER = 'en';
    const ENTERENTER = 'ee';
    const TAB = 'ta';
    const ESC = 'es';

    static function valores() {
        return array(
            self::ENTER,
        	self::ENTERENTER,
            self::TAB,
            self::ESC
        );
    }


}

?>