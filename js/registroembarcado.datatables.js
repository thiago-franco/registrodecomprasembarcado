//ARQUIVO DE DEFINIÇÃO DE CONFIGURAÇÕES DE DATATABLE ESPECÍFICAS A SEREM UTILIZADAS NO SISTEMA

/* Prepara uma configuração para se utilizar o português como linguagem do dataTable 
	retorno: variavel no formato json contendo textos em português a serem utilizados pelo dataTable
*/
function dataTablePortugues() {
	opcoes = { 
		"sLengthMenu": "Mostrar _MENU_ registros por página",
		"sZeroRecords": "Nenhum registro encontrado", 
		"sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)", 
		"sInfoEmpty": "Mostrando 0 / 0 de 0 registros", 
		"sInfoFiltered": "(filtrado de _MAX_ registros)", 
		"sSearch": "Pesquisar: ", 
		"oPaginate": { "sFirst": "Início", "sPrevious": "Anterior", "sNext": "Próximo", "sLast": "Último" } 
	};
	return opcoes;
}

/* Define o comportamento de um dataTable
	requisicao: fonte na qual serão buscados os dados para popular o dataTable
	colunas: colunas a serem adicionazdas ao dataTable, recebidas em formato json
 */
function carregarDataTable( tabela, requisicao, colunas ) {		
	var dataTable = $(tabela).dataTable({
		"bServerSide": true,
		"sAjaxSource": requisicao,
		"aoColumns": colunas,
		"aLengthMenu" : [ [ 10, 25, 50, 100, -1 ], [ 10, 25, 50, 100, "Todos" ] ],
		"oLanguage": dataTablePortugues(),
		"sDom": 'T<"clear">flrtip',
		"oTableTools": {
    		"sSwfPath": "js/plugins/dataTables/tableTools/copy_csv_xls_pdf.swf",
			"sRowSelect": "multi",
			"aButtons": [
                {
					"sExtends": "copy",
					"sButtonText": "copiar",
					"sInfo": "<h6>Tabela copiada</h6><p>Tabela copiada para a área de transferência.</p>",
 					"sLines": "linhas",
 					"sLine": "linha"
				},
				{
					"sExtends": "collection",
					"sButtonText": "relatórios",
					"aButtons": [
					                "csv",
									"xls", 
									"pdf"
					]
				},
				{
					"sExtends": "print",
					"sButtonText": "imprimir",
					"sInfo": "<h6>Vizualizar impressão</h6><p>Use a função de impressão do seu navegador. Pressione a tecla \"esc\" quando terminar.</p>",
				}
            ]
     	}
	});
	return dataTable;
}

/*
function dataTablesRegisterRowSelection( tabela, dblClickFn ) {

	var allRows = $( 'tbody tr ', tabela ); console.log(allRows);

	allRows.on( 'click', function(e) {
		var e = e || window.event; // funciona com os navegadores atuais
		var isSingleSelectionMode = ! e.ctrlKey;
		if ( isSingleSelectionMode ) {
			$( this ).siblings().removeClass( 'row_selected' );
		}
		$( this ).toggleClass( 'row_selected' ); console.log($(this));
		var selectCount = allRows.filter( '.row_selected' ).size();
		if ( editButton ) setEnabled( editButton, 1 == selectCount );
		if ( removeButton ) setEnabled( removeButton, selectCount >= 1 );
	} );
} 
*/