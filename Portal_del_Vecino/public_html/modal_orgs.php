<?php   
    if($_SESSION['id_org'] == "" || isset($_REQUEST['join-create-org'])){
?>
        <!-- Modal -->
        <div class="modal fade" id="news" role="dialog">
            <div class="modal-dialog">
        <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="btn btn-primary" id="createorg">Crear una organización</button>
                        <button class="btn btn-primary" id="uniteorg">Unirse a una organización</button>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="form-createorg" class="collapse">
                            <form method="POST">
                                <fieldset>
                                    <legend>Registrar organización</legend>
                                    <label for="nameorg" >Nombre de organización: </label>
                                    <input type="text" class="form-control" id="nameorg" name="nameorg" required><br>
                                    <label for="comorg" >Comuna: </label>
                                    <select class="form-control" id="comorg" name="comorg">
                                        <option value='DISABLED' hidden selected>Comuna</option>
                                        <?php  $stmt = $querys->comunas();
                                            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<option value=".$result['ID_COMUNA'].">".$result['COMUNA']."</option>";
                                            }
                                        ?>
                                    </select><br>
                                    <input type="submit" id="submit-create" name="submit-create" class="btn btn-success" value="Registrar organización">
                                </fieldset>
                            </form>
                        </div>
                        <div id="form-uniteorg">
                            <form action="home.php" method="POST">
                                <fieldset>
                                    <legend>Unirse a organización</legend>
                                    <label for="select-org" >Organizacion: </label>
                                    <select class="form-control" id="select-org" name="select_org">
                                        <option value='DISABLED' hidden selected>Organización</option>
                                <?php   $stmt = $querys->organizaciones();
                                        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                           echo "<option value='".$result['ID_ORGANIZACION']."'>".$result['NOMBRE']."</option>";
                                       }
                                ?>
                                    </select><br>
                                    <input type="submit" id="submit-join" name="submit_join" class="btn btn-success" value="Unirse a organización">
                                </fieldset>
                            </form>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
?>
