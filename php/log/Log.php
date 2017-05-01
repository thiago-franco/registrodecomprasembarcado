<?php

class Log {

    private $id = 0;
    private $evento = '';
    private $data = null;
    private $situacao = '';

    function __construct( $id = 0, $evento = '', $data = null, $situacao = '' ) {
        $this->id = $id;
        $this->evento = $evento;
        $this->data = $data;
        $this->situacao = $situacao;
    }

    public function setData($data)  { $this->data = $data; }
    public function getData() { return $this->data; }

    public function setEvento($evento) { $this->evento = $evento; }
    public function getEvento() { return $this->evento; }

    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    public function setSituacao($situacao) { $this->situacao = $situacao; }
    public function getSituacao() { return $this->situacao; }

}

?>