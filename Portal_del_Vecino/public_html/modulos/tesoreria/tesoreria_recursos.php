<?php
    require_once '../../validaciones/conexion_bd.php';

    if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        echo '
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Solicitud de recursos</title>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <link rel="stylesheet" href="../../css/font-awesome.min.css">
                    <link rel="stylesheet" href="../../css/bootstrap.css">
                    <script src="../../librerias/jquery-3.2.1.js"></script>
                    <script src="../../librerias/bootstrap.js"></script>
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
                                                <li class="active"><a href="tesoreria_recursos.php">Solicitar recursos</a></li>
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
                            <h1>Solicitar recursos</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Recurso</th>
                                        <th>Descripción</th>
                                        <th>Disponibilidad</th>
                                        <th>Solicitar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_REQUEST['submit-request'])){
                                            try{
                                                $sql = $conn->prepare("UPDATE recursos SET ESTADO = 1 WHERE ID_RECURSO = :id");
                                                $sql->bindparam(":id", $_POST['id_recurso']);
                                                if($sql->execute()){
                                                    $sql = $conn->prepare("INSERT INTO prestamos (ID_RECURSO, ID_USUARIO, FECHA_INICIO, FECHA_TERMINO, ELIMINADO) VALUES(:ID, :USER, :FROM, :TO, 0)");
                                                    $sql->bindparam(":ID", $_POST['id_recurso']);
                                                    $sql->bindparam(":USER", $_SESSION['id_usuario']);
                                                    $sql->bindparam(":FROM", date('Y-m-d', strtotime($_POST['from_date'])));
                                                    $sql->bindparam(":TO", date('Y-m-d', strtotime($_POST['to_date'])));
                                                    if($sql->execute()){
                                                        echo "<script>alert('Su solicitud se ha realizado correctamente')</script>";
                                                    }
                                                }
                                                
                                            } catch (Exception $e) {
                                                echo "Error: " . $e->getMessage();
                                            }
                                        }
                                        try {
                                            $sql = $conn->prepare("SELECT * FROM recursos WHERE ID_ORGANIZACION = :IDORG");
                                            $sql->bindparam(":IDORG", $_SESSION['id_org']);
                                            $sql->execute();
                                            while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                $solicitar = "<form action='tesoreria_recursos.php' method='POST'>
                                                                <input type='hidden' id='id_recurso' name='id_recurso' value=".$result['ID_RECURSO']."'>
                                                                <button type='button' class='btn btn-primary' id='solicitar' name='solicitar' data-toggle='modal' data-target='#".$result['ID_RECURSO']."'>Solicitar</button>
                                                                <!-- Modal -->
                                                                <div id='".$result['ID_RECURSO']."' class='modal fade' role='dialog'>
                                                                    <div class='modal-dialog'>
                                                                        <!-- Modal content-->
                                                                        <div class='modal-content'>
                                                                            <div class='modal-header'>
                                                                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                                                <h4 class='modal-title'>Solicitar</h4>
                                                                            </div>
                                                                            <div class='modal-body'>
                                                                                <label>Desde:</label>
                                                                                <input type='text' class='form-control' id='from_date' name='from_date' onfocus=\"(this.type='date')\" onblur=\"(this.type='text')\" placeholder='Seleccione una fecha' required><br>
                                                                                <label>Hasta:</label>
                                                                                <input type='text' class='form-control' id='to_date' name='to_date' onfocus=\"(this.type='date')\" onblur=\"(this.type='text')\" placeholder='Seleccione una fecha' required><br>
                                                                                <input type='submit' class='btn btn-success' id='submit-request' name='submit-request' value='Solicitar'>
                                                                            </div>
                                                                            <div class='modal-footer'>
                                                                                <button class='btn btn-danger btn-default pull-left' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span> Cancel</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                               </form>";
                                                
                                                if($result['ESTADO'] == 1){
                                                    $estado = 'Se ha solicitado';
                                                    $sql = $conn->prepare("SELECT * FROM prestamos WHERE ID_RECURSO = ".$result['ID_RECURSO']."");
                                                    $sql->execute();
                                                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                                                    $mindate = $data['FECHA_INICIO'];
                                                    $maxdate = $data['FECHA_TERMINO'];
                                                }else{
                                                    $estado = 'Disponible';
                                                }
                                                echo "<tr>                                       
                                                        <td class='text-center'>".$result['NOMBRE']."</td>
                                                        <td>".$result['DESCRIPCION']."</td>
                                                        <td>".$estado."</td>
                                                        <td>".$solicitar."</td>
                                                    </tr>";
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
                </body>
            </html>