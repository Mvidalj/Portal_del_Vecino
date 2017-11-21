<?php
if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        if(isset($_REQUEST['submit-request'])){
            $querys->recursos_peticion($_POST['from_date'],$_POST['from_time'],$_POST['to_date'],$_POST['to_time'],$_POST['id_recurso']);
        }
        
        if(isset($_REQUEST['submit-recurso'])){
            $querys->recursos_add($_POST['nombre-recurso'],$_POST['desc-recurso']);
        }

        if(isset($_REQUEST['submit-edit'])){
            $querys->recursos_edit($_POST['edit_name'],$_POST['edit_desc'],$_POST['id_recurso']);
        }

        if(isset($_REQUEST['delete_resource'])){
            $querys->recursos_delete($_POST['id_recurso']);
        }
    }?>
