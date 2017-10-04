<?php
    require_once 'validaciones/conexion_bd.php';

    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('index.php');
    } else {
        echo '
            <!DOCTYPE html>
                <html>
                <head>
                        <title>Portal del Vecino</title>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                        <link rel="stylesheet" href="css/font-awesome.min.css">
                        <link rel="stylesheet" href="css/bootstrap.css">
                        <script src="librerias/jquery-3.2.1.js"></script>
                        <script src="js/bootstrap.min.js"></script>
                        <link rel="stylesheet" href="css/bootstrap.min.css">
                        <script>
                            $(document).ready(function(){
                                $("#news").modal();
                            });
                        </script>
                </head>
                <body>
                <div class="container">
        ';
        if($_SESSION['id_rol'] == "1"){
?>
                        <div class="jumbotron">
                            <div class="row">
                                <div class="col-sm-2">
                                <img class="img-responsive" src="imagenes/home.jpg" width="130" height="130" alt="Icono de pagina">
                            </div>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-3 col-sm-push-9">
                                        <br><a class="btn btn-danger conf" href="cerrar_sesion.php" rel>Cerrar sesión <span class="fa fa-sign-out"></span></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 col-sm-push-9">
                                        <br><a class="btn btn-primary conf" href="config.html" rel>Configuración <span class="fa fa-cog"></span></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 col-sm-push-9">
                                        <br><a class="btn btn-success conf" href="home.php" rel>Aceptar Miembros <span class="fa fa-user-plus"></span></a>
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
                                                <li><a href="modulos/tesoreria/tesoreria_balances.php">Ver Balances</a></li>
                                                <li><a href="modulos/tesoreria/tesoreria_recursos.php">Solicitar Recursos</a></li>
                                                <li><a href="modulos/tesoreria/tesoreria_admin_balances.php">Administrar balances</a></li>
                                                <li><a href="modulos/tesoreria/tesoreria_admin_recursos.php">Administrar Recursos</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="modulos/actividades/actividades_reuniones.php">Reuniones</a></li>
                                                <li><a href="modulos/actividades/actividades_historial.php">Historial de Actividades</a></li>
                                                <li><a href="modulos/actividades/actividades_add_reuniones.html">Añadir Reuniones</a></li>
                                                <li><a href="modulos/actividades/actividades_add_actividades.html">Añadir Actividades</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proyectos <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="modulos/proyectos/proyectos_proyecto.php">Proyectos</a></li>
                                                <li><a href="modulos/proyectos/proyectos_add_proyectos.php">Añadir Proyectos</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="modulos/foro/foro.html">Foro</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
<?php
        } else { 
?>
                        <div class="jumbotron">
                            <div class="row">
                                <div class="col-sm-2">
                                    <img class="img-responsive" src="imagenes/home.jpg" width="130" height="130" alt="Icono de pagina">
                                </div>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-3 col-sm-push-9">
                                            <br><a class="btn btn-danger conf" href="cerrar_sesion.php" rel>Cerrar sesión <span class="fa fa-sign-out"></span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 col-sm-push-9">
                                            <br><a class="btn btn-primary conf" href="config.html" rel>Configuración <span class="fa fa-cog"></span></a>
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
                                                <li><a href="modulos/tesoreria/tesoreria_balances.php">Ver Balances</a></li>
                                                <li><a href="modulos/tesoreria/tesoreria_recursos.php">Solicitar Recursos</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="modulos/actividades/actividades_reuniones.php">Reuniones</a></li>
                                                <li><a href="modulos/actividades/actividades_historial.php">Historial de Actividades</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proyectos <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="modulos/proyectos/proyectos_proyecto.php">Proyectos</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="modulos/foro/foro.html">Foro</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
<?php   
        }
    }
?>


	

	<div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
              <div class="item active">
                <img class="center-image" src="imagenes/testimage.jpg" alt="Fiestas patrias">
                <div class="carousel-caption">
                  <h3>Titulo noticia</h3>
                  <p>Cuerpo noticia</p>
                </div>
              </div>
            
              <div class="item">
                <img class="center-image" src="imagenes/testimage.jpg" alt="Fiestas patrias">
                <div class="carousel-caption">
                  <h3>Titulo noticia</h3>
                  <p>Cuerpo noticia</p>
                </div>
              </div>
            
              <div class="item">
                <img class="center-image" src="imagenes/testimage.jpg" alt="Fiestas patrias">
                <div class="carousel-caption">
                  <h3>Titulo noticia</h3>
                  <p>Cuerpo noticia</p>
                </div>
              </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
</div>
</body>
</html>
