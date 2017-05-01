<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro de Compras Embarcado</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    
    <link href="css/registroembarcado.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <div id="menu" name="menu" > <?php include('menu.htm'); ?>  </div>

        <div id="page-wrapper">
            <div class="row wrapper-row">
                <div class="col-lg-12">
                    <h1 class="page-header">Notificações</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
             <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div id="tabela" class="panel panel-default">
                        <div class="panel-heading">                     
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            </div>
                        	<div class="row">
                            	<div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table id="tabela-notificacoes" class="table table-hover table-responsive ">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Evento</th>
                                                    <th>Hora</th>
                                                    <th>Data</th>
                                                    <th>Resolvido</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabela-notificacoes-body">
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
	<script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="js/plugins/morris/morris.js"></script>    
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    
    <script src="js/registroembarcado.js"></script>
    <script src="js/registroembarcado.notificacoes.js"></script>
    
    <script>
		$(document).ready(function() {
            notificacoes();
        });
	</script>

</body>

</html>
