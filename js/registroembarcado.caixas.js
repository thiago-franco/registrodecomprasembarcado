function caixa() {
	
	//Configuração do dataTable
	var requisicao = 'php/invoker.php?_c=CaixaControladora&_m=caixas&_raw=a';
	var colunas = [	{ "mData": "id" }, { "mData": "nome" }, { "mData": "numeroSerie" } ];
	var tabela = carregarDataTable( '#tabela-caixas', requisicao, colunas );
	var tableTools = TableTools.fnGetInstance('tabela-caixas');
	
	
	//Validação
	$('#adicionar-caixa').validate({
		rules: {
			nome: { 
				required: true,
				minlength: 1,
				maxlength: 15
			}
		},
		messages: {
			nome: {
				required: 'O campo nome deve ser preenchido',
				minlength: 'O nome deve conter ao menos 1 caractere',
				maxlength: 'O nome não deve conter mais do que 15 caracteres'
			}
		}
	});
	
	//Adicionar
	$('#adicionar-caixa').on('submit', function(e) { e.preventDefault() } );
	var retorno = function( resposta ) {
		var mensagem = 'Caixa salvo com sucesso.';
		alerta( resposta, mensagem ); 
		if( resposta.success ) {
			$('#nome').val('');
			$('#serie').val('');
		}
		$('#nome').focus();
		tabela.fnDraw();
	};
    $('#adicionar-confirma').click( function() {
		if($('#adicionar-caixa').valid()) {
			var nome = $('#nome').val();
			var serie = $('#serie').val();
			var	dados = { _c: 'CaixaControladora', _m: 'salvar', id: 0, nome: nome, serie: serie  };
			$.post('php/invoker.php', dados, retorno, 'json');
		}
	});

	//Alterar
	function alterar() {
		caixa = tableTools.fnGetSelectedData();
        if(caixa.length == 1){
            caixa=caixa[0];
            var valorNome = caixa.nome;
            var campoNome = '<div class="col-lg-10 form-alerta"><label>Nome</label><input id="alterar-nome" name="alterar-nome" type="text" class="form-control"></div>';
			var campoNumeroSerie = '<div class="col-lg-2 form-alerta"><label>Número de série</label><input id="alterar-numero-serie" name="alterar-numero-serie" type="text" class="form-control"></div>';
			var valorNumeroSerie = caixa.numeroSerie;
            var campos = campoNome+campoNumeroSerie;
            var validacao = {
                rules: { nome: { required: true, minlength: 1, maxlength: 15 } },
                messages: {
                    'alterar-nome': {
                        required: 'O campo nome deve ser preenchido',
                        minlength: 'O nome deve conter ao menos 1 caractere',
                        maxlength: 'O nome não deve conter mais do que 15 caracteres'
                    }
                }
            };
            var preencherCampos = function() {
                $('#alterar-nome').val(valorNome);
				$('#alterar-numero-serie').val(valorNumeroSerie);
            };
            var efetuarAlteracao = function() {
                var retorno = function( resposta ) {
                    var mensagem = 'Alteração efetuada com sucesso.';
                    alerta( resposta, mensagem );
                    tabela.fnDraw();
                }
                var dados  = { 
					_c: 'CaixaControladora', 
					_m: 'salvar', 
					id: caixa.id, 
					nome: $('#alterar-nome').val(), 
					serie: $('#alterar-numero-serie').val()
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
		caixas = tableTools.fnGetSelectedData();
		var efetuarExclusao = function() {
			var retorno = function( resposta ) {
				var mensagem = 'Exclusão efetuada com sucesso.';
				alerta( resposta, mensagem );
				tabela.fnDraw();
			}
			for (var i = 0; i < caixas.length; i++) {
				var dados  = { _c: 'CaixaControladora', _m: 'excluir', id: caixas[i].id };
				$.post('php/invoker.php', dados, retorno, 'json');	
			}
		};
		if( caixas != null && caixas != '' ) {
			alertaExclusao( caixas.length, efetuarExclusao );				
		}
	}
	$('#excluir').click(function() {
		excluir();
	});

}
		