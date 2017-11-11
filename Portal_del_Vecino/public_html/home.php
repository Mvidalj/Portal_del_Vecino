<?php
    require_once 'validaciones/conexion_bd.php';

    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('index.php');
    } else {
        if($_SESSION['id_org']!= ""){
            $stmt = $conn->prepare("SELECT * FROM ACTIVIDADES WHERE ID_ORGANIZACION=".$_SESSION['id_org']."");
            $stmt->execute();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0){
                $Titulo_act = $userRow['NOMBRE'];
                $Finicio_act = $userRow['FECHA_INICIO'];
                $Ftermino_act = $userRow['FECHA_TERMINO'];
                $Feach_act = "Desde el".$Finicio_act."Hasta el".$Ftermino_act;
            }else{
            $Titulo_act = "Lo sentimos no hay información disponible";
            $Fecha_act = "";
            }
            $stmt = $conn->prepare("SELECT * FROM PROYECTOS WHERE ID_ORGANIZACION=".$_SESSION['id_org']."");
            $stmt->execute();
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
            $stmt = $conn->prepare("SELECT * FROM REUNIONES WHERE ID_ORGANIZACION=".$_SESSION['id_org']."");
            $stmt->execute();
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
        function reSend() {
            document.querySelectorAll("button[type=submit]")[0].click();
        }
    </script>
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <div class="row">
            <div class="col-sm-2">
                <img class="img-responsive" src="imagenes/home.jpg" width="130" height="130">
            </div>
            <div class="col-sm-6 col-sm-push-1">
                <div class="row">
                    <div class="col-sm-3">
                        <img src="imagenes/testimage.jpg" width="100" height="100">
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
                                <?php  $stmt = $conn->prepare("SELECT * FROM ASOCIADOS, ORGANIZACIONES WHERE "
                                        . "ASOCIADOS.ID_ORGANIZACION = ORGANIZACIONES.ID_ORGANIZACION and ID_USUARIO = :id_usr");
                                    $stmt->bindParam(':id_usr', $_SESSION['id_usuario']);
                                    $stmt->execute();
                                    $data = array();$count = 0;
                                    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        array_push($data,$result['ID_USUARIO'],$result['ID_ORGANIZACION'],$result['ID_ROL']);
                                        if ($result['ID_ORGANIZACION'] == $_SESSION['id_org']){
                                            echo "<option value='".$count."' selected>".$result['NOMBRE']."</option>";
                                        }else{
                                            echo "<option value='".$count."'>".$result['NOMBRE']."</option>";
                                        }
                                        $count += 3;
                                    }
                                    if(isset($_REQUEST['submit-buscar'])){
                                        $cont = $_POST['morg'];
                                        try{
                                            $stmt = $conn->prepare("UPDATE usuarios SET ID_ORGANIZACION = :id_org, ID_ROL = :id_rol "
                                                    . "WHERE usuarios.ID_USUARIO = :id_usr");
                                            $stmt->bindParam(':id_usr', $data[$cont+0]);
                                            $stmt->bindParam(':id_org', $data[$cont+1]);
                                            $stmt->bindParam(':id_rol', $data[$cont+2]);
                                            if($stmt->execute()){
                                                $_SESSION['id_org'] = $data[$cont+1];
                                                $_SESSION['id_rol'] = $data[$cont+2];
                                                $user->Redirect('home.php');
                                            }
                                        }catch(PDOException $e){
                                            echo "<script>alert('Hubo un error, intentelo nuevamentes')</script>";
                                        }
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
                        <br><a type="button" class="btn btn-primary conf" href="config.php" rel>Configuración <span class="fa fa-cog"></span></a>
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
            if($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "3"){
                echo '<li><a href="modulos/tesoreria/tesoreria_admin_recursos.php">Administrar recursos</a></li>';}?> 
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
        <li><a href="modulos/foro" target="_blank">Foro</a></li>
        <li><form><button type="submit" class="btn btn-primary" name="join-create-org" data-toggle="modal" data-target="#news">+</button></form></li>
      </ul>
    </div>
  </div>
</nav>
<?php   
    if(isset($_REQUEST['submit-create'])){ 
        $stmt =$conn->prepare('SELECT NOMBRE FROM organizaciones WHERE NOMBRE = :nom');
        $stmt->bindParam(':nom', $_POST['nameorg']);
        $stmt->execute();
        if($stmt->rowCount() == 0){
            $stmt = $conn->prepare('INSERT INTO organizaciones (id_comuna, nombre)
            VALUES(:com,:nom)');
            $stmt->bindParam(':com', $_POST['comorg']);
            $stmt->bindParam(':nom', $_POST['nameorg']);
            $stmt->execute();
            $stmt =$conn->prepare('SELECT ID_ORGANIZACION FROM organizaciones WHERE NOMBRE = :nom');
            $stmt->bindParam(':nom', $_POST['nameorg']);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = $conn->prepare('UPDATE usuarios SET ID_ORGANIZACION = :id_org, ID_ROL = 1 WHERE ID_USUARIO = :id_usr');
            $stmt->bindParam(':id_org', $result['ID_ORGANIZACION']);
            $stmt->bindParam(':id_usr', $_SESSION['id_usuario']);
            $stmt->execute();
            $_SESSION['id_org']=$result['ID_ORGANIZACION'];
            $_SESSION['id_rol']=1;
            $stmt = $conn->prepare("INSERT INTO asociados (ID_USUARIO, ID_ORGANIZACION, ID_ROL) values (:id_usr, :id_org, 1)");
            $stmt->bindparam(":id_usr", $_SESSION['id_usuario']);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute();
            echo "<script>alert('Organización creada correctamente.');window.location.href='home.php';</script>";
        }
        else{
            echo "<script>alert('Nombre de organización ya en uso')</script>";
        }
    }
    
    if(isset($_REQUEST['submit_join'])){
        $stmt = $conn->prepare("INSERT INTO solicitudes(ID_USUARIO,ID_ORGANIZACION,ESTADO)
                                VALUES (:id_usr,:id_org,2)");
        $stmt->bindParam(':id_usr', $_SESSION['id_usuario']);
        $stmt->bindParam(':id_org', $_POST['select_org']);
        $stmt->execute();
    }
       
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
                                    <input type="text" class="form-control" id="nameorg" name="nameorg"><br>
                                    <label for="comorg" >Comuna: </label>
                                    <select class="form-control" id="comorg" name="comorg">
                                        <option value="" disabled selected>Comuna</option>
                                        <?php  $sql = $conn->prepare("SELECT * FROM COMUNA ORDER BY COMUNA ASC ");
                                            $sql->execute();
                                            while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
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
                                <?php  $sql = $conn->prepare("SELECT * FROM organizaciones ORDER BY NOMBRE ASC");
                                       $sql->execute();
                                       while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
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
	<?php include("modal_accept_user.php");?>		
    </div>
</body>
</html>