<?php
//Usar na raiz do servidor

require_once 'tcc/tcc/src/php/comum/BD.php';
require_once 'tcc/tcc/src/php/comum/RepositorioAbstrato.php';
require_once 'tcc/tcc/src/php/comum/ServicoAbstrato.php';
require_once 'tcc/tcc/src/php/compra/Compra.php';
require_once 'tcc/tcc/src/php/compra/CompraValidadora.php';
require_once 'tcc/tcc/src/php/compra/CompraRepositorio.php';
require_once 'tcc/tcc/src/php/compra/CompraServico.php';
require_once 'tcc/tcc/src/php/compra/CompraControladora.php';
require_once 'tcc/tcc/src/php/compra/CompraRequisicao.php';
require_once 'tcc/tcc/src/php/compra/CompraResposta.php';
require_once 'tcc/tcc/src/php/compra/CompraRespostaParaArduino.php';
require_once 'tcc/tcc/src/php/configuracao/ConfiguracaoRepositorio.php';
require_once 'tcc/tcc/src/php/configuracao/ConfiguracaoServico.php';
require_once 'tcc/tcc/src/php/configuracao/ConfiguracaoControladora.php';
require_once 'tcc/tcc/src/php/configuracao/Separador.php';
require_once 'tcc/tcc/src/php/compra/Operacao.php';
require_once 'tcc/tcc/src/php/compra/Validade.php';
require_once 'tcc/tcc/src/php/carrinho/Carrinho.php';
require_once 'tcc/tcc/src/php/carrinho/CarrinhoValidadora.php';
require_once 'tcc/tcc/src/php/carrinho/CarrinhoRepositorio.php';
require_once 'tcc/tcc/src/php/carrinho/CarrinhoServico.php';
require_once 'tcc/tcc/src/php/caixa/Caixa.php';
require_once 'tcc/tcc/src/php/caixa/CaixaValidadora.php';
require_once 'tcc/tcc/src/php/caixa/CaixaRepositorio.php';
require_once 'tcc/tcc/src/php/caixa/CaixaServico.php';
require_once 'tcc/tcc/src/php/item/Item.php';
require_once 'tcc/tcc/src/php/item/ItemValidadora.php';
require_once 'tcc/tcc/src/php/item/ItemRepositorio.php';
require_once 'tcc/tcc/src/php/item/ItemServico.php';
require_once 'tcc/tcc/src/php/log/Log.php';
require_once 'tcc/tcc/src/php/log/LogControladora.php';
require_once 'tcc/tcc/src/php/log/LogValidadora.php';
require_once 'tcc/tcc/src/php/log/LogRepositorio.php';
require_once 'tcc/tcc/src/php/log/LogServico.php';
require_once 'tcc/tcc/src/php/lote/Lote.php';
require_once 'tcc/tcc/src/php/lote/LoteValidadora.php';
require_once 'tcc/tcc/src/php/lote/LoteRepositorio.php';
require_once 'tcc/tcc/src/php/lote/LoteServico.php';
require_once 'tcc/tcc/src/php/produto/Produto.php';
require_once 'tcc/tcc/src/php/produto/ProdutoValidadora.php';
require_once 'tcc/tcc/src/php/produto/ProdutoRepositorio.php';
require_once 'tcc/tcc/src/php/produto/ProdutoServico.php';
require_once 'tcc/tcc/src/php/util/ParametroUtil.php';
require_once 'tcc/tcc/src/php/util/DateTimeUtil.php';
require_once 'tcc/tcc/src/php/util/TratamentoUtil.php';
require_once 'tcc/tcc/src/php/excecao/RepositorioException.php';
require_once 'tcc/tcc/src/php/excecao/ServicoException.php'; 
require_once 'tcc/tcc/src/php/excecao/ControladoraException.php';
require_once 'tcc/tcc/src/php/excecao/ValidadoraException.php';
require_once 'tcc/tcc/src/php/excecao/RequisicaoException.php';

$compra = new CompraControladora();
die( $compra->comprar() );

?>