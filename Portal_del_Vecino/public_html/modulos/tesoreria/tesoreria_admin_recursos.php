<?php
    require_once '../../validaciones/conexion_bd.php';

    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_rol'] != "1"){
            $user->Redirect('../../index.php');
        }
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        if(isset($_REQUEST['submit-recurso'])){
            try {
                $sql = $conn->prepare("INSERT INTO recursos (ID_ORGANIZACION, NOMBRE, DESCRIPCION, ESTADO, ELIMINADO)
                VALUES(1, :NOMBRE, :DESCRIPCION, 0, 0)");
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
<!DOCTYPE html>
<html>
    <head>
	<title>Administración de recursos</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<script src="../../librerias/jquery-3.2.1.js"></script>
	<script src="../../librerias/bootstrap.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-sm-2">
                    <img class="img-responsive" src="../../imagenes/home.jpg" width="130" height="130" alt="Icono de pagina">
                </div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3 col-sm-push-9">
                            <br><a class="btn btn-danger conf" href="../../cerrar_sesion.php" rel>Cerrar sesión <span class="fa fa-sign-out"></span></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-sm-push-9">
                            <br><a class="btn btn-primary conf" href="../../config.html" rel>Configuración <span class="fa fa-cog"></span></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-sm-push-9">
                            <br><a class="btn btn-success conf" href="../../home.php" rel>Aceptar Miembros <span class="fa fa-user-plus"></span></a>
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
                            <li class="dropdown active">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tesorería <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="tesoreria_balances.php">Ver libro caja</a></li>
                                    <li><a href="tesoreria_recursos.php">Solicitar recursos</a></li>
                                    <li><a href="tesoreria_admin_balances.php">Administrar balances</a></li>
                                    <li class="active"><a href="tesoreria_admin_recursos.php">Administrar recursos</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="../actividades/actividades_reuniones.php">Reuniones</a></li>
                                    <li><a href="../actividades/actividades_historial.php">Historial de Actividades</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proyectos <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="../proyectos/proyectos_proyecto.php">Proyectos</a></li>
                                    <li><a href="../proyectos/proyectos_add_proyectos.php">Añadir Proyectos</a></li>
                                </ul>
                            </li>
                            <li><a href="../foro">Foro</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="page-header">
                <h1>Administrar recursos <button type="button" class="btn pull-right btn-success" id="add_resource" name="add_resource" data-toggle="modal" data-target="#new_resource">Agregar recurso <i class='fa fa-edit'></i></button></h1>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Recurso</th>
                            <th>Descripción</th>
                            <th>Disponibilidad</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        try {
                            $sql = $conn->prepare("SELECT * FROM recursos WHERE ELIMINADO = 0 AND ID_ORGANIZACION = :IDORG");
                            $sql->bindparam(":IDORG", $_SESSION['id_org']);
                            $sql->execute();
                            while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                if($result['ESTADO'] == 1){
                                    $estado = 'En uso';
                                }else{
                                    $estado = 'Disponible';
                                }
                                echo "<tr>                                       
                                        <td class='text-center'>".$result['NOMBRE']."</td>
                                        <td>".$result['DESCRIPCION']."</td>
                                        <td>".$estado."</td>
                                        <td>
                                            <form action='tesoreria_admin_recursos.php' method='POST'>
                                                <input type='hidden' id='id_recurso' name='id_recurso' value='".$result['ID_RECURSO']."'>
                                                <button type='button' class='btn btn-info' id='edit_actividad' name='edit_actividad' data-toggle='modal' data-target='#".$result['ID_RECURSO']."'><i class='fa fa-edit'></i></button>
                                                <!-- Modal -->
                                                <div id='".$result['ID_RECURSO']."' class='modal fade' role='dialog'>
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
                                                                <input type='text' class='form-control' id='edit_desc' name='edit_desc' value='".$result['DESCRIPCION']."' required><br>
                                                                <input type='submit' class='btn btn-success' id='submit-edit' name='submit-edit' value='Editar' onclick=\"return confirm('¿Está seguro de que desea editar este recurso?')\">
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button class='btn btn-danger btn-default pull-left' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span> Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type='submit' class='btn btn-danger' id='delete_resource' name='delete_resource' onclick=\"return confirm('¿Está seguro de que desea eliminar este recurso?')\"><i class='fa fa-trash-o'></i></button>
                                            </form>
                                        </td>
                                    </tr>";
                            } # por cada dato crea una columna
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
                           <form action="tesoreria_admin_recursos.php" method="POST">
                                <label>Nombre de recurso:</label>
                                <input type="text" class="form-control" id="nombre-recurso" name="nombre-recurso"><br>
                                <label>Descripción de recurso:</label>
                                <input type="text" class="form-control" id="desc-recurso" name="desc-recurso"><br>
                                <input type="submit" class="btn btn-success" id="submit-recurso" name="submit-recurso" value="Añadir recurso">
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