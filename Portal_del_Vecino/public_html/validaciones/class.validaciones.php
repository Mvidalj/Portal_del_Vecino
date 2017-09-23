<?php
    
    class USER {

        private $db;

        function __construct($DB_con){
            $this->db = $DB_con;
        }
        
        //  Función para registro de usuarios
        //  IMPORTANTE MODIFICAR PARA QUE SEA FUNCIONAL RESPECTO A BD Y CAMPOS
        public function RegisterUser($fname,$lname,$uname,$umail,$upass){
            try
            {
                $new_password = password_hash($upass, PASSWORD_DEFAULT);

                $stmt = $this->db->prepare("INSERT INTO users(user_name,user_email,user_pass) VALUES(:uname, :umail, :upass)");

                $stmt->bindparam(":uname", $uname);
                $stmt->bindparam(":umail", $umail);
                $stmt->bindparam(":upass", $new_password);
                $stmt->execute();
                return $stmt; 
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }    
        }
        
        //  Función para obtener credenciales de usuario
        public function GetUserId($umail){
            try{
                $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE CORREO = :umail LIMIT 1");
                $stmt->execute(array(':umail'=>$umail));
                $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                    return $userRow['ID_USUARIO'];
                } else {return false;}
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
            if(isset($_SESSION['id_usuario'])) {return true;}
        }

        //  Función para redireccionamiento
        public function Redirect($url){header("Location: $url");}
        
        //  Función para cerrar sesión
        public function Logout(){
            SESSION_DESTROY();
            UNSET($_SESSION['id_usuario']);
            return true;
        }
    }
?>