function item() {
	
	//Configuração do dataTable
	var requisicao = 'php/invoker.php?_c=ItemControladora&_m=itens&_raw=a';
	var colunas = [	{ "mData": "id" }, { "mData": "uid" }, { "mData": "lote.nome" }, { "mData": "lote.produto.descricao" }, { "mData": "lote.validade" } ];
	var tabela = carregarDataTable( '#tabela-itens', requisicao, colunas );
	tableTools = TableTools.fnGetInstance('tabela-itens');
	
	//Validação
	$('#adicionar-item').validate({
		rules: {
			uid: { 
				required: true,
				minlength: 1,
				maxlength: 15
			},
			lote: {
				required: true,
				expreg: '[0-9][1-9]'
			}
		},
		messages: {
			uid: {
				required: 'O campo uid deve ser preenchido!',
				minlength: 'O nome deve conter ao menos 1 caractere!',
				maxlength: 'O nome não deve conter mais do que 15 caracteres!'
			},
			lote: {
				required: 'O campo lote deve ser selecionado!'
			}
		}
	});
	
	//Adicionar	
	var retorno = function( resposta ) {
		var mensagem = 'Item salvo com sucesso.';
		alerta( resposta, mensagem );
		if( resposta.success ) {
			$('#uid').val('');
		}
		$('#uid').focus();
		tabela.fnDraw();
	};
    $('#adicionar-confirma').click( function() {
		if($('#adicionar-item').valid()) {
			var uid = $('#uid').val();
			var lote = $('#lote').val();
			var	dados = { _c: 'ItemControladora', _m: 'salvar', uid: uid, lote: lote };
			$.post('php/invoker.php', dados, retorno, 'json');
		}

	});

	//Configurando campo select "lote"
	function preparaSelect(identificador) {
		var dados = { _c: 'LoteControladora', _m: 'lotes' };
		var acao = function( resposta ) { 
			if( resposta.success ) {	
				var lotes = resposta.data.aaData;
				for( var i = 0; i < lotes.length; i++) {
					var lote = lotes[i];	
					$(identificador).append( new Option( lote.nome + ' - ' + lote.produto.descricao, lote.id ) );
				}
				var opcoes = { no_results_text: 'Nenhum lote encontrado para a busca:', width: '100%' };
				$(identificador).chosen( opcoes );
			}
		};
		$.post('php/invoker.php', dados, acao, 'json');
		//$('#lote').trigger('chosen:updated');
	}

	preparaSelect('#lote');

	//Alterar
	function alterar() {
		item = tableTools.fnGetSelectedData();
        if( item.length == 1) {
            item = item[0];
            var valorUid = item.uid;
            var valorLote = item.lote.id;
            var campoUid = '<div class="col-lg-5 form-alerta"><label>UID</label><input id="alterar-uid" name="alterar-uid" type="text" class="form-control"></div>';
            var campoLote =  '<div class="col-lg-7 form-alerta"><label>Lote</label><select id="alterar-lote" name="alterar-lote" class="form-control" data-placeholder="selecione um lote..."><option></option></select></div>';
            var campos = campoUid+campoLote;
            var validacao = {
                rules: {
                    'alterar-uid': { required: true, minlength: 1, maxlength: 15 },
                    'alterar-lote': { required: true, expreg: '[0-9][1-9]' }
                },
                messages: {
                    'alterar-uid': {
                        required: 'O campo uid deve ser preenchido!',
                        minlength: 'O nome deve conter ao menos 1 caractere!',
                        maxlength: 'O nome não deve conter mais do que 15 caracteres!'
                    },
                    'alterar-lote': { required: 'O campo lote deve ser selecionado!' }
                }
            };
            var preencherCampos = function() {
                $('#alterar-uid').val(valorUid);
                preparaSelect('#alterar-lote');
				setTimeout( function() {
					$('#alterar-lote').val(valorLote).trigger('chosen:updated');	
				}, 200);
            };
            var efetuarAlteracao = function() {
                var retorno = function( resposta ) {
                    var mensagem = 'Alteração efetuada com sucesso.';
                    alerta( resposta, mensagem );
                    tabela.fnDraw();
                }
                var dados  = {
                    _c: 'ItemControladora',
                    _m: 'salvar',
                    id: item.id,
                    uid: $('#alterar-uid').val(),
                    lote: $('#alterar-lote').val()
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
		itens = tableTools.fnGetSelectedData();
		var efetuarExclusao = function() {
			var retorno = function( resposta ) {
				alerta( resposta, 'Exclusão efetuada com sucesso.' );
				tabela.fnDraw();
			}
			for (var i = 0; i < itens.length; i++) {
				var dados  = { _c: 'ItemControladora', _m: 'excluir', id: itens[i].id };
				$.post('php/invoker.php', dados, retorno, 'json');	
			}
		};
		if( itens != null && itens != '' ) {
			alertaExclusao( itens.length, efetuarExclusao );				
		}
	}
	$('#excluir').click(function() {
		excluir();
	});

}