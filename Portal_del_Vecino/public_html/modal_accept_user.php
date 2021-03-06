<?php
    if(isset($_REQUEST['accept_user'])){ //Hace las modificaciones en bd para aceptar un usuario en una org
        $querys->accept_user($_POST['id_usr']);
    }
    if(isset($_REQUEST['deny_user'])){ //Hace las modificaciones en bd para rechazar un usuario en una org
        $querys->deny_user($_POST['id_usr']);
    }
    if(isset($_REQUEST['add_tesorero'])){ //Hace las modificaciones en bd para agregar un tesorero a una org
        $querys->add_tesorero($_POST['id_usr']);
    }
    if(isset($_REQUEST['add_activity'])){ //Hace las modificaciones en bd para agregar un adm de actividades
        $querys->add_admin_actividades($_POST['id_usr']);
    }
    if(isset($_REQUEST['add_proyect'])){ //Hace las modificaciones en bd para agregar un adm de proyectos
        $querys->add_admin_proyectos($_POST['id_usr']);
    }
    if(isset($_REQUEST['delete_privilege'])){ //Hace las modificaciones en bd para quitar privilegios (adm) a un usuario
        $querys->delete_privileges($_POST['id_usr']);
    }
?>
<!-- Modal -->
<div class="modal fade" id="new_user" role="dialog">
    <div class="modal-dialog modal-lg">
<!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2>Administrar usuarios</h2>
            </div>
            <div class="modal-body">
                <h4> Aceptar usuarios</h4>
                    <div class="table-responsive">
                    <table id="modal_accept" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Acción</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $querys->pendientes();                               #se ejecuta la consulta
                                while($result = $stmt->fetch(PDO::FETCH_ASSOC)){   #obtiene los datos de la consulta
                                    $stmt = $querys->usuario($result['ID_USUARIO']);
                                    $result2 = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $fname = $result2['NOMBRE'];
                                    $lname = $result2['APELLIDO'];
                                    $mail  = $result2['CORREO'];
                                    $phone = $result2['TELEFONO'];
                                    $direc  = $result2['DIRECCION'];
                                            echo"<tr>
                                                <form action='home.php' method='POST'>
                                            <td class='text-center'>".$fname."</td>
                                            <td class='text-center'>".$lname."</td>
                                            <td class='text-center'>".$mail."</td>
                                            <td class='text-center'>".$direc."</td>
                                            <td class='text-center'>".$phone."</td>
                                            <td>
                                                <input type='hidden' id='id_usr' name='id_usr' value='".$result['ID_USUARIO']."'>
                                                <button type='submit' class='btn btn-success' id='accept_user' name='accept_user' onclick=\"return confirm('¿Está seguro de que desea aceptar este usuario?')\"><i class='fa fa-check'></i></button>
                                                <button type='submit' class='btn btn-danger' id='deny_user' name='deny_user' onclick=\"return confirm('¿Está seguro de que desea eliminar este usuario?')\"><i class='fa fa-trash-o'></i></button>
                                                </form>
                                            </td></tr>";
                                }
                            } 
                            catch (Exception $e) { // En caso de que algo salga mal, captura el error y lo indica
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                <h4>Admin's</h4>
                <table id="modal_accept" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Módulo</th>
                                <th>Acción</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $haytes = "0"; $hayact="0"; $haypro="0"; // Comienza suponiendo que no hay admin's de ningún tipo
                                $stmt = $querys->moderadores($_SESSION['id_org']);                                  #se ejecuta la consulta
                                while($result = $stmt->fetch(PDO::FETCH_ASSOC)){   #obtiene los datos de la consulta
                                    $fname = $result['NOMBRE'];
                                    $lname = $result['APELLIDO'];
                                    $mail  = $result['CORREO'];
                                    $phone = $result['TELEFONO'];
                                    $direc  = $result['DIRECCION'];
                                    if($result['ID_ROL'] == '3'){$modulo = 'Tesorería'; $haytes="1";}   // Verifica si hay algun
                                    if($result['ID_ROL'] == '4'){$modulo = 'Actividades'; $hayact="1";} // usuario con rol de adm
                                    if($result['ID_ROL'] == '5'){$modulo = 'Proyectos'; $haypro="1";}   // y lo asigna a su variable
                                            echo"<tr>
                                                <form action='home.php' method='POST'>
                                            <td class='text-center'>".$fname."</td>
                                            <td class='text-center'>".$lname."</td>
                                            <td class='text-center'>".$mail."</td>
                                            <td class='text-center'>".$direc."</td>
                                            <td class='text-center'>".$phone."</td>
                                            <td class='text-center'>".$modulo."</td>
                                            <td>
                                                    <input type='hidden' id='id_usr' name='id_usr' value='".$result['ID_USUARIO']."'>
                                                    <button type='submit' class='btn btn-danger' id='delete_privilege' name='delete_privilege'><i class='fa fa-trash-o'></i></button>
                                                </form>
                                            </td></tr>";
                                }
                            } 
                            catch (Exception $e) { // En caso de que algo salga mal, captura el error y lo indica
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                if($haytes == "0"){echo '<font>No existe administrador para Tesoreria,por favor <a data-toggle="modal" data-target="#new_tesorero">Asignar</a> uno.</font><br>';}
                if($hayact == "0"){echo '<font>No existe administrador para Actividades,por favor <a data-toggle="modal" data-target="#new_activity">Asignar</a> uno.</font><br>';}
                if($haypro == "0"){echo '<font>No existe administrador para Proyectos,por favor <a data-toggle="modal" data-target="#new_proyect">Asignar</a> uno.</font><br>';}
                ?>
            </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Para agregar un Tesorero-->
<div class="modal fade" id="new_tesorero" role="dialog"> 
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Agregar Tesorero</h2>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <h4>Usuarios sin Admin</h4>
                <table id="modal_accept" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Acción</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $querys->usr_normal($_SESSION['id_org']);                                   #se ejecuta la consulta
                                while($result = $stmt->fetch(PDO::FETCH_ASSOC)){   #obtiene los datos de la consulta 
                                    $fname = $result['NOMBRE'];
                                    $lname = $result['APELLIDO'];
                                    $mail  = $result['CORREO'];
                                    $phone = $result['TELEFONO'];
                                    $direc  = $result['DIRECCION'];
                                    echo"<tr>
                                        <form action='home.php' method='POST'>
                                    <td class='text-center'>".$fname."</td>
                                    <td class='text-center'>".$lname."</td>
                                    <td class='text-center'>".$mail."</td>
                                    <td class='text-center'>".$direc."</td>
                                    <td class='text-center'>".$phone."</td>
                                    <td>
                                            <input type='hidden' id='id_usr' name='id_usr' value='".$result['ID_USUARIO']."'>
                                            <button type='submit' class='btn btn-primary' id='add_tesorero' name='add_tesorero' onclick=\"return confirm('¿Está seguro de que desea asignar este usuario?')\"><i class='fa fa-plus'></i></button>
                                        </form>
                                    </td></tr>";
                                }
                            } 
                            catch (Exception $e) { echo "Error: " . $e->getMessage();}?>
                        </tbody>
                    </table>
            </div>
            </div>
            <div class="modal-footer">
                 <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Para agregar un admin de actividades -->
<div class="modal fade" id="new_activity" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Agregar Admin Actividades</h2>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <h4>Usuarios sin Admin</h4>
                <table id="modal_accept" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Acción</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $querys->usr_normal($_SESSION['id_org']);                        #se ejecuta la consulta
                                while($result = $stmt->fetch(PDO::FETCH_ASSOC)){   #obtiene los datos de la consulta 
                                    $fname = $result['NOMBRE'];
                                    $lname = $result['APELLIDO'];
                                    $mail  = $result['CORREO'];
                                    $phone = $result['TELEFONO'];
                                    $direc  = $result['DIRECCION'];
                                            echo"<tr>
                                                <form action='home.php' method='POST'>
                                            <td class='text-center'>".$fname."</td>
                                            <td class='text-center'>".$lname."</td>
                                            <td class='text-center'>".$mail."</td>
                                            <td class='text-center'>".$direc."</td>
                                            <td class='text-center'>".$phone."</td>
                                            <td>
                                                    <input type='hidden' id='id_usr' name='id_usr' value='".$result['ID_USUARIO']."'>
                                                    <button type='submit' class='btn btn-primary' id='add_activity' name='add_activity' onclick=\"return confirm('¿Está seguro de que desea asignar este usuario?')\"><i class='fa fa-plus'></i></button>
                                                </form>
                                            </td></tr>";
                                }
                            } 
                            catch (Exception $e) { echo "Error: " . $e->getMessage();}?>
                        </tbody>
                    </table>
            </div>
            </div>
            <div class="modal-footer">
                 <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Para agregar un admin a proyectos -->
<div class="modal fade" id="new_proyect" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Agregar Admin Proyectos</h2>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <h4>Usuarios sin Admin</h4>
                <table id="modal_accept" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Acción</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $querys->usr_normal($_SESSION['id_org']);                               #se ejecuta la consulta
                                while($result = $stmt->fetch(PDO::FETCH_ASSOC)){   #obtiene los datos de la consulta 
                                    $fname = $result['NOMBRE'];
                                    $lname = $result['APELLIDO'];
                                    $mail  = $result['CORREO'];
                                    $phone = $result['TELEFONO'];
                                    $direc  = $result['DIRECCION'];
                                            echo"<tr>
                                                <form action='home.php' method='POST'>
                                            <td class='text-center'>".$fname."</td>
                                            <td class='text-center'>".$lname."</td>
                                            <td class='text-center'>".$mail."</td>
                                            <td class='text-center'>".$direc."</td>
                                            <td class='text-center'>".$phone."</td>
                                            <td>
                                                    <input type='hidden' id='id_usr' name='id_usr' value='".$result['ID_USUARIO']."'>
                                                    <button type='submit' class='btn btn-primary' id='add_proyect' name='add_proyect' onclick=\"return confirm('¿Está seguro de que desea asignar este usuario?')\"><i class='fa fa-plus'></i></button>
                                                </form>
                                            </td></tr>";
                                }
                            } 
                            catch (Exception $e) { echo "Error: " . $e->getMessage();}?>
                        </tbody>
                    </table>
            </div>
            </div>
            <div class="modal-footer">
                 <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Script para las busquedas en tablas -->
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('#modal_accept').DataTable( {
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
