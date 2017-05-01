<?php

/**
 * TODO métodos de adição e remoção.
 * Class ConfiguracaoRepositorio
 */
class ConfiguracaoRepositorio extends RepositorioAbstrato {

    protected $tabela = 'configuracao';
    protected $pdo;

    function __construct( $pdo ) {
        if(! isset( $pdo ) ) throw new InvalidArgumentException( "Instância de objeto PDO inválida." );
        $this->pdo = $pdo;
    }

    function atualizarSeparador( $separador ) {
        switch ($separador) {
            case 'ENTER': $separador = Separador::ENTER; break;
            case 'ENTERENTER': $separador = Separador::ENTERENTER; break;
            case 'TAB': $separador = Separador::TAB; break;
            case 'ESC': $separador = Separador::ESC; break;
        }
        if( !in_array($separador, Separador::valores()))
            throw new RepositorioException('Impossível atualizar configuracao no banco. Separador inválido.');
        $comando = '';
        $adicionar = "INSERT INTO $this->tabela ( separador ) VALUES( :separador )";
        $atualizar = "UPDATE $this->tabela SET separador = :separador WHERE 1";
        $this->contarLinhas() == 0 ? $comando = $adicionar : $comando = $atualizar;
        $valores = array( 'separador' => $separador );
        if( $this->executar( $comando, $valores )->rowCount() < 1 )
            throw new RepositorioException( "Atualização de configuracões no banco mal sucessedida." );
    }

    function obterSeparador() {
        $comando = "SELECT separador FROM $this->tabela WHERE 1";
        $ps = $this->executar($comando, array());
        $separador = '';
        foreach( $ps as $linha )
            $separador = $linha['separador'];
        if( !in_array($separador, Separador::valores()))
            throw new RepositorioException('Separador inválido.');
        switch ($separador) {
            case Separador::ENTER: $separador = 'ENTER'; break;
            case Separador::ENTERENTER: $separador = 'ENTERENTER'; break;
            case Separador::TAB: $separador = 'TAB'; break;
            case Separador::ESC: $separador = 'ESC'; break;
        }
        return $separador;
    }

}

?>