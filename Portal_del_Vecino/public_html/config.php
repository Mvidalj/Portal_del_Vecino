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
        $phone = $_POST['tel'];
        //$img = $_POST['image'];
        //$img = "../imagenes/home.jpg";
        //$target_dir = "imagenes/";
        //$name = $_FILES['image']['name'];
        //$uploadOk = 1;
        //$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        //    $check = getimagesize($_FILES["image"]["tmp_name"]);
        //if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$name)) {
        //        echo "The file ". basename( $name). " has been uploaded.";
        //    }
        //$input = 'http://images.websnapr.com/?size=size&key=Y64Q44QLt12u&url=http://google.com';
        //$output = 'google.com.jpg';
        //file_put_contents($output, file_get_contents($input));
        //$image = imagecreatefromjpeg("C:\Usuarios\Mathias\Imágenes\Eevee.png");
        //imagecopy($image, $image, 0, 140, 0, 0, imagesx($image), imagesy($image));
        //imagejpeg($image, "imagenes/file.jpg");
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
    <link rel="stylesheet" href="css/jquery.dataTables.min.css">
    <script src="librerias/jquery-3.2.1.js"></script>
    <script src="librerias/bootstrap.js"></script>
    <script src="librerias/jquery.dataTables.min.js"></script>
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
			    		<br><a type="button" class="btn btn-success conf" data-toggle="modal" data-target="#new_user" rel>Aceptar Miembros <span class="fa fa-user-plus"></span></a>
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
                    <input type="text" class="form-control" value="<?php echo $fname?>" name="fname" id="fname" placeholder="Nombre" required onchange="validateInputs('fname')">
                </div>
                <div class="col-sm-4 col-sm-push-2">
                    <label for="lname">Apellido:</label>
                    <input type="text" class="form-control" value="<?php echo $lname?>" name="lname" id="lname" placeholder="Apellido" onchange="validateInputs('lname')" required>
                </div><br><br><br><br>
                <div class="col-sm-4 col-sm-push-2">
                    <label for="pass">Contraseña Actual:</label>
                    <input type="password" class="form-control" name="pass" placeholder="Contraseña" required>
                </div>
                <div class="col-sm-4 col-sm-push-2">
                    <label for="npass">Contraseña Nueva:</label>
                    <input type="password" class="form-control" name="npass" placeholder="Contraseña Nueva" required>
                </div><br><br><br><br>
                <div class="col-sm-4 col-sm-push-2">
                    <label for="phone">Cambiar Telefono:</label>
                    <input type="tel" class="form-control" name="tel" id="tel" placeholder="Teléfono Nuevo" pattern="[0-9]{9}"required>
                </div>
                <div class="col-sm-4 col-sm-push-2">
                    <label for="mail">Cambiar Correo:</label>
                    <input type="email" class="form-control" value="<?php echo $mail?>" name="mail" placeholder="Correo Nuevo">
                </div>
                <div class="col-sm-6 col-sm-push-2">
                    <br><label class="btn btn-info btn-file">
                        Perfil <i class="fa fa-picture-o" aria-hidden="true"></i><input type="file" name="image" style="display: none;" accept="image/*">
                    </label>
                </div>
                <div class="col-sm-4 col-sm-push-2">
                    <br><button type="submit" class="btn btn-primary" name="save-submit">Guardar <i class="fa fa-save" aria-hidden="true"></i></button>
                    
                </div>
            </div>
	</form>
</div>
<div>	
    <?php include("modal_accept_user.php");?>		
</div>
</body>
</html>