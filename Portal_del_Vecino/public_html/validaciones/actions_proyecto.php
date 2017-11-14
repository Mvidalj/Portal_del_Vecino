<?php
if($user->Is_Loggedin() != true)
{
    $user->Redirect('../../index.php');
} else {
    if($_SESSION['id_org'] == ""){
        $user->Redirect('../../home.php');
    }
    if(isset($_REQUEST['delete'])){
    try{
        $sentencia = $conn->prepare("UPDATE proyectos SET ELIMINADO = 1 WHERE ID_PROYECTO= :ID");
        $sentencia->bindParam(':ID', $_POST['id'],PDO::PARAM_INT);
        if($sentencia->execute()){$user->Redirect('proyectos_proyecto.php');}  
        }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
        }
    }
    if (isset($_REQUEST['submit-edit'])){
        try{
            $sentencia = $conn->prepare("UPDATE proyectos SET NOMBRE= :NOMBRE, DESCRIPCION= :DESC,
                                         FECHA_INICIO= :FECHIN, FECHA_TERMINO= :FECHTER
                                         WHERE ID_PROYECTO= :ID");
            $sentencia->bindParam(':NOMBRE',$_POST['nombre'],PDO::PARAM_STR);
            $sentencia->bindParam(':FECHIN', $_POST['fecha_in']);
            $sentencia->bindParam(':FECHTER', $_POST['fecha_ter']); 
            $sentencia->bindParam(':DESC',$_POST['desc'],PDO::PARAM_STR);
            $sentencia->bindParam(':ID',$_POST['id'],PDO::PARAM_INT);
            if($sentencia->execute()){$user->Redirect('proyectos_proyecto.php');}  
        }catch(PDOException $e){
                echo 'Fallo la conexion:'.$e->GetMessage();
        }
    }
    if(isset($_REQUEST['add_proyecto'])){
        try{
            $sentencia = $conn->prepare("INSERT INTO proyectos (ID_ORGANIZACION, NOMBRE, DESCRIPCION, FECHA_INICIO, FECHA_TERMINO)
            VALUES(1, :NOMBRE, :DESCRIPCION,:FECHA_INICIO,:FECHA_TERMINO)");
            $date_in = date('Y-m-d', strtotime($_POST['fecha_in']));
            $date_ter = date('Y-m-d', strtotime($_POST['fecha_ter']));
            $sentencia->bindParam(':NOMBRE', $_POST['nombre'],PDO::PARAM_STR);
            $sentencia->bindParam(':FECHA_INICIO', $date_in);
            $sentencia->bindParam(':FECHA_TERMINO', $date_ter); 
            $sentencia->bindParam(':DESCRIPCION', $_POST['desc'],PDO::PARAM_STR);
            if($sentencia->execute()){$user->Redirect('proyectos_proyecto.php');}  
        }catch(PDOException $e){
            echo 'Fallo la conexion:'.$e->GetMessage();
        }
    }
}?>