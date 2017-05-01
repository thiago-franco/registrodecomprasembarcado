<?php

class Item {
	
	private $id = 0;
	private $uid = 0;
	private $lote = null;	
	
	public function __construct( $id = 0, $uid = 0, $lote = null ){
		$this->id = $id;
		$this->uid = $uid;
		$this->lote = $lote;
	}
	
	public function getId(){ return $this->id; }
	public function setId($id){ $this->id = $id; }
	
	public function getUid(){ 	return $this->uid; }
	public function setUid($uid){ $this->uid = $uid; }

	public function getLote(){ return $this->lote; }
	public function setLote($lote){ $this->lote = $lote; }
	
}

?>