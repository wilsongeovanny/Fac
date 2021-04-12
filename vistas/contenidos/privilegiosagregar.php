<?php
require_once "./controladores/privilegiosControlador.php";
$iEm= new privilegiosControlador();
$cEm=$iEm->datos_privilegios_controlador("Conteo",0);

if (true) {
                                            # code...
    
    ?>
    <div class="">
        <div class="x_panel">
          <div class="x_title">
            <h2>Agregar nueva entidad <small></small></h2>
            <div class="clearfix"></div>
        </div>
        <form action="<?php echo SERVERURL; ?>ajax/privilegiosAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
            <!--<span class="section">Agregar nuevo empleado</span>-->
            <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Selecciones Entidad <span class="required">:</label>
                    <div class="col-md-6 col-sm-6 ">
                        <?php
                        require_once "./controladores/privilegiosControlador.php";
                        $iEs= new privilegiosControlador();
                        $cEs=$iEs->datos_privilegios_controlador("Modulos",0);
                        ?>
                        <select class="form-control" name="modulo-reg" placeholder="" required="required">
                            <?php
                            while($campos=$cEs->fetch()){
                                ?>
                                <option value="<?php echo $campos['MODULOCODIGO']; ?>">
                                    <?php echo $campos['MODULONOMBRE']; ?>
                                </option>
                                <?php
                            } 
                            
                            ?>
                        </select>
                    </div>
                </div>
                <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Seleccione Departamento <span class="required">:</label>
                        <div class="col-md-6 col-sm-6">

                            <?php
                            require_once "./controladores/privilegiosControlador.php";
                            $iEs= new privilegiosControlador();
                            $cEs=$iEs->datos_privilegios_controlador("Menus",0);
                            ?>
                            <select class="form-control" name="menu-reg" placeholder="" required="required">
                                <?php
                                while($campos=$cEs->fetch()){
                                    ?>
                                    <option value="<?php echo $campos['MENUCODIGO']; ?>">
                                        <?php echo $campos['MENUNOMBRE']; ?>
                                    </option>
                                    <?php
                                } 
                                
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="ln_solid">
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <button type='submit' class="btn btn-primary">Agregar</button>
                                <button type='reset' class="btn btn-success">Limpiar</button>
                            </div>
                        </div>
                    </div>
                    <div class="RespuestaAjax"></div>
                </form>
            </div>
        </div>
    <?php }else{ ?>
        <div class="alert alert-dismissible alert-primary text-center">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="zmdi zmdi-alert-octagon zmdi-hc-5x"></i>
            <h4>¡Lo sentimos!</h4>
            <p>Ya existe una empresa registrada por lo tanto ya no puede registrar más</p>
        </div>
        <?php } ?>