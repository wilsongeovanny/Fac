
<div class="">
    <div class="x_panel">
      <div class="x_title">
        <h2>Agregar nuevo tipo de hardware <small></small></h2>
        <div class="clearfix"></div>
    </div>
    <form action="<?php echo SERVERURL; ?>ajax/tipoHardwareAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <!--<span class="section">Agregar nuevo empleado</span>-->
        <div class="field item form-group">
            <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre <span class="required">:</span></label>
            <div class="col-md-6 col-sm-6">
                <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="nombre-reg" placeholder=""/>
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
