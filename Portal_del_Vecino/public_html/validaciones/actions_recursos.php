<?php
if($user->Is_Loggedin() != true)
    {
        $user->Redirect('../../index.php');
    } else {
        if($_SESSION['id_org'] == ""){
            $user->Redirect('../../home.php');
        }
        
        if(isset($_REQUEST['submit-request'])){
            $fecha_desde = $_POST['from_date']." ".$_POST['from_time'];
            $fecha_hasta = $_POST['to_date']." ".$_POST['to_time'];
            
            $query = $conn->prepare("SELECT * FROM prestamos WHERE FECHA_INICIO BETWEEN :FEC_IN AND :FEC_TER");
            $query->bindparam(":FEC_IN", $fecha_desde);
            $query->bindparam(":FEC_TER", $fecha_hasta);
            $query->execute();
            if($query->rowCount() > 0){
                echo "<script>alert('Lo sentimos, el recurso se encuentra solicitado en esos horarios')</script>";
            }else{
                try{
                    $sql = $conn->prepare("UPDATE recursos SET ESTADO = 1 WHERE ID_RECURSO = :id");
                    $sql->bindparam(":id", $_POST['id_recurso']);
                    if($sql->execute()){
                        $sql = $conn->prepare("INSERT INTO prestamos (ID_RECURSO, ID_USUARIO, FECHA_INICIO, FECHA_TERMINO, ELIMINADO) VALUES(:ID, :USER, :FROM, :TO, 0)");
                        $sql->bindparam(":ID", $_POST['id_recurso']);
                        $sql->bindparam(":USER", $_SESSION['id_usuario']);
                        $sql->bindparam(":FROM", date('Y-m-d H:i:s', strtotime($fecha_desde)));
                        $sql->bindparam(":TO", date('Y-m-d H:i:s', strtotime($fecha_hasta)));
                        if($sql->execute()){
                            echo "<script>alert('Su solicitud se ha realizado correctamente')</script>";
                        }
                    }

                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
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
