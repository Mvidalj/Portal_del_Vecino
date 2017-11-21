<?php
    require_once 'validaciones/conexion_bd.php';

    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('index.php');
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
    <link rel="stylesheet" href="estilos/estilo.css">
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
        <li class="active" ><a href="foro.php">Foro</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          <li><button type="submit" class="btn btn-danger navbar-btn" name="join-create-org" data-toggle="modal" data-target="#news">+</button></li>
      </ul>
    </div>
  </div>
</nav>
</form>
    <div id="demo-frame">
        <iframe id="frame" src="modulos/foro"></iframe>
    </div>
</div>
<div>
    	<?php include("modal_accept_user.php");
              include("config.php");
              include("modal_orgs.php");?>			
</div>
</body>
</html>
