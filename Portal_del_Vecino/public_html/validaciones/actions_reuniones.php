<?php    
if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        if(isset($_REQUEST['submit-edit'])){
            $destino = '../../files' ; // Carpeta donde se guardata 
            $tipo = $_FILES["file"]["name"]; 
            if($_FILES['file']['size']<1500000){ //Solo sube la imagen si su tamaño en bytes es pequeña(para no ralentizar el server)
                move_uploaded_file ( $_FILES [ 'file' ][ 'tmp_name' ], $destino . '/' .$_SESSION['id_org'].'-'.$_POST['id_reunion'].' '.$tipo."");  // Subimos el archivo
            }
            else echo "<script>alert('Imagen muy grande')</script>";

            $querys->reuniones_edit($_POST['edit_date'],$_POST['edit_state'],$_POST['edit_desc'],$_POST['acta'],$_POST['id_reunion']);
        }

        if(isset($_REQUEST['submit-delete'])){
            $querys->reuniones_delete($_POST['id_reunion']);
        }
        
        if(isset($_REQUEST['submit-add'])){
            $querys->reuniones_add($_POST['fecha_in'],$_POST['desc']);
        }
    }?>