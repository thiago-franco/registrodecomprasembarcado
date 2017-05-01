<?php

class LoteValidadora { 
	
	private $produtoValidadora;
	
	function __construct( ) {
		$this->produtoValidadora = new ProdutoValidadora();
	}

	public function validar( Lote $lote ) {
		
		$codigo = 0;

		$msg = array();

		if(! isset($lote) )
			throw new ValidadoraException("lote não pode ser um objeto nulo");

		if( $lote->getId() < 0 )
			$msg[] = 'Id do lote deve ser igual ou maior que zero.';
		
		if( $lote->getProduto() !== null ){
			try{
				$this->produtoValidadora->validar( $lote->getProduto() );
			} catch ( ValidadoraException $e ) {
				$msg[] = 'Produto inválido';
			}
		}

		$validade = $lote->getValidade();
		if( $validade !== null ){
			$erros = $validade::getLastErrors();
			if( !DateTimeUtil::checkDate( $validade ) || $erros['warning_count'] > 0  )
				$msg[] = 'Data de validade incorreta.';
			else {
				$dataAtual = new DateTime();
				if( $validade <= $dataAtual ) {
					$msg[] = 'Data de validade vencida';
					$codigo = Validade::VENCIDA;
				}
			}	
		}  
		if( count($msg) > 0 )
			throw new ValidadoraException(implode(PHP_EOL, $msg), $codigo);

	}

}

?>