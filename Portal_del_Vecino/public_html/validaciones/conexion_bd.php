<?php
    date_default_timezone_set('America/Santiago'); // Se indica la zona horaria a PHP
    $adate = date('Y-m-d'); // Obtención de fecha actual mediante PHP
    $time = date('H:i');    // Obtención de hora actual mediante PHP

    $servername = "localhost";
    $dbname     = "vecino";
    $username   = "root";
    $password   = "";

    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Se asgina atributos de error y excepción a la conexión
    } catch(PDOException $e){
        echo "Conexion fallida: ". $e->getMessage();
    }

    include_once 'class.validaciones.php';
    include_once 'class.querys.php';
    $user = new USER($conn);
    $querys = new QUERY($conn);
?>
