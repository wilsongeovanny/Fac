<?php
require_once "./controladores/perfilControlador.php";
$iEm= new perfilControlador();
$cEm=$iEm->datos_perfil_controlador("Conteo",0);

if ($cEm->rowCount()<=0) {
                                            # code...
    
    ?>
    <div class="">
        <div class="x_panel">
          <div class="x_title">
            <h2>Agregar nueva entidad <small></small></h2>
            <div class="clearfix"></div>
        </div>
        <form action="<?php echo SERVERURL; ?>ajax/perfilAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
            <!--<span class="section">Agregar nuevo empleado</span>-->
            <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre <span class="required">:</span></label>
                <div class="col-md-6 col-sm-6">
                    <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="nombre-reg" placeholder="" required="required" />
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
        <p>Ya existe unnperfil de usuario registrado por lo tanto ya no puede registrar más</p>
    </div>
    <?php } ?>