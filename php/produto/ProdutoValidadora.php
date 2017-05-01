<?php

class ProdutoValidadora {
	
	public function validar( Produto $produto ) {
		
		$msg = array();
		
		if(! isset($produto) ) 
			throw new ValidadoraException("Produto não pode ser um objeto nulo");
		
		if( $produto->getId() < 0 ) 
			$msg[] = 'Id do produto deve ser igual ou maior que zero.';
		
		if( $produto->getCodigoBarras() < 0  || strlen($produto->getCodigoBarras()) > 15)  
			$msg[] = 'Código de barras inválido';
		
		if( strlen($produto->getDescricao()) > 1 )
			if( strlen( $produto->getDescricao() ) > 200  )
				$msg[] = 'A descrição deve ter de 5 a 100 caracteres.';
			
		/*$valor = TratamentoUtil::decimalComVirgulaParaPonto($produto->getValor());
		if(! (is_numeric($valor)) || preg_match('/[0-9]{1,10}[\.][0-9]{2}/', $valor ))
			$msg[] = 'Preço deve ser um valor numérico contendo até duas casas decimais.';*/
		
		if( count($msg) > 0 )
			throw new ValidadoraException(implode(PHP_EOL, $msg));
	}
	
}

?>