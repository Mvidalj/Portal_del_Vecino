<?php    
if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        if(isset($_REQUEST['submit-edit'])){
            $querys->reuniones_edit($_POST['edit_date'],$_POST['edit_state'],$_POST['edit_desc'],$_POST['acta'],$_POST['id_reunion']);
        }

        if(isset($_REQUEST['submit-delete'])){
            $querys->reuniones_delete($_POST['id_reunion']);
        }
        
        if(isset($_REQUEST['submit-add'])){
            $querys->reuniones_add($_POST['fecha_in'],$_POST['desc']);
        }
    }?>