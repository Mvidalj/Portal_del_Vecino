<?php
    require_once '../../validaciones/conexion_bd.php';
 
    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    }
    if(isset($_REQUEST['delete'])){
        $id = $_POST['delete'];
	try{
            $sentencia = $conn->prepare("UPDATE proyectos SET ELIMINADO = 1 WHERE ID_PROYECTO= :ID");
            $sentencia->bindParam(':ID', $id,PDO::PARAM_INT);
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

    <?php
    if($_SESSION['id_rol'] == "1")
        {
        echo 
        '                <div class="row">
                    <div class="col-sm-3 col-sm-push-9">
                        <br><a type="button" class="btn btn-success conf" href="../../home.php" rel>Aceptar Miembros (*) <span class="fa fa-user-plus"></span></a>
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
                    <li><a href="../tesoreria/tesoreria_resumen.php">Ver resumen</a></li>
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
	            <li class="active"><a href="proyectos_proyecto.php">Proyectos</a></li>
	            <li><a href="proyectos_add_proyectos.php">Añadir Proyectos (*)</a></li>
	          </ul>
	        </li>
	        <li><a href="../foro">Foro</a></li>
	    </div>
	  </div>
	</nav>';
        }
    else {
        echo 
        '                <div class="row">
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
	            <li><a href="../tesoreria/tesoreria_balances.php">Ver Balances</a></li>
	            <li><a href="../tesoreria/tesoreria_recursos.php">Solicitar Recursos</a></li>
	          </ul>
	        </li>
	        <li class="dropdown">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="../actividades/actividades_reuniones.php">Reuniones</a></li>
	            <li><a href="../actividades/actividades_historial.php">Historial de Actividades</a></li>
	          </ul>
	        </li>
	        <li class="dropdown active">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proyectos <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li class="active"><a href="proyectos_proyecto.php">Proyectos</a></li>
	          </ul>
	        </li>
	        <li><a href="../foro">Foro</a></li>
	    </div>
	  </div>
	</nav>';
 }
    ?>
	<div class="row">
            <div class="col-sm-12">
                <h1>Proyectos<small> (Vigentes)</small></h1>
                <hr>
                <div class="table-responsive">
                    <form action="proyectos_proyecto.php" method='POST'>
                        <table id="example" class="table table-striped cell-border">
                            <thead>
                                <tr>
                                    <?php
                                    if($_SESSION['id_rol'] == "1")
                                        {
                                        echo '
                                    <th class="col-sm-1 text-center">N°</th>
                                    <th class="col-sm-4">Nombre</th>
                                    <th class="col-sm-3 ">Fecha Inicio</th>
                                    <th class="col-sm-3">Fecha Termino</th>
                                    <th class="col-sm-1">Opciones</th>';
                                        }
                                    else{
                                        echo '
                                    <th class="col-sm-2 text-center">N°</th>
                                    <th class="col-sm-4">Nombre</th>
                                    <th class="col-sm-3 ">Fecha Inicio</th>
                                    <th class="col-sm-3">Fecha Termino</th>';
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    try {
                                        $sql = $conn->prepare("SELECT * FROM proyectos");#se prepara la consulta
                                        $sql->execute();                                 #se ejecuta la consulta
                                        while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {#obtiene los datos de la consulta
                                        if($result['ELIMINADO'] == '0'){
                                            if($_SESSION['id_rol'] == "1")
                                                {
                                                echo "
                                                <tr>                                       
                                                  <td class='text-center'>".$result['ID_PROYECTO']."</td>
                                                  <td>".$result['NOMBRE']."</td>
                                                  <td class='text-center'>".$result['FECHA_INICIO']."</td>
                                                  <td class='text-center'>".$result['FECHA_TERMINO']."</td>
                                                  <td class='text-center'>
                                                  <a href='proyectos_edit.php?id=".$result['ID_PROYECTO']."'><span class='fa fa-pencil'></span></a>
                                                  <button type='submit' class='btn-link' name='delete' id='asd2' value=".$result['ID_PROYECTO'].">
                                                  <span class='fa fa-times'></span>
                                                  </button>
                                                  </td>
                                                </tr>";
                                                } # por cada dato crea una columna
                                            else
                                                {
                                                echo "
                                                <tr>                                       
                                                  <td class='text-center'>".$result['ID_PROYECTO']."</td>
                                                  <td>".$result['NOMBRE']."</td>
                                                  <td class='text-center'>".$result['FECHA_INICIO']."</td>
                                                  <td class='text-center'>".$result['FECHA_TERMINO']."</td>
                                                </tr>";
                                                }
                                        }}
                                    }
                                    catch (Exception $e) {
                                        echo "Error: " . $e->getMessage();#captura el error y lo muestra
                                    }
                                ?>
                            </tbody>
                        </table>
                        </form>
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
