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
        
        if (isset($_REQUEST['delete_actividad'])){
            try {
                $sql = $conn->prepare("UPDATE tesoreria SET ELIMINADO = 1 WHERE ID_TESORERIA = :id");
                $sql->bindParam(':id', $_POST['id']);
                $sql->execute();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        if (isset($_REQUEST['submit-edit'])){
            try {
                $sql = $conn->prepare("UPDATE tesoreria SET FECHA = :EDITFECHA, CONCEPTO = :EDITCONCEPTO, MONTO = :EDITOMONTO, E_S = :EDITACTIVIDAD WHERE ID_TESORERIA = :ID");
                $sql->bindParam(':EDITFECHA', date('Y-m-d', strtotime($_POST['edit_date'])));
                $sql->bindParam(':EDITCONCEPTO', $_POST['edit_caption']);
                $sql->bindParam(':EDITOMONTO', $_POST['edit_ammount']);
                $sql->bindParam(':EDITACTIVIDAD', $_POST['edit_activity']);
                $sql->bindParam(':ID', $_POST['id']);
                $sql->execute();
            } 
            catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        if(isset($_REQUEST['submit-entrada'])){
            try {
                $sql = $conn->prepare("INSERT INTO tesoreria (ID_ORGANIZACION, FECHA, CONCEPTO, E_S, MONTO)
                VALUES(1, :FECHA, :CONCEPTO, :E_S, :MONTO)");
                $sql->bindParam(':FECHA', date('Y-m-d', strtotime($_POST['fecha_ingreso'])));
                $sql->bindParam(':CONCEPTO', $_POST['concepto']);
                $sql->bindParam(':E_S', $_POST['select_actividad']);
                $sql->bindParam(':MONTO', $_POST['monto']);
                $sql->execute();
            } 
            catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
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
                            <br><a class="btn btn-primary conf" href="../../config.php" rel>Configuración <span class="fa fa-cog"></span></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-sm-push-9">
                            <br><a type="button" class="btn btn-success conf" data-toggle="modal" data-target="#new_user" rel>Aceptar Miembros <span class="fa fa-user-plus"></span></a>
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
                                    <li class="active"><a href="tesoreria_admin_balances.php">Administrar libro caja</a></li>
                                    <li><a href="tesoreria_admin_recursos.php">Administrar recursos</a></li>
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
                <h1>Administrar libro caja <button type="button" class="btn pull-right btn-success" id="add_entry" name="add_entry" data-toggle="modal" data-target="#new_entry">Nueva entrada <i class='fa fa-edit'></i></button></h1>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Concepto</th>
                            <th>Actividad</th>
                            <th>Monto</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            try {
                                $sql = $conn->prepare("SELECT * FROM tesoreria WHERE ELIMINADO = 0 AND ID_ORGANIZACION = :IDORG");
                                $sql->bindparam(":IDORG", $_SESSION['id_org']);
                                $sql->execute();
                                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                    if($result['E_S'] == 1 || $result['E_S'] == 3){
                                        $actividad = 'Entrada';
                                        $options = "<option value='3'>Registro de saldo</option>
                                                    <option value='1' selected>Ingreso</option>
                                                    <option value='0'>Egreso</option>
                                                    ";
                                        if($result['E_S'] == 3){
                                            $options = "<option value='3' selected>Registro de saldo</option>
                                                    <option value='1'>Ingreso</option>
                                                    <option value='0'>Egreso</option>
                                                    ";
                                        }
                                    }
                                    else{
                                        $actividad = 'Salida';
                                        $options = "<option value='3'>Registro de saldo</option>
                                                    <option value='1'>Ingreso</option>
                                                    <option value='0' selected>Egreso</option>
                                                    ";
                                    }

                                    echo "<tr>                                       
                                        <td class='text-center'>".$result['FECHA']."</td>
                                        <td>".$result['CONCEPTO']."</td>
                                        <td>".$actividad."</td>
                                        <td>".$result['MONTO']."</td>
                                        <td class='text-center'>
                                            <form action='tesoreria_admin_balances.php' method='POST'>
                                                <input type='hidden' id='id_actividad' name='id' value='".$result['ID_TESORERIA']."'>
                                                <button type='button' class='btn btn-info' id='edit_actividad' name='edit_actividad' data-toggle='modal' data-target='#".$result['ID_TESORERIA']."'><i class='fa fa-edit'></i></button>
                                                <!-- Modal -->
                                                <div id='".$result['ID_TESORERIA']."' class='modal fade' role='dialog'>
                                                    <div class='modal-dialog'>
                                                    <!-- Modal content-->
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                                <h4 class='modal-title'>Editar entrada</h4>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <label>Fecha: </label>
                                                                <input type='text' class='form-control' id='edit_date' name='edit_date' onfocus=\"(this.type='date')\" onblur=\"(this.type='text')\" value='".$result['FECHA']."' required><br>
                                                                <label>Concepto: </label>
                                                                <input type='text' class='form-control' id='edit_caption' name='edit_caption' value='".$result['CONCEPTO']."' required><br>
                                                                <label>Actividad: </label>
                                                                <select class='form-control' id='edit_activity' name='edit_activity' required>
                                                                    ".$options."
                                                                </select><br>
                                                                <label>Monto: </label>
                                                                <input type='number' class='form-control' id='edit_ammount' name='edit_ammount' value='".$result['MONTO']."' required><br>
                                                                <button type='submit' class='btn btn-primary' id='submit-edit' name='submit-edit' onclick=\"return confirm('¿Está seguro de que desea editar este dato?')\">Editar <span class='fa fa-save'></span></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type='submit' class='btn btn-danger' id='delete_actividad' name='delete_actividad' onclick=\"return confirm('¿Está seguro de que desea eliminar este dato?')\"><i class='fa fa-trash-o'></i></button>
                                            </form>
                                        </td>
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
            &nbsp;
            <!-- Modal -->
            <div id="new_entry" class='modal fade' role='dialog'>
                <div class='modal-dialog'>
                <!-- Modal content-->
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                            <h4 class='modal-title'>Agregar entrada</h4>
                        </div>
                        <div class='modal-body'>
                           <form action="tesoreria_admin_balances.php" method="POST">
                                <label>Fecha:</label>
                                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso"><br>
                                <label>Concepto:</label>
                                <input type="text" class="form-control" id="concepto" name="concepto"><br>
                                <label>Actividad:</label>
                                <select class="form-control" id="select_actividad" name="select_actividad">
                                    <option value="" disabled selected>Ingreso/Egreso</option>
                                    <option value="3">Registro de saldo</option>
                                    <option value="1">Ingreso</option>
                                    <option value="0">Egreso</option>
                                </select><br>
                                <label>Monto:</label>
                                <input type="number" class="form-control" id="monto" name="monto"><br>
                                <button type='submit' class='btn btn-success' id='submit-entrada' name='submit-entrada'>Añadir entrada <span class='fa fa-save'></span></button>
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