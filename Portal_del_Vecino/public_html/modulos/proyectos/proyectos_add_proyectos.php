<?php
    require_once '../../validaciones/conexion_bd.php';
    
    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    }
	
	if(isset($_REQUEST['add_proyecto'])){
	try{
		$sentencia = $conn->prepare("INSERT INTO proyectos (ID_ORGANIZACION, NOMBRE, DESCRIPCION, FECHA_INICIO, FECHA_TERMINO)
		VALUES(1, :NOMBRE, :DESCRIPCION,:FECHA_INICIO,:FECHA_TERMINO)");
		$date_in = date('Y-m-d', strtotime($_POST['fecha_in']));
		$date_ter = date('Y-m-d', strtotime($_POST['fecha_ter']));
		$sentencia->bindParam(':NOMBRE', $_POST['nombre'],PDO::PARAM_STR);
		$sentencia->bindParam(':FECHA_INICIO', $date_in);
		$sentencia->bindParam(':FECHA_TERMINO', $date_ter); 
		$sentencia->bindParam(':DESCRIPCION', $_POST['desc'],PDO::PARAM_STR);
                if($sentencia->execute()){$user->Redirect('proyectos_proyecto.php');}  
		}catch(PDOException $e){
			echo 'Fallo la conexion:'.$e->GetMessage();
		}
	}
									
?>
<html>
<head>
    <title>Portal del Vecino</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/jquery.dataTables.min.css">
    <script src="../../librerias/jquery-3.2.1.js"></script>
    <script src="../../librerias/bootstrap.js"></script>
    <script src="../../librerias/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="container">
    <div class="jumbotron">
            <div class="row">
                <div class="col-sm-2">
                <img class="img-responsive" src="../../imagenes/home.jpg" width="130" height="130">
            </div>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-3 col-sm-push-9">
                        <br><a type="button" class="btn btn-danger conf" href="../../index.php" rel>Cerrar sesión <span class="fa fa-sign-out"></span></a>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-sm-push-9">
                            <br><a type="button" class="btn btn-primary conf" href="../../config.html" rel>Configuración <span class="fa fa-cog"></span></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-sm-push-9">
                            <br><a type="button" class="btn btn-success conf" href="../../home.html" rel>Aceptar Miembros (*) <span class="fa fa-user-plus"></span></a>
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
	        <li class="dropdown">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tesorería <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="../tesoreria/tesoreria_balances.php">Ver libro caja</a></li>
                    <li><a href="../tesoreria/tesoreria_recursos.php">Solicitar recursos</a></li>
                    <li><a href="../tesoreria/tesoreria_admin_balances.php">Administrar libro caja</a></li>
                    <li><a href="../tesoreria/tesoreria_admin_recursos.php">Administrar recursos</a></li>
	          </ul>
	        </li>
	        <li class="dropdown">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="../actividades/actividades_reuniones.php">Reuniones</a></li>
	            <li><a href="../actividades/actividades_historial.php">Historial de Actividades</a></li>
	            <li><a href="../actividades/actividades_add_reuniones.php">Añadir Reuniones (*)</a></li>
                    <li><a href="../actividades/actividades_add_actividades.php">Añadir Actividades (*)</a></li>
	          </ul>
	        </li>
	        <li class="dropdown active">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proyectos <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="proyectos_proyecto.php">Proyectos</a></li>
	            <li class="active"><a href="proyectos_add_proyectos.html">Añadir Proyectos (*)</a></li>
	          </ul>
	        </li>
	        <li><a href="../foro">Foro</a></li>
	    </div>
	  </div>
	</nav>

	<div class="row">
            <div class="col-sm-12">
                <h1>Añadir proyecto</h1>
                <hr>
                    <form action="proyectos_add_proyectos.php" method="post">
                        <div class="row ">
                            <div class="col-sm-6 col-sm-offset-3" >
                                <div class="row">
                                    <div class="col-sm-6">
                                    <label for="fecha_in">Fecha Inicio:</label>
                                    <input type="date" class="form-control" id="fecha_in" name="fecha_in">
                                </div>
                                <div class="col-sm-6 ">
                                    <label for="fecha_ter">Fecha Termino:</label>
                                    <input type="date" class="form-control" id="fecha_ter" name="fecha_ter">
                                </div><br><br><br><br>
                                <div class="col-sm-12">
                                    <label for="nombre">Nombre Proyecto:</label>
                                    <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre">
                                </div><br><br><br><br>
                                    <div class="col-sm-12 ">
                                    <label for="desc">Descripcion:</label>
                                    <textarea class="form-control" id="desc" rows="5" placeholder="Descripcion" name="desc"></textarea>
                                </div>
                                    <div class="col-sm-3 col-sm-offset-5">
                                    <br><button type="submit" class="btn btn-primary btn-md" name="add_proyecto">Guardar <span class="fa fa-save"></span></button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </form>
		</div>
	</div>
	<br><br><br>
</div>
</body>
</html>
