<?php
    require_once 'validaciones/conexion_bd.php';
    
    $stmt = $querys->usuario($_SESSION['id_usuario']);
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
        $destino = 'imagenes' ; // Carpeta donde se guardata 
        $sep = explode('image/',$_FILES["file"]["type"]); // Separamos image/ 
        $tipo=$sep[1]; // Optenemos el tipo de imagen que es 
        if($tipo == "jpeg" || $tipo == "jpg" || $tipo == "bmp" || $tipo == "png"){
            if($_FILES['file']['size']<1500000){ //Solo sube la imagen si su tamaño en bytes es pequeña(para no ralentizar el server)
                move_uploaded_file ( $_FILES [ 'file' ][ 'tmp_name' ], $destino . '/' .$_SESSION['id_usuario'].'.jpg');  // Subimos el archivo
            }
            else echo "<script>alert('Imagen muy grande')</script>";
        }
        try{
            $stmt = $querys->pass();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                    $epass = $userRow['PASSWORD'];
                }
            if(password_verify($pass, $epass)){
                $nepass = password_hash($npass,PASSWORD_DEFAULT);
                $querys->newpass($nepass);
                $querys->user_edit($fname,$lname,$mail,$phone);
            }else echo "<script>alert('Contraseña Incorrecta')</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error')</script>";
        }
    }
?>
<div class="modal fade" id="config" role="dialog">
    <div class="modal-dialog modal-lg">
<!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2>Configuración de cuenta</h2>
            </div>
            <div class="modal-body">
        <form method="POST" enctype="multipart/form-data">
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
                    <input type="tel" class="form-control" value="<?php echo $phone?>" name="tel" id="tel" placeholder="Teléfono Nuevo" pattern="[0-9]{9}"required>
                </div>
                <div class="col-sm-4 col-sm-push-2">
                    <label for="mail">Cambiar Correo:</label>
                    <input type="email" class="form-control" value="<?php echo $mail?>" name="mail" placeholder="Correo Nuevo">
                </div>
                <div class="col-sm-6 col-sm-push-2">
                    <br><label class="btn btn-info btn-file">
                        Perfil <i class="fa fa-picture-o" aria-hidden="true"></i><input id="file" name="file" type="file" style="display: none;" accept="image/*">
                    </label>
                </div>
                <div class="col-sm-5 col-sm-push-2">
                    <br><button type="submit" class="btn btn-primary" name="save-submit">Guardar <i class="fa fa-save" aria-hidden="true"></i></button>
                    
                </div>
            </div>
	</form>
            <div class="modal-footer">
                 <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
            </div>
        </div>
    </div>
</div>
</div>