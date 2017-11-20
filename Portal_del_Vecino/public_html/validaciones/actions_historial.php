<?php
require_once '../../validaciones/conexion_bd.php';
if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        
        if(isset($_REQUEST['submit-edit'])){
            try{   
                $sentencia = $conn->prepare("UPDATE actividades SET NOMBRE = :NOMBRE, DESCRIPCION= :DESC, FECHA_INICIO = :FECHFROM, FECHA_TERMINO = :FECHTO WHERE ID_ACTIVIDAD = :ID");
                $sentencia->bindParam(':NOMBRE', $_POST['edit_nom']);
                $sentencia->bindParam(':DESC', $_POST['edit_desc']);
                $sentencia->bindParam(':FECHFROM', $_POST['edit_datefrom']);
                $sentencia->bindParam(':FECHTO', $_POST['edit_dateto']);
                $sentencia->bindParam(':ID', $_POST['id_actividad']);
                $sentencia->execute();
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }

        if(isset($_REQUEST['submit-delete'])){
            try{   
                $sentencia = $conn->prepare("UPDATE actividades SET ELIMINADO = 1 WHERE ID_ACTIVIDAD= :ID");
                $sentencia->bindParam(':ID', $_POST['id_actividad']);
                $sentencia->execute();
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
        }
        
        if(isset($_REQUEST['submit-add'])){
            try{
                $sentencia = $conn->prepare("INSERT INTO actividades (ID_ORGANIZACION, NOMBRE, DESCRIPCION, FECHA_INICIO, FECHA_TERMINO, ELIMINADO)
                VALUES(1, :NOMBRE, :DESCRIPCION,:FECHA_INICIO,:FECHA_TERMINO,0)");
                $date_in = date('Y-m-d', strtotime($_POST['fecha_in']));
                $date_ter = date('Y-m-d', strtotime($_POST['fecha_ter']));
                $sentencia->bindParam(':NOMBRE', $_POST['nombre'],PDO::PARAM_STR);
                $sentencia->bindParam(':FECHA_INICIO', $date_in);
                $sentencia->bindParam(':FECHA_TERMINO', $date_ter); 
                $sentencia->bindParam(':DESCRIPCION', $_POST['desc'],PDO::PARAM_STR);
                if($sentencia->execute()){
                    $user->Redirect('actividades_historial.php');
                }  
            }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
            }
	}
    }?>
