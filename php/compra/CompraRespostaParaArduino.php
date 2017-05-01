<?php

/**
 * Classe responsável por preparar as respostas do servidor e adequa-las ao formato esperado pelos receptores microcontrolados (carrinho-protótipo e caixa-protótipo).
 * Respostas direcionadas ao carrinho-protótipo devem atender ao formato: 
 * '"DESCRIÇÃO DO PRODUTO","R$: VALOR DO PRODUTO","Val: VALIDADE DO PRODUTO", "VENCIDO OU NÃO", "R$: TOTAL DA COMPRA","CÓDIGO INDICATIVO DE OPERAÇÃO"'
 * Respostas direcionadas ao caixa-protótipo devem atender ao formato:
 * '"PRÓXIMA PÁGINA", "SEPARADOR", "QUANTIDADE DE CÓDIGOS", "CÓDIGO 1", "CÓDIGO 2"'
 * @author Thiago Franco
 */
class CompraRespostaParaArduino implements CompraResposta {

    /**
     *
     * @return String
     */
    private static function separador() {
        $configuracao = new ConfiguracaoControladora();
        $separador = $configuracao->separador();
        return $separador;
        }
	
	/**
	 * Resposta para a operação de adição de item.
	 * @param Compra $compra
	 * @return string
	 */
	static function adicao( Compra $compra ) {
		$item = current( $compra->getItens() ); 
		return '"'.TratamentoUtil::removeAcento( $item->getLote()->getProduto()->getDescricao() )
              .'","R$:'.$item->getLote()->getProduto()->getValor()
              .'","Val: '.DateTimeUtil::toBrazilianFormat($item->getLote()->getValidade())
              .'","'.Validade::VALIDA
              .'","R$:'.$compra->getTotal()
              .'","'.Operacao::ADICAO.'"';
    }
	
	/**
	 * Resposta para validade vencida.
	 * @param Compra $compra
	 * @return string
	 */
	static function validadeVencida( Compra $compra ) {
		return '" "," "," ","'.Validade::VENCIDA.'","R$: '.$compra->getTotal().'","'.Operacao::ADICAO.'"';
	}
	
	/**
	 * Resposta para operação de remoção de item.
	 * @param Compra $compra
	 * @return string
	 */
	static function remocao( Compra $compra ) {
		$item = current( $compra->getItens() );
		return '"'.TratamentoUtil::removeAcento( $item->getLote()->getProduto()->getDescricao() )
              .'"," "," ","'
              .Validade::VALIDA
              .'","R$:'.$compra->getTotal()
              .'","'.Operacao::REMOCAO.'"';
	}

    /**
     * Retorna para o caixa-protótipo os códigos de barra de cada item da compra recebida. Seu retorno deve atender ao formato:
     * "proxima página", "separador", "quantidade de códigos", "código 1", "código 2"
     * @param $compra
     * @param $pagina Auxiliar de paginação. Valores de 0 em diante representam páginas válidas, -1 representa última página e -2 representa erro.
     *                Caso seu valor for -1, [proxima página] deve valer 0, e caso for -2, [proxima página] deve valer -1
     * @return string
     */
    static function retornarCodigoBarras( $compra, $pagina ) {
		$codigosBarras = array();
        $qtdCodigos = 0;
        $stringCodigoBarras = '"';
		$itens = $compra->getItens();
		foreach ( $itens as $item ) {
            if( $item->getLote() != null ) {
                $codigoBarras = $item->getLote()->getProduto()->getCodigoBarras();
                array_push( $codigosBarras, $codigoBarras );
                $stringCodigoBarras .= ', "'.$codigoBarras.'"';
                $qtdCodigos++;
            }
		}
        $proximaPagina = $qtdCodigos > 0 ? $pagina == -1 ? 0 : ++$pagina : -1;
        $resposta = '';
        if( $qtdCodigos == 0 )
            $resposta =  '"2", "'.self::separador().'", "'.$qtdCodigos.'"';
        else
            $resposta = '"'.$proximaPagina.'", "'.self::separador().'", "'.$qtdCodigos.$stringCodigoBarras;
		return $resposta;
    }
    
    static function retornarTotalCompra( $compra ) {
    	$totalCompra = $compra->getTotal();
    	
    	if( $totalCompra == '0.00' ) {
    		$totalCompra = '0,00'; 
    	}
    	return '" ", " ", " ", " ", "R$:'.$totalCompra.'", "0"';
    }

    /**
     * Resposta para carrinho-protótipo indicando erro.
     * @return string
     */
    private static function erroParaCarrinho() {
        return '" ", " ", " ", " ", " ", "'.Operacao::ERRO.'"';
    }

    /**
     * Resposta para caixa-protótipo indicando erro.
     * @return string
     */
    private static function erroParaCaixa() {
        return '"-1", "'.self::separador().'", "0"';
    }

    /**
     * Resposta indicando erro
     * @param $obs Parâmetro que indica quem espera pela resposta: um caixa-protótipo ( $obs = 'caixa' ) ou um carrinho-protÃ³tipo ( $obs = 'carrinho' ).
     * @return string
     */
    static function erro( $obs ) {
        if( $obs == 'carrinho')
            return self::erroParaCarrinho();
        if( $obs == 'caixa' )
            return self::erroParaCaixa();
    }

}

?>