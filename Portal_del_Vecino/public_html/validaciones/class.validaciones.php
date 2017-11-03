<?php
    SESSION_START();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    class USER {

        private $db;

        function __construct($DB_con){
            $this->db = $DB_con;
        }
        
        //  Función para registro de usuarios
        //  IMPORTANTE MODIFICAR PARA QUE SEA FUNCIONAL RESPECTO A BD Y CAMPOS
          
        // Función para Encriptar la contraseña
        public function EncryptPass($id,$umail,$pass){
            try{
                
                $stmt = $this->db->prepare("INSERT INTO login(ID_USUARIO,PASSWORD)"
                        . "VALUES(:id, :pass)");
                $epass = password_hash($pass,PASSWORD_DEFAULT);
                $stmt->bindparam(":id", $id);
                $stmt->bindparam(":pass", $epass);
                $stmt->execute();
                
                require 'vendor/autoload.php';
                //Correo:     portaldelvecino@gmail.com
                //Contraseña: juntavecinal
                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                try {
                    //Server settings
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'in-v3.mailjet.com';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = 'b38c4baf0a6e52d7a04781a9b83caa3b';                 // SMTP username
                    $mail->Password = 'cf6adbb5a21655f233b788f57bae81d1';                           // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom('portaldelvecino@gmail.com', 'Portal del vecino');
                    $mail->addAddress($umail);               // Name is optional
                    $mail->addReplyTo('no-reply@vecinos.cl', 'No responder a este correo');

                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Confirmación de cuenta';
                    $mail->Body    = 'Por favor click aquí para activar tu cuenta: <a href="http://localhost/Portal_del_Vecino/Portal_del_vecino/public_html/validaciones/verify.php?email='.$umail.'&hash='.$epass.'">Confirmar mi cuenta!</a>';
                    $mail->AltBody = 'Por favor click aquí para activar tu cuenta: <a href="http://localhost/Portal_del_Vecino/Portal_del_vecino/public_html/validaciones/verify.php?email='.$umail.'&hash='.$epass.'">Confirmar mi cuenta!</a>';
                    
                    $mail->send();
                } catch (Exception $e) {
                    echo "<script>alert('No se pudo enviar el mensaje.')</script>";
                }
                return $stmt;

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        // Función para guardar datos de un nuevo usuario
        public function RegisterUser($fname,$lname,$umail,$phone,$com,$dir){
            try
            {   
                $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE CORREO = :umail LIMIT 1");
                $stmt->bindparam(":umail", $umail);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    return false;
                }

                $stmt = $this->db->prepare("INSERT INTO usuarios (NOMBRE, APELLIDO, CORREO, TELEFONO, ID_ROL, ID_COMUNA, DIRECCION, ELIMINADO) VALUES (:fname, :lname, :umail, :phone, 2, :com, :dir, 0)");

                $stmt->bindparam(":fname", $fname);
                $stmt->bindparam(":lname", $lname);
                $stmt->bindparam(":umail", $umail);
                $stmt->bindparam(":phone", $phone);
                $stmt->bindparam(":com"  , $com);
                $stmt->bindparam(":dir"  , $dir);
                $stmt->execute();
                return true;             
            }catch(PDOException $e){
                echo $e->getMessage();
            } 

        }
        //  Función para obtener credenciales de usuario
        public function GetUserId($umail){
            try{
                $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE CORREO = :umail LIMIT 1");
                $stmt->bindparam(":umail", $umail);
                $stmt->execute();
                if ($userRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    return $userRow['ID_USUARIO'];
                }else {return 0;}
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        
        //  Función para verificar credenciales e iniciar sesión
        public function LoginUser($uid,$upass){
            try{
                $stmt = $this->db->prepare("SELECT * FROM login WHERE ID_USUARIO = :uid LIMIT 1");
                $stmt->execute(array(':uid'=>$uid));
                $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                    if(password_verify($upass, $userRow['PASSWORD'])){
                        $_SESSION['id_usuario'] = $userRow['ID_USUARIO'];
                        
                        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE ID_USUARIO = :uid LIMIT 1");
                        $stmt->execute(array(':uid'=>$uid));
                        $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                        if($stmt->rowCount() > 0){
                            $_SESSION['id_rol'] = $userRow['ID_ROL'];
                            $_SESSION['id_org'] = $userRow['ID_ORGANIZACION'];
                            $_SESSION['correo'] = $userRow['CORREO'];
                            $_SESSION['nombre'] = $userRow['NOMBRE'];
                            $_SESSION['apellido'] = $userRow['APELLIDO'];
                            $stmt = $this->db->prepare("SELECT NOMBRE FROM organizaciones WHERE ID_ORGANIZACION = :oid LIMIT 1");
                            $stmt->execute(array(':oid'=>$_SESSION["id_org"]));
                            $orgrow=$stmt->fetch(PDO::FETCH_ASSOC);
                            if($stmt->rowCount() > 0){
                                $_SESSION["org"] = $orgrow['NOMBRE'];
                            }else{$_SESSION["org"] = "Sin Organización";}
                        } else {return false;}
                        
                        return true;
                    } else {return false;}
                }
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        
        //  Función para verificar si el usuario ya inicio sesión
        public function Is_Loggedin()
        {
            if(isset($_SESSION['id_usuario']) && isset($_SESSION['id_rol'])) {return true;}
        }

        //  Función para redireccionamiento
        public function Redirect($url){header("Location: $url");}
        
        //  Función para cerrar sesión
        public function Logout(){
            SESSION_UNSET();
            SESSION_DESTROY();
            return true;
        }
    }
?>