<?php
    require_once '../../validaciones/conexion_bd.php';

    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        if(isset($_REQUEST['submit-request'])){
            try{
                $sql = $conn->prepare("UPDATE recursos SET ESTADO = 1 WHERE ID_RECURSO = :id");
                $sql->bindparam(":id", $_POST['id_recurso']);
                if($sql->execute()){
                    $sql = $conn->prepare("INSERT INTO prestamos (ID_RECURSO, ID_USUARIO, FECHA_INICIO, FECHA_TERMINO, ELIMINADO) VALUES(:ID, :USER, :FROM, :TO, 0)");
                    $sql->bindparam(":ID", $_POST['id_recurso']);
                    $sql->bindparam(":USER", $_SESSION['id_usuario']);
                    $sql->bindparam(":FROM", date('Y-m-d', strtotime($_POST['from_date'])));
                    $sql->bindparam(":TO", date('Y-m-d', strtotime($_POST['to_date'])));
                    if($sql->execute()){
                        echo "<script>alert('Su solicitud se ha realizado correctamente')</script>";
                    }
                }

            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        
        if(isset($_REQUEST['submit-recurso'])){
            try {
                $sql = $conn->prepare("INSERT INTO recursos (ID_ORGANIZACION, NOMBRE, DESCRIPCION, ESTADO, ELIMINADO)
                VALUES(:IDORG, :NOMBRE, :DESCRIPCION, 0, 0)");
                $sql->bindParam(':IDORG', $_SESSION['id_org']);
                $sql->bindParam(':NOMBRE', $_POST['nombre-recurso']);
                $sql->bindParam(':DESCRIPCION', $_POST['desc-recurso']);  
                $sql->execute();
            } 
            catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        if(isset($_REQUEST['submit-edit'])){
            try {
                $sql = $conn->prepare("UPDATE recursos SET NOMBRE = :NOMBRE, DESCRIPCION = :DESC WHERE ID_RECURSO = :ID");
                $sql->bindParam(':NOMBRE', $_POST['edit_name']);
                $sql->bindParam(':DESC', $_POST['edit_desc']);
                $sql->bindParam(':ID', $_POST['id_recurso']);
                $sql->execute();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        if(isset($_REQUEST['delete_resource'])){
            try {
                $sql = $conn->prepare("UPDATE recursos SET ELIMINADO = 1 WHERE ID_RECURSO = :ID");
                $sql->bindParam(':ID', $_POST['id_recurso']);  
                $sql->execute();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
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
      <a class="navbar-brand" href="../../home.php">Inicio</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="dropdown active">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tesorería <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="tesoreria_balances.php">Ver libro caja</a></li>
            <li class="active"><a href="tesoreria_recursos.php">Solicitar recursos</a></li>
          </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="../actividades/actividades_reuniones.php">Reuniones</a></li>
                <li><a href="../actividades/actividades_historial.php">Historial de Actividades</a></li>
            </ul>
        </li>
        <li><a href="../proyectos/proyectos_proyecto.php">Proyectos</a></li>
        <li><a href="../foro" target="_blank">Foro</a></li>
      </ul>
    </div>
  </div>
</nav>
                        <div class="page-header">
                            <h1>Solicitar recursos <?php if ($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "3"){echo '<button type="button" class="btn pull-right btn-success" id="add_resource" name="add_resource" data-toggle="modal" data-target="#new_resource">Agregar recurso <i class="fa fa-edit"></i></button>';}?></h1>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Recurso</th>
                                        <th>Descripción</th>
                                        <th>Disponibilidad</th>
                                        <th>Solicitar</th>
                                        <?php if($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "3"){echo '<th class="col-sm-2">Opciones</th>';}?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        try {
                                            $sql = $conn->prepare("SELECT * FROM recursos WHERE ELIMINADO = 0 AND ID_ORGANIZACION = :IDORG");
                                            $sql->bindparam(":IDORG", $_SESSION['id_org']);
                                            $sql->execute();
                                            while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                $solicitar = "<form name='form' action='tesoreria_recursos.php' method='POST'>
                                                                <input type='hidden' id='id_recurso' name='id_recurso' value=".$result['ID_RECURSO']."'>
                                                                <button type='button' class='btn btn-primary' id='solicitar' name='solicitar' data-toggle='modal' data-target='#".$result['ID_RECURSO']."'>Solicitar</button>
                                                                <!-- Modal -->
                                                                <div id='".$result['ID_RECURSO']."' class='modal fade' role='dialog'>
                                                                    <div class='modal-dialog'>
                                                                        <!-- Modal content-->
                                                                        <div class='modal-content'>
                                                                            <div class='modal-header'>
                                                                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                                                <h4 class='modal-title'>Solicitar recurso</h4>
                                                                            </div>
                                                                            <div class='modal-body'>
                                                                                <label>Desde:</label>
                                                                                <input type='date' class='form-control' id='from_date' name='from_date' onblur=form.to_date.min=form.from_date.value placeholder='Seleccione una fecha' required><br>
                                                                                <label>Hasta:</label>
                                                                                <input type='date' class='form-control' id='to_date' name='to_date' placeholder='Seleccione una fecha' required><br>
                                                                                <input type='submit' class='btn btn-success' id='submit-request' name='submit-request' value='Solicitar'>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                               </form>";
                                                
                                                if($result['ESTADO'] == 1){
                                                    $estado = 'Se ha solicitado';
                                                    #$sql = $conn->prepare("SELECT * FROM prestamos WHERE ID_RECURSO = ".$result['ID_RECURSO']."");
                                                    #$sql->execute();
                                                    #$data = $sql->fetch(PDO::FETCH_ASSOC);
                                                    #$mindate = $data['FECHA_INICIO'];
                                                    #$maxdate = $data['FECHA_TERMINO'];
                                                }else{
                                                    $estado = 'Disponible';
                                                }
                                                echo "<tr>                                       
                                                        <td class='text-center'>".$result['NOMBRE']."</td>
                                                        <td>".$result['DESCRIPCION']."</td>
                                                        <td>".$estado."</td>
                                                        <td>".$solicitar."</td>
                                                    "; if ($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "3"){
                                                        echo "<td class='text-center'>
                                                            <form action='tesoreria_recursos.php' method='POST'>
                                                                <input type='hidden' id='id_recurso' name='id_recurso' value='".$result['ID_RECURSO']."'>
                                                                <button type='button' class='btn btn-info' id='edit_actividad' name='edit_actividad' data-toggle='modal' data-target='#".$result['ID_RECURSO']."edit'><i class='fa fa-edit'></i></button>
                                                                <!-- Modal -->
                                                                <div id='".$result['ID_RECURSO']."edit' class='modal fade' role='dialog'>
                                                                    <div class='modal-dialog'>
                                                                    <!-- Modal content-->
                                                                        <div class='modal-content'>
                                                                            <div class='modal-header'>
                                                                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                                                <h4 class='modal-title'>Editar recurso</h4>
                                                                            </div>
                                                                            <div class='modal-body'>
                                                                                <label>Recurso: </label>
                                                                                <input type='text' class='form-control' id='edit_name' name='edit_name' value='".$result['NOMBRE']."' required><br>
                                                                                <label>Descripción: </label>
                                                                                <textarea class='form-control' name='edit_desc' id='edit_desc' rows='5' placeholder='Descripcion'>".$result['DESCRIPCION']."</textarea><br>
                                                                                <button type='submit' class='btn btn-primary' id='submit-edit' name='submit-edit' onclick=\"return confirm('¿Está seguro de que desea editar este dato?')\">Editar <span class='fa fa-save'></span></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type='submit' class='btn btn-danger' id='delete_resource' name='delete_resource' onclick=\"return confirm('¿Está seguro de que desea eliminar este recurso?')\"><i class='fa fa-trash-o'></i></button>
                                                            </form>
                                                        </td>";
                                                    }echo "</tr>";
                                            }
                                        } 
                                        catch (Exception $e) {
                                            echo "Error: " . $e->getMessage();#captura el error y lo muestra
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        &nbsp;
                        <!-- Modal -->
                        <div id="new_resource" class='modal fade' role='dialog'>
                            <div class='modal-dialog'>
                            <!-- Modal content-->
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        <h4 class='modal-title'>Agregar recurso</h4>
                                    </div>
                                    <div class='modal-body'>
                                       <form action="tesoreria_recursos.php" method="POST">
                                            <label>Nombre de recurso:</label>
                                            <input type="text" class="form-control" id="nombre-recurso" name="nombre-recurso"><br>
                                            <label>Descripción de recurso:</label>
                                            <textarea class="form-control" name="desc-recurso" id="desc-recurso" rows="5" placeholder="Descripcion"></textarea><br>
                                            <button type='submit' class='btn btn-success' id='submit-recurso' name='submit-recurso'>Añadir recurso <span class='fa fa-save'></span></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>	
                        <?php include("../../modal_accept_user.php");?>		
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