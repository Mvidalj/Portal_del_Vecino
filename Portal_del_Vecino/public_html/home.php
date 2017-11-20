<?php
    require_once 'validaciones/conexion_bd.php';
    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('index.php');
    } else {
        if($_SESSION['id_org']!= ""){

            $stmt = $querys->Actividades();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0){
                $Titulo_act = $userRow['NOMBRE'];
                $Finicio_act = $userRow['FECHA_INICIO'];
                $Ftermino_act = $userRow['FECHA_TERMINO'];
                $Fecha_act = "Desde el".$Finicio_act."Hasta el".$Ftermino_act;
            }else{
            $Titulo_act = "Lo sentimos no hay información disponible";
            $Fecha_act = "";
            }

            $stmt = $querys->Proyectos();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0){
                $Titulo_pro = $userRow['NOMBRE'];
                $Finicio_pro = $userRow['FECHA_INICIO'];
                $Ftermino_pro = $userRow['FECHA_TERMINO'];
                $Fecha_pro = "Desde el ".$Finicio_pro." Hasta el ".$Ftermino_pro;
            }else{
            $Titulo_pro = "Lo sentimos no hay información disponible";
            $Fecha_pro = "";
            }

            $stmt = $querys->Reuniones();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0){
                $Titulo_reu = $userRow['DESCRIPCION'];
                $Fecha_reu = "Se realizara el dia".$userRow['FECHA_REUNION'];
            }else{
            $Titulo_reu = "Lo sentimos no hay información disponible";
            $Fecha_reu = "";
            }

        }else{
            $Titulo_act = "Lo sentimos no hay información disponible";
            $Fecha_act = "";
            $Titulo_pro = "Lo sentimos no hay información disponible";
            $Fecha_pro = "";
            $Titulo_reu = "Lo sentimos no hay información disponible";
            $Fecha_reu = "";
        }
    }
    if(isset($_REQUEST['submit-create'])){
        if($_POST['comorg'] != 'DISABLED'){
            $querys->org_create($_POST['nameorg'],$_POST['comorg']);
        }else{
            echo "<script>alert('Seleccione una comuna')</script>";
        } 
    }
    
    if(isset($_REQUEST['submit_join'])){
        if($_POST['select_org'] != 'DISABLED'){
            $querys->org_join($_POST['select_org']);
            if ($_SESSION['id_org'] == ''){$user->Logout();}
        }else{
            echo "<script>alert('Seleccione una organización')</script>"; 
        }
    }
?>
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
    <script>
        $(document).ready(function(){
            $("#news").modal();

            $("#createorg").click(function(){
                $("#form-createorg").show();
                $("#form-uniteorg").hide();
            });
            $("#uniteorg").click(function(){
                $("#form-uniteorg").show();
                $("#form-createorg").hide();
            });
        });
        function reSend() {
            document.querySelectorAll("button[type=submit]")[0].click();
        }
    </script>
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <div class="row">
            <div class="col-sm-2 col-xs-6">
                <img class="img-responsive" src="imagenes/home.jpg" width="130" height="130">
            </div>
            <div class="col-sm-6 col-sm-push-1 col-xs-6">
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <?php
                        if (file_exists("imagenes/".$_SESSION["id_usuario"].".".$_SESSION["extensionimage"]."")){
                            echo '<img src="imagenes/'.$_SESSION["id_usuario"].'.'.$_SESSION["extensionimage"].'" width="100" height="100">';
                        }else{ echo '<img src="imagenes/testimage.jpg" width="100" height="100">';}
                        ?>
                    </div>
                    <div class="col-sm-9">
                        <h3>Bienvenido <?php echo $_SESSION["nombre"]." ". $_SESSION["apellido"]?></h3>
                    </div>
                    <div class="col-sm-3">
                        <h4>Organización:</h4> 
                    </div>
                    <div class="col-sm-6">
                        <form name="form" action="home.php" method="POST">
                            <button type="submit" id="submit-buscar" name="submit-buscar" hidden></button>
                            <select class="form-control" id="morg" name="morg" onchange="reSend()">
                                <?php   
                                    $data = $querys->org_select();
                                    if(isset($_REQUEST['submit-buscar'])){
                                        $querys->org_update($data,$_POST['morg']);
                                    }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-sm-push-1">
                <div class="row">
                    <div class="col-sm-10 col-sm-push-2">
                        <br><a type="button" class="btn btn-danger conf" href="cerrar_sesion.php" rel>Cerrar sesión <span class="fa fa-sign-out"></span></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10 col-sm-push-2">
                        <br><a type="button" class="btn btn-primary conf" data-toggle="modal" data-target="#config" rel>Configuración <span class="fa fa-cog"></span></a>
                    </div>
                </div>
                <?php
                if($_SESSION['id_rol'] == "1"){
                    echo '
                <div class="row">
                <div class="col-sm-10 col-sm-push-2">
                    <br><a type="button" class="btn btn-success conf" data-toggle="modal" data-target="#new_user" rel>Administrar Miembros <span class="fa fa-user-plus"></span></a>
                </div>
                </div>';}?>
            </div>
        </div>
    </div>
    <form>
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
        <li><a href="modulos/proyectos/proyectos_proyecto.php">Proyectos</a></li>
        <li><a href="foro.php">Foro</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          <li><button type="submit" class="btn btn-primary navbar-btn" name="join-create-org" data-toggle="modal" data-target="#news">+</button></li>
      </ul>
    </div>
  </div>
</nav>
    </form>
<?php   
    if($_SESSION['id_org'] == "" || isset($_REQUEST['join-create-org'])){
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
                                    <input type="text" class="form-control" id="nameorg" name="nameorg" required><br>
                                    <label for="comorg" >Comuna: </label>
                                    <select class="form-control" id="comorg" name="comorg">
                                        <option value='DISABLED' hidden selected>Comuna</option>
                                        <?php  $stmt = $querys->comunas();
                                            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<option value=".$result['ID_COMUNA'].">".$result['COMUNA']."</option>";
                                            }
                                        ?>
                                    </select><br>
                                    <input type="submit" id="submit-create" name="submit-create" class="btn btn-success" value="Registrar organización">
                                </fieldset>
                            </form>
                        </div>
                        <div id="form-uniteorg">
                            <form action="home.php" method="POST">
                                <fieldset>
                                    <legend>Unirse a organización</legend>
                                    <label for="select-org" >Organizacion: </label>
                                    <select class="form-control" id="select-org" name="select_org">
                                        <option value='DISABLED' hidden selected>Organización</option>
                                <?php   $stmt = $querys->organizaciones();
                                        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                           echo "<option value='".$result['ID_ORGANIZACION']."'>".$result['NOMBRE']."</option>";
                                       }
                                ?>
                                    </select><br>
                                    <input type="submit" id="submit-join" name="submit_join" class="btn btn-success" value="Unirse a organización">
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
                  <p><?php echo $Fecha_act;?></p>
                </div>
              </div>
            
              <div class="item">
                <img class="center-image" src="imagenes/prueba.png" alt="Fiestas patrias">
                <div class="carousel-caption">
                  <h3><?php echo $Titulo_pro;?></h3>
                  <p><?php echo $Fecha_pro;?></p>
                </div>
              </div>
            
              <div class="item">
                <img class="center-image" src="imagenes/prueba.png" alt="Fiestas patrias">
                <div class="carousel-caption">
                  <h3><?php echo $Titulo_reu;?></h3>
                  <p><?php echo $Fecha_reu;?></p>
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
    <div>	
	<?php include("modal_accept_user.php");
              include("config.php");?>		
    </div>
</body>
</html>