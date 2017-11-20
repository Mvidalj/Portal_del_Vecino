<?php
    require_once '../../validaciones/conexion_bd.php';
    require_once '../../header.php';
    require_once '../../validaciones/actions_proyecto.php';
    
?>
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
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="../actividades/actividades_reuniones.php">Reuniones</a></li>
                <li><a href="../actividades/actividades_historial.php">Historial de Actividades</a></li>
            </ul>
        </li>
        <li class="active"><a href="proyectos_proyecto.php">Proyectos</a></li>
        <li><a href="../../foro.php">Foro</a></li>
      </ul>
    </div>
  </div>
</nav>

    <div class="page-header">
        <h1>Proyectos<small> (Vigentes)</small> <?php if ($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "5"){echo '<button type="button" class="btn pull-right btn-success" id="add_proyectos" name="add_proyectos" data-toggle="modal" data-target="#new_proyecto">Agregar proyectos <i class="fa fa-edit"></i></button>';}?></h1>
    </div>
    <div class="table-responsive">
    <table id="example" class="table table-bordered">
            <thead>
                <tr>
                    <th class="col-sm-4">Nombre</th>
                    <th class="col-sm-3 ">Fecha Inicio</th>
                    <th class="col-sm-3">Fecha Termino</th>
                    <?php if($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "5"){echo '<th class="col-sm-2">Opciones</th>';}?>
                </tr>
            </thead>
            <tbody>
                <?php
                    try {
                        $sql = $conn->prepare("SELECT * FROM proyectos WHERE ID_ORGANIZACION = :IDORG");#se prepara la consulta
                        $sql->bindparam(":IDORG", $_SESSION['id_org']);
                        $sql->execute();                                 #se ejecuta la consulta
                        while ($result = $sql->fetch(PDO::FETCH_ASSOC)){ #obtiene los datos de la consulta
                            if($result['ELIMINADO'] == '0'){
                                echo "<tr>
                                        <td><a href='#' data-toggle='modal' data-target='#DESC".$result['ID_PROYECTO']."'>".$result['NOMBRE']."</a></td>
                                        <td class='text-center'>".$result['FECHA_INICIO']."</td>
                                        <td class='text-center'>".$result['FECHA_TERMINO']."</td>";
                                echo "
                                        <!-- Modal -->
                                        <div id='DESC".$result['ID_PROYECTO']."' class='modal fade' role='dialog'>
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
                                if($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "5"){
                                    echo "
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
                                                            <label>Fecha de inicio:</label>
                                                            <input type='date' class='form-control' id='fecha_in' name='fecha_in' onblur=form.fecha_ter.min=form.fecha_in.value value='".$result['FECHA_INICIO']."' min='".$adate."' required><br>
                                                            <label>Fecha de termino:</label>
                                                            <input type='date' class='form-control' id='fecha_ter' name='fecha_ter' value='".$result['FECHA_TERMINO']."' min='".$adate."' required><br>
                                                            <label>Nombre de proyecto:</label>
                                                            <input type='text' class='form-control' id='nombre' name='nombre' value= '".$result['NOMBRE']."' required><br>
                                                            <label>Descripción del proyecto:</label>
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
                        <input type="date" class="form-control" id="fecha_in" name="fecha_in" oninput='form.fecha_ter.min=form.fecha_in.value' <?php echo 'min='.$adate.''; ?> required><br>
                        <label for="fecha_ter">Fecha Termino:</label><br>
                        <input type="date" class="form-control" id="fecha_ter" name="fecha_ter" <?php echo 'min='.$adate.''; ?> required><br>
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
<div>	
    <?php include("../../modal_accept_user.php");
          include ('../../config.php');?>
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