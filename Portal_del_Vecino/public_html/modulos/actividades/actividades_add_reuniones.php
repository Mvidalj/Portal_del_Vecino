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
	      <a class="navbar-brand" href="../../home.html">Inicio</a>
	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="nav navbar-nav">
	        <li class="dropdown">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tesorería <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="../tesoreria/tesoreria_balances.php">Ver libro caja</a></li>
                    <li><a href="../tesoreria/tesoreria_resumen.php">Ver resumen</a></li>
                    <li><a href="../tesoreria/tesoreria_recursos.php">Solicitar recursos</a></li>
                    <li><a href="../tesoreria/tesoreria_admin_balances.php">Administrar libro caja</a></li>
                    <li><a href="../tesoreria/tesoreria_admin_recursos.php">Administrar recursos</a></li>
	          </ul>
	        </li>
	        <li class="dropdown active">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="actividades_reuniones.php">Reuniones</a></li>
	            <li><a href="actividades_historial.php">Historial de Actividades</a></li>
	            <li class="active"><a href="actividades_add_reuniones.php">Añadir Reuniones (*)</a></li>
                    <li><a href="actividades_add_actividades.php">Añadir Actividades (*)</a></li>
	          </ul>
	        </li>
	        <li class="dropdown">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proyectos <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="../proyectos/proyectos_proyecto.php">Proyectos</a></li>
	            <li><a href="../proyectos/proyectos_add_proyectos.php">Añadir Proyectos (*)</a></li>
	          </ul>
	        </li>
	        <li><a href="../foro">Foro</a></li>
	    </div>
	  </div>
	</nav>

	<div class="row">
		<div class="col-sm-12">
			<h1>Añadir reunion</h1>
			<hr>
			<form>
				<div class="row ">
					<div class="col-sm-4 col-sm-offset-4" >
						<div class="row">
							<div class="col-sm-12">
					    		<label for="fecha_in">Fecha Inicio:</label>
					    		<input type="date" class="form-control" id="fecha_in">
					    	</div>
					    	<div class="col-sm-12 ">
					    		<label for="desc">Descripcion:</label>
					    		<textarea name="" class="form-control" id="desc" rows="5" placeholder="Descripcion"></textarea>
					    	</div>
							<div class="col-sm-4 col-sm-offset-4">
					    		<br><a type="button" class="btn btn-primary btn-md" href="../../home.php">Guardar <span class="fa fa-save"></span></a>
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