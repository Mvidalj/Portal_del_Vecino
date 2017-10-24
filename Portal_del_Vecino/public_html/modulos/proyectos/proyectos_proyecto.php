<?php
    require_once '../../validaciones/conexion_bd.php';
 
    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        if(isset($_REQUEST['delete'])){
        try{
            $sentencia = $conn->prepare("UPDATE proyectos SET ELIMINADO = 1 WHERE ID_PROYECTO= :ID");
            $sentencia->bindParam(':ID', $_POST['id'],PDO::PARAM_INT);
            if($sentencia->execute()){$user->Redirect('proyectos_proyecto.php');}  
            }catch(PDOException $e){
                    echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        if (isset($_REQUEST['submit-edit'])){
            try{
                $sentencia = $conn->prepare("UPDATE proyectos SET NOMBRE= :NOMBRE, DESCRIPCION= :DESC,
                                             FECHA_INICIO= :FECHIN, FECHA_TERMINO= :FECHTER
                                             WHERE ID_PROYECTO= :ID");
                $sentencia->bindParam(':NOMBRE',$_POST['nombre'],PDO::PARAM_STR);
                $sentencia->bindParam(':FECHIN', $_POST['fecha_in']);
                $sentencia->bindParam(':FECHTER', $_POST['fecha_ter']); 
                $sentencia->bindParam(':DESC',$_POST['desc'],PDO::PARAM_STR);
                $sentencia->bindParam(':ID',$_POST['id'],PDO::PARAM_INT);
                if($sentencia->execute()){$user->Redirect('proyectos_proyecto.php');}  
            }catch(PDOException $e){
                    echo 'Fallo la conexion:'.$e->GetMessage();
            }
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
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="../actividades/actividades_reuniones.php">Reuniones</a></li>
                <li><a href="../actividades/actividades_historial.php">Historial de Actividades</a></li>
            </ul>
        </li>
        <li class="active"><a href="proyectos_proyecto.php">Proyectos</a></li>
        <li><a href="../foro" target="_blank">Foro</a></li>
      </ul>
    </div>
  </div>
</nav>

    <div class="page-header">
        <h1>Proyectos<small> (Vigentes)</small> <?php if ($_SESSION['id_rol'] == "1"){echo '<button type="button" class="btn pull-right btn-success" id="add_proyectos" name="add_proyectos" data-toggle="modal" data-target="#new_proyecto">Agregar proyectos <i class="fa fa-edit"></i></button>';}?></h1>
    </div>
    <div class="table-responsive">
    <table id="example" class="table table-bordered">
            <thead>
                <tr>
                    <th class="col-sm-4">Nombre</th>
                    <th class="col-sm-3 ">Fecha Inicio</th>
                    <th class="col-sm-3">Fecha Termino</th>
                    <?php if($_SESSION['id_rol'] == "1"){echo '<th class="col-sm-2">Opciones</th>';}?>
                </tr>
            </thead>
            <tbody>
                <?php
                    try {
                        $sql = $conn->prepare("SELECT * FROM proyectos");#se prepara la consulta
                        $sql->execute();                                 #se ejecuta la consulta
                        while ($result = $sql->fetch(PDO::FETCH_ASSOC)){ #obtiene los datos de la consulta
                            if($result['ELIMINADO'] == '0'){
                                if($_SESSION['id_rol'] == "1"){
                                    echo "<tr>                                       
                                        <td>".$result['NOMBRE']."</td>
                                        <td class='text-center'>".$result['FECHA_INICIO']."</td>
                                        <td class='text-center'>".$result['FECHA_TERMINO']."</td>
                                        <td class='text-center'> 
                                        <form name='form' action='proyectos_proyecto.php' method='POST'>
                                            <button type='button' class='btn btn-info' id='lol' name='lol' data-toggle='modal' data-target='#".$result['ID_PROYECTO']."'><i class='fa fa-edit'></i></button>
                                            <!-- Modal -->
                                            <div id='".$result['ID_PROYECTO']."' class='modal fade' role='dialog'>
                                                <div class='modal-dialog'>
                                                    <!-- Modal content-->
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                            <h4 class='modal-title'>Editar</h4>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <input type='hidden' id='id' name='id' value='".$result['ID_PROYECTO']."'>
                                                            <input type='date' class='form-control' id='fecha_in' name='fecha_in' onblur=form.fecha_ter.min=form.fecha_in.value value='".$result['FECHA_INICIO']."' required><br>
                                                            <input type='date' class='form-control' id='fecha_ter' name='fecha_ter' value='".$result['FECHA_TERMINO']."' required><br>
                                                            <input type='text' class='form-control' id='nombre' name='nombre' value= '".$result['NOMBRE']."' required><br>
                                                            <textarea class='form-control' id='desc' rows='5' name='desc'>".$result['DESCRIPCION']."</textarea><br>
                                                            <button type='submit' class='btn btn-primary' id='submit-edit' name='submit-edit' onclick=\"return confirm('¿Está seguro de que desea editar este dato?')\">Editar <span class='fa fa-save'></span></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type='submit' class='btn btn-danger' id='delete' name='delete' onclick=\"return confirm('¿Está seguro de que desea eliminar este dato?')\"><i class='fa fa-trash-o'></i></button>
                                        </form>
                                        </td>
                                    </tr>";} # por cada dato crea una columna
                                else{
                                    echo "<tr>                                       
                                        <td>".$result['NOMBRE']."</td>
                                        <td class='text-center'>".$result['FECHA_INICIO']."</td>
                                        <td class='text-center'>".$result['FECHA_TERMINO']."</td>
                                    </tr>";
                                }
                            }
                        }
                    }
                    catch (Exception $e) {
                        echo "Error: " . $e->getMessage();#captura el error y lo muestra
                    }
                ?>
            </tbody>
        </table>
    </div>
<br><br><br>
<!-- Modal -->
    <div id="new_proyecto" class='modal fade' role='dialog'>
        <div class='modal-dialog'>
        <!-- Modal content-->
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    <h4 class='modal-title'>Agregar Proyecto</h4>
                </div>
                <div class='modal-body'>
                    <form name="form" action="proyectos_proyecto.php" method="post">
                        <label for="fecha_in">Fecha Inicio:</label>
                        <input type="date" class="form-control" id="fecha_in" name="fecha_in" onblur=form.fecha_ter.min=form.fecha_in.value required><br>
                        <label for="fecha_ter">Fecha Termino:</label><br>
                        <input type="date" class="form-control" id="fecha_ter" name="fecha_ter" required><br>
                        <label for="nombre">Nombre Proyecto:</label><br>
                        <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre" required><br>
                        <label for="desc">Descripcion:</label><br>
                        <textarea class="form-control" id="desc" rows="5" placeholder="Descripcion" name="desc"></textarea><br>
                        <button type="submit" class="btn btn-success btn-md" name="add_proyecto">Guardar <span class="fa fa-save"></span></button>
                    </form>
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
