function menu() {

	//carrega menu
    $('#side-menu').metisMenu();
	
	//Carrega o sidebar correto ao carregar e redimensionar a janela.
	$(function() {
		$(window).bind("load resize", function() {
			console.log($(this).width());
			if ($(this).width() < 760) {
				$('.sidebar-collapse').hide();
				$('#charts').hide(); //Esconde o gráfico
			    //$('div.sidebar-collapse').addClass('collapse')
			} else {
				$('.sidebar-collapse').show();
				$('#charts').show();
				//$('div.sidebar-collapse').removeClass('collapse')
			}
		})
	})
	
	//Configurações da interface de notificação
	$('.dropdown-alert').click( function() {
		$('#notificacao').toggle(350);
		
	});
	
	function limparNotificacao() {
		$('.fa-bell').css('color', 'inherit');
		var acao = $('#notificacao').hide(250);
		$.when( acao ).then( function() {
			$('#notificacao-msg').css( 'color', '#428BCA' );
			$('#notificacao-msg').html('<a href="notificacoes.php">Nenhuma nova notificação.</a>');
		});	
	}
	
	var jaNotificado = false;
	function notificar( msg, sucesso, conf ) {
		//limparNotificacao();
		var mostrar = !(jaNotificado && $('#notificacao').css('display') == 'none');
		$('#notificacao-msg').html('<a href="notificacoes.php">' + msg + '</a>');
		var width = 700+(msg.length)/2;
		$('#notificacao').css( 'width', width );
		if( sucesso ) {
			$('#notificacao-msg').children().css( 'color', 'green' );
			$('.fa-bell').css('color', 'green');
		} else { 
			$('#notificacao-msg').children().css( 'color', 'red' );
			$('.fa-bell').css('color', 'red');		
			jaNotificado = true;		
		}
		if( mostrar || conf )
			$('#notificacao').show(350);
	}
	
	//Configurações da interface de configuração
	$('.navbar-toggle').click( function() {
		$('.sidebar-collapse').toggle(100);
	});
	
	$('#toggle-config').click( function(){
		$('#configuracoes').toggle(100);	
	});
	
	$('#btn-configurar-caixas').click( function() {
		$('#configurar-caixas').toggle(100);
		$('#configuracoes').hide(100);
	});
	
	$('#configurar-caixas-cancela').click( function() {
		$('#separador').val('');
		$('#configurar-caixas').toggle(100);
		
	});
	
	$('#form-configurar-caixas').on( 'submit', function(e) {
		e.preventDefault();
	});
	
	$('#configurar-caixas-confirma').click( function() { 
		var separador = $('#separador').val().toUpperCase();
		if( separador.length > 0 ) {
			var acao = function( retorno ) {
				var msg = '';
				var sucesso = retorno.success;
				sucesso ? msg = 'Configuração efetuada com sucesso.' : msg = 'Configuração mal sucedia.';
				notificar( msg, sucesso, true );
				setTimeout( function() {
					limparNotificacao();
				}, 4000);
				$('#configurar-caixas').hide(100);
				$('#configuracoes').hide(100);
				$('#separador').val('');
			};
			var dados = { _c: 'ConfiguracaoControladora', _m: 'separador', separador: separador };
			$.post( 'php/invoker.php', dados, acao, 'json' );			
		}
	});
	
	//Define configurações de atualização de exibição de notificações
	var dadosNotificacoes = { _c: 'LogControladora', _m: 'logs', situacao: 'new' };
	var acaoNotificacoes = function( resposta ) {
		var notificacoes = resposta.data;
		var qtdNotificacoes = notificacoes.length; 
		if( qtdNotificacoes > 0 ) {  
			var msg = '';
			qtdNotificacoes == 1 ? msg = (notificacoes[0].evento.split('*'))[0] : msg = 'Existem '+qtdNotificacoes+' novas notificações.';
			notificar( msg, false, false );
		}
	};
	setInterval( function() {
		$.post('php/invoker.php', dadosNotificacoes, acaoNotificacoes, 'json');
	}, 10000);
	
	//Define configurações do gráfico donut
	var carrinhosDisponiveis = 0;
	var carrinhosAtivos = 0;
	Morris.Donut({
					element: 'carrinhos-chart',
					data: [{
						label: "Carrinhos em compra",
						value: carrinhosAtivos 
					}, {
						label: "Carrinhos disponíveis",
						value: carrinhosDisponiveis
					}],
					resize: true
	});
	var dadosGrafico = { _c: 'CompraControladora', _m: 'contarCarrinhos' };
	var acaoGrafico = function( resposta ) {
		if(resposta.success){ 
			carrinhosDisponiveisDepois = (resposta.data.total - resposta.data.ativos);
			carrinhosAtivosDepois = resposta.data.ativos;
			var redesenhar = (carrinhosDisponiveisDepois !== carrinhosDisponiveis || carrinhosAtivosDepois !== carrinhosAtivos ); 
			if(redesenhar) {
				$('#carrinhos-chart').empty();
				Morris.Donut({
					element: 'carrinhos-chart',
					data: [{
						label: "Carrinhos em compra",
						value: carrinhosAtivosDepois 
					}, {
						label: "Carrinhos disponíveis",
						value: carrinhosDisponiveisDepois
					}],
					resize: true
				});
				carrinhosDisponiveis = carrinhosDisponiveisDepois;
				carrinhosAtivos = carrinhosAtivosDepois;
			}
		}
	}
	setInterval( function() {
		$.post('php/invoker.php', dadosGrafico, acaoGrafico, 'json'); 
	}, 3000);
	
}