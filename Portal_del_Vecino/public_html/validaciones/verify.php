<?php
    require_once 'conexion_bd.php';
    // En caso de que el usuario haya ingresado mediante el link enviado a su correo se verifica su cuenta
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
        try{
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE CORREO = :umail LIMIT 1");
            $stmt->bindparam(":umail", $_GET['email']);
            $stmt->execute();
            if ($userRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $stmt = $conn->prepare("SELECT * FROM login WHERE ID_USUARIO = :uid LIMIT 1");
                $iduser = $userRow['ID_USUARIO'];
                $stmt->bindparam(":uid", $iduser);
                $stmt->execute();
                if ($userRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if($_GET['hash'] == $userRow['PASSWORD']){
                        $stmt = $conn->prepare("UPDATE login SET ACTIVO = 1 WHERE ID_USUARIO = :uid");
                        $stmt->bindparam(":uid", $iduser);
                        if ($stmt->execute()){
                        echo "<script>alert('Tu cuenta ha sido verificada correctamente');window.location.href='../index.php';</script>";                   
                        }
                    }
                }
            }
            
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    // De caso contrario se le redirige al index
    }else{
        $user->Redirect('../index.php');
    }
?>