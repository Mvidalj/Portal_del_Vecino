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
                            $(document).ready(function(){
                                $("#createorg").click(function(){
                                    $("#form-createorg").show();
                                    $("#form-uniteorg").hide();
                                });
                                $("#uniteorg").click(function(){
                                    $("#form-uniteorg").show();
                                    $("#form-createorg").hide();
                                });
                            });
                        </script>
                </head>
                <body>
                <div class="container">
        ';
        if($_SESSION['id_org']!= ""){
            $stmt = $conn->prepare("SELECT * FROM ACTIVIDADES WHERE ID_ORGANIZACION=".$_SESSION['id_org']."");
            $stmt->execute();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                    $Titulo_act = $userRow['NOMBRE'];
                    $Finicio_act = $userRow['FECHA_INICIO'];
                    $Ftermino_act = $userRow['FECHA_TERMINO'];
                }
            $stmt = $conn->prepare("SELECT * FROM PROYECTOS WHERE ID_ORGANIZACION=".$_SESSION['id_org']."");
            $stmt->execute();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                    $Titulo_pro = $userRow['NOMBRE'];
                    $Finicio_pro = $userRow['FECHA_INICIO'];
                    $Ftermino_pro = $userRow['FECHA_TERMINO'];
                }
            $stmt = $conn->prepare("SELECT * FROM REUNIONES WHERE ID_ORGANIZACION=".$_SESSION['id_org']."");
            $stmt->execute();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                    $Titulo_reu = $userRow['DESCRIPCION'];
                    $Fecha_reu = $userRow['FECHA_REUNION'];
                }
        }
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
                                        <br><a class="btn btn-primary conf" href="config.php" rel>Configuración <span class="fa fa-cog"></span></a>
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
                                                <li><a href="modulos/tesoreria/tesoreria_balances.php">Ver libro caja</a></li>
                                                <li><a href="modulos/tesoreria/tesoreria_recursos.php">Solicitar recursos</a></li>
                                                <li><a href="modulos/tesoreria/tesoreria_admin_balances.php">Administrar libro caja</a></li>
                                                <li><a href="modulos/tesoreria/tesoreria_admin_recursos.php">Administrar recursos</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="modulos/actividades/actividades_reuniones.php">Reuniones</a></li>
                                                <li><a href="modulos/actividades/actividades_historial.php">Historial de Actividades</a></li>
                                                <li><a href="modulos/actividades/actividades_add_reuniones.php">Añadir Reuniones</a></li>
                                                <li><a href="modulos/actividades/actividades_add_actividades.php">Añadir Actividades</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proyectos <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="modulos/proyectos/proyectos_proyecto.php">Proyectos</a></li>
                                                <li><a href="modulos/proyectos/proyectos_add_proyectos.php">Añadir Proyectos</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="modulos/foro">Foro</a></li>
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
                                            <br><a class="btn btn-primary conf" href="config.php" rel>Configuración <span class="fa fa-cog"></span></a>
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
    if(isset($_REQUEST['submit-create'])){
        echo "<script>alert('Estamos trabajando para usted')</script>";
    }
    
    if(isset($_REQUEST['submit-join'])){
        echo "<script>alert('Estamos trabajando para usted')</script>";
    }
    
    if($_SESSION['id_org'] == ""){
?>
        <!-- Modal -->
        <div class="modal fade" id="news" role="dialog">
            <div class="modal-dialog">
        <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="btn btn-primary" id="createorg">Crear una organización</button>
                        <button class="btn btn-primary" id="uniteorg">Unirse a una organización</button>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="form-createorg" class="collapse">
                            <form action="home.php" method="POST">
                                <fieldset>
                                    <legend>Registrar organización</legend>
                                    <label for="nameorg" >Nombre de organización: </label>
                                    <input type="text" class="form-control" id="nameorg" name="nameorg"><br>
                                    <label for="comorg" >Comuna: </label>
                                    <select class="form-control" id="comorg" name="comorg">
                                        <option value="" disabled selected>Comuna</option>
                                        <option value="0">Agregar dinamicamente</option>
                                    </select><br>
                                    <input type="submit" id="submit-create" name="submit-create" class="btn btn-success" value="Registrar organización">
                                </fieldset>
                            </form>
                        </div>
                        <div id="form-uniteorg">
                            <form action="home.php" method="POST">
                                <fieldset>
                                    <legend>Unirse a organización</legend>
                                    <label for="select-org" >Comuna: </label>
                                    <select class="form-control" id="select-org" name="select-org">
                                        <option value="" disabled selected>Organización</option>
                                <?php  $sql = $conn->prepare("SELECT * FROM organizaciones");
                                       $sql->execute();
                                       while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                           echo "<option value='".$result['ID_ORGANIZACION']."'>".$result['NOMBRE']."</option>";
                                       }
                                ?>
                                    </select><br>
                                    <input type="submit" id="submit-join" name="submit-join" class="btn btn-success" value="Unirse a organización">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    </div>
                </div>
            </div>
        </div>
<?php
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
                <img class="center-image" src="imagenes/prueba.png" alt="Fiestas patrias">
                <div class="carousel-caption">
                    <h3><?php echo $Titulo_act;?></h3>
                  <p><?php echo "Desde el".$Finicio_act."Hasta el".$Ftermino_act;?></p>
                </div>
              </div>
            
              <div class="item">
                <img class="center-image" src="imagenes/prueba.png" alt="Fiestas patrias">
                <div class="carousel-caption">
                  <h3><?php echo $Titulo_pro;?></h3>
                  <p><?php echo "Desde el ".$Finicio_pro." Hasta el ".$Ftermino_pro;?></p>
                </div>
              </div>
            
              <div class="item">
                <img class="center-image" src="imagenes/prueba.png" alt="Fiestas patrias">
                <div class="carousel-caption">
                  <h3><?php echo $Titulo_reu;?></h3>
                  <p><?php echo "Se realizara el dia".$Fecha_reu?></p>
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