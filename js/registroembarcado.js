/* ARQUIVO DE CONFIGURAÇÃO DE ELEMENTOS COMUNS ENTRES AS PÁGINAS DO SISTEMA */

//define o comportamento do clique em botões "adicionar-toggle"
$('#adicionar-toggle').on( 'click', function() {
		adicionarToggle();
});

function adicionarToggle() {
	iconeAdicionarToggle(); 
	$('#adicionar-body').slideToggle(160);
}

//Estabelece o comportamento do ícone presente em botões "adicionar-toggle"
function iconeAdicionarToggle() {
	if($('#adicionar-toggle').hasClass( 'fa-plus' ) ) {
		$('#adicionar-toggle').removeClass( 'fa-plus' );
		$('#adicionar-toggle').addClass( 'fa-minus' );	
	} else if( $('#adicionar-toggle').hasClass( 'fa-minus' ) ) {
		$('#adicionar-toggle').removeClass( 'fa-minus' );
		$('#adicionar-toggle').addClass( 'fa-plus' );	
	}
}

//Definições de comportamento da div "alerta"
function prepararAlerta() {
	$('#alerta').hide();
	$('#alerta-msg').empty();
	$('#alerta').removeClass();
	$(document).scrollTop( $("#alerta").offset() );
}

function alerta( resposta, mensagem ) {
	prepararAlerta();
	if( resposta.success ) {
		$('#alerta').addClass('alert alert-success alert-dismissable');
		$('#alerta-msg').append(mensagem);
	} else {
		$('#alerta').addClass('alert alert-danger alert-dismissable');
		$('#alerta-msg').append(resposta.message);	
	}
	$('#alerta').show(140);
	setTimeout( function() {
		$('#alerta').hide(200);
	}, 3000);
}

//Função que, caso o valor recebido seja maior que 1, retorna o sufixo indicativo de plural "s"
function plural( qtd ) {
	if( qtd > 1 )
		return 's';
	return '';
}

function alertaAlteracao( campos, validacao, callbackPreencheCampos, callbackAlteracao ) {
	prepararAlerta();
	$('#alerta').addClass('alert alert-info alert-dismissable');
	var mensagem = '<p>Faça as alterações desejadas.</p>';
	var botaoCancela = '<button type="button" class="alerta-cancela btn btn-default" data-dismiss="modal">Cancelar</button>';
	var botaoConfirma = '<button type="button" class="alterar-confirma btn btn-success btn-outline" id="confirm">Confirmar</button>';
	var botoes = '<div clas="col-lg-12"><div class="botao-direita">'+botaoConfirma+' '+botaoCancela+'</div></div>';
	$('#alerta-msg').append(mensagem+'<form id="form-alteracao" class="row">'+campos+botoes+'</form>');
	$('#form-alteracao').validate(validacao);
	callbackPreencheCampos();
	$('#alerta').show(140);
	$('.alerta-cancela').click( function() {
		$('#alerta').hide(200);
	});
	$('.alterar-confirma').click( function() {
		if( $('#form-alteracao').valid() ) {
			$('#alerta').hide(200);
			callbackAlteracao();	
		}
	});
}

function alertaExclusao( qtdRegistros, callbackExclusao ) {
	prepararAlerta();
	$('#alerta').addClass('alert alert-warning alert-dismissable');
	var mensagem = '<p>Você está prestes à excluir '+qtdRegistros+' registro'+plural( qtdRegistros )+' permanentemente. Está certo disso?</p>';
	var botaoCancela = '<button type="button" class="alerta-cancela btn btn-default" data-dismiss="modal">Cancelar</button>';
	var botaoConfirma = '<button type="button" class="alerta-confirma btn btn-danger btn-outline" id="confirm">Confirmar</button>';
	var botoes = '<div class="botao-direita">'+botaoConfirma+' '+botaoCancela+'</div>';
	$('#alerta-msg').append($(mensagem+'<div class="row">'+botoes+'</div>'));
	$('#alerta').show(140);
	$('.alerta-cancela').click( function() {
		$('#alerta').hide(200);
	});
	$('.alerta-confirma').click( function() {
	 	$('#alerta').hide(200);
		callbackExclusao();
	});
}

//Adiciona o método expreg(), para expressão regular, ao método validator
$.validator.addMethod(
    "expreg",
    function(valor, elemento, expressaoRegular) {
        var er = new RegExp(expressaoRegular);
        return this.optional(elemento) || er.test(valor);
    }
);
