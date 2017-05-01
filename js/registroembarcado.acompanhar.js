function acompanhar() {
	
	//Configuração do timeline

    /**
     * Retorna array com id das compras já preenchidas na timeline.
     */
    function comprasJaPreenchidas() {
        var comprasPreenchidas = [];
        $('[id^=compra]').each( function() {
            var id = $(this).attr('id').slice(6);
           comprasPreenchidas.push(id);
        });
        return comprasPreenchidas;
    }

	/**
	 * Adiciona à lista "timeline" elementos com novas compras. Caso a compra já esteja preenchida na timeline, é ignorada.
	 */
	function preencheTimeline( compras ) {
		if( compras.length == undefined ) {
			$('#timeline-msg').show(100);
		} else {
			$('#timeline-msg').hide(100);
			for( var i = 0; i < compras.length; i++ ) {
				var compra = compras[i];
                var comprasPreenchidas = comprasJaPreenchidas();
                if( $.inArray( compra.id, comprasPreenchidas ) == -1 ) {
                    var conteudo = '';
                    if( i % 2 == 0 )
                        conteudo += '<li id="elemento'+compra.id+'" class="div-compra timeline-panel">';
                    else
                        conteudo += '<li id="elemento'+compra.id+'" class="div-compra timeline-inverted">';
                    conteudo += '<button id="compra'+compra.id+'" class="btn-compra timeline-badge warning"><i class="fa fa-shopping-cart"></i></button>';
                    conteudo += '<div class="timeline-panel">';
                    conteudo += '<div class="timeline-heading">';
                    conteudo += '<h4 class="timeline-title">'+compra.carrinho.nome+'</h4>';
                    conteudo += '</div>';
                    conteudo += '<div class="timeline-body">';
                    conteudo += '<p>Total:</p><p id="total'+compra.id+'">R$ '+compra.total+'</p>';
                    conteudo += '</div></div></li>';
                    $('#timeline').prepend(conteudo);
                    $('#timeline').children('.timeline-panel, .timeline-inverted').show(300);
                }
			}
		}
	}
	
	/**
	 * Atualiza o valor do total de compra das compras preenchidas na timeline, caso este tenha sofrido alguma alteração.
	 */
	function atualizaTotalCompra( compras ) { 
		var comprasPreenchidas = comprasJaPreenchidas();  
		for( var i = 0; i < comprasPreenchidas.length; i++ ) {
			var compra = compras[i];
			if( (compra != undefined) && (compra.id != undefined) ) {
				if( $.inArray(compra.id, comprasPreenchidas) != -1 ) { 
					var seletor = '#total'+compra.id;
					if( $(seletor).text().slice(3) != compra.total ) {
						$(seletor).empty().append('R$ '+compra.total);
					}
				}
			}
		}
	}
	
	/**
	 * Apaga da timeline compras que eventualemnte não constem mais na base de dados.
	 */
	function removeCompraInexistente( compras ) {  
		var comprasPreenchidas = comprasJaPreenchidas();
		var comprasExistentes = []; 
		for( var i = 0; i < compras.length; i++ ) {
			var compra = compras[i];
			comprasExistentes.push(compra.id);	
		} 
		for ( var i = 0; i < comprasPreenchidas.length; i++ ) {
			var compraId = comprasPreenchidas[i];
			if( $.inArray(compraId, comprasExistentes) == -1 ) {
				if( $('#itens-compra-id').val() == compraId ) { console.log('entrou');
					$('#itens-compra-id').val('');
					$('#itens-compra').hide(300, function() {
						$('#itens-compra').empty();
						$('#itens-compra').append('<h3>Selecione uma compra para a visualização de seus itens</h3>');						
						$('#itens-compra').show(50);	
					});					
				}
				$('#elemento'+compraId).hide(300, function() {
					$(this).remove();
				});
			}
		}
	}

	/**
	 * Adiciona tabela contendo os itens relaciodados à compra cujo id é passado por parâmetro.
	 */
	function mostraItens( compra ) {
		$('#itens-compra').empty();
		var itens = compra.itens; 
		var carrinho = compra.carrinho;
		var conteudo = '<h4>Compras em '+carrinho.nome+'</h4>';
		conteudo += '<table class="table"><th style"width=30%">Produto</th><th>Valor</th><th>Validade</th>';
		for( var i = 0; i < itens.length; i++ ) {
			var item = itens[i];
			conteudo += '<tr><td>'+item.lote.produto.descricao+'</td><td>R$ '+item.lote.produto.valor+'</td><td>'+item.lote.validade+'</td></tr>'; 	
		}
		conteudo += '</table>';
		$('#itens-compra').append(conteudo);
	}

	function buscarItens( compraId ) {
		var dados = { _c: 'CompraControladora', _m: 'compraCompleta', id: compraId };
		var acao = function( resposta ) {
			var compra  = resposta.data; 
			mostraItens( compra );
		}
		$.post( 'php/invoker.php', dados, acao, 'json' );
	}

	function executaTimeline() { 
		var dados = { _c: 'CompraControladora', _m: 'comprasSimplificadas' };	
		var acao = function( resposta ) {
			var compras = resposta.data;
			removeCompraInexistente( compras );
			atualizaTotalCompra( compras );
			preencheTimeline( compras );
			$('[id^=compra]').unbind('click');
			$('[id^=compra]').click( function() {
				var id = $(this).attr('id').slice(6);
				$('#itens-compra-id').val(id);
				buscarItens(id);
			});
		};
		setInterval(function() {
			var compraId = $('#itens-compra-id').val();
			var buscar = $.isNumeric( $('#itens-compra-id').val() ) ? true : false;
			if( buscar )
				buscarItens( compraId );
			$.post( 'php/invoker.php', dados, acao, 'json' );
		}, 2000);	
	}

	executaTimeline();

}