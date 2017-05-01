<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro de Compras Embarcado</title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Dashboard -->
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="css/plugins/timeline/timeline.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/registroembarcado.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

		<div id="menu" name="menu" > <?php include('menu.htm'); ?> </div>

        <div id="page-wrapper">
            <div class="row wrapper-row">
                <div class="col-lg-12">
                    <h1 class="page-header">Acompanhar</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4">
           			<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Compras
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	<div id="timeline-msg">
                             <!-- mensagem para 0 elementos --> 
                             	<h4>Nenhuma compra no momento.<h4>
                            </div>
                            <ul id="timeline" class="timeline">
                                <!-- <li>s adicionados dinamicamente -->
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <div class="col-lg-8">
                    <div class="panel panel-default fixo">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Itens 
                        </div>
                        <input type="hidden" id="itens-compra-id">
                        <div class="panel-body">
                        	<div id="itens-compra">
                            	<h3>Selecione uma compra para a visualização de seus itens</h3>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    
    <!-- Arquivos necessários para o carregamento do menu  -->
	<script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="js/plugins/morris/morris.js"></script>    
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    
    <script src="js/registroembarcado.js"></script>
    <script src="js/registroembarcado.acompanhar.js"></script>    
    <script src="js/registroembarcado.datatables.js"></script>
    
    <script>
	$(document).ready(function() {
            acompanhar();
        });
	</script>    

</body>

</html>
