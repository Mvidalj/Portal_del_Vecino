<?php    
if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        if(isset($_REQUEST['submit-edit'])){
            try{   
                $sql = $conn->prepare("UPDATE reuniones SET DESCRIPCION = :DESC, FECHA_REUNION = :FECHIN, ESTADO = :STATE, ACTA_REUNION = :ACTA WHERE ID_REUNION = :ID");
                $sql->bindParam(':FECHIN', $_POST['edit_date']);
                $sql->bindParam(':STATE', $_POST['edit_state']);
                $sql->bindParam(':DESC', $_POST['edit_desc']);
                $sql->bindParam(':ACTA', $_POST['acta']);
                $sql->bindParam(':ID', $_POST['id_reunion']);
                $sql->execute();
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }

        if(isset($_REQUEST['submit-delete'])){
            try{   
                $sql = $conn->prepare("UPDATE reuniones SET ESTADO = 'CANCELADO' WHERE ID_REUNION = :ID");
                $sql->bindParam(':ID', $_POST['id_reunion']);
                $sql->execute();
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        
        if(isset($_REQUEST['submit-add'])){
            try{
                $sentencia = $conn->prepare("INSERT INTO reuniones (ID_ORGANIZACION, FECHA_REUNION, DESCRIPCION, ESTADO, ACTA_REUNION)
                VALUES(:IDORG, :FECHA, :DESCRIPCION,'PENDIENTE',' ')");
                $sentencia->bindParam(':IDORG', $_SESSION['id_org']);
                $date = date('Y-m-d', strtotime($_POST['fecha_in']));
                $sentencia->bindParam(':FECHA', $date);
                $sentencia->bindParam(':DESCRIPCION',$_POST['desc'],PDO::PARAM_STR);
                if($sentencia->execute()){
                    $user->Redirect('actividades_reuniones.php');
                }
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
    }?>