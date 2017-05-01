function lote() {
	
	//Configuração do dataTable
	var requisicao = 'php/invoker.php?_c=LoteControladora&_m=lotes&_raw=a';
	var colunas = [	{ "mData": "id" }, { "mData": "nome" }, { "mData": "produto.descricao" }, { "mData": "validade" } ];
	var tabela = carregarDataTable( '#tabela-lotes', requisicao, colunas );
	tableTools = TableTools.fnGetInstance('tabela-lotes');
	
	//Validação
	$('#adicionar-lote').validate({
		rules: {
			produto: { required: true },
			validade: { required: true, expreg: "^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/[12][0-9]{3}$" }
		},
		messages: {
			produto: { required: 'Selecione um produto! ' },
			validade: { required: 'O campo validade deve ser preenchido', expreg: 'Informe uma data válida!' }
		}
	});
	
	//Configurando campo select "produto"
	function preparaSelect(identificador) {
		var	dados = { _c: 'ProdutoControladora', _m: 'produtos'  };	
		var acao = function( resposta ) {
			if( resposta.success ) {
				var produtos = 	resposta.data.aaData;
				for( var i = 0; i < produtos.length; i++ ) {
					$(identificador).append( new Option( produtos[i].descricao, produtos[i].id ) );	 
				}
				var opcoes = { no_results_text: 'Nenhum produto encontrado para a busca:', width: '100%' };
				$(identificador).chosen( opcoes );
			}
		};
    	$.post('php/invoker.php', dados, acao, 'json');
	}

	preparaSelect('#produto');
	
	$('#validade').mask('99/99/9999');
	
	//Adicionar	
	var retorno = function( resposta ) {
		var mensagem = 'Lote salvo com sucesso.';
		alerta( resposta, mensagem );
		if( resposta.success ) {
			$('nome').val('');
			$('#validade').val('');			
		}
		$('nome').focus();
		tabela.fnDraw();
	};
    $('#adicionar-confirma').click( function() {
		if($('#adicionar-lote').valid()) {
			var nome = $('#nome').val();
			var produto = $('#produto').val();
			var validade = $('#validade').val();
			var	dados = { _c: 'LoteControladora', _m: 'salvar', nome: nome, produto: produto, validade: validade };
			$.post('php/invoker.php', dados, retorno, 'json');
		}
	});

    //Alterar
	function alterar() {
		lote = tableTools.fnGetSelectedData();
        if( lote.length == 1 ) { 
            lote = lote[0];
            var valorNome = lote.nome;
			var valorValidade = lote.validade;
            var valorProduto = lote.produto.id;
			var campoNome = '<div class="col-lg-2 form-alerta"><label>Nome</label><input id="alterar-nome" name="alterar-nome" type="text" class="form-control"></div>';
            var campoValidade = '<div class="col-lg-2 form-alerta"><label>Vaidade</label><input id="alterar-validade" name="alterar-validade" type="text" class="form-control"></div>';
            var campoProduto = '<div class="col-lg-8 form-alerta"><label>Produto</label><select id="alterar-produto" name="alterar-produto" class="form-control" data-placeholder="selecione um lote..."><option></option></select></div>';
            var campos = campoNome+campoProduto+campoValidade;
            var validacao =	{
                rules: {
                    'alterar-produto': { required: true },
                    'alterar-validade': { required: true, expreg: "^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/[12][0-9]{3}$" }
                },
                messages: {
                    'alterar-produto': { required: 'Selecione um produto! ' },
                    'alterar-validade': { required: 'O campo validade deve ser preenchido', expreg: 'Informe uma data válida!' }
                }
            };
            var preencherCampos = function() {
				$('#alterar-nome').val(valorNome);
                $('#alterar-validade').mask('99/99/9999');
                $('#alterar-validade').val(valorValidade);
                preparaSelect('#alterar-produto');
				setTimeout( function() {
					$('#alterar-produto').val(valorProduto).trigger('chosen:updated');
				}, 200);
                
            };
            var efetuarAlteracao = function() {
                var retorno = function( resposta ) {
                    var mensagem = 'Alteração efetuada com sucesso.';
                    alerta( resposta, mensagem );
                    tabela.fnDraw();
                }
                var dados  = {
                    _c: 'LoteControladora',
                    _m: 'salvar',
                    id: lote.id,
					nome: $('#alterar-nome').val(),
                    produto: $('#alterar-produto').val(),
                    validade: $('#alterar-validade').val()
                };
                $.post('php/invoker.php', dados, retorno, 'json');
            };
            alertaAlteracao( campos, validacao, preencherCampos, efetuarAlteracao );
        }
	}
	$('#alterar').click(function() {
		alterar();
	})

    //Remover
	function excluir() {
		lotes = tableTools.fnGetSelectedData();
		var efetuarExclusao = function() {
			var retorno = function( resposta ) {
				alerta( resposta, 'Exclusão efetuada com sucesso.' );
				tabela.fnDraw();
			}
			for (var i = 0; i < lotes.length; i++) {
				var dados  = { _c: 'LoteControladora', _m: 'excluir', id: lotes[i].id };
				$.post('php/invoker.php', dados, retorno, 'json');	
			}
		};
		if( lotes != null && lotes != '' ) {
			alertaExclusao( lotes.length, efetuarExclusao );				
		}
	}
	$('#excluir').click(function() {
		excluir();
	})
		
}