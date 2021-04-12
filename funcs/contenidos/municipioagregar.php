<?php
require_once "./controladores/empresaControlador.php";
$iEm= new empresaControlador();
$cEm=$iEm->datos_empresa_controlador("Conteo",0);

if (true) {
                                            # code...
    
    ?>
    <div class="">
        <div class="x_panel">
          <div class="x_title">
            <h2>Agregar nueva empresa <small></small></h2>
            <div class="clearfix"></div>
        </div>
        <form action="<?php echo SERVERURL; ?>ajax/empresaAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
            <!--<span class="section">Agregar nuevo empleado</span>-->
            <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Ruc <span class="required">:</span></label>
                <div class="col-md-6 col-sm-6">
                    <input class="form-control" type="number" class='number' name="ruc-reg" data-validate-minmax="10,100">
                </div>
            </div>
            <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre <span class="required">:</span></label>
                <div class="col-md-6 col-sm-6">
                    <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="nombre-reg" placeholder=""/>
                </div>
            </div>
            <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Télefono <span class="required">:</span></label>
                <div class="col-md-6 col-sm-6">
                    <input class="form-control" type="number" class='number' name="telefono-reg" data-validate-minmax="10,100">
                </div>
            </div>
            <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Correo <span class="required">:</span></label>
                <div class="col-md-6 col-sm-6">
                    <input class="form-control" name="correo-reg" placeholder="" class='email' type="email" />
                </div>
            </div>
            <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Dirección <span class="required">:</span></label>
                <div class="col-md-6 col-sm-6">
                    <input class="form-control" data-validate-length-range="6" data-validate-words="1" name="direccion-reg" placeholder=""/>
                </div>
            </div>
            <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Logo <span class="required">:</span></label>
                <div class="col-md-8 col-sm-8">
                    <input class="form-control" type="file" name="foto-reg" maxlength="250"/>
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
        <p>Ya existe una empresa registrada por lo tanto ya no puede registrar más</p>
    </div>
    <?php } ?>