<?php

interface CompraResposta {
	
	static function adicao( Compra $compra );
	
	static function remocao( Compra $compra );
	
	static function validadeVencida( Compra $compra );
	
	static function erro( $obs );
	
}

?>