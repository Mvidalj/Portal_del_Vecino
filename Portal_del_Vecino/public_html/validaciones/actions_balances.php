<?php  
require_once '../../validaciones/conexion_bd.php';
if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        if (isset($_REQUEST['delete_actividad'])){
            $querys->balance_delete($_POST['id']);
        }

        if (isset($_REQUEST['submit-edit'])){
            $querys->balance_edit($_POST['edit_date'],$_POST['edit_caption'],$_POST['edit_ammount'],$_POST['edit_activity'],$_POST['id']);
        }
        
        if(isset($_REQUEST['submit-entrada'])){
            $querys->balance_insert($_POST['fecha_ingreso'],$_POST['concepto'],$_POST['select_actividad'],$_POST['monto']);
        }
    }
 ?>