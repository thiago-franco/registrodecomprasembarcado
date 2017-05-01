function notificacoes() {
	
	function carregarLogs() {
		var dados = { _c: 'LogControladora', _m: 'logs' }; 
		var acao = function( resposta ) {
			var logs = resposta.data;
			for(var i =0; i<logs.length; i++){
				var l = logs[i];
				var evento = l.evento.split('*');
				var data = l.data.split(' ')[0];
				var ano = data.split('-')[0];
				var mes  = data.split('-')[1];
				var dia  = data.split('-')[2];
				var hora = l.data.split(' ')[1];
				var lido = '<input id="lido'+l.id+'" type="button" class="btn btn-success btn-circle';
				l.situacao == 'old' ? lido +=  '" disabled="true"/>' :  lido += ' btn-outline" />';
				var linha = '<tr><td>'+l.id+'</td><td>'+evento[0]+'</br>'+evento[1]+'</td><td>'+hora+'</td><td>'+dia+'/'+mes+'/'+ano+'<td>'+lido+'</td></tr>'; 
				$("#tabela-notificacoes-body").append(linha);
			}
		};
		$.post('php/invoker.php', dados, acao, 'json');	
	}
	
	carregarLogs();
	setTimeout( function() {
		$('[id^=lido]').click( function() {
			$(this).removeClass('btn-outline');
			$(this).attr('disabled', true)
			var logId = $(this).attr('id').slice(4);
			var dados = { _c: 'LogControladora', _m: 'alterarSituacaoDeLog', logId: logId };
			var acao = function( resposta ) {};
			$.post('php/invoker.php', dados, acao, 'json');
		});	
	}, 1000);
	
		
		
}