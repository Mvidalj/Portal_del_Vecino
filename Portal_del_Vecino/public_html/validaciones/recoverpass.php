<?php
    require_once 'conexion_bd.php';
    use PHPMailer\PHPMailer\PHPMailer; // Inicialización para uso de clase
    use PHPMailer\PHPMailer\Exception; // Inicialización para uso de clase

    if(isset($_REQUEST['mail-submit'])){
        $umail = $_POST['recover-mail'];
        $uid   = $user->GetUserId($umail);
        
        // Cargado de librería para enviar correos
        
        // Correo:     portaldelvecino@gmail.com
        // Contraseña: juntavecinal
        require 'vendor/autoload.php';
        $mail = new PHPMailer(true);                              // Inicia variable con añadido de excepciones
        $mail->setLanguage('es');                                 // Se setea lenguaje de la librería
        $mail->CharSet = 'UTF-8';                                 // Se setea codificación para tíldes en correo
        try {
            // Configuraciones de servidor
            $mail->isSMTP();                                      // Se indica prótocolo SMTP
            $mail->Host = 'in-v3.mailjet.com';                    // Se indica servidor SMTP
            $mail->SMTPAuth = true;                               // Activa autenticación en servidor
            $mail->Username = 'b38c4baf0a6e52d7a04781a9b83caa3b'; // Key pública Mailjet
            $mail->Password = 'cf6adbb5a21655f233b788f57bae81d1'; // Key privada Mailjet 
            $mail->SMTPSecure = 'tls';                            // Habilita encriptación tls si el servidor la posee
            $mail->Port = 587;                                    // Puerto de conexión TCP

            //Recipients
            $mail->setFrom('portaldelvecino@gmail.com', 'Portal del vecino');       // Dirección y nombre del remitente
            $mail->addAddress($umail);                                              // Dirección del receptor
            $mail->addReplyTo('no-reply@vecinos.cl', 'No responder a este correo'); // Dirección de correo en caso de respuesta del receptor

            //Content
            $mail->isHTML(true);                                                     // Se habilita muestra de contenido en formato HTML
            $mail->Subject = 'Portal del vecino: Recuperación de contraseña';        // Asunto del correo
            $mail->Body    = 'Por favor click aquí para recuperar tu contraseña: <a href="http://localhost/Portal_del_Vecino/Portal_del_vecino/public_html/validaciones/recoverpass.php?email='.$umail.'&userid='.$uid.'">Recuperar mi contraseña</a>'; // Texto plano a enviar
            $mail->AltBody = 'Por favor click aquí para recuperar tu contraseña: <a href="http://localhost/Portal_del_Vecino/Portal_del_vecino/public_html/validaciones/recoverpass.php?email='.$umail.'&userid='.$uid.'">Recuperar mi contraseña</a>'; // Contenido HTML

            $mail->send(); // Se envía el mensaje
        } catch (Exception $e) { // En caso de error lo muestra
            echo "<script>alert('No se pudo enviar el mensaje.')</script>";
        }
        echo "<script>alert('Te hemos enviado un correo para recuperar tu contraseña');window.location.href='../index.php';</script>";
    }
    
    if(isset($_REQUEST['recover-submit'])){
        $uid = $_POST['recover-id'];
        $newpswd = $_POST['recoverpswd'];
        try{
            $epass = password_hash($newpswd, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE login SET PASSWORD = :epass WHERE ID_USUARIO = :uid");
            $stmt->bindparam(":epass", $epass);
            $stmt->bindparam(":uid", $uid);
            if($stmt->execute()){
                echo "<script>alert('Tu contraseña se ha actualizado');window.location.href='../index.php';</script>";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Portal del Vecino</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="../librerias/jquery-3.2.1.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/validate-user-register.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-push-3">
                <div class="jumbotron">
                    <img class="img-responsive center-image" src="../imagenes/unlock.png" width="200" height="200"><br>
                    <div class="row">
                        <div class="col-sm-8 col-sm-push-2">
                            <?php
                                // Si el usuario ingreso mediante el link enviado a su correo se despliega un formulario para actualizar su contraseña
                                if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['userid']) && !empty($_GET['userid'])){
                            ?>
                            <form action="recoverpass.php" method="POST">
                                <?php
                                    echo '<input type="hidden" id="recover-id" name="recover-id" value="'.$_GET['userid'].'">';
                                ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="recoverpswd"><i class="fa fa-unlock"></i> Nueva contraseña:</label>
                                        <input type="password" id="recoverpswd" class="form-control" name="recoverpswd" placeholder="Nueva contraseña" required onchange="validatePassword('recoverpswd', 'recoverconfirm')">
                                    </div>
                                </div>&nbsp;
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="recoverconfirm"><i class="fa fa-unlock"></i> Confirmar contraseña:</label>
                                        <input type="password" id="recoverconfirm" class="form-control" name="recoverconfirm" placeholder="Confirmar contraseña" required onkeyup="validatePassword('recoverpswd', 'recoverconfirm')">
                                    </div>
                                </div>&nbsp;
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" id="recover-submit" class="btn btn-primary form-control" name="recover-submit">Guardar contraseña <i class="fa fa-save"></i></button>
                                    </div>&nbsp;
                                </div>
                            </form>
                            <?php
                                // En caso contrario se despliega un formulario para enviar al correo del usuario la recuperación de contraseña
                            }else{
                            ?>
                                <form action="recoverpass.php" method="POST">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="recover-mail"><i class="fa fa-user-circle-o"></i> Ingrese su correo:</label>
                                            <input type="email" id="recover-mail" class="form-control" name="recover-mail" placeholder="Correo" required>
                                        </div>
                                    </div>&nbsp;
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" id="mail-submit" class="btn btn-primary form-control" name="mail-submit">Recuperar contraseña <i class="fa fa-mail-forward"></i></button>
                                        </div>&nbsp;
                                    </div>
                                </form>
                            <?php
                            }
                            ?>
                            <a class="btn btn-danger form-control" href="../index.php">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>