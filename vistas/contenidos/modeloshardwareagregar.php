<?php
require_once "./controladores/modelosHardwareControlador.php";
$iEs= new modelosHardwareControlador();
$cEs=$iEs->datos_modelosHardware_controlador("Conteo",0);

    if (true) { //Son mas de un servicio
        # code...
        
        ?>
        <script type="text/javascript">
          function cargarModelos(opcion){
            var data;
            $.ajax({
              url: '../controladores/marca.php?marcahardwarecodigo='+opcion.value,
              type: 'GET',
              data: data,         
              success: function(data) {
            //alert("aa");
            $("#divModel").html(data);        
        }
    })            
        }
    </script>
    <div class="">
        <div class="x_panel">
          <div class="x_title">
            <h2>Agregar nuevo modelo de hardware <small></small></h2>
            <div class="clearfix"></div>
        </div>
        <form action="<?php echo SERVERURL; ?>ajax/modeloHardwareAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
            <!--<span class="section">Agregar nuevo empleado</span>-->
            <div class="field item form-group">
                <label class="col-form-label col-md-3 col-sm-3  label-align">Selecciones tipo de hardware <span class="required">:</label>
                    <div class="col-md-6 col-sm-6 ">
                        <?php
                        require_once "./controladores/modelosHardwareControlador.php";
                        $iEs= new modelosHardwareControlador();
                        $cEs=$iEs->datos_modelosHardware_controlador("TipoHardware",0);
                        ?>
                        <select class="form-control" name="tipo-reg" onchange="cargarModelos(this)" placeholder="">
                            <?php
                            while($campos=$cEs->fetch()){
                                ?>
                                <option value="<?php echo $campos['tipohardwarecodigo']; ?>">
                                    <?php echo $campos['tipohardwarenombre']; ?>
                                </option>
                                <?php
                            } 
                            
                            ?>
                        </select>
                    </div>
                </div>
                <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Seleccione tipo de marca <span class="required">:</label>
                        <div id="divModel" class="col-md-6 col-sm-6">

                            <?php
                            require_once "./controladores/modelosHardwareControlador.php";
                            $iEs= new modelosHardwareControlador();
                            $cEs=$iEs->datos_modelosHardware_controlador("MarcaHardware",0);
                            ?>
                            <select class="form-control" name="marca-reg" required="required"> 
                                <?php
                                while($campos=$cEs->fetch()){
                                    ?>
                                    <option value="<?php echo $campos['marcahardwarecodigo']; ?>">
                                        <?php echo $campos['marcahardwarenombre']; ?>
                                    </option>
                                    <?php
                                } 
                                
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre del modelo<span class="required">:</span></label>
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
    <?php }else{ ?>
        <div class="alert alert-dismissible alert-primary text-center">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="zmdi zmdi-alert-octagon zmdi-hc-5x"></i>
            <h4>¡Lo sentimos!</h4>
            <p>Ya existe una MATERIA registrada por lo tanto ya no puede registrar más</p>
        </div>
        <?php } ?>