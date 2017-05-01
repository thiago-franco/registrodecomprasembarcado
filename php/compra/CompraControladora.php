<?php

class CompraControladora {
	
	private $pdo;
	private $compraServico;
	private $carrinhoServico;
	private $caixaServico;
	private $itemServico;
	private $compraRequisicao;
    private $logServico;
	
	function __construct( ) {
		$this->pdo = BD::pdo();
		$compraRepositorio = new CompraRepositorio( $this->pdo );
		$compraValidadora = new CompraValidadora( );
		$this->compraServico = new CompraServico( $compraValidadora, $compraRepositorio );
		$carrinhoRepositorio = new CarrinhoRepositorio( $this->pdo );
		$carrinhoValidadora = new CarrinhoValidadora( );
		$this->carrinhoServico = new CarrinhoServico( $carrinhoValidadora, $carrinhoRepositorio );
		$caixaRepositorio = new CaixaRepositorio( $this->pdo );
		$caixaValidadora = new CaixaValidadora( );
		$this->caixaServico = new CaixaServico( $caixaValidadora, $caixaRepositorio );
		$itemRepositorio = new ItemRepositorio( $this->pdo );
		$itemValidadora = new ItemValidadora( );
		$this->itemServico = new ItemServico( $itemValidadora, $itemRepositorio );
		$this->compraRequisicao = new CompraRequisicao( $this->carrinhoServico, $this->caixaServico, $this->itemServico, $this->compraServico );
        $logRepositorio = new LogRepositorio( $this->pdo );
        $logValidadora = new LogValidadora( );
        $this->logServico = new LogServico( $logValidadora, $logRepositorio );
	}
	
	/**
	 * Checa se a compra recebida por parâmetro já foi cadastrada no banco.
	 * @param Compra $compra
	 * @return boolean
	 */
	function compraIniciada( $compra ) { 
	if( $this->compraServico->comCarrinhoId($compra->getCarrinho()->getId()) !== null )
			return true;
		return false;
	}
	
	/**
	 * Cria uma nova entrada no banco para a compra recebida por parâmetro.
	 * @param Compra $compra
	 * @return Compra
	 */
	function iniciarCompra( &$compra ) {
        $this->compraServico->salvar( $compra );
	}
	
	/**
	 * Remove a entrada no banco referente à compra recebida por parâmetro.
	 * @param Compra $compra
	 */
	function finalizarCompra( $compra ) {
        if( $compra == null || $compra->getId() == null )
            throw new InvalidArgumentException("Instância de compra inválida");
        $this->compraServico->remover( $compra->getId() );
	}
	
	/**
	 * Associa um item a uma compra no banco.
	 * @param Compra $compra
	 */
	function incluirItem( $compra ) {
        $this->compraServico->adicionarItens( $compra );
	}
	
	/**
	 * Remove a associação do item recebido por parâmetro a sua respectiva compra no banco.
	 * @param Item $item
	 */
	function excluirItem( $compra ) {
        $this->compraServico->removerItens( $compra );
	}

	/**
	 * Faz a movimentação entre o item e a compra recebidos por parâmetro. Caso a associação entre ambos ainda não exista, é criada, do contrário, é removida.
	 * @param Compra $compra
	 * @param Item $item
	 * @throws ControladoraException
	 * @return string 
	 */
    function movimentarItem( $compra, $item ) {
        if( $compra == null || $item == null )
            throw new InvalidArgumentException("Instâncias de compra ou item inválidas");
        if(! $this->compraServico->checarItem( $compra, $item ) ) {
            try {
                $this->incluirItem( $compra );
            }
            catch ( ServicoException $e  ) {
                if( $e->getCode() == Validade::VENCIDA ) {
                    return CompraRespostaParaArduino::validadeVencida( $compra );
                }
                throw new ControladoraException( "Erro em movimentação de item: ". $e->getMessage() );
            }
            $compra = $this->compraServico->comCarrinhoId( $compra->getCarrinho()->getId() );
            $compra->setItens( array($item) );
            return CompraRespostaParaArduino::adicao( $compra );
        } else {
            $this->excluirItem( $compra );
            $compra = $this->compraServico->comCarrinhoId( $compra->getCarrinho()->getId() );
            if( count($compra->getItens()) == 0 ) {
                $this->finalizarCompra( $compra );
            }
            $compra->setItens( array($item) );
            return CompraRespostaParaArduino::remocao( $compra );
        }
    }

    function processarCompra( $compra ) { 
        $pagina = CompraRequisicao::pagina();
        $this->compraServico->atualizarCaixa( $compra );
        $pagina = ($this->compraServico->contarItens($compra)/2) <= $pagina+1 ? -1 : $pagina+2;//$pagina+2 no retorno pois arduino inicia contagem de paginação em 1 e o sistema em 0.
        $retorno = CompraRespostaParaArduino::retornarCodigoBarras( $compra, $pagina );
        if( $pagina == -1 )
            $this->finalizarCompra( $compra );
        return $retorno;
    }
	
	/**
	 * Efetua o ciclo de operações inerentes à compra.
	 * @return string
	 */
	function comprar() {
		try{
            $compra = $this->compraRequisicao->montarCompra();
            $caixaExiste = ($compra->getCaixa() != null && $compra->getCaixa()->getId() != 0);
            $carrinoExiste = ($compra->getCarrinho() != null && $compra->getCarrinho()->getIr() != null);
			if( $caixaExiste && $carrinoExiste ) {
                return $this->processarCompra( $compra );
            } else if( $caixaExiste && (!$carrinoExiste) ) {
                return CompraRespostaParaArduino::erro( 'caixa' );
            }
        } catch(Exception $e) {
            if( isset($compra)) {
                $compraId = $compra->getId();
                $caixa = $compra->getCaixa()->getNome();
                $carrinho = $compra->getCarrinho()->getNome();
                $evento = "Erro ocorreu durante processamento de itens em caixa.*compra: $compraId, caixa: $caixa, carrinho: $carrinho";
                $this->logServico->criarLog($evento);
            }
            return CompraRespostaParaArduino::erro('caixa');
        }
        try {
            $compra = $this->compraRequisicao->montarCompra();
            //provisório
            $acao = CompraRequisicao::acao();
            if( $acao == 'totalcompra'){ 
            	return CompraRespostaParaArduino::retornarTotalCompra( $compra );
            }
            //provisório
			if(! $this->compraIniciada( $compra ) )
				$this->iniciarCompra( $compra );
			$itens = $compra->getItens();
			foreach ( $itens as $item )
				return $this->movimentarItem( $compra, $item );
		} catch ( Exception $e ) {
            $compraId = $compra->getId();
            $carrinho = $compra->getCarrinho()->getNome();
            $item = CompraRequisicao::uid();
			if( $e->getCode() == Validade::VENCIDA) {
                $evento = "Item com prazo de validade vencido foi encontrado.*compra: $compraId, carrinho: $carrinho, UID do item: $item";
                $this->logServico->criarLog($evento);
                return CompraRespostaParaArduino::validadeVencida( $compra );
            }
            $evento = "Erro durante movimentação de item.*compra: $compraId, carrinho: $carrinho, UID do item: $item";
            $this->logServico->criarLog($evento);
			return CompraRespostaParaArduino::erro('carrinho');
		}
	}

	function compras() {
		$limit = 0;
		$offset = 0;
		$ordenacao = array();
		$filtros = array();
		$total = $this->compraServico->contar();
		$linhasAExibir = $total;
		if( DataTablesUtil::hasLimit() &&  DataTablesUtil::hasOffset() ) {
			$limit = DataTablesUtil::limit();
			$offset = DataTablesUtil::offset();
		}
		switch ( ParamUtil::request( 'iSortCol_0' ) ) {
			case 0: $ordenacao['id'] = ParamUtil::request( 'sSortDir_0' ); break;
			case 1: $ordenacao['carrinho_id'] = ParamUtil::request( 'sSortDir_0' ); break;
			case 2: $ordenacao['total'] = ParamUtil::request( 'sSortDir_0' ); break;

		}
        if( ParamUtil::post('id') !== null )
            $filtros['id'] = ParamUtil::post('id');
		$compras = $this->compraServico->repositorio()->todos( $limit, $offset, $ordenacao, $filtros );
		return $compras;
	}

    function comprasSimplificadas() {
        return $this->compraServico->comprasSimplificadas();
    }
    
    function compraCompleta() {
    	$compra = current( $this->compras() );
    	$itens = $compra->getItens();
    	foreach ( $itens as $item ) {
    		$lote = $item->getLote();
    		$validade = $lote->getValidade();
    		$lote->setValidade( DateTimeUtil::toBrazilianFormat($validade) );
    	}
    	return $compra;
    }

    /**
     * Retorna a quantidade de carrinhos associados a uma compra e a quantidade total de carrinhos.
     * @return multitype:unknown
     */
    function contarCarrinhos() {
        $carrinhosAtivos =  $this->compraServico->contar();
        $total = $this->carrinhoServico->contar();
        return array( 'ativos' => $carrinhosAtivos, 'total' => $total );
    }
	
}

?>