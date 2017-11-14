<?php
    require_once '../../validaciones/conexion_bd.php';
    require_once '../../validaciones/actions_balances.php';
    require_once '../../header.php';
?>
    <style type="text/css">
        @media print
        {
            body * { visibility: hidden; }
            #printcontent * { visibility: visible; }
            #printcontent { position: absolute; top: 40px; left: 30px; }
        }
    </style>
    <script>
        function GetSub(IN) {
            var table = document.getElementById("detalles");
            var total = 0;
            for (var r = 1, n = table.rows.length; r < n; r++) {
                total += Number(table.rows[r].cells[IN].innerHTML);
            }
            table.rows[n-1].cells[IN].innerHTML = (total.toString()).bold();
        }

        function GetBalance(){
            var table = document.getElementById("detalles");
            var total = 0;
            for (var r = 1, n = table.rows.length -1 ; r < n; r++) {
                table.rows[r].cells[4].innerHTML = Number(table.rows[r].cells[2].innerHTML)-Number(table.rows[r].cells[3].innerHTML);
                if(r > 1){
                    table.rows[r].cells[4].innerHTML = Number(table.rows[r-1].cells[4].innerHTML)+(Number(table.rows[r].cells[2].innerHTML)-Number(table.rows[r].cells[3].innerHTML));
                }
            }
        }
    </script>

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
            <li class="active"><a href="tesoreria_balances.php">Ver libro caja</a></li>
            <li><a href="tesoreria_recursos.php">Solicitar recursos</a></li>
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
                            <h1>Libro caja <?php if ($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "3"){echo '<button type="button" class="btn pull-right btn-success" id="add_entry" name="add_entry" data-toggle="modal" data-target="#new_entry">Nueva entrada <i class="fa fa-edit"></i></button>';}?></h1>
                        </div>
                        <form name="form" action="tesoreria_balances.php" method="POST">
                            <div class="row">
                                <div class="col-sm-1">
                                    <label>Búsqueda:</label>
                                </div>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" onblur=form.fecha_hasta.min=form.fecha_desde.value >
                                </div>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta">
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" id="select_actividad" name="select_actividad" onchange="reSendSearch()">
                                        <option value="" disabled selected>Ingresos/Egresos</option>
                                        <option value="1">Ingresos</option>
                                        <option value="0">Egresos</option>
                                    </select> 
                                </div>
                                <div class="col-sm-1">
                                    <button type="submit" class="btn btn-primary" id="submit-buscar" name="submit-buscar">Buscar <i class="fa fa-search"></i></button>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-info" onclick="PrintPage()">Imprimir resumen <i class="fa fa-print"></i></button>
                                </div>
                            </div>
                        </form>
                        &nbsp;
                        <div id="printcontent" class="table-responsive">
                            <table id="detalles" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Detalle</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                        <th>Saldo</th>
                                        <?php if($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "3"){echo '<th class="col-sm-2">Opciones</th>';}?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_REQUEST['submit-buscar'])){
                                            if($_POST['fecha_desde'] != "" && $_POST['fecha_hasta'] != ""){
                                                if(isset($_POST['select_actividad'])){
                                                    $sql = $conn->prepare("SELECT * FROM tesoreria WHERE ELIMINADO = 0 AND FECHA BETWEEN :fecha_desde AND :fecha_hasta AND E_S = :actividad  AND ID_ORGANIZACION = :IDORG");
                                                    $sql->bindparam(":IDORG", $_SESSION['id_org']);
                                                    $sql->bindparam(":fecha_desde",  date('Y-m-d', strtotime($_POST['fecha_desde'])));
                                                    $sql->bindparam(":fecha_hasta",  date('Y-m-d', strtotime($_POST['fecha_hasta'])));
                                                    $sql->bindparam(":actividad", $_POST['select_actividad']);
                                                }else{
                                                    $sql = $conn->prepare("SELECT * FROM tesoreria WHERE ELIMINADO = 0 AND FECHA BETWEEN :fecha_desde AND :fecha_hasta AND ID_ORGANIZACION = :IDORG");
                                                    $sql->bindparam(":IDORG", $_SESSION['id_org']);
                                                    $sql->bindparam(':fecha_desde',  date('Y-m-d', strtotime($_POST['fecha_desde'])));
                                                    $sql->bindparam(':fecha_hasta',  date('Y-m-d', strtotime($_POST['fecha_hasta'])));
                                                }
                                            }else{
                                                if(isset($_POST['select_actividad'])){
                                                    $sql = $conn->prepare("SELECT * FROM tesoreria WHERE ELIMINADO = 0 AND E_S = :actividad OR E_S = 3 AND ID_ORGANIZACION = :IDORG");
                                                    $sql->bindparam(":IDORG", $_SESSION['id_org']);
                                                    $sql->bindparam(":actividad", $_POST['select_actividad']);
                                                }else{
                                                    $sql = $conn->prepare("SELECT * FROM tesoreria WHERE ELIMINADO = 0 AND ID_ORGANIZACION = :IDORG");
                                                    $sql->bindparam(":IDORG", $_SESSION['id_org']);
                                                }
                                            }
                                            
                                            try {
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
                                                        echo "<tr>                          
                                                                <td>".$result['FECHA']."</td>
                                                                <td>".$result['CONCEPTO']."</td>
                                                                <td class='text-right'>".$result['MONTO']."</td>
                                                                <td></td>
                                                                <td class='text-right'>".$result['MONTO']."</td>
                                                             "; if ($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "3"){
                                                                    echo "<td class='text-center'>
                                                                        <form action='tesoreria_balances.php' method='POST'>
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
                                                                    </td>";
                                                                }
                                                            echo "</tr>";
                                                    } else {
                                                        $actividad = 'Salida';
                                                        $options = "<option value='3'>Registro de saldo</option>
                                                                    <option value='1'>Ingreso</option>
                                                                    <option value='0' selected>Egreso</option>
                                                                    ";
                                                        echo "<tr>                                       
                                                                <td>".$result['FECHA']."</td>
                                                                <td>".$result['CONCEPTO']."</td>
                                                                <td></td>
                                                                <td class='text-right'>".$result['MONTO']."</td>
                                                                <td class='text-right'>".$result['MONTO']."</td>
                                                                "; if ($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "3"){
                                                                    echo "<td class='text-center'>
                                                                        <form action='tesoreria_balances.php' method='POST'>
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
                                                                    </td>";
                                                                }
                                                            echo "</tr>";
                                                    }
                                                }
                                                echo "<tr class='info'>
                                                        <td><strong>".date('Y-m-d', time())."</strong></td>
                                                        <td><strong>SUB-TOTAL</strong></td>
                                                        <td class='text-right'></td>
                                                        <td class='text-right'></td>
                                                        <td></td>
                                                      </tr>";
                                            }
                                            catch (Exception $e) {
                                                echo "Error: " . $e->getMessage();#captura el error y lo muestra
                                            }
                                        } else{
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
                                                        
                                                        echo "<tr>                                       
                                                            <td>".$result['FECHA']."</td>
                                                            <td>".$result['CONCEPTO']."</td>
                                                            <td class='text-right'>".$result['MONTO']."</td>
                                                            <td></td>
                                                            <td class='text-right'>".$result['MONTO']."</td>
                                                            "; if ($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "3"){
                                                                    echo "<td class='text-center'>
                                                                        <form action='tesoreria_balances.php' method='POST'>
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
                                                                    </td>";
                                                                }
                                                            echo "</tr>";
                                                    }
                                                    else{
                                                        $actividad = 'Salida';
                                                        $options = "<option value='3'>Registro de saldo</option>
                                                                    <option value='1'>Ingreso</option>
                                                                    <option value='0' selected>Egreso</option>
                                                                    ";
                                                        echo "<tr>                                       
                                                            <td>".$result['FECHA']."</td>
                                                            <td>".$result['CONCEPTO']."</td>
                                                            <td></td>
                                                            <td class='text-right'>".$result['MONTO']."</td>
                                                            <td class='text-right'>".$result['MONTO']."</td>
                                                            "; if ($_SESSION['id_rol'] == "1" || $_SESSION['id_rol'] == "3"){
                                                                    echo "<td class='text-center'>
                                                                        <form action='tesoreria_balances.php' method='POST'>
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
                                                                    </td>";
                                                                }
                                                            echo "</tr>";
                                                    }
                                                }
                                                
                                                echo "<tr class='info'>
                                                        <td><strong>".date('Y-m-d', time())."</strong></td>
                                                        <td><strong>SUB-TOTAL</strong></td>
                                                        <td class='text-right'></td>
                                                        <td class='text-right'></td>
                                                        <td class='text-right'></td>
                                                      </tr>";
                                                
                                            }
                                            catch (Exception $e) {
                                                echo "Error: " . $e->getMessage();
                                            }
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
                                       <form action="tesoreria_balances.php" method="POST">
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
                    <script>
                        GetSub('2');
                        GetSub('3');
                        GetBalance();
                        function PrintPage() {
                            window.print();
                        }
                        function reSendSearch() {
                            document.querySelectorAll("button[type=submit]")[1].click(); //
                        }
                    </script>
                    <div>	
                        <?php include("../../modal_accept_user.php");
                              include ('../../config.php');?>		
                    </div>
                </body>
            </html>