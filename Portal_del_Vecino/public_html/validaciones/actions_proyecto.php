<?php
if($user->Is_Loggedin() != true)
{
    $user->Redirect('../../index.php');
} else {
    if($_SESSION['id_org'] == ""){
        $user->Redirect('../../home.php');
    }
    if(isset($_REQUEST['delete'])){
        $querys->proyecto_delete($_POST['id']);
    }
    if (isset($_REQUEST['submit-edit'])){
        $querys->proyecto_edit($_POST['nombre'],$_POST['fecha_in'],$_POST['fecha_ter'],$_POST['desc'],$_POST['id']);
    }
    if(isset($_REQUEST['add_proyecto'])){
        $querys->proyecto_add($_POST['fecha_in'],$_POST['fecha_ter'],$_POST['nombre'],$_POST['desc']);
    }
}?>