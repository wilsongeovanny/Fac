<?php
require_once "./controladores/departamentosControlador.php";
$iEs= new departamentosControlador();
$cEs=$iEs->datos_departamentos_controlador("Conteo",0);

    if (true) { //Son mas de un servicio
        # code...
        
        ?>
        <div class="">
            <div class="x_panel">
              <div class="x_title">
                <h2>Agregar nuevo departamento <small></small></h2>
                <div class="clearfix"></div>
            </div>
            <form action="<?php echo SERVERURL; ?>ajax/departamentosAjax.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                <!--<span class="section">Agregar nuevo empleado</span>-->
                
                <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Selecciones la empresa <span class="required">:</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select class="form-control" name="opcion-reg" placeholder="">
                                <?php
                                                        /*require_once "./controladores/materiaControlador.php";
                                                        $iEs= new materiaControlador();*/
                                                        $cEs=$iEs->datos_departamentos_controlador("Select",0);

                                                        while($campos=$cEs->fetch()){
                                                            ?>
                                                            <option value="<?php echo $campos['empresacodigo']; ?>">
                                                                <?php echo $campos['empresanombre']; ?>
                                                            </option>
                                                            <?php
                                                        } 
                                                        
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="field item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre del departamento<span class="required">:</span></label>
                                                <div class="col-md-6 col-sm-6">
                                                    <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="nombre-reg" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="ln_solid">
                                                <div class="form-group">
                                                    <div class="col-md-6 offset-md-3">
                                                        <button type='submit' class="btn btn-primary">Registrar</button>
                                                        
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
                                    <p>Ya existe una MATERIA registrada por lo tanto ya no puede registrar más</p>
                                </div>
                                <?php } ?>