<?php

class LogRepositorio extends RepositorioAbstrato {

    protected $tabela = 'log';
    protected $pdo;

    function __construct( $pdo ) {
        if(! isset( $pdo ) ) throw new InvalidArgumentException("Instância de objeto PDO inválida.");
            $this->pdo = $pdo;
    }

    function linhaParaObjeto( $linha ) {
        //$data = DateTimeUtil::( $linha['data'] );
        return new Log( $linha['id'], $linha['evento'], $linha['data'], $linha['situacao'] );
    }

    function adicionar( $obj ) {
        if( $this->existe( $obj ) )
            throw new RepositorioException( "Log com mesmo id já existente no banco de dados.");
        $comando  = 'INSERT INTO '.$this->tabela.'( evento, data, situacao ) VALUES ( :evento, :data, :situacao )';
        $valores = array('evento' => $obj->getEvento(), 'data' => DateTimeUtil::toDateTimeFormat( $obj->getData() ), 'situacao' => $obj->getSituacao() );
        if( $this->executar( $comando, $valores )->rowCount() < 1 )
            throw new RepositorioException( "Adição de log ao banco mal sucessedida." );
        $obj->setId( $this->pdo->lastInsertId() );
        return $obj;
    }

    function atualizar( $obj ) {
        $comando = 'UPDATE '.$this->tabela.' SET situacao = :situacao WHERE id = :id';
        $valores = array( 'situacao' => $obj->getSituacao(), 'id' => $obj->getId() );
        if( $this->executar( $comando, $valores )->rowCount() < 1 )
            throw new RepositorioException( "Atualização de log no banco mal sucessedida." );
    }

}

?>