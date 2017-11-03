<?php
    if(isset($_REQUEST['accept_user'])){
        $stmt = $conn->prepare("UPDATE usuarios set ID_ORGANIZACION = :id_org WHERE ID_USUARIO = :id_usr");
        $stmt->bindparam(":id_org", $_SESSION['id_org']);
        $stmt->bindparam(":id_usr", $_POST['id_usr']);
        $stmt->execute();
        $stmt = $conn->prepare("UPDATE solicitudes set ESTADO = 1 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
        $stmt->bindparam(":id_usr", $_POST['id_usr']);
        $stmt->bindparam(":id_org", $_SESSION['id_org']);
        $stmt->execute();
    }
    if(isset($_REQUEST['deny_user'])){
        $stmt = $conn->prepare("UPDATE solicitudes set ESTADO = 3 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
        $stmt->bindparam(":id_usr", $_POST['id_usr']);
        $stmt->bindparam(":id_org", $_SESSION['id_org']);
        $stmt->execute();
    }
    if(isset($_REQUEST['delete_privilege'])){
        $stmt = $conn->prepare("UPDATE usuarios set ID_ROL = 2 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
        $stmt->bindparam(":id_usr", $_POST['id_usr']);
        $stmt->bindparam(":id_org", $_SESSION['id_org']);
        $stmt->execute(); 
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
                                $sql = $conn->prepare("SELECT * FROM solicitudes WHERE ID_ORGANIZACION = :id_org AND ESTADO = 2");
                                $sql->bindParam(':id_org', $_SESSION['id_org']);
                                $sql->execute();                                  #se ejecuta la consulta
                                while($result = $sql->fetch(PDO::FETCH_ASSOC)){   #obtiene los datos de la consulta
                                    $sql = $conn->prepare("SELECT * FROM usuarios WHERE ID_USUARIO = :id_usr");
                                    $sql->bindParam(':id_usr', $result['ID_USUARIO']);
                                    $sql->execute();  
                                    $result2 = $sql->fetch(PDO::FETCH_ASSOC);
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
                            catch (Exception $e) {
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
                                $sql = $conn->prepare("SELECT * FROM usuarios WHERE ID_ORGANIZACION = :id_org AND ID_ROL != 1");
                                $sql->bindParam(':id_org', $_SESSION['id_org']);
                                $sql->execute();                                  #se ejecuta la consulta
                                while($result = $sql->fetch(PDO::FETCH_ASSOC)){   #obtiene los datos de la consulta
                                    $fname = $result['NOMBRE'];
                                    $lname = $result['APELLIDO'];
                                    $mail  = $result['CORREO'];
                                    $phone = $result['TELEFONO'];
                                    $direc  = $result['DIRECCION'];
                                    if($result['ID_ROL'] == '2'){$modulo = 'No modulo';}
                                    if($result['ID_ROL'] == '3'){$modulo = 'Tesorería';}
                                    if($result['ID_ROL'] == '4'){$modulo = 'Actividades';}
                                    if($result['ID_ROL'] == '5'){$modulo = 'Proyectos';}
                                            echo"<tr>
                                                <form action='home.php' method='POST'>
                                            <td class='text-center'>".$fname."</td>
                                            <td class='text-center'>".$lname."</td>
                                            <td class='text-center'>".$mail."</td>
                                            <td class='text-center'>".$direc."</td>
                                            <td class='text-center'>".$phone."</td>
                                            <td class='text-center'>".$modulo."</td>
                                            <td>
                                                    <input type='hidden' id='id_usr' name='id_usr' value='".$result['ID_USUARIO']."'>";
                                                    if($modulo == 'No modulo'){echo "<button type='submit' class='btn btn-primary' id='add_admin' name='add_admin'><i class='fa fa-plus'></i></button>";}
                                                    else {echo "
                                                    <button type='submit' class='btn btn-success' id='change_privilege' name='change_privilege'><i class='fa fa-edit'></i></button>
                                                    <button type='submit' class='btn btn-danger' id='delete_privilege' name='delete_privilege'><i class='fa fa-trash-o'></i></button>
                                                </form>
                                            </td></tr>";
                                }}
                            } 
                            catch (Exception $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
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
