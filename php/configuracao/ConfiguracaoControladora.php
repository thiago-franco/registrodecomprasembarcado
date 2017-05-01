<?php

class ConfiguracaoControladora {

    private $pdo;
    private $configuracaoServico;

    function __construct() {
        $this->pdo = BD::pdo();
        $configuracaoRepositorio = new ConfiguracaoRepositorio($this->pdo);
        $this->configuracaoServico = new ConfiguracaoServico($configuracaoRepositorio);
    }

    function separador() {
        $separador = ParametroUtil::request('separador');
        if( isset($separador) ) {
            $this->configuracaoServico->configurarSeparador($separador);
        } else {
            $separador = $this->configuracaoServico->obterSeparador();
            return $separador;
        }
    }

}

?>