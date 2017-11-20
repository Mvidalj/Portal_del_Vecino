<?php
    class QUERY {

        private $db;

        function __construct($DB_con){
            $this->db = $DB_con;
        }

        public function Actividades(){
            $stmt = $this->db->prepare("SELECT * FROM actividades WHERE ID_ORGANIZACION=".$_SESSION['id_org']."");
            $stmt -> execute();
            return $stmt;
        }
        public function Proyectos(){
            $stmt = $this->db->prepare("SELECT * FROM proyectos WHERE ID_ORGANIZACION=".$_SESSION['id_org']."");
            $stmt -> execute();
            return $stmt;
        }
        public function Reuniones(){
            $stmt = $this->db->prepare("SELECT * FROM reuniones WHERE ID_ORGANIZACION=".$_SESSION['id_org']."");
            $stmt -> execute();
            return $stmt;
        }
        public function org_create($nameorg,$comorg){
            $stmt = $this->db->prepare('SELECT NOMBRE FROM organizaciones WHERE NOMBRE = :nom');
            $stmt->bindParam(':nom', $nameorg);
            $stmt->execute();
            if($stmt->rowCount() == 0){
                $stmt = $this->db->prepare('INSERT INTO organizaciones (id_comuna, nombre) VALUES(:com,:nom)');
                $stmt->bindParam(':com', $comorg);
                $stmt->bindParam(':nom', $nameorg);
                $stmt->execute();
                $stmt = $this->db->prepare('SELECT ID_ORGANIZACION FROM organizaciones WHERE NOMBRE = :nom');
                $stmt->bindParam(':nom', $nameorg);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $stmt = $this->db->prepare('UPDATE usuarios SET ID_ORGANIZACION = :id_org, ID_ROL = 1 WHERE ID_USUARIO = :id_usr');
                $stmt->bindParam(':id_org', $result['ID_ORGANIZACION']);
                $stmt->bindParam(':id_usr', $_SESSION['id_usuario']);
                $stmt->execute();
                $_SESSION['id_org']=$result['ID_ORGANIZACION'];
                $_SESSION['id_rol']=1;
                $stmt = $this->db->prepare("INSERT INTO asociados (ID_USUARIO, ID_ORGANIZACION, ID_ROL) values (:id_usr, :id_org, 1)");
                $stmt->bindparam(":id_usr", $_SESSION['id_usuario']);
                $stmt->bindparam(":id_org", $_SESSION['id_org']);
                $stmt->execute();
                echo "<script>alert('Organización creada correctamente.');window.location.href='home.php';</script>";
            }
            else{
                echo "<script>alert('Nombre de organización ya en uso')</script>";
            }
        }
        public function org_join($org){
            $stmt = $this->db->prepare("INSERT INTO solicitudes(ID_USUARIO,ID_ORGANIZACION,ESTADO) VALUES (:id_usr,:id_org,2)");
            $stmt->bindParam(':id_usr', $_SESSION['id_usuario']);
            $stmt->bindParam(':id_org', $org);
            $stmt->execute();
            echo "<script>alert('Petición de unión enviada');window.location.href='index.php';</script>";
        }
        public function org_select(){
            $stmt = $this->db->prepare("SELECT * FROM asociados, organizaciones WHERE "."asociados.ID_ORGANIZACION = organizaciones.ID_ORGANIZACION and ID_USUARIO = :id_usr");
            $stmt->bindParam(':id_usr', $_SESSION['id_usuario']);
            $stmt->execute();
            $data = array();
            $count = 0;
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($data,$result['ID_USUARIO'],$result['ID_ORGANIZACION'],$result['ID_ROL']);
                if ($result['ID_ORGANIZACION'] == $_SESSION['id_org']){
                    echo "<option value='".$count."' selected>".$result['NOMBRE']."</option>";
                }else{
                    echo "<option value='".$count."'>".$result['NOMBRE']."</option>";
                }
                $count += 3;
            }
            return $data;
        }
        public function org_update($data,$cont){
            try{
                $stmt = $this->db->prepare("UPDATE usuarios SET ID_ORGANIZACION = :id_org, ID_ROL = :id_rol "."WHERE usuarios.ID_USUARIO = :id_usr");
                $stmt->bindParam(':id_usr', $data[$cont+0]);
                $stmt->bindParam(':id_org', $data[$cont+1]);
                $stmt->bindParam(':id_rol', $data[$cont+2]);
                if($stmt->execute()){
                    $_SESSION['id_org'] = $data[$cont+1];
                    $_SESSION['id_rol'] = $data[$cont+2];
                    header("Location: home.php");
                }
            }catch(PDOException $e){
                echo "<script>alert('Hubo un error, intentelo nuevamentes')</script>";
            }
        }
        public function comunas(){
            $stmt = $this->db->prepare("SELECT * FROM comuna ORDER BY COMUNA ASC ");
            $stmt->execute();
            return $stmt;
        }
        public function organizaciones(){
            $stmt = $this->db->prepare("SELECT * FROM organizaciones ORDER BY NOMBRE ASC");
            $stmt->execute();
            return $stmt;
        }
    }
?>