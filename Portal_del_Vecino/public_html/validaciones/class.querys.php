<?php
    class QUERY {

        private $db;
        
        function __construct($DB_con){
            $this->db = $DB_con;
        }
        public function insert_log($accion){
            $adate = date('d-m-Y');
            $time = date('H:i');
            $stmt = $this->db->prepare("INSERT INTO  log (ID_USUARIO, ID_ORGANIZACION, ACCION, FECHA, HORA) VALUES (:ID,:ORG,:ACCION,:FECHA,:HORA)");
            $stmt->bindParam(':ID', $_SESSION['id_usuario']);
            $stmt->bindParam(':ORG', $_SESSION['id_org']);
            $stmt->bindParam(':ACCION', $accion);
            $stmt->bindParam(':FECHA', $adate);
            $stmt->bindParam(':HORA', $time);
            $stmt -> execute();
        }

        public function Actividades(){
            $stmt = $this->db->prepare("SELECT * FROM actividades WHERE ID_ORGANIZACION = :idorg AND FECHA_TERMINO >= :date AND ELIMINADO = 0 ORDER BY FECHA_INICIO ASC");
            $stmt->bindParam(':idorg', $_SESSION['id_org']);
            $stmt->bindParam(':date', date('Y-m-d'));
            $stmt -> execute();
            return $stmt;
        }
        public function Proyectos(){
            $stmt = $this->db->prepare("SELECT * FROM proyectos WHERE ID_ORGANIZACION = :idorg AND FECHA_TERMINO >= :date AND ELIMINADO = 0 ORDER BY FECHA_INICIO ASC");
            $stmt->bindParam(':idorg', $_SESSION['id_org']);
            $stmt->bindParam(':date', date('Y-m-d'));
            $stmt -> execute();
            return $stmt;
        }
        public function Reuniones(){
            $stmt = $this->db->prepare("SELECT * FROM reuniones WHERE ID_ORGANIZACION = :idorg AND ESTADO != 'CANCELADO' ORDER BY FECHA_REUNION ASC");
            $stmt->bindParam(':idorg', $_SESSION['id_org']);
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
                echo "<script>alert('Organización creada correctamente.');</script>";
                $this->insert_log("Creo organizacion");

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
            $this->insert_log("Solicito organizacion");
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
                    header("Location: #");
                }
            }catch(PDOException $e){
                echo "<script>alert('Hubo un error, intentelo nuevamente')</script>";
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
                $this->insert_log("Elimino balance");
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
                $this->insert_log("Edito balance");
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
                $this->insert_log("Agrego balance");
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
                $this->insert_log("Edito historial");
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        public function historial_delete($id){
            try{   
                $stmt = $this->db->prepare("UPDATE actividades SET ELIMINADO = 1 WHERE ID_ACTIVIDAD= :ID");
                $stmt->bindParam(':ID', $id);
                $stmt->execute();
                $this->insert_log("Elimino historial");
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
                    $this->insert_log("Agrego historial");
                }  
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        public function proyecto_delete($id){
            try{
                $stmt = $this->db->prepare("UPDATE proyectos SET ELIMINADO = 1 WHERE ID_PROYECTO= :ID");
                $stmt->bindParam(':ID', $id,PDO::PARAM_INT);
                if($stmt->execute()){
                    header("Location: proyectos_proyecto.php");
                    $this->insert_log("Elimino proyecto");
                }  
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
                if($stmt->execute()){
                    header("Location: proyectos_proyecto.php");
                    $this->insert_log("Edito proyecto");
                }  
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
                if($stmt->execute()){
                    header("Location: proyectos_proyecto.php");
                    $this->insert_log("Agrego proyecto");
                }  
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        public function recursos_peticion($date_from,$time_from,$date_to,$time_to,$id_resource){
                $fecha_desde = $date_from." ".$time_from;
                $fecha_hasta = $date_to." ".$time_to;
                
                $stmt = $this->db->prepare("SELECT * FROM prestamos WHERE FECHA_INICIO BETWEEN :FEC_IN AND :FEC_TER");
                $stmt->bindparam(":FEC_IN", $fecha_desde);
                $stmt->bindparam(":FEC_TER", $fecha_hasta);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    echo "<script>alert('Lo sentimos, el recurso se encuentra solicitado en esos horarios')</script>";
                }else{
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
                                $this->insert_log("Pidio recurso");
                            }
                        }
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
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
                    $this->insert_log("Agrego recurso");
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
                    $this->insert_log("Edito recurso");
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
                    $this->insert_log("Elimino recurso");
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
                    $this->insert_log("Edito reunion");
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
                    $this->insert_log("Elimino reunion");
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
                    $this->insert_log("Agrego reunion");
                }
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        public function accept_user($id){
            $stmt = $this->db->prepare("UPDATE usuarios set ID_ORGANIZACION = :id_org WHERE ID_USUARIO = :id_usr");
            $stmt->bindparam(":id_usr", $id);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute();
            $stmt = $this->db->prepare("UPDATE solicitudes set ESTADO = 1 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
            $stmt->bindparam(":id_usr", $id);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute();
            $stmt = $this->db->prepare("INSERT INTO asociados (ID_USUARIO, ID_ORGANIZACION, ID_ROL) values (:id_usr, :id_org, 2)");
            $stmt->bindparam(":id_usr", $id);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute();
            $this->insert_log("Acepto usuario");    
        }
        public function deny_user($id){
            $stmt = $this->db->prepare("UPDATE solicitudes set ESTADO = 3 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
            $stmt->bindparam(":id_usr", $id);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute();
            $this->insert_log("Rechazo usuario");
        }
        public function add_tesorero($id){
            $stmt = $this->db->prepare("UPDATE usuarios set ID_ROL = 3 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
            $stmt->bindparam(":id_usr", $id);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute();
            $stmt = $this->db->prepare("UPDATE asociados set ID_ROL = 3 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
            $stmt->bindparam(":id_usr", $id);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute();
            $this->insert_log("Agrego tesorero");
        }
        public function add_admin_actividades($id){
            $stmt = $this->db->prepare("UPDATE usuarios set ID_ROL = 4 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
            $stmt->bindparam(":id_usr", $id);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute(); 
            $stmt = $this->db->prepare("UPDATE asociados set ID_ROL = 4 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
            $stmt->bindparam(":id_usr", $id);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute();
            $this->insert_log("Agrego admin Actividades"); 
        }
        public function add_admin_proyectos($id){
            $stmt = $this->db->prepare("UPDATE usuarios set ID_ROL = 5 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
            $stmt->bindparam(":id_usr", $id);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute(); 
            $stmt = $this->db->prepare("UPDATE asociados set ID_ROL = 5 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
            $stmt->bindparam(":id_usr", $id);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute(); 
            $this->insert_log("Agrego admin Proyectos");
        }
        public function delete_privileges($id){
            $stmt = $this->db->prepare("UPDATE usuarios set ID_ROL = 2 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
            $stmt->bindparam(":id_usr", $_POST['id_usr']);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute(); 
            $stmt = $this->db->prepare("UPDATE asociados set ID_ROL = 2 WHERE ID_USUARIO = :id_usr AND ID_ORGANIZACION = :id_org");
            $stmt->bindparam(":id_usr", $id);
            $stmt->bindparam(":id_org", $_SESSION['id_org']);
            $stmt->execute();
            $this->insert_log("Elimino privilegios"); 
        }
        public function pendientes(){
            $stmt = $this->db->prepare("SELECT * FROM solicitudes WHERE ID_ORGANIZACION = :id_org AND ESTADO = 2");
            $stmt->bindParam(':id_org', $_SESSION['id_org']);
            $stmt->execute(); 
            return $stmt;  
        }
        public function usuario($id){
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE ID_USUARIO = :id_usr");
            $stmt->bindParam(':id_usr', $id);
            $stmt->execute(); 
            return $stmt; 
        }
        public function moderadores($id){
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE ID_ORGANIZACION = :id_org AND ID_ROL > 2");
            $stmt->bindParam(':id_org', $id);
            $stmt->execute();
            return $stmt; 
        }
        public function usr_normal($id){
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE ID_ORGANIZACION = :id_org AND ID_ROL = 2");
            $stmt->bindParam(':id_org', $id);
            $stmt->execute();
            return $stmt;   
        }
        public function recursos(){
            $stmt = $this->db->prepare("SELECT * FROM recursos WHERE ELIMINADO = 0 AND ID_ORGANIZACION = :IDORG");
            $stmt->bindparam(":IDORG", $_SESSION['id_org']);
            $stmt->execute();
            return $stmt;
        }
        public function prestamos($recurso){
            $stmt = $this->db->prepare("SELECT * FROM prestamos WHERE ID_RECURSO = :IDREC");
            $stmt->bindparam(":IDREC", $recurso);
            $stmt->execute();
            return $stmt;
        }
        public function nombre_usr($user){
            $stmt = $this->db->prepare("SELECT NOMBRE, APELLIDO FROM usuarios WHERE ID_USUARIO = :IDUSR");
            $stmt->bindparam(":IDUSR", $user);
            $stmt->execute();
            return $stmt;
        }
        public function balance(){
            $stmt = $this->db->prepare("SELECT * FROM tesoreria WHERE ELIMINADO = 0 AND ID_ORGANIZACION = :IDORG");
            $stmt->bindparam(":IDORG", $_SESSION['id_org']);
            $stmt->execute();
            return $stmt;
        }
        public function search_balances($fecha_desde,$fecha_hasta,$actividad){
            if($fecha_desde != "" && $fecha_hasta != ""){
                if($actividad < 2){
                    $stmt = $this->db->prepare("SELECT * FROM tesoreria WHERE ELIMINADO = 0 AND FECHA BETWEEN :fecha_desde AND :fecha_hasta AND E_S = :actividad  AND ID_ORGANIZACION = :IDORG");
                    $stmt->bindparam(":IDORG", $_SESSION['id_org']);
                    $stmt->bindparam(":fecha_desde",  date('Y-m-d', strtotime($fecha_desde)));
                    $stmt->bindparam(":fecha_hasta",  date('Y-m-d', strtotime($fecha_hasta)));
                    $stmt->bindparam(":actividad", $actividad);
                }else{
                    $stmt = $this->db->prepare("SELECT * FROM tesoreria WHERE ELIMINADO = 0 AND FECHA BETWEEN :fecha_desde AND :fecha_hasta AND ID_ORGANIZACION = :IDORG");
                    $stmt->bindparam(":IDORG", $_SESSION['id_org']);
                    $stmt->bindparam(':fecha_desde',  date('Y-m-d', strtotime($fecha_desde)));
                    $stmt->bindparam(':fecha_hasta',  date('Y-m-d', strtotime($fecha_hasta)));
                }
            }else{
                if($actividad < 2){
                    $stmt = $this->db->prepare("SELECT * FROM tesoreria WHERE ELIMINADO = 0 AND E_S in (:actividad, '3') AND ID_ORGANIZACION = :IDORG");
                    $stmt->bindparam(":IDORG", $_SESSION['id_org']);
                    $stmt->bindparam(":actividad", $actividad);
                }else{
                    $stmt = $this->db->prepare("SELECT * FROM tesoreria WHERE ELIMINADO = 0 AND ID_ORGANIZACION = :IDORG");
                    $stmt->bindparam(":IDORG", $_SESSION['id_org']);
                }
            }
            $stmt->execute();
            return $stmt;
        }
        public function pass(){
            $stmt = $this->db->prepare("SELECT PASSWORD FROM LOGIN WHERE ID_USUARIO=".$_SESSION['id_usuario']."");
            $stmt->execute();
            return $stmt;
        }
        public function newpass($nepass){
            $stmt = $this->db->prepare("UPDATE LOGIN SET PASSWORD= :nepass WHERE ID_USUARIO =".$_SESSION['id_usuario']."");
            $stmt->bindparam(":nepass", $nepass);
            $stmt->execute();
        }
        public function user_edit($fname,$lname,$mail,$phone){
            $stmt = $this->db->prepare("UPDATE USUARIOS SET NOMBRE=:fname, APELLIDO=:lname,CORREO=:mail,TELEFONO=:phone WHERE ID_USUARIO =".$_SESSION['id_usuario']."");
            $stmt->bindparam(":fname", $fname);
            $stmt->bindparam(":lname", $lname);
            $stmt->bindparam(":mail", $mail);
            $stmt->bindparam(":phone", $phone);
            if($stmt->execute()){
                echo "<script>alert('Datos Guardados Exitosamente')</script>";
                echo 'location.reload();';
                $this->insert_log("Edito su usuario");
            }
        }
         public function Active(){
            $stmt = $this->db->prepare("SELECT * FROM login WHERE ID_USUARIO = :id LIMIT 1");
            $stmt->bindparam(":id", $_SESSION["id_usuario"]);
            $stmt->execute();
            if ($userRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $active= $userRow['ACTIVO'];
                if ($active == '0'){
                    echo '<script>alert("por favor verifique su correo para acceder al portal");window.location.href="home.php";</script>';
                }
            }
        }
    }
?>
