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
                    <title>Resumen</title>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <link rel="stylesheet" href="../../css/font-awesome.min.css">
                    <link rel="stylesheet" href="../../css/bootstrap.css">
                    <link rel="stylesheet" href="../../css/jquery.dataTables.min.css">
                    <script src="../../librerias/jquery-3.2.1.js"></script>
                    <script src="../../librerias/bootstrap.js"></script>
                    <script src="../../librerias/jquery.dataTables.min.js"></script>

                    <!-- Configuración de lenguaje de DataTable -->
                    <script type="text/javascript">
                    $(document).ready(function() {
                            $("#example").DataTable( {
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
                                                <li><a href="tesoreria_balances.php">Ver libro caja</a></li>
                                                <li class="active"><a href="tesoreria_resumen.php">Ver resumen</a></li>
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
                                                <li><a href="../actividades/actividades_add_reuniones.html">Añadir Reuniones</a></li>
                                                <li><a href="../actividades/actividades_add_actividades.html">Añadir Actividades</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proyectos <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="../proyectos/proyectos_proyecto.php">Proyectos</a></li>
                                                <li><a href="../proyectos/proyectos_add_proyectos.php">Añadir Proyectos</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="../foro/foro.html">Foro</a></li>
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
                                                <li><a href="tesoreria_balances.php">Ver libro caja</a></li>
                                                <li class="active"><a href="tesoreria_resumen.php">Ver resumen</a></li>
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
                            <h4>Resumen</h4>
                        </div>
                        
                        <form action="tesoreria_resumen.php" method="POST">
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
                                    <select class="form-control" id="select_actividad" name="select_actividad">
                                        <option value="" disabled selected>Ingresos/Egresos</option>
                                        <option value="1">Ingresos</option>
                                        <option value="0">Egresos</option>
                                    </select> 
                                </div>
                                <div class="col-sm-2">
                                    <input type="submit" class="btn btn-primary" id="submit-buscar" name="submit-buscar" value="Buscar">
                                </div>
                            </div>
                        </form>
                        &nbsp;
                        <div class="table-responsive">
                            <table id="example" class="table table-striped cell-border">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Actividad</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_REQUEST['submit-buscar'])){
                                            if($_POST['fecha_desde'] != "" && $_POST['fecha_hasta'] != ""){
                                                if(isset($_POST['select_actividad'])){
                                                    $sql = $conn->prepare("SELECT * FROM tesoreria WHERE FECHA BETWEEN :fecha_desde AND :fecha_hasta AND E_S = :actividad");
                                                    $sql->bindparam(":fecha_desde",  date('Y-m-d', strtotime($_POST['fecha_desde'])));
                                                    $sql->bindparam(":fecha_hasta",  date('Y-m-d', strtotime($_POST['fecha_hasta'])));
                                                    $sql->bindparam(":actividad", $_POST['select_actividad']);
                                                }else{
                                                    $sql = $conn->prepare("SELECT * FROM tesoreria WHERE FECHA BETWEEN :fecha_desde AND :fecha_hasta");
                                                    $sql->bindparam(':fecha_desde',  date('Y-m-d', strtotime($_POST['fecha_desde'])));
                                                    $sql->bindparam(':fecha_hasta',  date('Y-m-d', strtotime($_POST['fecha_hasta'])));
                                                }
                                            }else{
                                                $sql = $conn->prepare("SELECT * FROM tesoreria");
                                            }
                                            
                                            try {
                                                $sql->execute();                                 #se ejecuta la consulta
                                                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {#obtiene los datos de la consulta
                                                    if($result['E_S'] == 1){$actividad = 'Ingreso';}
                                                    else{$actividad = 'Egreso';}
                                                
                                                    echo "<tr>                                       
                                                            <td class='text-center'>".$result['FECHA']."</td>
                                                            <td>".$actividad."</td>
                                                            <td>".$result['MONTO']."</td>
                                                        </tr>";
                                                } # por cada dato crea una columna
                                            }
                                            catch (Exception $e) {
                                                echo "Error: " . $e->getMessage();#captura el error y lo muestra
                                            }
                                        } else{
                                            try {
                                                $sql = $conn->prepare("SELECT * FROM tesoreria");
                                                $sql->execute();                                 #se ejecuta la consulta
                                                while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {#obtiene los datos de la consulta
                                                    if($result['E_S'] == 1){$actividad = 'Ingreso';}
                                                    else{$actividad = 'Egreso';}
                                                
                                                    echo "<tr>                                       
                                                            <td class='text-center'>".$result['FECHA']."</td>
                                                            <td>".$actividad."</td>
                                                            <td>".$result['MONTO']."</td>
                                                        </tr>";
                                                } # por cada dato crea una columna
                                            }
                                            catch (Exception $e) {
                                                echo "Error: " . $e->getMessage();#captura el error y lo muestra
                                            }
                                        }
                                        
                                    ?>
                                </tbody>
                            </table>
                        </div>
                </body>
            </html>