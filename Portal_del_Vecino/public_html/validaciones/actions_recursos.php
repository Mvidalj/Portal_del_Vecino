<?php
if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        if(isset($_REQUEST['submit-request'])){
            try{
                $sql = $conn->prepare("UPDATE recursos SET ESTADO = 1 WHERE ID_RECURSO = :id");
                $sql->bindparam(":id", $_POST['id_recurso']);
                if($sql->execute()){
                    $sql = $conn->prepare("INSERT INTO prestamos (ID_RECURSO, ID_USUARIO, FECHA_INICIO, FECHA_TERMINO, ELIMINADO) VALUES(:ID, :USER, :FROM, :TO, 0)");
                    $sql->bindparam(":ID", $_POST['id_recurso']);
                    $sql->bindparam(":USER", $_SESSION['id_usuario']);
                    $sql->bindparam(":FROM", date('Y-m-d', strtotime($_POST['from_date'])));
                    $sql->bindparam(":TO", date('Y-m-d', strtotime($_POST['rd_to_date'])));
                    if($sql->execute()){
                        echo "<script>alert('Su solicitud se ha realizado correctamente')</script>";
                    }
                }

            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        
        if(isset($_REQUEST['submit-recurso'])){
            try {
                $sql = $conn->prepare("INSERT INTO recursos (ID_ORGANIZACION, NOMBRE, DESCRIPCION, ESTADO, ELIMINADO)
                VALUES(:IDORG, :NOMBRE, :DESCRIPCION, 0, 0)");
                $sql->bindParam(':IDORG', $_SESSION['id_org']);
                $sql->bindParam(':NOMBRE', $_POST['nombre-recurso']);
                $sql->bindParam(':DESCRIPCION', $_POST['desc-recurso']);  
                $sql->execute();
            } 
            catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        if(isset($_REQUEST['submit-edit'])){
            try {
                $sql = $conn->prepare("UPDATE recursos SET NOMBRE = :NOMBRE, DESCRIPCION = :DESC WHERE ID_RECURSO = :ID");
                $sql->bindParam(':NOMBRE', $_POST['edit_name']);
                $sql->bindParam(':DESC', $_POST['edit_desc']);
                $sql->bindParam(':ID', $_POST['id_recurso']);
                $sql->execute();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        if(isset($_REQUEST['delete_resource'])){
            try {
                $sql = $conn->prepare("UPDATE recursos SET ELIMINADO = 1 WHERE ID_RECURSO = :ID");
                $sql->bindParam(':ID', $_POST['id_recurso']);  
                $sql->execute();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }?>