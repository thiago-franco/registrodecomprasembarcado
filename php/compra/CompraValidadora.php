<?php

class CompraValidadora {
	
	private $carrinhoValidadora;
	private $caixaValidadora;
	private $itemValidadora;
	
	function __construct( ) {
		$this->carrinhoValidadora = new CarrinhoValidadora();
		$this->caixaValidadora = new CaixaValidadora();
		$this->itemValidadora = new ItemValidadora(); 
	}
	
	function validar( Compra $compra ) { 
		
		$codigo = 0;
	
		$msg = array();
	
		if(! isset( $compra ) )
			throw new ValidadoraException("Compra não deve ser um objeto nulo");
	
		if( $compra->getId( ) < 0 )
			$msg[] = "Id de compra deve ser um numero positivo";
		
		if( $compra->getCarrinho() !== null ) {
			try{
				$this->carrinhoValidadora->validar( $compra->getCarrinho() );
			} catch ( ValidadoraException $e ) {
				$msg[] = 'Carrinho inválido';
			}
		}
			
		if( $compra->getCaixa() !== null ) {
			try{
				$this->caixaValidadora->validar( $compra->getCaixa() );
			} catch ( ValidadoraException $e ) {
				$msg[] = 'Caixa inválido';
			}
		}
		
		if( $compra->getItens() !== null )
			foreach ( $compra->getItens() as $item ) {
				if($item !== null) {
					try{
						$this->itemValidadora->validar( $item );
					} catch ( ValidadoraExcpetion $e ) {
						$codigo = $e->getCode();
						$msg[] = 'Item inválido'; 
					}
				}
			}
	
		/*$total = TratamentoUtil::decimalComVirgulaParaPonto($compra->getTotal());
		if( $total !== null)
			if (! (is_numeric ( $total ) || preg_match ( "/^[0-9]{1,10}(\.)?[0-9]*$/", $total ) ) )
				$msg [] = 'Valor de compra deve conter até 10 dígitos e 2 casas decimais';*/
	
		if( count($msg) > 0 )
			throw new ValidadoraException(implode(PHP_EOL, $msg), $codigo);
	
	}
}

?>