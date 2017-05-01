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
                    <h1 class="page-header">Produtos</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
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
                                <form id="adicionar-produto" role="form">
                                   <div class="form-group col-lg-3">
                                        <label>Código de Barras</label>
                                        <input id="codigo_barras" name="codigo_barras" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Descrição</label>
                                        <input id="descricao" name="descricao" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-2" style="float:left">
                                        <label>Valor</label>
                                        <input id="valor" name="valor" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-1" >
                                        <button id="adicionar-confirma" type="button" class="botao-direita btn btn-outline btn-success btn-circle btn-xl" ><i class="fa fa-check"></i></button>
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
                            <div class=" row">
                            	<div class="col-lg-12">
                                	<div class="table-responsive">
                                        <table id="tabela-produtos" class="table table-bordered">
                                            <div class="btn-double">
                                                <button id="alterar" class="col-lg-1 btn btn-info btn-alterar">Alterar</button>
                                                <button id="excluir" class="col-lg-1 btn btn-danger btn-excluir">Excluir</button>
                                            </div><br/><br/>
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Código de Barras</th>
                                                    <th>Descrição</th>
                                                    <th>Valor</th>
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
    <script src="js/registroembarcado.produtos.js"></script>
    <script src="js/registroembarcado.datatables.js"></script>
    
    <script>
		$(document).ready(function() {
            produto();
        });
	</script>


</body>

</html>
