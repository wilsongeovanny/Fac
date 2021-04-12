<?php
require_once "./controladores/modulosControlador.php";
$iEm= new modulosControlador();
$cEm=$iEm->datos_modulos_controlador("Conteo",0);

if ($cEm->rowCount()<=6) {
                                            # code...
    
    ?>
    <div class="">
        <div class="x_panel">
          <div class="x_title">
            <h2>Agregar nuevo modulo <small></small></h2>
            <div class="clearfix"></div>
        </div>
        <form action="<?php echo SERVERURL; ?>ajax/modulosAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
            <!--<span class="section">Agregar nuevo empleado</span>-->
            <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre <span class="required">:</span></label>
                <div class="col-md-6 col-sm-6">
                    <select class="form-control" name="nombre-reg" placeholder="">
                        <option value="Empresa">1. Empresa</option>
                        <option value="Personal">2. Personal</option>
                        <option value="Ingresos">3. Ingresos</option>
                        <option value="Re / Asignacion">4. Re / Asignación</option>
                        <option value="Mantenimiento">5. Mantenimiento</option>
                        <option value="Administrador">6. Administrador</option>
                        <option value="Accesos">7. Accesos</option>
                    </select>
                </div>
            </div>
            <div class="ln_solid">
                <div class="form-group">
                    <div class="col-md-6 offset-md-3">
                        <button type='submit' class="btn btn-primary">Registrar</button>
                        <!--<button type='reset' class="btn btn-success">Limpiar</button>-->
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
        <p>Ya se encuentran registrados los 7 módulos del sistema por lo tanto ya no puede registrar más</p>
    </div>
    <?php } ?>