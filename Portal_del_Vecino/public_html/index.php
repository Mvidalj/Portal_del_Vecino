<?php
    require_once 'validaciones/conexion_bd.php';
    
    if($user->Is_Loggedin() == true)
    {
        $user->Redirect('home.php');
    }
    $fname = '';$lname = '';$pass = '';$mail = '';$phone = '';$com = '';$dir = '';$umail='';
    if(isset($_REQUEST['login-submit']))
    {//Acciones para loguear al usuario
        $umail = $_POST['login-user'];
        $upass = $_POST['login-pswd'];
        if($user->LoginUser(($user->GetUserId($umail)),$upass))
        {
            $user->Redirect('home.php');
        }
        else
        {
            echo "<script>alert('Contraseña incorrecta')</script>";
        } 
    }
    if(isset($_REQUEST['register-submit'])){ //Acciones para registrarse como usuario
        $fname = $_POST['register-fname'];
        $lname = $_POST['register-lname'];
        $pass = $_POST['register-pass'];
        $mail = $_POST['register-mail'];
        $phone = $_POST['register-phone'];
        $com = $_POST['register-com'];
        $dir = $_POST['register-dir'];
        
        // Se verifica si el captcha ingresado coincide si es así el usuario es registrado, en caso contrario se indica el fallo
        if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
            echo "<script>alert('Los codigos nos coinciden, intente nuevamente.')</script>";
	}else{	
            if($user->RegisterUser($fname, $lname, $mail, $phone, $com, $dir)){
                $user->EncryptPass(($user->GetUserId($mail)), $mail, $pass);
                echo "<script>alert('Por favor revise su correo y confirme su cuenta.')</script>";
            }else{
                echo "<script>alert('Este correo ya esta en uso.')</script>";
            }
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
    <link rel="stylesheet" href="estilos/estilo.css">
    <script src="librerias/jquery-3.2.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/validate-user-register.js"></script>
    <script type='text/javascript'>
        // Cambia el captcha
        function refreshCaptcha(){
            var img = document.images['captchaimg'];
            img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-push-3">
                <div class="jumbotron">
                    <img class="img-responsive center-image" src="imagenes/user-icon.svg" width="200" height="200"><br>
                    <div class="row">
                        <div class="col-sm-8 col-sm-push-2">
                            <form action="index.php" method="POST">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="login-user"><i class="fa fa-user-circle-o"></i> Usuario:</label>
                                        <input type="text" id="login-user" class="form-control" name="login-user" placeholder="Correo" autofocus required value= <?php echo $umail; ?>>
                                    </div>
                                </div>&nbsp;
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="login-pswd"><i class="fa fa-lock"></i> Contraseña:</label>
                                        <input type="password" id="login-pswd" class="form-control" name="login-pswd" placeholder="Contraseña" required>
                                        <a href="validaciones/recoverpass.php">¿Olvido su Contraseña <i class="fa fa-unlock-alt"></i> ?</a>
                                    </div>
                                </div>&nbsp;
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" id="login-user-submit" class="btn btn-primary form-control" name="login-submit">Iniciar sesión</button>
                                    </div>&nbsp;
                                    <div class="col-sm-12">
                                        <button type="button" id="register-user-submit" class="btn btn-success form-control" data-toggle="modal" data-target="#register">Registrarse como usuario</button>
                                    </div>
                                </div>&nbsp;&nbsp;
                            </form>
                            <!-- Modal para registrarse-->
                            <div class="modal fade" id="register" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form action="index.php" method="POST">
                                                <div class="row">
                                                    <div class="col-sm-5 col-sm-push-1">
                                                        <label for="fname">Nombre:</label>
                                                        <input type="text" class="form-control" name="register-fname" id="fname" placeholder="Nombre" required onchange="validateInputs('fname')" value=<?php echo $fname; ?>>
                                                    </div>
                                                    <div class="col-sm-5 col-sm-push-1">
                                                        <label for="lname">Apellido:</label>
                                                        <input type="text" class="form-control" name="register-lname" id="lname" placeholder="Apellido" required onchange="validateInputs('lname')" value=<?php echo $lname; ?>>
                                                    </div>
                                                </div><br><br>
                                                <div class="row">
                                                    <div class="col-sm-5 col-sm-push-1">
                                                        <label for="pass">Contraseña:</label>
                                                        <input type="password" class="form-control" name="register-pass" id="pass" placeholder="Contraseña" required onchange="validatePassword('pass','cpass')">
                                                    </div>
                                                    <div class="col-sm-5 col-sm-push-1">
                                                        <label for="cpass">Confirmar Contraseña:</label>
                                                        <input type="password" class="form-control" id="cpass" placeholder="Confirmar Contraseña" required onkeyup="validatePassword('pass','cpass')">
                                                    </div>
                                                </div><br><br>
                                                <div class="row">
                                                    <div class="col-sm-5 col-sm-push-1">
                                                        <label for="com">Comuna:</label>
                                                        <select class="form-control" id="com" name="register-com" value=<?php echo $com; ?>>
                                                            <option value="" selected disabled>Comuna</option>
                                                            <?php  $stmt = $querys->comunas(); //Consulta a bs las comunas y las pone como opciones
                                                                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                    echo "<option value=".$result['ID_COMUNA'].">".$result['COMUNA']."</option>";
                                                                }
                                                             ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-5 col-sm-push-1">
                                                            <label for="dir">Dirección:</label>
                                                            <input type="text" class="form-control" name="register-dir" id="dir" placeholder="Dirección" required value=<?php echo $dir; ?>>
                                                    </div>
                                                </div><br><br>
                                                <div class="row">
                                                    <div class="col-sm-5 col-sm-push-1">
                                                        <label for="cor">Correo:</label>
                                                        <input type="email" class="form-control" name="register-mail" id="cor" placeholder="Correo" required value=<?php echo $mail; ?>>
                                                    </div>
                                                    <div class="col-sm-5 col-sm-push-1">
                                                        <label for="tel">Teléfono:</label>
                                                        <input type="tel" class="form-control" name="register-phone" id="tel" placeholder="Teléfono" pattern="[0-9]{9}"required value=<?php echo $phone; ?>>
                                                    </div>
                                                    
                                                </div><br>
                                                <div class="row">
                                                    <div class="col-sm-4 col-sm-push-4">
                                                        <img src="validaciones/phpcaptcha/captcha.php?rand=<?php echo rand();?>" id='captchaimg'>
                                                    </div>
                                                </div>
                                                <div class="row">   
                                                    <div class="col-sm-4 col-sm-push-4">
                                                        <input id="captcha_code" class="form-control" name="captcha_code" type="text">
                                                    </div>
                                                    <div class="col-sm-1 col-sm-push-4">
                                                        <a href='javascript: refreshCaptcha();'><i class="fa fa-refresh fa-lg"></i></a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4 col-sm-push-1">
                                                        <br><input type="submit" class="btn btn-success" value="Registrarse" name="register-submit"><br><br>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
