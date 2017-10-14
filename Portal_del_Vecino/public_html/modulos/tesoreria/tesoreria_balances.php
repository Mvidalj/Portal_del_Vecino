<?php
    require_once '../../validaciones/conexion_bd.php';
    
    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        echo '
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Libro caja</title>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <link rel="stylesheet" href="../../css/font-awesome.min.css">
                    <link rel="stylesheet" href="../../css/bootstrap.css">
                    <style type="text/css">
                        @media print
                        {
                            body * { visibility: hidden; }
                            #printcontent * { visibility: visible; }
                            #printcontent { position: absolute; top: 40px; left: 30px; }
                        }
                    </style>
                    <script src="../../librerias/jquery-3.2.1.js"></script>
                    <script src="../../librerias/bootstrap.js"></script>
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
                </head>
                <body>
                    <div class="container">
        ';
        if($_SESSION['id_rol'] == "1"){
?>
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
                                                <li class="active"><a href="tesoreria_balances.php">Ver libro caja</a></li>
                                                <li><a href="tesoreria_recursos.php">Solicitar recursos</a></li>
                                                <li><a href="tesoreria_admin_balances.php">Administrar libro caja</a></li>
                                                <li><a href="tesoreria_admin_recursos.php">Administrar recursos</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Actividades <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="../actividades/actividades_reuniones.php">Reuniones</a></li>
                                                <li><a href="../actividades/actividades_historial.php">Historial de Actividades</a></li>
                                                <li><a href="../actividades/actividades_add_reuniones.php">Añadir Reuniones</a></li>
                                                <li><a href="../actividades/actividades_add_actividades.php">Añadir Actividades</a></li>
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
<?php
        } else { 
?>
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
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proyectos <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="../proyectos/proyectos_proyecto.php">Proyectos</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="../foro/foro.html">Foro</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
<?php   
        }
    }
?>
                        <div class="page-header">
                            <h1>Libro caja</h1>
                        </div>
                        <form action="tesoreria_balances.php" method="POST">
                            <div class="row">
                                <div class="col-sm-1">
                                    <label>Búsqueda:</label>
                                </div>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde">
                                </div>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta">
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" id="select_actividad" name="select_actividad" onchange="reSend()">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_REQUEST['submit-buscar'])){
                                            if($_POST['fecha_desde'] != "" && $_POST['fecha_hasta'] != ""){
                                                if(isset($_POST['select_actividad'])){
                                                    $sql = $conn->prepare("SELECT * FROM tesoreria WHERE FECHA BETWEEN :fecha_desde AND :fecha_hasta AND E_S = :actividad AND ELIMINADO = 0");
                                                    $sql->bindparam(":fecha_desde",  date('Y-m-d', strtotime($_POST['fecha_desde'])));
                                                    $sql->bindparam(":fecha_hasta",  date('Y-m-d', strtotime($_POST['fecha_hasta'])));
                                                    $sql->bindparam(":actividad", $_POST['select_actividad']);
                                                }else{
                                                    $sql = $conn->prepare("SELECT * FROM tesoreria WHERE FECHA BETWEEN :fecha_desde AND :fecha_hasta AND ELIMINADO = 0");
                                                    $sql->bindparam(':fecha_desde',  date('Y-m-d', strtotime($_POST['fecha_desde'])));
                                                    $sql->bindparam(':fecha_hasta',  date('Y-m-d', strtotime($_POST['fecha_hasta'])));
                                                }
                                            }else{
                                                if(isset($_POST['select_actividad'])){
                                                    $sql = $conn->prepare("SELECT * FROM tesoreria WHERE E_S = :actividad OR E_S = 3 AND ELIMINADO = 0");
                                                    $sql->bindparam(":actividad", $_POST['select_actividad']);
                                                }else{
                                                    $sql = $conn->prepare("SELECT * FROM tesoreria WHERE ELIMINADO = 0");
                                                }
                                            }
                                            
                                            try {
                                                $sql->execute();                                 #se ejecuta la consulta
                                                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    if($result['E_S'] == 1 || $result['E_S'] == 3){
                                                        echo "<tr>                                       
                                                            <td>".$result['FECHA']."</td>
                                                            <td>".$result['CONCEPTO']."</td>
                                                            <td class='text-right'>".$result['MONTO']."</td>
                                                            <td></td>
                                                            <td class='text-right'>".$result['MONTO']."</td>
                                                        </tr>";    
                                                    }
                                                    else{
                                                        echo "<tr>                                       
                                                            <td>".$result['FECHA']."</td>
                                                            <td>".$result['CONCEPTO']."</td>
                                                            <td></td>
                                                            <td class='text-right'>".$result['MONTO']."</td>
                                                            <td class='text-right'>".$result['MONTO']."</td>
                                                        </tr>";
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
                                                $sql = $conn->prepare("SELECT * FROM tesoreria WHERE ELIMINADO = 0");
                                                $sql->execute();
                                                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                    if($result['E_S'] == 1 || $result['E_S'] == 3){
                                                        echo "<tr>                                       
                                                            <td>".$result['FECHA']."</td>
                                                            <td>".$result['CONCEPTO']."</td>
                                                            <td class='text-right'>".$result['MONTO']."</td>
                                                            <td></td>
                                                            <td class='text-right'>".$result['MONTO']."</td>
                                                        </tr>";    
                                                    }
                                                    else{
                                                        echo "<tr>                                       
                                                            <td>".$result['FECHA']."</td>
                                                            <td>".$result['CONCEPTO']."</td>
                                                            <td></td>
                                                            <td class='text-right'>".$result['MONTO']."</td>
                                                            <td class='text-right'>".$result['MONTO']."</td>
                                                        </tr>";
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
                    </div>
                    <script>
                        GetSub('2');
                        GetSub('3');
                        GetBalance();
                        function PrintPage() {
                            window.print();
                        }
                        function reSend() {
                            document.querySelectorAll("button[type=submit]")[0].click();
                        }
                    </script>
                </body>
            </html>
