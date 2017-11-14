<?php    
if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        if (isset($_REQUEST['delete_actividad'])){
            try {
                $sql = $conn->prepare("UPDATE tesoreria SET ELIMINADO = 1 WHERE ID_TESORERIA = :id");
                $sql->bindParam(':id', $_POST['id']);
                $sql->execute();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        if (isset($_REQUEST['submit-edit'])){
            try {
                $sql = $conn->prepare("UPDATE tesoreria SET FECHA = :EDITFECHA, CONCEPTO = :EDITCONCEPTO, MONTO = :EDITOMONTO, E_S = :EDITACTIVIDAD WHERE ID_TESORERIA = :ID");
                $sql->bindParam(':EDITFECHA', $_POST['edit_date']);
                $sql->bindParam(':EDITCONCEPTO', $_POST['edit_caption']);
                $sql->bindParam(':EDITOMONTO', $_POST['edit_ammount']);
                $sql->bindParam(':EDITACTIVIDAD', $_POST['edit_activity']);
                $sql->bindParam(':ID', $_POST['id']);
                $sql->execute();
            } 
            catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        
        if(isset($_REQUEST['submit-entrada'])){
            try {
                $sql = $conn->prepare("INSERT INTO tesoreria (ID_ORGANIZACION, FECHA, CONCEPTO, E_S, MONTO)
                VALUES(:IDORG, :FECHA, :CONCEPTO, :E_S, :MONTO)");
                $sql->bindParam(':IDORG', $_SESSION['id_org']);
                $sql->bindParam(':FECHA', $_POST['fecha_ingreso']);
                $sql->bindParam(':CONCEPTO', $_POST['concepto']);
                $sql->bindParam(':E_S', $_POST['select_actividad']);
                $sql->bindParam(':MONTO', $_POST['monto']);
                $sql->execute();
            } 
            catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }?>