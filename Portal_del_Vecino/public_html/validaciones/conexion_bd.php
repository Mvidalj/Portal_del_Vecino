<?php
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d');
    $time = date('H:i');

    $servername = "localhost";
    $dbname     = "vecino";
    $username   = "root";
    $password   = "";

    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        echo "Conexion fallida: ". $e->getMessage();
    }

    include_once 'class.validaciones.php';
    $user = new USER($conn);
?>