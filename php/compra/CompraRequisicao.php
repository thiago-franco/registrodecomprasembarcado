<?php

class CompraRequisicao { 
	
	private $carrinhoServico;
	private $caixaServico;
	private $itemServico;
	private $compraServico;
	
	function __construct( $carrinhoServico, $caixaServico, $itemServico, $compraServico ) {
		if( !isset( $carrinhoServico ) || !isset($caixaServico) || !isset($itemServico) || !isset($compraServico) )
			throw new InvalidArgumentException( "Parâmetros para construção de classe de comunicação de compra inválidos" );
		$this->carrinhoServico = $carrinhoServico;
		$this->caixaServico = $caixaServico; 
		$this->itemServico = $itemServico;
		$this->compraServico = $compraServico;
	}

    static function pagina() {
        $pagina = ParametroUtil::get('pagina')-2; //Diminuindo 2 pois arduino inicia contagem de paginação em 1 e o sistema em -1.
        if( is_numeric($pagina) ) {
            return $pagina;
        }
        throw new RequisicaoException( 'Requisicao com parâmetro "pagina" inválido.' );
    }

    static function uid() {
        $uid = ParametroUtil::get('UID');
        return( $uid );
    }
    
    static function acao(){
    	$acao = ParametroUtil::get('acao');
    	return $acao;
    }

	private function carrinho() {
		$carrinho = new Carrinho();
		if( ParametroUtil::get('carrinho') != null ) {
			$numeroSerie = ParametroUtil::get('carrinho');
			$c = $this->carrinhoServico->comNumeroSerie( $numeroSerie ); 
			if( $c != null )
				$carrinho = $c;
            return $carrinho;
		} else if( ParametroUtil::get('IR') !== null ) {
			$ir = ParametroUtil::get('IR');
			$c = $this->carrinhoServico->comIr( $ir );
			if( $c != null )
				$carrinho = $c;
            return $carrinho;
		}
        throw new RequisicaoException( 'Requisicao com parâmetro "carrinho" ou "IR" inválido.' );
	}
	
	private function item() {
		$item = new Item();
		if( ParametroUtil::get('UID') !== null ) {
			$uid = ParametroUtil::get('UID');
			$i = $this->itemServico->comUid( $uid );
			if( $i != null ) {
                $item = $i; 
                $valor = $item->getLote()->getProduto()->getValor();
                $item->getLote()->getProduto()->setValor(TratamentoUtil::decimalComVirgulaParaPonto($valor));
            }
		} 
		return $item;
	}

    private function itens( $compra ) {
        $itens = array();
        $limit = 2;
        $offset = 2*self::pagina();
        if( self::pagina() !== -1 ) //Caso $pagina = -1, ou seja, para a 1ª solicitação do caixa, ainda não devem ser enviados códigos de barra.
            $itens = $this->itemServico->repositorio()->todos($limit, $offset, array(), array('compra_id' => $compra->getId()));
        return $itens;
    }
	
	private function caixa() {
		$caixa = new Caixa();
		if( ParametroUtil::get('caixa') !== null ) {
			$id = ParametroUtil::get('caixa');
            if( is_numeric($id) ) {
                $c = $this->caixaServico->comId( $id );
                if ( $c != null )
                    $caixa = $c;
                else throw new RequisicaoException( 'Requisicao com parâmetro "caixa" inválido.' );
            } else throw new RequisicaoException( 'Requisicao com parâmetro "caixa" inválido.' );
		} 
		return $caixa;
	}
	
	function montarCompra() { 
		$carrinho = $this->carrinho();
		$item = $this->item();
        $itens = array();
		$caixa = $this->caixa();
		$compra = $this->compraServico->comCarrinhoId( $carrinho->getId() );
		if( $compra !== null) {
            $compra->setCaixa($caixa);
            if( $caixa->getId() != 0 ) {
                $itens = $this->itens($compra);
            } else {
                array_push( $itens, $item );
            }
            $compra->setItens($itens);
			return $compra;
		}
        array_push( $itens, $item );
		return new Compra( 0, $carrinho, $caixa, $itens );
	} 
	
}

?>