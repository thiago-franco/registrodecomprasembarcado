<?php

class LogControladora {

    private $pdo;
    private $logServico;

    function __construct( ) {
        $this->pdo = BD::pdo();
        $logRepositorio = new LogRepositorio( $this->pdo );
        $logValidadora = new LogValidadora( );
        $this->logServico = new LogServico( $logValidadora, $logRepositorio );
    }

    function alterarSituacaoDeLog() {
        $logId = ParametroUtil::request('logId');
        $log = $this->logServico->comId($logId);
        $log->setSituacao('old');
        $this->logServico->salvar($log);
    }

    function logs() {
        $limit = 0;
        $offset = 0;
        $ordenacao = array('situacao'=>'asc', 'data'=> 'desc');
        $filtros = array();
        $situacao = ParametroUtil::request('situacao');
        if( isset($situacao)) {
            $filtros['situacao'] = $situacao;
        }
        $logs = $this->logServico->repositorio()->todos( $limit, $offset, $ordenacao, $filtros );
        //foreach ( $log as $l ){
            //$log->setData( DateTimeUtil::toBrazilianFormat( $log->getData() ) );
        //}
        return $logs;
    }

}

?>