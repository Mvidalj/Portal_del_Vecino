<?php
    require_once 'validaciones/conexion_bd.php';
    if($user->Logout()){
        $user->Redirect('index.php');
    }
?>