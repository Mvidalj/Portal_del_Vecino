<?php
    require_once 'validaciones/conexion_bd.php';
    
    $stmt = $conn->prepare("SELECT * FROM USUARIOS WHERE ID_USUARIO=".$_SESSION['id_usuario']."");
    $stmt->execute();
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0){
            $fname = $userRow['NOMBRE'];
            $lname = $userRow['APELLIDO'];
            $mail = $userRow['CORREO'];
            $phone = $userRow['TELEFONO'];
        }
    if(isset($_REQUEST['save-submit'])){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $pass = $_POST['pass'];
        $npass = $_POST['npass'];
        $mail = $_POST['mail'];
        $phone = $_POST['phone'];
        try{
            $stmt = $conn->prepare("SELECT PASSWORD FROM LOGIN WHERE ID_USUARIO=".$_SESSION['id_usuario']."");
            $stmt->execute();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                    $epass = $userRow['PASSWORD'];
                }
            if(password_verify($pass, $epass)){
                $nepass = password_hash($npass,PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE LOGIN SET PASSWORD= :nepass WHERE ID_USUARIO =".$_SESSION['id_usuario']."");
                $stmt->bindparam(":nepass", $nepass);
                $stmt->execute();
                $stmt = $conn->prepare("UPDATE USUARIOS SET NOMBRE=:fname, APELLIDO=:lname,CORREO=:mail,TELEFONO=:phone WHERE ID_USUARIO =".$_SESSION['id_usuario']."");
                $stmt->bindparam(":fname", $fname);
                $stmt->bindparam(":lname", $lname);
                $stmt->bindparam(":mail", $mail);
                $stmt->bindparam(":phone", $phone);
                if($stmt->execute()){
                    echo "<script>alert('Datos Guardados Exitosamente')</script>";
                }
            }else echo "<script>alert('Contraseña Incorrecta')</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error')</script>";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Portal del Vecino</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="css/bootstrap-imageupload.css" rel="stylesheet">
</head>
<body>
<div class="container">
	<div class="jumbotron">
		<div class="row">
			<div class="col-sm-2">
	    		<img class="img-responsive" src="imagenes/home.jpg" width="130" height="130">
	    	</div>
	    	<div class="col-sm-10">
	    		<div class="row">
			    	<div class="col-sm-3 col-sm-push-9">
			    		<br><a type="button" class="btn btn-danger conf" href="cerrar_sesion.php" rel>Cerrar sesión <span class="fa fa-sign-out"></span></a>
			    	</div>
			    </div>
			    <div class="row">
			    	<div class="col-sm-3 col-sm-push-9">
			    		<br><a type="button" class="btn btn-primary conf" href="#" rel>Configuración <span class="fa fa-cog"></span></a>
			    	</div>
			    </div>
			    <div class="row">
			    	<div class="col-sm-3 col-sm-push-9">
			    		<br><a type="button" class="btn btn-success conf" href="home.php" rel>Aceptar Miembros (*) <span class="fa fa-user-plus"></span></a>
			    	</div>
			    </div>
			</div>
	    </div>
	</div>

  	<div class="page-header">
  		<h1><a href="home.php"><span class="fa fa-arrow-left"></span></a> Configuración</h1>
	</div>

        <form method="POST">
            <div class="row">
                <div class="col-sm-4 col-sm-push-2">
                    <label for="fname">Nombre:</label>
                    <input type="text" class="form-control" value="<?php echo $fname?>" name="fname" placeholder="Nombre">
                </div>
                <div class="col-sm-4 col-sm-push-2">
                    <label for="lname">Apellido:</label>
                    <input type="text" class="form-control" value="<?php echo $lname?>" name="lname" placeholder="Correo Nuevo">
                </div><br><br><br><br>
                <div class="col-sm-4 col-sm-push-2">
                    <label for="pass">Contraseña Actual:</label>
                    <input type="password" class="form-control" name="pass" placeholder="Contraseña">
                </div>
                <div class="col-sm-4 col-sm-push-2">
                    <label for="npass">Contraseña Nueva:</label>
                    <input type="password" class="form-control" name="npass" placeholder="Contraseña Nueva">
                </div><br><br><br><br>
                <div class="col-sm-4 col-sm-push-2">
                    <label for="phone">Cambiar Telefono:</label>
                    <input type="text" class="form-control" value="<?php echo $phone?>" name="phone" placeholder="Telefono Nuevo">
                </div>
                <div class="col-sm-4 col-sm-push-2">
                    <label for="mail">Cambiar Correo:</label>
                    <input type="email" class="form-control" value="<?php echo $mail?>" name="mail" placeholder="Correo Nuevo">
                </div>
                <div class="col-sm-4 col-sm-offset-5">
                    <br><input type="submit" class="btn btn-primary" value="Guardar todo" name="save-submit">
                    
                </div>
            </div>
        <!--<div class="col-sm-6">
            <div class="imageupload panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title pull-left">Cambiar Imagen</h3>
                </div>
                <div class="file-tab panel-body">
                    <label class="btn btn-default btn-file">
                        <span>Browse</span>
                        <input type="file" name="image-file">
                    </label>
                </div>
            </div>-->	
	</form>
	<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="js/bootstrap-imageupload.js"></script>

    <!--<script>
        var $imageupload = $('.imageupload');
        $imageupload.imageupload();
    </script>-->

</div>
</body>
</html>

<!-- 

    <div id="configuracion" class='modal fade' role='dialog'>
        <div class='modal-dialog'>

            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    <h4 class='modal-title'>Agregar Proyecto</h4>
                </div>
                <div class='modal-body'>
                    <form method="POST">
                        <div class="row">
                            <div class="col-sm-4 col-sm-push-2">
                                <label for="fname">Nombre:</label>
                                <input type="text" class="form-control" value="<?php #echo $fname?>" name="fname" placeholder="Nombre">
                            </div>
                            <div class="col-sm-4 col-sm-push-2">
                                <label for="lname">Apellido:</label>
                                <input type="text" class="form-control" value="<?php #echo $lname?>" name="lname" placeholder="Correo Nuevo">
                            </div><br><br><br><br>
                            <div class="col-sm-4 col-sm-push-2">
                                <label for="pass">Contraseña Actual:</label>
                                <input type="password" class="form-control" name="pass" placeholder="Contraseña">
                            </div>
                            <div class="col-sm-4 col-sm-push-2">
                                <label for="npass">Contraseña Nueva:</label>
                                <input type="password" class="form-control" name="npass" placeholder="Contraseña Nueva">
                            </div><br><br><br><br>
                            <div class="col-sm-4 col-sm-push-2">
                                <label for="phone">Cambiar Telefono:</label>
                                <input type="text" class="form-control" value="<?php #echo $phone?>" name="phone" placeholder="Telefono Nuevo">
                            </div>
                            <div class="col-sm-4 col-sm-push-2">
                                <label for="mail">Cambiar Correo:</label>
                                <input type="email" class="form-control" value="<?php #echo $mail?>" name="mail" placeholder="Correo Nuevo">
                            </div>
                            <div class="col-sm-4 col-sm-offset-5">
                                <br><input type="submit" class="btn btn-primary" value="Guardar todo" name="save-submit">

                            </div>
                        </div>	
                    </form>
                </div>
                <div class='modal-footer'>
                    <button class='btn btn-danger btn-default pull-left' data-dismiss='modal'><span class='glyphicon glyphicon-remove'></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>
-->