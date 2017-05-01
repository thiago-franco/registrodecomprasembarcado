function produto() {
	
	//Configuração do dataTable
	var requisicao = 'php/invoker.php?_c=ProdutoControladora&_m=produtos&_raw=a';
	var colunas = [	{ "mData": "id" }, { "mData": "codigoBarras" }, { "mData": "descricao" }, { "mData": "valor" } ];
	tabela = carregarDataTable( '#tabela-produtos', requisicao, colunas );
	tableTools = TableTools.fnGetInstance('tabela-produtos');
	
	//Validação
	$('#adicionar-produto').validate({
		rules: {
			codigo_barras: { 
				required: true,
				minlength: 8,
				maxlength: 15
			},
			descricao: {
				required: true,
				minlength: 5,
				maxlength: 100
			},
			valor: {
				required: true
			}
		},
		messages: {
			codigo_barras: {
				required: 'O campo código de barras deve ser preenchido',
				minlength: 'O código de barras deve conter ao menos 8 caracteres',
				maxlength: 'O código de barras deve até 15 caracteres'
			},
			descricao: {
				required: 'O campo descrição deve ser preenchido',
				minlength: 'A descrição deve conter ao menos 5 caractere',
				maxlength: 'A descrição não deve conter mais do que 100 caracteres'
			},
			valor: {
				required: 'O campo valor deve ser preenchido'
			}
		}
	});

	//Adicionar
	var retorno = function( resposta ) {
		var mensagem = 'Produto salvo com sucesso.';
		alerta( resposta, mensagem );
		if( resposta.success ) {
			$('#codigo_barras').val('');
			$('#descricao').val('');
			$('#valor').val('');
		}
		$('#codigo_barras').focus();
		tabela.fnDraw();
	};
    $('#adicionar-confirma').click( function() {
		if($('#adicionar-produto').valid()) {
			var codigo_barras = $('#codigo_barras').val();
			var descricao = $('#descricao').val();
			var valor = $('#valor').val();
			var	dados = { _c: 'ProdutoControladora', _m: 'salvar', codigo_barras: codigo_barras, descricao: descricao, valor: valor };
			$.post('php/invoker.php', dados, retorno, 'json');
		}
	});

	//Alterar
	function alterar() {
		produto = tableTools.fnGetSelectedData();
        if( produto.length == 1 ) {
            produto = produto[0];
            var valorCodigoBarras = produto.codigoBarras;
            var valorDescricao = produto.descricao;
            var valorValor = produto.valor;
            var campoCodigoBarras = '<div class="col-lg-2 form-alerta"><label>Código de barras</label><input id="alterar-codigo-barras" name="alterar-codigo-barras" type="text" class="form-control"></div>';
            var campoDescricao = '<div class="col-lg-8 form-alerta"><label>Descrição</label><input id="alterar-descricao" name="alterar-descricao" type="text" class="form-control"></div>';
            var campoValor = '<div class="col-lg-2 form-alerta"><label>Valor</label><input id="alterar-valor" name="alterar-valor" type="text" class="form-control"></div>';
            var campos = campoCodigoBarras+campoDescricao+campoValor;
            var validacao = {
                rules: {
                    'alterar-codigo-barras': { required: true, minlength: 8, maxlength: 15 },
                    'alterar-descricao': { required: true, minlength: 5, maxlength: 100 },
                    'alterar-valor': { required: true }
                },
                messages: {
                    'alterar-codigo-barras': {
                        required: 'O campo código de barras deve ser preenchido',
                        minlength: 'O código de barras deve conter ao menos 8 caracteres',
                        maxlength: 'O código de barras deve até 15 caracteres'
                    },
                    'alterar-descricao': {
                        required: 'O campo descrição deve ser preenchido',
                        minlength: 'A descrição deve conter ao menos 5 caractere',
                        maxlength: 'A descrição não deve conter mais do que 100 caracteres'
                    },
                    'alterar-valor': { required: 'O campo valor deve ser preenchido' }
                }
            };
            var preencherCampos = function() {
                $('#alterar-codigo-barras').val(valorCodigoBarras);
                $('#alterar-descricao').val(valorDescricao);
                $('#alterar-valor').val(valorValor);
            };
            var efetuarAlteracao = function() {
                var retorno = function( resposta ) {
                    var mensagem = 'Alteração efetuada com sucesso.';
                    alerta( resposta, mensagem );
                    tabela.fnDraw();
                }
                var dados  = {
                    _c: 'ProdutoControladora',
                    _m: 'salvar',
                    id: produto.id,
                    codigo_barras: $('#alterar-codigo-barras').val(),
                    descricao: $('#alterar-descricao').val(),
                    valor: $('#alterar-valor').val()
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
		produtos = tableTools.fnGetSelectedData();
		var efetuarExclusao = function() {
			var retorno = function( resposta ) {
				alerta( resposta, 'Exclusão efetuada com sucesso.' );
				tabela.fnDraw();
			}
			for (var i = 0; i < produtos.length; i++) {
				var dados  = { _c: 'ProdutoControladora', _m: 'excluir', id: produtos[i].id };
				$.post('php/invoker.php', dados, retorno, 'json');	
			}
		};
		if( produtos != null && produtos != '' ) {
			alertaExclusao( produtos.length, efetuarExclusao );				
		}
	}
	$('#excluir').click(function() {
		excluir();
	})
		
}