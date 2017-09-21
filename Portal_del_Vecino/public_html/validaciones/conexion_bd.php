<?php
	
    $servername = "localhost";
    $dbname     = "vecino";
    $username   = "root";
    $password   = "";

    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        echo "Conexion fallida: ". $e->getMessage();
    }

    include_once 'class.validaciones.php';
    $user = new USER($conn);
?>