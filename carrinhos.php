<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro de Compras Embarcado</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    
    <link href="css/registroembarcado.css" rel="stylesheet">
    
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet"> 
    <link href="css/plugins/dataTables/tableTools/dataTables.tableTools.min.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <div id="menu" name="menu" > <?php include('menu.htm'); ?> </div>

        <div id="page-wrapper">
            <div class="row wrapper-row">
                <div class="col-lg-12">
                    <h1 class="page-header">Carrinhos</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                   	<div id="alerta">  
                        <p id="alerta-msg"></p>
                    </div> 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Adicionar
                            <div class="pull-right">
	                        	<button type="button" id="adicionar-toggle" class="fa fa-plus">
                        	</div>
                        </div>                    
                        <div id="adicionar-body" class="panel-body">
                            <div class="row">
                                <form id="adicionar-carrinho" role="form">
                                    <div class="form-group col-lg-3">
                                        <label>Número de Série</label>
                                        <input id="serie" name="serie" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Nome</label>
                                        <input id="nome" name="nome" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>IR</label>
                                        <input id="ir" name="ir" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-1" >
                                        <button id="adicionar-confirma" type="button" class="botao-direita btn btn-outline btn-success btn-circle btn-xl"><i class="fa fa-check"></i></button>
                                    </div>
								</form>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                       <div class="panel panel-default">
                        <div class="panel-heading">
                            Visualizar
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            	<div class="col-lg-12">
                                	<div class="table-responsive">
                                <table id="tabela-carrinhos" class="table table-bordered">
                                	<div class="btn-double">
	                                    <button id="alterar" class="col-lg-1 btn btn-info btn-alterar">Alterar</button>
                                        <button id="excluir" class="col-lg-1 btn btn-danger btn-excluir">Excluir</button>
                                    </div><br/><br/>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Número de Série</th>
                                            <th>Nome</th>
                                            <th>IR</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
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
    
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/plugins/dataTables/tableTools/dataTables.tableTools.min.js"></script>
    
    <script src="js/plugins/validate/jquery.validate.min.js"></script>
    
    <!-- Arquivos necessários para o carregamento do menu  -->
	<script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="js/plugins/morris/morris.js"></script>    
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <script src="js/registroembarcado.js"></script>
    <script src="js/registroembarcado.carrinhos.js"></script>
    <script src="js/registroembarcado.datatables.js"></script>
    
    <script>
		$(document).ready(function() {
            carrinho();
        });
	</script>

</body>

</html>
