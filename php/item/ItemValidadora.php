<?php

class ItemValidadora {
	
	private $loteValidadora;
	
	function __construct( ) {
		$this->loteValidadora = new LoteValidadora();
	}

	public function validar( Item $item ) {
		
		$codigo = 0;

		$msg = array();

		if(! isset($item) )
			throw new ValidadoraException("Item não pode ser um objeto nulo");

		if( $item->getId() < 0 )
			$msg[] = 'Id do item deve ser igual ou maior que zero.';
		
		if( $item->getUid() < 0 )
			$msg[] = 'Uid do item deve ser igual ou maior que zero.';;
		
		if( $item->getLote() !== null ) {
			try{ 
				$this->loteValidadora->validar( $item->getLote() );
			} catch ( ValidadoraException $e ) {
				$codigo = $e->getCode();
				$msg[] = 'Lote inválido';
			}		
		}
		
		if( count($msg) > 0 )
			throw new ValidadoraException(implode(PHP_EOL, $msg), $codigo);

	}

}

?>