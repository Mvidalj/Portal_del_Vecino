<?php
    require_once '../../validaciones/conexion_bd.php';

    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_rol'] != "1"){
            $user->Redirect('../../index.php');
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
	<title>Administración de balances</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/jquery.dataTables.min.css">
	<script src="../../librerias/jquery-3.2.1.js"></script>
	<script src="../../librerias/bootstrap.js"></script>
	<script src="../../librerias/jquery.dataTables.min.js"></script>
        
        <!-- Configuración de lenguaje de DataTable -->
	<script type="text/javascript">
	$(document).ready(function() {
		$("#example").DataTable( {
        "language": {
            "lengthMenu"    :   "Mostrar _MENU_ registros por pagina",
            "zeroRecords"   :   "Lo sentimos, no hay información",
            "info"          :   "Mostrando _PAGE_ de _PAGES_",
            "search"        :   "Buscar:",
            "infoEmpty"     :   "Lo sentimos, no hay información",
            "infoFiltered"  :   "(filtered from _MAX_ total records)",
		    "paginate"      : {
		        "first"     :   "Primero",
		        "last"      :   "Último",
		        "next"      :   "Siguiente",
		        "previous"  :   "Anterior"
		    }
        }
    	} );
	} );
	</script>
    </head>
    <body>
        <div class="container">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-sm-2">
                    <img class="img-responsive" src="../../imagenes/home.jpg" width="130" height="130" alt="Icono de pagina">
                </div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3 col-sm-push-9">
                            <br><a class="btn btn-danger conf" href="../../cerrar_sesion.php" rel>Cerrar sesión <span class="fa fa-sign-out"></span></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-sm-push-9">
                            <br><a class="btn btn-primary conf" href="../../config.html" rel>Configuración <span class="fa fa-cog"></span></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-sm-push-9">
                            <br><a class="btn btn-success conf" href="../../home.php" rel>Aceptar Miembros <span class="fa fa-user-plus"></span></a>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>                        
                        </button>
                        <a class="navbar-brand" href="../../home.php">Inicio</a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li class="dropdown active">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tesorería <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="tesoreria_balances.php">Ver Balances</a></li>
                                    <li><a href="tesoreria_recursos.php">Solicitar Recursos</a></li>
                                    <li class="active"><a href="tesoreria_admin_balances.php">Administrar balances</a></li>
                                    <li><a href="tesoreria_admin_recursos.php">Administrar Recursos</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="../actividades/actividades_reuniones.php">Reuniones</a></li>
                                    <li><a href="../actividades/actividades_historial.php">Historial de Actividades</a></li>
                                    <li><a href="../actividades/actividades_add_reuniones.html">Añadir Reuniones</a></li>
                                    <li><a href="../actividades/actividades_add_actividades.html">Añadir Actividades</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proyectos <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="../proyectos/proyectos_proyecto.php">Proyectos</a></li>
                                    <li><a href="../proyectos/proyectos_add_proyectos.php">Añadir Proyectos</a></li>
                                </ul>
                            </li>
                            <li><a href="../foro">Foro</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="page-header">
                <h1>Administrar balances</h1>
            </div>

            <div class="table-responsive">
                <table id="example" class="table table-striped cell-border">
                    <thead>
                        <tr>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                        </tr>
                        <tr>
                            <td>Mary</td>
                            <td>Moe</td>
                            <td>mary@example.com</td>
                        </tr>
                        <tr>
                            <td>July</td>
                            <td>Dooley</td>
                            <td>july@example.com</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>