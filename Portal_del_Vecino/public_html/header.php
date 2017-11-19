<html>
<head>
    <title>Portal del Vecino</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/jquery.dataTables.min.css">
    <script src="../../librerias/jquery-3.2.1.js"></script>
    <script src="../../librerias/bootstrap.js"></script>
    <script src="../../librerias/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#news").modal();
        });
        $(document).ready(function(){
            $("#createorg").click(function(){
                $("#form-createorg").show();
                $("#form-uniteorg").hide();
            });
            $("#uniteorg").click(function(){
                $("#form-uniteorg").show();
                $("#form-createorg").hide();
            });
        });
        function reSend() {
            document.querySelectorAll("button[type=submit]")[0].click();
        }
    </script>
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <div class="row">
            <div class="col-sm-2">
                <img class="img-responsive" src="../../imagenes/home.jpg" width="130" height="130">
            </div>
            <div class="col-sm-6 col-sm-push-1">
                <div class="row">
                    <div class="col-sm-3">
                        <?php
                        if (file_exists("../../imagenes/".$_SESSION["id_usuario"].".".$_SESSION["extensionimage"]."")){
                            echo '<img src="../../imagenes/'.$_SESSION["id_usuario"].'.'.$_SESSION["extensionimage"].'" width="100" height="100">';
                        }else{ echo '<img src="../../imagenes/testimage.jpg" width="100" height="100">';}
                        ?>
                    </div>
                    <div class="col-sm-9">
                        <h3>Bienvenido <?php echo $_SESSION["nombre"]." ". $_SESSION["apellido"]?></h3>
                    </div>
                    <div class="col-sm-3">
                        <h4>Organización:</h4> 
                    </div>
                    <div class="col-sm-6">
                        <form name="form" action="" method="POST">
                            <button type="submit" id="submit-select" name="submit-select" hidden></button>
                            <select class="form-control" id="morg" name="morg" onchange="reSend()">
                                <?php  $stmt = $conn->prepare("SELECT * FROM ASOCIADOS, ORGANIZACIONES WHERE "
                                        . "ASOCIADOS.ID_ORGANIZACION = ORGANIZACIONES.ID_ORGANIZACION and ID_USUARIO = :id_usr");
                                    $stmt->bindParam(':id_usr', $_SESSION['id_usuario']);
                                    $stmt->execute();
                                    $data = array();$count = 0;
                                    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        array_push($data,$result['ID_USUARIO'],$result['ID_ORGANIZACION'],$result['ID_ROL']);
                                        if ($result['ID_ORGANIZACION'] == $_SESSION['id_org']){
                                            echo "<option value='".$count."' selected>".$result['NOMBRE']."</option>";
                                        }else{
                                            echo "<option value='".$count."'>".$result['NOMBRE']."</option>";
                                        }
                                        $count += 3;
                                    }
                                    if(isset($_REQUEST['submit-select'])){
                                        $cont = $_POST['morg'];
                                        try{
                                            $stmt = $conn->prepare("UPDATE usuarios SET ID_ORGANIZACION = :id_org, ID_ROL = :id_rol "
                                                    . "WHERE usuarios.ID_USUARIO = :id_usr");
                                            $stmt->bindParam(':id_usr', $data[$cont+0]);
                                            $stmt->bindParam(':id_org', $data[$cont+1]);
                                            $stmt->bindParam(':id_rol', $data[$cont+2]);
                                            if($stmt->execute()){
                                                $_SESSION['id_org'] = $data[$cont+1];
                                                $_SESSION['id_rol'] = $data[$cont+2];
                                                echo '<script> window.location.replace(location);</script>';
                                            }
                                        }catch(PDOException $e){
                                            echo "<script>alert('Hubo un error, intentelo nuevamentes')</script>";
                                        }
                                    }
                                 ?>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-sm-push-1">
                <div class="row">
                    <div class="col-sm-10 col-sm-push-2">
                        <br><a type="button" class="btn btn-danger conf" href="../../cerrar_sesion.php" rel>Cerrar sesión <span class="fa fa-sign-out"></span></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10 col-sm-push-2">
                        <br><a type="button" class="btn btn-primary conf" data-toggle="modal" data-target="#config" rel>Configuración <span class="fa fa-cog"></span></a>
                    </div>
                </div>
                <?php
                if($_SESSION['id_rol'] == "1"){
                    echo '
                <div class="row">
                <div class="col-sm-10 col-sm-push-2">
                    <br><a type="button" class="btn btn-success conf" data-toggle="modal" data-target="#new_user" rel>Administrar Miembros <span class="fa fa-user-plus"></span></a>
                </div>
                </div>';}?>
            </div>
        </div>
    </div>