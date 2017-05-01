<?php

class ConfiguracaoServico extends ServicoAbstrato {

    protected $repositorio;

    function __construct( ConfiguracaoRepositorio $repositorio ) {
        if ( ! isset( $repositorio ) ) throw new InvalidArgumentException( 'Repositório inválido.' );
        $this->repositorio = $repositorio;
    }

    function configurarSeparador( $separador ) {
        $this->repositorio->atualizarSeparador($separador);
    }

    function obterSeparador() {
        return $this->repositorio->obterSeparador();
    }


}

?>