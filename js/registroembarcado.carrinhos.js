function carrinho() {
	
	//Configuração do dataTable
	var requisicao = 'php/invoker.php?_c=CarrinhoControladora&_m=carrinhos&_raw=a';
	var colunas = [	{ "mData": "id" }, { "mData": "numeroSerie" }, { "mData": "nome" }, { "mData": "ir" } ];
	var tabela = carregarDataTable( '#tabela-carrinhos', requisicao, colunas ); 
	tableTools = TableTools.fnGetInstance('tabela-carrinhos');
	
	//Validação
	$('#adicionar-carrinho').validate({
		rules: {
			serie: {
				required: true,
				minlength: 1,
				maxlength: 8
			},
			nome: { 
				required: true,
				minlength: 1,
				maxlength: 15
			},
			ir: {
				required: true,
				minlength: 1,
				maxlength: 15
			}
		},
		messages: {
			serie: {
				required: 'O campo número de série deve ser preenchido!',
				minlength: 'O número de série deve conter ao menos 1 caractere!',
				maxlength: 'O número de série não deve conter mais do que 8 caracteres!'
			},
			nome: {
				required: 'O campo nome deve ser preenchido!',
				minlength: 'O nome deve conter ao menos 1 caractere!',
				maxlength: 'O nome não deve conter mais do que 15 caracteres!'
			},
			ir: {
				required: 'O campo ir deve ser preenchido!',
				minlength: 'O ir deve conter ao menos 1 caractere!',
				maxlength: 'O ir não deve conter mais do que 15 caracteres!'
			}
		}
	});
	
	//Adicionar	
	var retorno = function( resposta ) {
		var mensagem = 'Carrinho salvo com sucesso.';
		alerta( resposta, mensagem );
		if( resposta.success ) {
			$('#serie').val('');
			$('#nome').val('');
			$('#ir').val('');			
		}
		$('#serie').focus();
		tabela.fnDraw();
	};
    $('#adicionar-confirma').click( function() {
		if($('#adicionar-carrinho').valid()) {
			var numeroSerie = $('#serie').val();
			var nome = $('#nome').val();
			var ir = $('#ir').val();
			var	dados = { _c: 'CarrinhoControladora', _m: 'salvar', id: 0, serie: numeroSerie, nome: nome, ir: ir};
			$.post('php/invoker.php', dados, retorno, 'json');
		}
	});

	//Alterar
	function alterar() {
		carrinho = tableTools.fnGetSelectedData();
        if( carrinho.length == 1){
            carrinho = carrinho[0];
            var valorNumeroSerie = carrinho.numeroSerie;
            var valorNome = carrinho.nome;
            var valorIr = carrinho.ir;
            var campoNumeroSerie = '<div class="col-lg-3 form-alerta"><label>Número de série</label><input id="alterar-numero-serie" name="alterar-numero-serie" type="text" class="form-control"></div>';
            var campoNome = '<div class="col-lg-6 form-alerta"><label>Nome</label><input id="alterar-nome" name="alterar-nome" type="text" class="form-control"></div>';
            var campoIr = '<div class="col-lg-3 form-alerta"><label>IR</label><input id="alterar-ir" name="alterar-ir" type="text" class="form-control"></div>';
            var campos = campoNumeroSerie+campoNome+campoIr;
            var validacao = {
                rules: {
                    'alterar-serie': { required: true, minlength: 1, maxlength: 8 },
                    'alterar-nome': { required: true, minlength: 1, maxlength: 15 },
                    'alterar-ir': { required: true, minlength: 1, maxlength: 15 }
                },
                messages: {
                    'alterar-serie': {
                        required: 'O campo número de série deve ser preenchido!',
                        minlength: 'O número de série deve conter ao menos 1 caractere!',
                        maxlength: 'O número de série não deve conter mais do que 8 caracteres!'
                    },
                    'alterar-nome': {
                        required: 'O campo nome deve ser preenchido!',
                        minlength: 'O nome deve conter ao menos 1 caractere!',
                        maxlength: 'O nome não deve conter mais do que 15 caracteres!'
                    },
                    'alterar-ir': {
                        required: 'O campo ir deve ser preenchido!',
                        minlength: 'O ir deve conter ao menos 1 caractere!',
                        maxlength: 'O ir não deve conter mais do que 15 caracteres!'
                    }
                }
            };
            var preencherCampos = function() {
                $('#alterar-ir').val(valorIr);
                $('#alterar-nome').val(valorNome);
                $('#alterar-numero-serie').val(valorNumeroSerie);
            }
            var efetuarAlteracao = function() {
                var retorno = function( resposta ) {
                    var mensagem = 'Alteração efetuada com sucesso.';
                    alerta( resposta, mensagem );
                    tabela.fnDraw();
                }
                var dados  = {
                    _c: 'CarrinhoControladora',
                    _m: 'salvar',
                    id: carrinho.id,
                    serie: $('#alterar-numero-serie').val(),
                    nome: $('#alterar-nome').val(),
                    ir: $('#alterar-ir').val()
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
		carrinhos = tableTools.fnGetSelectedData(); console.log(carrinhos);
		var efetuarExclusao = function() {
			var retorno = function( resposta ) {
				alerta( resposta, 'Exclusão efetuada com sucesso.' );
				tabela.fnDraw();
			}
			for (var i = 0; i < carrinhos.length; i++) {
				var dados  = { _c: 'CarrinhoControladora', _m: 'excluir', id: carrinhos[i].id };
				$.post('php/invoker.php', dados, retorno, 'json');	
			}
		};
		if( carrinhos != null && carrinhos != '' ) {
			alertaExclusao( carrinhos.length, efetuarExclusao );				
		}
	}
	$('#excluir').click(function() {
		excluir();
	});
		
}