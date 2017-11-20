<?php 
    require_once '../../validaciones/conexion_bd.php';
    require_once '../../validaciones/actions_reuniones.php';
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
                <li class="active"><a href="actividades_reuniones.php">Reuniones</a></li>
                <li><a href="actividades_historial.php">Historial de Actividades</a></li>
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
                            <h1>Reuniones <?php if ($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "4"){echo '<button type="button" class="btn pull-right btn-success" id="add_reunion" name="add_reunion" data-toggle="modal" data-target="#new_reunion">Agregar reunión <i class="fa fa-edit"></i></button>';}?></h1>
                        </div>
			<div class="table-responsive">
                            <form action="actividades_reuniones.php" method='POST'>
				<table id="example" class="table table-bordered">
				    <thead>
				     	<tr>
                                            <th>Descripcion</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <?php if($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "4"){echo '<th>Acción</th>';}?>
				      	</tr>
				    </thead>
				    <tbody>
                                        <?php
                                            try {
                                                $sql = $conn->prepare("SELECT * FROM reuniones WHERE ID_ORGANIZACION = :IDORG ORDER BY FECHA_REUNION ASC");
                                                $sql->bindparam(":IDORG", $_SESSION['id_org']);
                                                $sql->execute();
                                                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    if($result['ESTADO'] != 'CANCELADO'){
                                                        echo "<tr>
                                                                <td>".$result['DESCRIPCION']."</td>
                                                                <td class='text-center'>".$result['FECHA_REUNION']."</td>";
                                                        if($result['ESTADO'] == 'PENDIENTE'){
                                                                echo "<td class='text-center'><a href='#' data-toggle='popover' data-trigger='focus' title='Acta de reunión' data-content='No existe acta disponible'>".$result['ESTADO']."</a></td>";
                                                        }
                                                        if($result['ESTADO'] == 'REALIZADO'){
                                                            echo "<td class='text-center'><a href='#' data-toggle='modal' data-target='#ACTA".$result['ID_REUNION']."'>".$result['ESTADO']."</a></td>";
                                                            echo "
                                                                <!-- Modal -->
                                                                <div id='ACTA".$result['ID_REUNION']."' class='modal fade' role='dialog'>
                                                                    <div class='modal-dialog'>
                                                                    <!-- Modal content-->
                                                                        <div class='modal-content'>
                                                                            <div class='modal-header'>
                                                                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                                                <h4 class='modal-title'>Acta de reunión</h4>
                                                                            </div>
                                                                            <div class='modal-body'>
                                                                                <p>
                                                                                    ".$result['ACTA_REUNION']."
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>";
                                                        }
                                                        if($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "4"){
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
                                                            "<td class='text-center'>
                                                                <form action='actividades_reuniones.php' method='POST'>
                                                                    <input type='hidden' id='id_reunion' name='id_reunion' value='".$result['ID_REUNION']."'>
                                                                    <button type='button' class='btn btn-info' id='edit_reunion' name='edit_reunion' data-toggle='modal' data-target='#".$result['ID_REUNION']."' onclick=\"DisplayActa('".$result['ID_REUNION']."')\"><i class='fa fa-edit'></i></button>
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
                                                                                    <textarea class='form-control' id='edit_desc' rows='5' name='edit_desc'>".$result['DESCRIPCION']."</textarea><br>
                                                                                    <label>Estado: </label>
                                                                                    <select class='form-control' id='edit_state".$result['ID_REUNION']."' name='edit_state' required onchange=\"DisplayActa('".$result['ID_REUNION']."')\">
                                                                                        ".$options."
                                                                                    </select><br>
                                                                                    <div id='dacta".$result['ID_REUNION']."'>
                                                                                        <label>Acta de reunión: </label>
                                                                                        <textarea class='form-control' id='acta".$result['ID_REUNION']."' rows='5' name='acta' >".$result['ACTA_REUNION']."</textarea><br>
                                                                                    </div>
                                                                                    <button type='submit' class='btn btn-primary' id='submit-edit' name='submit-edit' onclick=\"return confirm('¿Está seguro de que desea editar este dato?')\">Editar <span class='fa fa-save'></span></button>
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
                        <!-- Modal -->
                        <div id="new_reunion" class='modal fade' role='dialog'>
                            <div class='modal-dialog'>
                            <!-- Modal content-->
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        <h4 class='modal-title'>Agregar reunión</h4>
                                    </div>
                                    <div class='modal-body'>
                                       <form action="actividades_reuniones.php" method="POST">
                                            <label for="fecha_in">Fecha Inicio:</label>
                                            <input type="date" class="form-control" id="fecha_in" name='fecha_in'>
                                            <label for="desc">Descripcion:</label>
                                            <textarea class="form-control" id="desc" rows="5" placeholder="Descripcion" name="desc"></textarea>
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
                    $('[data-toggle="popover"]').popover(); 
                    
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

                function DisplayActa(aid){
                    if(document.getElementById('edit_state'.concat(aid)).value == 'REALIZADO'){
                        document.getElementById('dacta'.concat(aid)).style.display = "block";
                    } else {
                        document.getElementById('dacta'.concat(aid)).style.display = "none";
                        document.getElementById('acta'.concat(aid)).value = "";
                    }
                }
            </script>