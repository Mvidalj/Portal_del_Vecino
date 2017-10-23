<?php
    
    require_once '../../validaciones/conexion_bd.php';

    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        
        if(isset($_REQUEST['submit-edit'])){
            try{   
                $sentencia = $conn->prepare("UPDATE actividades SET NOMBRE = :NOMBRE, DESCRIPCION= :DESC, FECHA_INICIO = :FECHFROM, FECHA_TERMINO = :FECHTO WHERE ID_ACTIVIDAD = :ID");
                $sentencia->bindParam(':NOMBRE', $_POST['edit_nom']);
                $sentencia->bindParam(':DESC', $_POST['edit_desc']);
                $sentencia->bindParam(':FECHFROM', date('Y-m-d', strtotime($_POST['edit_datefrom'])));
                $sentencia->bindParam(':FECHTO', date('Y-m-d', strtotime($_POST['edit_dateto'])));
                $sentencia->bindParam(':ID', $_POST['id_actividad']);
                $sentencia->execute();
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }

        if(isset($_REQUEST['submit-delete'])){
            try{   
                $sentencia = $conn->prepare("UPDATE actividades SET ELIMINADO = 1 WHERE ID_ACTIVIDAD= :ID");
                $sentencia->bindParam(':ID', $_POST['id_actividad']);
                $sentencia->execute();
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        
        if(isset($_REQUEST['submit-add'])){
            try{
                $sentencia = $conn->prepare("INSERT INTO actividades (ID_ORGANIZACION, NOMBRE, DESCRIPCION, FECHA_INICIO, FECHA_TERMINO, ELIMINADO)
                VALUES(1, :NOMBRE, :DESCRIPCION,:FECHA_INICIO,:FECHA_TERMINO,0)");
                $date_in = date('Y-m-d', strtotime($_POST['fecha_in']));
                $date_ter = date('Y-m-d', strtotime($_POST['fecha_ter']));
                $sentencia->bindParam(':NOMBRE', $_POST['nombre'],PDO::PARAM_STR);
                $sentencia->bindParam(':FECHA_INICIO', $date_in);
                $sentencia->bindParam(':FECHA_TERMINO', $date_ter); 
                $sentencia->bindParam(':DESCRIPCION', $_POST['desc'],PDO::PARAM_STR);
                if($sentencia->execute()){
                    $user->Redirect('actividades_historial.php');
                }  
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
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
                        <br><a type="button" class="btn btn-danger conf" href="../../cerrar_sesion.php" rel>Cerrar sesión <span class="fa fa-sign-out"></span></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-sm-push-9">
                        <br><a type="button" class="btn btn-primary conf" href="../../config.php" rel>Configuración <span class="fa fa-cog"></span></a>
                    </div>
                </div>
                <?php
                if($_SESSION['id_rol'] == "1"){
                    echo '
                <div class="row">
                <div class="col-sm-3 col-sm-push-9">
                    <br><a type="button" class="btn btn-success conf" href="../../home.php" rel>Aceptar Miembros <span class="fa fa-user-plus"></span></a>
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
                echo '      
            <li><a href="../tesoreria/tesoreria_admin_balances.php">Administrar libro caja</a></li>
            <li><a href="../tesoreria/tesoreria_admin_recursos.php">Administrar recursos</a></li>';}?> 
          </ul>
        </li>
        <li class="dropdown active">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="actividades_reuniones.php">Reuniones</a></li>
                <li class="active"><a href="actividades_historial.php">Historial de Actividades</a></li>
            </ul>
        </li>
        <li><a href="../proyectos/proyectos_proyecto.php">Proyectos</a></li>
        <li><a href="../foro" target="_blank">Foro</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="page-header">
    <h1>Historial de actividades <?php if ($_SESSION['id_rol'] == "1"){echo '<button type="button" class="btn pull-right btn-success" id="add_activity" name="add_activity" data-toggle="modal" data-target="#new_activity">Agregar actividad <i class="fa fa-edit"></i></button>';}?></h1>
</div>
    <div class="table-responsive">
            <table id="example" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-sm-4">Nombre</th>
                        <th class="col-sm-3 ">Fecha Inicio</th>
                        <th class="col-sm-3">Fecha Termino</th>
                        <?php if($_SESSION['id_rol'] == "1"){echo '<th class="col-sm-1">Acción</th>';}?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try {
                            $sql = $conn->prepare("SELECT * FROM actividades");
                            $sql->execute();
                            while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                if($result['ELIMINADO'] == '0'){
                                    echo "<tr>
                                            <td>".$result['NOMBRE']."</td>
                                            <td class='text-center'>".$result['FECHA_INICIO']."</td>
                                            <td class='text-center'>".$result['FECHA_TERMINO']."</td>";
                                            if($_SESSION['id_rol'] == "1"){echo
                                                "<td>
                                                    <form action='actividades_historial.php' method='POST'>
                                                        <input type='hidden' id='id_actividad' name='id_actividad' value='".$result['ID_ACTIVIDAD']."'>
                                                        <button type='button' class='btn btn-info' id='edit_reunion' name='edit_reunion' data-toggle='modal' data-target='#".$result['ID_ACTIVIDAD']."'><i class='fa fa-edit'></i></button>
                                                        <!-- Modal -->
                                                        <div id='".$result['ID_ACTIVIDAD']."' class='modal fade' role='dialog'>
                                                            <div class='modal-dialog'>
                                                            <!-- Modal content-->
                                                                <div class='modal-content'>
                                                                    <div class='modal-header'>
                                                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                                        <h4 class='modal-title'>Editar actividad</h4>
                                                                    </div>
                                                                    <div class='modal-body'>
                                                                        <label>Nombre: </label>
                                                                        <input type='text' class='form-control' id='edit_nom' name='edit_nom' value='".$result['NOMBRE']."' required><br>
                                                                        <label>Fecha de inicio: </label>
                                                                        <input type='text' class='form-control' id='edit_datefrom' name='edit_datefrom' onfocus=\"(this.type='date')\" onblur=\"(this.type='text')\" value='".$result['FECHA_INICIO']."' required><br>
                                                                        <label>Fecha de termino: </label>
                                                                        <input type='text' class='form-control' id='edit_dateto' name='edit_dateto' onfocus=\"(this.type='date')\" onblur=\"(this.type='text')\" value='".$result['FECHA_TERMINO']."' required><br>
                                                                        <label>Descripción: </label>
                                                                        <textarea class='form-control' id='edit_desc' name='edit_desc' required>".$result['DESCRIPCION']."</textarea><br>
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
                                                </td>";}
                                        echo "</tr>";
                                }
                            }
                        } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    ?>
                </tbody>
            </table>
    </div>
    <!-- Modal -->
    <div id="new_activity" class='modal fade' role='dialog'>
        <div class='modal-dialog'>
        <!-- Modal content-->
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    <h4 class='modal-title'>Agregar actividad</h4>
                </div>
                <div class='modal-body'>
                   <form action="actividades_historial.php" method="POST">
                        <label for="fecha_in">Fecha Inicio:</label>
                        <input type="date" class="form-control" id="fecha_in" name="fecha_in"><br>
                        <label for="fecha_ter">Fecha Termino:</label>
                        <input type="date" class="form-control" id="fecha_ter" name="fecha_ter"><br>
                        <label for="nombre">Nombre Actividad:</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre"><br>
                        <label for="desc">Descripcion:</label>
                        <textarea name="desc" class="form-control" id="desc" rows="5" placeholder="Descripcion"></textarea><br>
                        <br><button type="submit" class="btn btn-primary btn-md" name="submit-add">Guardar <span class="fa fa-save"></span></button>
                    </form>
                </div>
                <div class='modal-footer'>
                    <button class='btn btn-danger btn-default pull-left' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>
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