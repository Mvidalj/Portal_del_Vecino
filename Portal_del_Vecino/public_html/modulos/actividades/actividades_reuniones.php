<?php
    require_once '../../validaciones/conexion_bd.php';

    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    }
    
    if(isset($_REQUEST['submit-edit'])){
        try{   
            $sentencia = $conn->prepare("UPDATE reuniones SET DESCRIPCION= :DESC, FECHA_REUNION= :FECHIN, ESTADO = :STATE, ACTA_REUNION = ' ' WHERE ID_REUNION= :ID");
            $sentencia->bindParam(':FECHIN', date('Y-m-d', strtotime($_POST['edit_date'])));
            $sentencia->bindParam(':STATE', $_POST['edit_state']);
            $sentencia->bindParam(':DESC', $_POST['edit_desc']);
            $sentencia->bindParam(':ID', $_POST['id_reunion']);
            $sentencia->execute();
        }catch(PDOException $e){
            echo 'Fallo la conexion:'.$e->GetMessage();
        }
    }
        
    if(isset($_REQUEST['submit-delete'])){
        try{   
            $sentencia = $conn->prepare("UPDATE reuniones SET ESTADO = 'CANCELADO' WHERE ID_REUNION= :ID");
            $sentencia->bindParam(':ID', $_POST['id_reunion']);
            $sentencia->execute();
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
    <?php
        if($_SESSION['id_rol'] == "1"){                
            echo   "<li><a href='../tesoreria/tesoreria_admin_balances.php'>Administrar libro caja</a></li>
                    <li><a href='../tesoreria/tesoreria_admin_recursos.php'>Administrar recursos</a></li>";
        }
    ?>
	          </ul>
	        </li>
	        <li class="dropdown active">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li class="active"><a href="actividades_reuniones.php">Reuniones</a></li>
	            <li><a href="actividades_historial.php">Historial de Actividades</a></li>
    <?php
        if($_SESSION['id_rol'] == "1"){
            echo   "<li><a href='actividades_add_reuniones.php'>Añadir Reuniones (*)</a></li>
                    <li><a href='actividades_add_actividades.php'>Añadir Actividades (*)</a></li>";
        }
    ?>
	          </ul>
	        </li>
	        <li class="dropdown">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proyectos <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="../proyectos/proyectos_proyecto.php">Proyectos</a></li>
    <?php
        if($_SESSION['id_rol'] == "1"){
	    echo   "<li><a href='../proyectos/proyectos_add_proyectos.php'>Añadir Proyectos (*)</a></li>";
        }
    ?>
	          </ul>
	        </li>
	        <li><a href="../foro">Foro</a></li>
	    </div>
	  </div>
	</nav>

	<div class="row">
		<div class="col-sm-12">
			<h1>Reuniones:</h1>
			<hr>
			<div class="table-responsive">
                            <form action="actividades_reuniones.php" method='POST'>
				<table id="example" class="table table-striped cell-border">
				    <thead>
				     	<tr>
                                            <th class="col-sm-7">Descripcion</th>
                                            <th class="col-sm-2 ">Fecha</th>
                                            <th class="col-sm-2">Estado</th>
                                            <?php if($_SESSION['id_rol'] == "1"){echo '<th class="col-sm-1">Opciones</th>';}?>
				      	</tr>
				    </thead>
				    <tbody>
                                        <?php
                                            try {
                                                $sql = $conn->prepare("SELECT * FROM reuniones");
                                                $sql->execute();
                                                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    if($result['ESTADO'] != 'CANCELADO'){
                                                        echo "<tr>
                                                                <td>".$result['DESCRIPCION']."</td>
                                                                <td class='text-center'>".$result['FECHA_REUNION']."</td>
                                                                <td class='text-center'>".$result['ESTADO']."</td>";
                                                        if($_SESSION['id_rol'] == "1"){
                                                            if($result['ESTADO'] == 'PENDIENTE'){
                                                                $options = "<option value='PENDIENTE' selected>Pendiente</option>
                                                                            <option value='REALIZADO'>Realizado</option>
                                                                            ";
                                                            }
                                                            if($result['ESTADO'] == 'REALIZADO'){
                                                                $options = "<option value='PENDIENTE'>Pendiente</option>
                                                                            <option value='REALIZADO' selected>Realizado</option>
                                                                            ";
                                                            }
                                                            echo
                                                            "<td>
                                                                <form action='actividades_reuniones.php' method='POST'>
                                                                    <input type='hidden' id='id_reunion' name='id_reunion' value='".$result['ID_REUNION']."'>
                                                                    <button type='button' class='btn btn-info' id='edit_reunion' name='edit_reunion' data-toggle='modal' data-target='#".$result['ID_REUNION']."'><i class='fa fa-edit'></i></button>
                                                                    <!-- Modal -->
                                                                    <div id='".$result['ID_REUNION']."' class='modal fade' role='dialog'>
                                                                        <div class='modal-dialog'>
                                                                        <!-- Modal content-->
                                                                            <div class='modal-content'>
                                                                                <div class='modal-header'>
                                                                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                                                    <h4 class='modal-title'>Editar reunión</h4>
                                                                                </div>
                                                                                <div class='modal-body'>
                                                                                    <label>Fecha: </label>
                                                                                    <input type='text' class='form-control' id='edit_date' name='edit_date' onfocus=\"(this.type='date')\" onblur=\"(this.type='text')\" value='".$result['FECHA_REUNION']."' required><br>
                                                                                    <label>Descripción: </label>
                                                                                    <input type='text' class='form-control' id='edit_desc' name='edit_desc' value='".$result['DESCRIPCION']."' required><br>
                                                                                    <label>Estado: </label>
                                                                                    <select class='form-control' id='edit_state' name='edit_state' required>
                                                                                        ".$options."
                                                                                    </select><br>
                                                                                    <input type='submit' class='btn btn-success' id='submit-edit' name='submit-edit' value='Editar' onclick=\"return confirm('¿Está seguro de que desea editar este dato?')\">
                                                                                </div>
                                                                                <div class='modal-footer'>
                                                                                    <button class='btn btn-danger btn-default pull-left' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span> Cancel</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <button type='submit' class='btn btn-danger' id='submit-delete' name='submit-delete' onclick=\"return confirm('¿Está seguro de que desea eliminar este dato?')\"><i class='fa fa-trash-o'></i></button>
                                                                </form>
                                                            </td>";
                                                        }
                                                              echo"</tr>";
                                                    }
                                                }
                                            } 
                                            catch (Exception $e) {
                                                    echo "Error: " . $e->getMessage();
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
