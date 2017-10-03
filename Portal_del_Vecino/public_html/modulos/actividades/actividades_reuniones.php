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
	            <li><a href="../tesoreria/tesoreria_balances.html">Ver Balances</a></li>
	            <li><a href="../tesoreria/tesoreria_recursos.html">Solicitar Recursos</a></li>
	            <li><a href="../tesoreria/tesoreria_add_balances.html">Añadir balances (*)</a></li>
	            <li><a href="../tesoreria/tesoreria_admin_recursos.html">Administrar Recursos (*)</a></li>
	          </ul>
	        </li>
	        <li class="dropdown active">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li class="active"><a href="actividades_reuniones.php">Reuniones</a></li>
	            <li><a href="actividades_historial.php">Historial de Actividades</a></li>
	            <li><a href="actividades_add_reuniones.html">Añadir Reuniones (*)</a></li>
                    <li><a href="actividades_add_actividades.html">Añadir Actividades (*)</a></li>
	          </ul>
	        </li>
	        <li class="dropdown">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proyectos <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="../proyectos/proyectos_proyecto.php">Proyectos</a></li>
	            <li><a href="../proyectos/proyectos_add_proyectos.php">Añadir Proyectos (*)</a></li>
	          </ul>
	        </li>
	        <li><a href="../foro/foro.html">Foro</a></li>
	    </div>
	  </div>
	</nav>

	<div class="row">
		<div class="col-sm-12">
			<h1>Reuniones:</h1>
			<hr>
			<div class="table-responsive">
				<table id="example" class="table table-striped cell-border">
				    <thead>
				     	<tr>
				        	<th class="col-sm-1 text-center">N°</th>
				        	<th class="col-sm-7">Descripcion</th>
				        	<th class="col-sm-2 ">Fecha</th>
				        	<th class="col-sm-2">Estado</th>
				      	</tr>
				    </thead>
				    <tbody>
                                        <?php
                                            require_once '../../validaciones/conexion_bd.php';
                                            try {
							$sql = $conn->prepare("SELECT * FROM reuniones");
							$sql->execute();
							while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
							echo "<tr>
									<td class='text-center'>".$result['ID_REUNION']."</td>
									<td>".$result['DESCRIPCION']."</td>
									<td class='text-center'>".$result['FECHA_REUNION']."</td>
									<td class='text-center'>".$result['ESTADO']."</td>
                                                              </tr>";
							}
                                                } 
                                                catch (Exception $e) {
                                                        echo "Error: " . $e->getMessage();
                                                }
                                        ?>
				    </tbody>
				</table>
			</div>
		</div>
	</div>
<br><br><br>
</div>
</body>
</html>
<script type="text/javascript" language="javascript" class="init">
	$(document).ready(function() {
		$('#example').DataTable( {
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
