<?php
    SESSION_START();
    class USER {

        private $db;

        function __construct($DB_con){
            $this->db = $DB_con;
        }
        
        //  Función para registro de usuarios
        //  IMPORTANTE MODIFICAR PARA QUE SEA FUNCIONAL RESPECTO A BD Y CAMPOS
          
        // Función para Encriptar la contraseña
        public function EncryptPass($id,$pass){
            try{
                
                $stmt = $this->db->prepare("INSERT INTO login(ID_USUARIO,PASSWORD)"
                        . "VALUES(:id, :pass)");
                $epass = password_hash($pass,PASSWORD_DEFAULT);
                $stmt->bindparam(":id", $id);
                $stmt->bindparam(":pass", $epass);
                $stmt->execute();
                return $stmt;

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        // Función para guardar datos de un nuevo usuario
        public function RegisterUser($fname,$lname,$umail,$phone,$com,$dir){
            try
            {   
                echo "<script>alert(".$umail.")</script>";
                $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE CORREO = :umail LIMIT 1");
                $stmt->bindparam(":umail", $umail);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    echo "<script>alert(".$umail.")</script>";
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