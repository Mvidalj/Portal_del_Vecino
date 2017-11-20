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
            $stmt = $this->db->prepare("SELECT * FROM reuniones WHERE ID_ORGANIZACION=".$_SESSION['id_org']." ORDER BY FECHA_REUNION ASC");
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
        public function balance_delete($id){
            try {
                $stmt = $this->db->prepare("UPDATE tesoreria SET ELIMINADO = 1 WHERE ID_TESORERIA = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        public function balance_edit($date,$caption,$ammount,$activity,$id){
            try {
                $stmt = $this->db->prepare("UPDATE tesoreria SET FECHA = :EDITFECHA, CONCEPTO = :EDITCONCEPTO, MONTO = :EDITOMONTO, E_S = :EDITACTIVIDAD WHERE ID_TESORERIA = :ID");
                $stmt->bindParam(':EDITFECHA', $date);
                $stmt->bindParam(':EDITCONCEPTO', $caption);
                $stmt->bindParam(':EDITOMONTO', $ammount);
                $stmt->bindParam(':EDITACTIVIDAD', $activity);
                $stmt->bindParam(':ID', $id);
                $stmt->execute();
            } 
            catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        public function balance_insert($date,$concept,$activity,$ammount){
            try {
                $stmt = $this->db->prepare("INSERT INTO tesoreria (ID_ORGANIZACION, FECHA, CONCEPTO, E_S, MONTO) VALUES(:IDORG, :FECHA, :CONCEPTO, :E_S, :MONTO)");
                $stmt->bindParam(':IDORG', $_SESSION['id_org']);
                $stmt->bindParam(':FECHA', $date);
                $stmt->bindParam(':CONCEPTO', $concept);
                $stmt->bindParam(':E_S', $activity);
                $stmt->bindParam(':MONTO', $ammount);
                $stmt->execute();
            } 
            catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        public function historial_edit($nom,$desc,$datefrom,$dateto,$actividad){
            try{   
                $stmt = $this->db->prepare("UPDATE actividades SET NOMBRE = :NOMBRE, DESCRIPCION= :DESC, FECHA_INICIO = :FECHFROM, FECHA_TERMINO = :FECHTO WHERE ID_ACTIVIDAD = :ID");
                $stmt->bindParam(':NOMBRE', $nom);
                $stmt->bindParam(':DESC', $desc);
                $stmt->bindParam(':FECHFROM', $datefrom);
                $stmt->bindParam(':FECHTO', $dateto);
                $stmt->bindParam(':ID', $actividad);
                $stmt->execute();
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        public function historial_delete($id){
            try{   
                $stmt = $this->db->prepare("UPDATE actividades SET ELIMINADO = 1 WHERE ID_ACTIVIDAD= :ID");
                $stmt->bindParam(':ID', $id);
                $stmt->execute();
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        public function historial_add($date_in,$date_ter,$nombre,$desc){
            try{
                $stmt = $this->db->prepare("INSERT INTO actividades (ID_ORGANIZACION, NOMBRE, DESCRIPCION, FECHA_INICIO, FECHA_TERMINO, ELIMINADO)
                VALUES(".$_SESSION['id_org'].", :NOMBRE, :DESCRIPCION,:FECHA_INICIO,:FECHA_TERMINO,0)");
                $date_in = date('Y-m-d', strtotime($date_in));
                $date_ter = date('Y-m-d', strtotime($date_ter));
                $stmt->bindParam(':NOMBRE', $nombre);
                $stmt->bindParam(':FECHA_INICIO', $date_in);
                $stmt->bindParam(':FECHA_TERMINO', $date_ter); 
                $stmt->bindParam(':DESCRIPCION', $desc);
                if($stmt->execute()){
                    header("Location: actividades_historial.php");
                }  
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        public function proyecto_delete($id){
            try{
                $stmt = $this->db->prepare("UPDATE proyectos SET ELIMINADO = 1 WHERE ID_PROYECTO= :ID");
                $stmt->bindParam(':ID', $id,PDO::PARAM_INT);
                if($stmt->execute()){header("Location: proyectos_proyecto.php");}  
                }catch(PDOException $e){
                    echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        public function proyecto_edit($nombre,$date_in,$date_ter,$desc,$id){
            try{
                $stmt = $this->db->prepare("UPDATE proyectos SET NOMBRE= :NOMBRE, DESCRIPCION= :DESC,
                                             FECHA_INICIO= :FECHIN, FECHA_TERMINO= :FECHTER
                                             WHERE ID_PROYECTO= :ID");
                $stmt->bindParam(':NOMBRE',$nombre,PDO::PARAM_STR);
                $stmt->bindParam(':FECHIN', $date_in);
                $stmt->bindParam(':FECHTER', $date_ter); 
                $stmt->bindParam(':DESC',$desc,PDO::PARAM_STR);
                $stmt->bindParam(':ID',$id,PDO::PARAM_INT);
                if($stmt->execute()){header("Location: proyectos_proyecto.php");}  
            }catch(PDOException $e){
                    echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        public function proyecto_add($date_in,$date_ter,$nombre,$desc){
            try{
                $stmt = $this->db->prepare("INSERT INTO proyectos (ID_ORGANIZACION, NOMBRE, DESCRIPCION, FECHA_INICIO, FECHA_TERMINO)
                VALUES(:ORG, :NOMBRE, :DESCRIPCION,:FECHA_INICIO,:FECHA_TERMINO)");
                $date_in = date('Y-m-d', strtotime($date_in));
                $date_ter = date('Y-m-d', strtotime($date_ter));
                $stmt->bindParam(':ORG',$_SESSION['id_org'],PDO::PARAM_INT);
                $stmt->bindParam(':NOMBRE', $nombre,PDO::PARAM_STR);
                $stmt->bindParam(':FECHA_INICIO', $date_in);
                $stmt->bindParam(':FECHA_TERMINO', $date_ter); 
                $stmt->bindParam(':DESCRIPCION', $desc,PDO::PARAM_STR);
                if($stmt->execute()){header("Location: proyectos_proyecto.php");}  
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        public function recursos_peticion($date_from,$time_from,$date_to,$time_to,$id_resource){
            $fecha_desde = $date_from." ".$time_from;
            $fecha_hasta = $date_to." ".$time_to;
            try{
                $stmt = $this->db->prepare("UPDATE recursos SET ESTADO = 1 WHERE ID_RECURSO = :id");
                $stmt->bindparam(":id", $id_resource);
                if($stmt->execute()){
                    $stmt = $this->db->prepare("INSERT INTO prestamos (ID_RECURSO, ID_USUARIO, FECHA_INICIO, FECHA_TERMINO, ELIMINADO) VALUES(:ID, :USER, :FROM, :TO, 0)");
                    $stmt->bindparam(":ID", $id_resource);
                    $stmt->bindparam(":USER", $_SESSION['id_usuario']);
                    $stmt->bindparam(":FROM", date('Y-m-d H:i:s', strtotime($fecha_desde)));
                    $stmt->bindparam(":TO", date('Y-m-d H:i:s', strtotime($fecha_hasta)));
                    if($stmt->execute()){
                        echo "<script>alert('Su solicitud se ha realizado correctamente')</script>";
                    }
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            } 
        }
        public function recursos_add($nombre,$desc){
            try {
                $stmt = $this->db->prepare("INSERT INTO recursos (ID_ORGANIZACION, NOMBRE, DESCRIPCION, ESTADO, ELIMINADO)
                VALUES(:IDORG, :NOMBRE, :DESCRIPCION, 0, 0)");
                $stmt->bindParam(':IDORG', $_SESSION['id_org']);
                $stmt->bindParam(':NOMBRE', $nombre);
                $stmt->bindParam(':DESCRIPCION', $desc);  
                if($stmt->execute()){
                    echo "<script>alert('El recurso se ha agregado correctamente')</script>";
                }
            } 
            catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        public function recursos_edit($name,$desc,$id){
            try {
                $stmt = $this->db->prepare("UPDATE recursos SET NOMBRE = :NOMBRE, DESCRIPCION = :DESC WHERE ID_RECURSO = :ID");
                $stmt->bindParam(':NOMBRE', $name);
                $stmt->bindParam(':DESC', $desc);
                $stmt->bindParam(':ID', $id);
                if($stmt->execute()){
                    echo "<script>alert('El recurso se ha editado correctamente')</script>";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        public function recursos_delete(){
            try {
                $stmt = $this->db->prepare("UPDATE recursos SET ELIMINADO = 1 WHERE ID_RECURSO = :ID");
                $stmt->bindParam(':ID', $_POST['id_recurso']);  
                if($stmt->execute()){
                    echo "<script>alert('El recurso se ha eliminado correctamente')</script>";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        public function reuniones_edit($date,$state,$desc,$acta,$id){
            try{   
                $stmt = $this->db->prepare("UPDATE reuniones SET DESCRIPCION = :DESC, FECHA_REUNION = :FECHIN, ESTADO = :STATE, ACTA_REUNION = :ACTA WHERE ID_REUNION = :ID");
                $stmt->bindParam(':FECHIN', $date);
                $stmt->bindParam(':STATE', $state);
                $stmt->bindParam(':DESC', $desc);
                $stmt->bindParam(':ACTA', $acta);
                $stmt->bindParam(':ID', $id);
                if($stmt->execute()){
                    echo "<script>alert('La reunion se ha editado correctamente')</script>";
                }
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        public function reuniones_delete($id){
            try{   
                $stmt = $this->db->prepare("UPDATE reuniones SET ESTADO = 'CANCELADO' WHERE ID_REUNION = :ID");
                $stmt->bindParam(':ID', $id);
                if($stmt->execute()){
                    echo "<script>alert('La reunion se ha eliminado correctamente')</script>";
                }
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        public function reuniones_add($date,$desc){
            try{
                $stmt = $this->db->prepare("INSERT INTO reuniones (ID_ORGANIZACION, FECHA_REUNION, DESCRIPCION, ESTADO, ACTA_REUNION)
                VALUES(:IDORG, :FECHA, :DESCRIPCION,'PENDIENTE',' ')");
                $stmt->bindParam(':IDORG', $_SESSION['id_org']);
                $date = date('Y-m-d', strtotime($date));
                $stmt->bindParam(':FECHA', $date);
                $stmt->bindParam(':DESCRIPCION',$desc);
                if($stmt->execute()){
                    header("Location: actividades_reuniones.php");
                }
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
    }
?>
