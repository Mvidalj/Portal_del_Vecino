<?php
    require_once '../../validaciones/conexion_bd.php';
    require_once '../../validaciones/actions_historial.php';
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
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tesorería <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../tesoreria/tesoreria_balances.php">Ver libro caja</a></li>
            <li><a href="../tesoreria/tesoreria_recursos.php">Solicitar recursos</a></li>
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
        <li><a href="../../foro.php">Foro</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><button type="submit" class="btn btn-primary navbar-btn" name="join-create-org" data-toggle="modal" data-target="#news">+</button></li>
      </ul>
    </div>
  </div>
</nav>
</form>
<div class="page-header">
    <h1>Historial de actividades <?php if ($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "4"){echo '<button type="button" class="btn pull-right btn-success" id="add_activity" name="add_activity" data-toggle="modal" data-target="#new_activity">Agregar actividad <i class="fa fa-edit"></i></button>';}?></h1>
</div>
    <div class="table-responsive">
            <table id="example" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-sm-4">Nombre</th>
                        <th class="col-sm-3 ">Fecha Inicio</th>
                        <th class="col-sm-3">Fecha Termino</th>
                        <?php if($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "4"){echo '<th class="col-sm-2">Acción</th>';}?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try {
                            $sql = $conn->prepare("SELECT * FROM actividades WHERE ID_ORGANIZACION = :IDORG");
                            $sql->bindparam(":IDORG", $_SESSION['id_org']);
                            $sql->execute();
                            while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                if($result['ELIMINADO'] == '0'){
                                    echo "<tr>
                                            <td><a href='#' data-toggle='modal' data-target='#DESC".$result['ID_ACTIVIDAD']."'>".$result['NOMBRE']."</a></td>
                                            <td class='text-center'>".$result['FECHA_INICIO']."</td>
                                            <td class='text-center'>".$result['FECHA_TERMINO']."</td>";
                                    echo "
                                            <!-- Modal -->
                                            <div id='DESC".$result['ID_ACTIVIDAD']."' class='modal fade' role='dialog'>
                                                <div class='modal-dialog'>
                                                <!-- Modal content-->
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                            <h4 class='modal-title'>Descripción de actividad</h4>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <p>
                                                                ".$result['DESCRIPCION']."
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                                            if($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "4"){echo
                                                "<td class='text-center'>
                                                    <form name='form' action='actividades_historial.php' method='POST'>
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
                                                                        <input type='text' class='form-control' id='edit_datefrom' name='edit_datefrom' onfocus=\"(this.type='date')\" onblur=form.edit_dateto.min=form.edit_datefrom.value value='".$result['FECHA_INICIO']."' min='".$adate."' required><br>
                                                                        <label>Fecha de termino: </label>
                                                                        <input type='text' class='form-control' id='edit_dateto' name='edit_dateto' onfocus=\"(this.type='date')\" onblur=\"(this.type='text')\" value='".$result['FECHA_TERMINO']."' min='".$adate."' required><br>
                                                                        <label>Descripción: </label>
                                                                        <textarea class='form-control' id='edit_desc' rows='5' name='edit_desc' required>".$result['DESCRIPCION']."</textarea><br>
                                                                        <button type='submit' class='btn btn-primary' id='submit-edit' name='submit-edit' onclick=\"return confirm('¿Está seguro de que desea editar este dato?')\">Editar <span class='fa fa-save'></span></button>
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
                   <form name ="form" action="actividades_historial.php" method="POST">
                        <label for="fecha_in">Fecha Inicio:</label>
                        <input type="date" class="form-control" id="fecha_in" oninput='form.fecha_ter.min=form.fecha_in.value' name="fecha_in" <?php echo 'min='.$adate.''; ?>><br>
                        <label for="fecha_ter">Fecha Termino:</label>
                        <input type="date" class="form-control" id="fecha_ter" name="fecha_ter" <?php echo 'min='.$adate.''; ?>><br>
                        <label for="nombre">Nombre Actividad:</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre"><br>
                        <label for="desc">Descripcion:</label>
                        <textarea name="desc" class="form-control" id="desc" rows="5" placeholder="Descripcion"></textarea><br>
                        <br><button type="submit" class="btn btn-success btn-md" name="submit-add">Guardar <span class="fa fa-save"></span></button>
                    </form>
                </div>
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