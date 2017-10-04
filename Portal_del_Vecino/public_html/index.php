<?php
    require_once 'validaciones/conexion_bd.php';

    if($user->Is_Loggedin()!="")
    {
        $user->Redirect('home.php');
    }
    
    if(isset($_POST['login-submit']))
    {
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
    if(isset($_POST['register-submit'])){
        $fname = $_POST['register-fname'];
        $lname = $_POST['register-lname'];
        $pass = $_POST['register-pass'];
        $mail = $_POST['register-mail'];
        $dir = $_POST['register-dir'];
        $phone = $_POST['register-phone'];
        if($user->RegisterUser($fname, $lname, $mail, $phone, $dir)){
            $user->EncryptPass(($user->GetUserId($mail)),$pass);
            echo "<script>alert('Registrado Correctamente')</script>";
            $user->Redirect('index.php');
        }else{
            echo "<script>alert('Este correo ya esta en uso')</script>";
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/validate-user-register.js"></script>
    <script>
    $(document).ready(function(){
        $("#register-user-submit").click(function(){
            $("#myModal").modal();
        });
    });
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-push-3">
                <div class="jumbotron">
                    <img class="img-responsive center-image" src="imagenes/user-icon.svg" width="200" height="200"><br>

                        <form acton="index.php" method="POST">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="login-user"><i class="fa fa-user-circle-o"></i> Usuario:</label>
                                    <input type="text" id="login-user" class="form-control" name="login-user" placeholder="Correo" autofocus><br>
                                </div>
                                <div class="col-sm-12">
                                    <label for="login-pswd"><i class="fa fa-lock"></i> Contraseña:</label>
                                    <input type="password" id="login-pswd" class="form-control" name="login-pswd" placeholder="Contraseña">
                                </div>
                                <a href="#">¿Olvido su Contraseña? <i class="fa fa-unlock-alt"></i></a>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" id="login-user-submit" class="btn btn-primary" name="login-submit">Iniciar sesión</button>
                                </div>
                                <br><br>
                                <div class="col-sm-12">
                                    <button type="submit" id="register-user-submit" class="btn btn-success">Registrarse como usuario</button>
                                </div>
                            </div>
                        </form>
                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST">
                                                <div class="row">
                                                    <div class="col-sm-3 col-sm-push-3">
                                                        <label for="fname">Nombre:</label>
                                                        <input type="text" class="form-control" name="register-fname" id="fname" placeholder="Nombre" required onchange="validateInputs('fname')">
                                                    </div>
                                                    <div class="col-sm-3 col-sm-push-3">
                                                        <label for="lname">Apellido:</label>
                                                        <input type="text" class="form-control" name="register-lname" id="lname" placeholder="Apellido" required>
                                                    </div>
                                                </div><br><br>
                                                <div class="row">
                                                    <div class="col-sm-3 col-sm-push-3">
                                                        <label for="pass">Contraseña:</label>
                                                        <input type="password" class="form-control" name="register-pass" id="pass" placeholder="Contraseña" required onchange="validatePassword()">
                                                    </div>
                                                    <div class="col-sm-3 col-sm-push-3">
                                                        <label for="cpass">Confirmar Contraseña:</label>
                                                        <input type="password" class="form-control" id="cpass" placeholder="Confirmar Contraseña" required onkeyup="validatePassword()">
                                                    </div>
                                                </div><br><br>
                                                <div class="row">
                                                    <div class="col-sm-3 col-sm-push-3">
                                                        <label for="com">Comuna:</label>
                                                        <input type="text" class="form-control" name="register-com" id="com" placeholder="Comuna" required>
                                                    </div>
                                                    <div class="col-sm-3 col-sm-push-3">
                                                            <label for="dir">Dirección:</label>
                                                            <input type="text" class="form-control" name="register-dir" id="dir" placeholder="Dirección" required>
                                                    </div>
                                                </div><br><br>
                                                <div class="row">
                                                    <div class="col-sm-3 col-sm-push-3">
                                                        <label for="cor">Correo:</label>
                                                        <input type="email" class="form-control" name="register-mail" id="cor" placeholder="Correo" required>
                                                    </div>
                                                    <div class="col-sm-3 col-sm-push-3">
                                                        <label for="tel">Teléfono:</label>
                                                        <input type="text" class="form-control" name="register-phone" id="tel" placeholder="Teléfono" required>
                                                    </div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="col-sm-2 col-sm-push-5">
                                                        <div class="row">
                                                            <div class="col-sm-2 col-sm-push-2">
                                                                <br><input type="submit" class="btn btn-success" name="register-submit"><br><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
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