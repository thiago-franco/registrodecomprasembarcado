<?php

class LogServico extends ServicoAbstrato {

    protected  $repositorio;
    protected  $validadora;

    function __construct( LogValidadora $validadora, LogRepositorio $repositorio ) {
        if ( ! isset( $validadora ) ) throw new InvalidArgumentException( 'Validadora inválida.' );
        if ( ! isset( $repositorio ) ) throw new InvalidArgumentException( 'Repositório inválido.' );
        $this->validadora = $validadora;
        $this->repositorio = $repositorio;
    }

    function criarLog( $evento ) {
        $data = new DateTime();
        $data->setTimezone( new DateTimeZone('America/Sao_Paulo') );
        $log = new Log( 0, $evento, $data, 'new' ); 
        $this->salvar($log);
    }

}

?>