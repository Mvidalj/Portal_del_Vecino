<?php
require_once dirname(__FILE__).'/functions.jsconnect.php';
require_once dirname(__FILE__).'/conexion_bd.php';
$stmt = $conn->prepare("SELECT * FROM USUARIOS WHERE ID_USUARIO=".$_SESSION['id_usuario']."");
    $stmt->execute();
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0){
        	$uid = $userRow['ID_USUARIO'];
            $fname = $userRow['NOMBRE'];
            $mail = $userRow['CORREO'];
        }

// 1. Get your client ID and secret here. These must match those in your jsConnect settings.
$clientID = "2046445266";
$secret = "f96a9e075ad336a5c29c4a2238acd8be";

// 2. Grab the current user from your session management system or database here.
$signedIn = true; // this is just a placeholder

// YOUR CODE HERE.

// 3. Fill in the user information in a way that Vanilla can understand.
$user = array();

if ($signedIn) {
    // CHANGE THESE FOUR LINES.
    $user['uniqueid'] = $uid;
    $user['name'] = $fname;
    $user['email'] = $mail;
    $user['photourl'] = '';
}

// 4. Generate the jsConnect string.

// This should be true unless you are testing.
// You can also use a hash name like md5, sha1 etc which must be the name as the connection settings in Vanilla.
$secure = true;
writeJsConnect($user, $_GET, $clientID, $secret, $secure);