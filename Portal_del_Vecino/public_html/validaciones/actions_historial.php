<?php
if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        
        if(isset($_REQUEST['submit-edit'])){
            $querys->historial_edit($_POST['edit_nom'],$_POST['edit_desc'],$_POST['edit_datefrom'],$_POST['edit_dateto'],$_POST['id_actividad']);
        }

        if(isset($_REQUEST['submit-delete'])){
            $querys->historial_delete($_POST['id_actividad']);
        }
        
        if(isset($_REQUEST['submit-add'])){
            $querys->historial_add($_POST['fecha_in'],$_POST['fecha_ter'],$_POST['nombre'],$_POST['desc']);
	}
    }
?>
