<?php
require_once "./controladores/coloresHardwareControlador.php";
$iEs= new coloresHardwareControlador();
$cEs=$iEs->datos_coloresHardware_controlador("Conteo",0);

    if ($cEs->rowCount()<=10) { //Son mas de un servicio
        # code...
        
        ?>
        <div class="">
            <div class="x_panel">
              <div class="x_title">
                <h2>Agregar nuevo color de hardware <small></small></h2>
                <div class="clearfix"></div>
            </div>
            <form action="<?php echo SERVERURL; ?>ajax/coloresHardwareAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                <!--<span class="section">Agregar nuevo empleado</span>-->
                <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Seleccionar Nombre<span class="required">:</span></label>
                    <div class="col-md-6 col-sm-6">
                        <select class="form-control" name="nombre-reg" placeholder="" required="required">
                            <option value="AMARILLO">1. AMARILLO</option>
                            <option value="AZUL">2. AZUL</option>
                            <option value="BLANCO">3. BLANCO</option>
                            <option value="GRIS">4. GRIS</option>
                            <option value="MARRON">5. MARRON</option>
                            <option value="NARANJA">6. NARANJA</option>
                            <option value="NEGRO">7. NEGRO</option>
                            <option value="PURPURA">8. PURPURA</option>
                            <option value="ROJO">9. ROJO</option>
                            <option value="ROSA">10. ROSA</option>
                            <option value="VERDE">11. VERDE</option>
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
        <p>Los 11 colores del hardware ya se encuentran registrados por lo tanto ya no puede registrar más</p>
    </div>
<?php } ?>
