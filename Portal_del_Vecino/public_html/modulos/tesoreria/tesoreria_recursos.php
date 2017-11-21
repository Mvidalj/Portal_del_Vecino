<?php
    require_once '../../validaciones/conexion_bd.php';
    require_once '../../validaciones/actions_recursos.php';
    require_once '../../header.php';
?>
<form>
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
                <li><a href="../../foro.php">Foro</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><button type="submit" class="btn btn-danger navbar-btn" name="join-create-org" data-toggle="modal" data-target="#news">+</button></li>
            </ul>
        </div>
    </div>
</nav>
</form>
<div class="jumbotron">
    <div class="page-header">
        <h2>Solicitar recursos <?php if ($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "3"){echo '<button type="button" class="btn pull-right btn-success" id="add_resource" name="add_resource" data-toggle="modal" data-target="#new_resource">Agregar recurso <i class="fa fa-edit"></i></button>';}?></h2>
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
                        $stmt = $querys->recursos();
                        echo "<datalist id='hourlist'>";
                                for ($i = 9; $i <= 22; $i++) {
                                    if($i == 9){
                                        echo "<option value='0".strval($i).":00'>";
                                    }else{
                                        echo "<option value='".strval($i).":00'>";
                                    }
                                }
                        echo "</datalist>";
                        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $usuarios = array();
                            $idusuerios = array();
                            $solicitudes = "";
                            $stmt = $querys->prestamos($result['ID_RECURSO']);
                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                array_push($idusuerios, ($data['ID_USUARIO']));
                                array_push($usuarios, (" Desde ".$data['FECHA_INICIO']." Hasta ".$data['FECHA_TERMINO']));
                            }
                            foreach ($idusuerios as &$user){
                                $stmt = $querys->nombre_usr($user);
                                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                                $solicitudes = $solicitudes."<li>".$res['NOMBRE']." ".$res['APELLIDO'].$usuarios[$user]."</li>";
                            }
                            if($solicitudes == ""){$solicitudes = "No hay usuarios que hayan solicitado este recurso aún";}
                                 
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
                                                            <div class='row'>
                                                                <div class='col-sm-2'>
                                                                    <label>Desde:</label>
                                                                </div>
                                                                <div class='col-sm-3'>
                                                                    <input type='time' class='form-control' id='from_time' name='from_time' min='09:00:00' max='22:00:00' onmouseover='focus();' oninput='form.to_time.min=form.from_time.value' list='hourlist' required>
                                                                </div>
                                                                <div class='col-sm-4'>
                                                                    <input type='date' class='form-control' id='from_date' name='from_date' oninput='form.to_date.min=form.from_date.value, form.to_date.max=form.from_date.value, form.to_date.value=form.from_date.value, form.rd_to_date.value=form.from_date.value' min='".$adate."' required><br>
                                                                </div> 
                                                            </div>
                                                            <div class='row'>
                                                                <div class='col-sm-2'>
                                                                    <label>Hasta:</label>
                                                                </div>
                                                                <div class='col-sm-3'>
                                                                    <input type='time' class='form-control' id='to_time' name='to_time' min='09:00:00' max='22:00:00' list='hourlist' required>
                                                                </div>
                                                                <div class='col-sm-4'>
                                                                    <input type='date' class='form-control' id='to_date' name='to_date' readonly><br>
                                                                </div> 
                                                            </div>
                                                            <input type='submit' class='btn btn-success' id='submit-request' name='submit-request' value='Solicitar'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           </form>";
                            if($result['ESTADO'] == 1){
                                $estado = 'Se ha solicitado';
                            }else{
                                $estado = 'Disponible';
                            }
                            echo "<tr>
                                    <td class='text-center'>".$result['NOMBRE']."</td>
                                    <td>".$result['DESCRIPCION']."</td>";
                                   if ($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "3"){
                                       echo "<td><a href='#' data-toggle='modal' data-target='#ADMIN".$result['ID_RECURSO']."'>".$estado."</a></td>";
                                       echo "
                                            <!-- Modal -->
                                            <div id='ADMIN".$result['ID_RECURSO']."' class='modal fade' role='dialog'>
                                                <div class='modal-dialog'>
                                                <!-- Modal content-->
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                            <h4 class='modal-title'>Usuarios que han solicitado este recurso</h4>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <ul>
                                                                ".$solicitudes."
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                                   }else{
                                       echo "<td>".$estado."</td>";
                                   }
                                   echo "
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
    <div>	
        <?php include("../../modal_accept_user.php");
              include ('../../config.php');
              include("../../modal_orgs.php");?>		
    </div>
    </body>
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
</html>
