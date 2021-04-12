<?php
require_once "./controladores/estadosHardwarevidaControlador.php";
$iEs= new estadosHardwarevidaControlador();
$cEs=$iEs->datos_estadosHardwarevida_controlador("Conteo",0);

    if ($cEs->rowCount()<=1) { //Son mas de un servicio
        # code...
        
        ?>
        <div class="">
            <div class="x_panel">
              <div class="x_title">
                <h2>Agregar nuevo estado al hardware <small></small></h2>
                <div class="clearfix"></div>
            </div>
            <form action="<?php echo SERVERURL; ?>ajax/estadosHardwarevidaAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                <!--<span class="section">Agregar nuevo empleado</span>-->
                
                <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Estado<span class="required">:</label>
                        <div class="col-md-6 col-sm-6 ">
                            <select class="form-control" name="opcion-reg" placeholder="" required="required">
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="DADO DE BAJA">DADO DE BAJA</option>
                                <!--<option value="LIBERADO">LIBERADO</option>-->
                            </select>
                        </div>
                    </div>
                    <div class="ln_solid">
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <button type='submit' class="btn btn-primary">Registrar</button>
                                <!--<button type='reset' class="btn btn-secondary">Limpiar</button>-->
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
            <p>Los dos estados del hardware ya se encuentran registrados por lo tanto ya no puede registrar más</p>
        </div>
        <?php } ?>