<?php
    SESSION_START();
    use PHPMailer\PHPMailer\PHPMailer; // Inicialización para uso de clase
    use PHPMailer\PHPMailer\Exception; // Inicialización para uso de clase
    
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
                
                // Cargado de librería para enviar correos
                require 'vendor-phpmailer/autoload.php';
                // Correo:     portaldelvecino@gmail.com
                // Contraseña: juntavecinal
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
                    $mail->Subject = 'Portal del vecino: Confirmación de cuenta';            // Asunto del correo
                    $mail->Body    = 'Por favor click aquí para activar tu cuenta: <a href="http://localhost/Portal_del_Vecino/Portal_del_vecino/public_html/validaciones/verify.php?email='.$umail.'&hash='.$epass.'">Confirmar mi cuenta!</a>'; // Texto plano a enviar
                    $mail->AltBody = 'Por favor click aquí para activar tu cuenta: <a href="http://localhost/Portal_del_Vecino/Portal_del_vecino/public_html/validaciones/verify.php?email='.$umail.'&hash='.$epass.'">Confirmar mi cuenta!</a>'; // Contenido HTML
                    
                    $mail->send(); // Se envía el mensaje
                } catch (Exception $e) { // En caso de error lo muestra
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