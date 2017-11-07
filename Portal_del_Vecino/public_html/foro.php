<?php
    require_once 'validaciones/conexion_bd.php';

    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('index.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Portal del Vecino</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/jquery.dataTables.min.css">
    <script src="librerias/jquery-3.2.1.js"></script>
    <script src="librerias/bootstrap.js"></script>
    <script src="librerias/jquery.dataTables.min.js"></script>
    <style>
        #demo-frame  { /* necessary because it for some reason doesn't work with the iframe */
        position: absolute;
        width: 85%;
        height: 100%;
        
        border: 0;
        }

        #demo-frame iframe {
	    position: absolute;
        width: 100%;
        height: 100%;
        border: 0;
        }
      </style>
</head>
<body>
<div class="container">
    <div class="jumbotron">
            <div class="row">
                    <div class="col-sm-2">
                    <img class="img-responsive" src="imagenes/home.jpg" width="130" height="130">
            </div>
            <div class="col-sm-10">
                    <div class="row">
                            <div class="col-sm-3 col-sm-push-9">
                                    <br><a type="button" class="btn btn-danger conf" href="cerrar_sesion.php" rel>Cerrar sesión <span class="fa fa-sign-out"></span></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-sm-push-9">
                                    <br><a type="button" class="btn btn-primary conf" href="#" rel>Configuración <span class="fa fa-cog"></span></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-sm-push-9">
                                    <br><a type="button" class="btn btn-success conf" data-toggle="modal" data-target="#new_user" rel>Aceptar Miembros <span class="fa fa-user-plus"></span></a>
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
          <a class="navbar-brand" href="home.php">Inicio</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tesorería <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="modulos/tesoreria/tesoreria_balances.php">Ver libro caja</a></li>
                <li><a href="modulos/tesoreria/tesoreria_recursos.php">Solicitar recursos</a></li>
                <?php
                if($_SESSION['id_rol'] == "1"){
                    echo '      
                <li><a href="modulos/tesoreria/tesoreria_admin_balances.php">Administrar libro caja</a></li>
                <li><a href="modulos/tesoreria/tesoreria_admin_recursos.php">Administrar recursos</a></li>';}?> 
              </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="modulos/actividades/actividades_reuniones.php">Reuniones</a></li>
                    <li><a href="modulos/actividades/actividades_historial.php">Historial de Actividades</a></li>
                </ul>
            </li>
            <li><a href="modulos/proyectos/proyectos_proyecto.php">Proyectos</a></li>
            <li class="active"><a href="foro.php">Foro</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <div id="demo-frame">
        <iframe id="frame" src="modulos/foro"></iframe>
    </div>
</div>
    
    
<div>	
    <?php include("modal_accept_user.php");?>		
</div>
</body>
</html>