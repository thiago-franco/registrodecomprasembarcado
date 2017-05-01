<?php

class CompraRepositorio extends RepositorioAbstrato {
	
	protected $tabela = 'compra';
	protected $pdo;
	private $carrinhoRepositorio;
	private $caixaRepositorio;
	private $itemRepositorio;
	
	function __construct( $pdo ) {
		if(! isset( $pdo ) ) throw new InvalidArgumentException("Instância de objeto PDO inválida.");
		$this->pdo = $pdo;
		$this->carrinhoRepositorio = new CarrinhoRepositorio( $this->pdo );
		$this->caixaRepositorio = new CaixaRepositorio( $this->pdo );
		$this->itemRepositorio = new ItemRepositorio( $this->pdo );
	}
	
	function linhaParaObjeto( $linha, $completo = true ) {
		$carrinho = new Carrinho();
        $caixa = new Caixa();
        $itens = array();
        if( isset( $linha['carrinho_id'] ) )
            $carrinho = $this->carrinhoRepositorio->comId( $linha['carrinho_id'] );
		if( $completo ) {
            if( isset( $linha['caixa_id'] ) )
                $caixa = $this->caixaRepositorio->comId( $linha['caixa_id'] );
            $itens = $this->itemRepositorio->todos(0, 0, array(), array('compra_id' => $linha['id'] ) );
        }
		return new Compra( $linha['id'], $carrinho, $caixa, $itens, TratamentoUtil::decimalComPontoParaVirgula($linha['total']) );
	}

    /**
     * Retorna array contendo todas as compras do sistema. Os objetos de compra retornados são simplificados, não contendo objetos de caixas ou itens.
     * @return array
     */
    function buscarComprasSimples() {
        $busca = 'SELECT * FROM  compra';
        $compras = array();
        $ps = $this->executar( $busca, array() );
        foreach ( $ps as $linha )
            $compras[] = $this->linhaParaObjeto( $linha, false );
        return $compras;
    }
	
	function adicionar( $obj ) {
		if( $this->existe( $obj ) )
			throw new RepositorioException( "Compra com mesmo id já existente no banco de dados." );
		$comando  = "INSERT INTO $this->tabela ( carrinho_id ) VALUES ( :carrinho_id )";
		$valores = array( 'carrinho_id' => $obj->getCarrinho()->getId() );
		if( $this->executar( $comando, $valores )->rowCount() < 1 )
			throw new RepositorioException( "Adição de compra ao banco mal sucessedida." );
		$obj->setId( $this->pdo->lastInsertId() );
		return $obj;
	}
	
	function atualizarCaixa( $obj ) {
		$comando = "UPDATE $this->tabela SET caixa_id = :caixa_id WHERE id = :id";
		$valores = array( 'caixa_id' => $obj->getCaixa()->getId(), 'id' => $obj->getId() );
		$this->executar( $comando, $valores );
	}

	function adicionarItem( $compra, $item ) {
		$objs = $this->itemRepositorio->buscarObjetos( "SELECT * FROM item WHERE id = :id AND (compra_id != null OR compra_id != 0)", array('id' => $item->getId()) );
		if( count( $objs ) > 0 )
			throw new RepositorioException("Item já adicionado a outra compra");
		$this->itemRepositorio->setCompraId( $compra->getId() );
		$this->itemRepositorio->atualizarCompraId( $item );
	}
	
	function removerItem( $item ) {
		$this->itemRepositorio->setCompraId( null );
		$this->itemRepositorio->atualizarCompraId( $item );
	}
	
	function checarItem( $compra, $item ) {
		$retorno = $this->itemRepositorio->todos( 0, 0, array(), array( 'compra_id' => $compra->getId(), 'uid' => $item->getUid() ), true ); 
		if( count( $retorno ) > 0 )
			return true;
		return false;
	}

    function contarItens( $compra ) {
        $itens = $this->itemRepositorio->todos( 0, 0, array(), array( 'compra_id' => $compra->getId()), true );
        return count($itens);
    }
	
}

?>