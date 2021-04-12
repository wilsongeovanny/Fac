<?php
require_once "./controladores/manteEntregarControlador.php";
require_once './core/forced.php';
  //$datos=explode("/", $_GET['views']);
$query1=forced::ejecutar_consulta_simple("SELECT *,T1.mantenimientocodigo FROM mantenimiento as T1, estado_mantenimiento as T2 WHERE T1.hardwareqr='$aa'AND T1.estadomantenimientocodigo=T2.estadomantenimientocodigo AND T2.estadomantenimientonombre='EN REPARACION'");
$Datosestado=$query1->fetch();

$estado_mant=$Datosestado['estadomantenimientonombre'];
$verificar=$campos['estadohardwarenombre'];
if ((trim($verificar)=='DADO DE BAJA')) {

  ?>
  <div class="alert alert-dismissible alert-primary text-center">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <i class="zmdi zmdi-alert-octagon zmdi-hc-5x"></i>
    <h4>¡Lo sentimos!</h4>
    <p>No podemos mostrar información para la hoja de diagnóstico del hardware debido a que el hardware ya ha sido dado de baja de la empresa</p>
  </div>
<?php }else if(trim($estado_mant)=='EN REPARACION'){ ?>
  <div class="alert alert-dismissible alert-primary text-center">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <i class="zmdi zmdi-alert-octagon zmdi-hc-5x"></i>
    <h4>¡Lo sentimos!</h4>
    <p>No podemos mostrar información del hardware debido a que la hoja de diagnóstico ya ha sido generada para su respectiva reparación</p>
  </div>
<?php }else if(($verificar!='DADO DE BAJA') && ($estado_mant!='EN REPARACION')){ ?>












  <div class="">
    <div class="x_panel">
      <div class="x_title">
        <h2>HOJA DE DIAGNÓSTICO DEL HARDWARE <small></small></h2>

        <div class="clearfix"></div>
      </div>

      <form action="<?php echo SERVERURL; ?>ajax/manteIngresoAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <input name="codqr-reg" type="hidden" value="<?php echo $campos['hardwareqr']; ?>"></input>
        <input name="respo-reg" type="hidden" value="<?php echo trim($_SESSION['empleado_gad']); ?>"></input>
        <div class="row">


          <label class="col-md-12 col-sm-12 form-group" for="message">Datos del usuario</label>
          <div class="col-md-6 col-sm-12  form-group">        
            <div class="">
              <input class="form-control" data-validate-length-range="6" type="text" data-validate-words="2" name="emple-reg" disabled="disabled" placeholder="" value="<?php echo $campos['empleadoapellidos']." ".$campos['empleadonombres']; ?>" required="required" />
            </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
            <div class="">
              <input class="form-control" data-validate-length-range="6" type="text" data-validate-words="2" name="depar-reg" disabled="disabled" value="<?php echo $campos['departamentonombre']; ?>" required="required" />
            </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group">         
            <div class="">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="cargo-reg" disabled="disabled" value="<?php echo $campos['cargonombre']; ?>" required="required" />
            </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group">         
            <div class="">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="number" name="telefono-reg" value="<?php echo $campos['empleadocelular']; ?>" disabled="disabled" placeholder="TÉLEFONO" required="required" />
            </div>
          </div>


          <label class="col-md-12 col-sm-12 form-group" for="message">Datos del hardware</label>
          <div class="col-md-6 col-sm-12  form-group">        
            <div class="">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="tipo-reg" disabled="disabled" placeholder="" value="<?php echo $campos['tipohardwarenombre']; ?>" required="required" />
            </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
            <div class="">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="marca-reg" disabled="disabled" value="<?php echo $campos['marcahardwarenombre']; ?>" required="required" />
            </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group">         
            <div class="">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="modelo-reg" disabled="disabled" value="<?php echo $campos['modelohardwarenombre']; ?>" required="required" />
            </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group">         
            <div class="">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="color-reg" disabled="disabled" value="<?php echo $campos['colorhardwarenombre']; ?>" required="required" />
            </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group">         
            <div class="">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="serie-reg" disabled="disabled" value="<?php echo $campos['serireexterno']; ?>" required="required" />
            </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group">         
            <div class="">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="serie-reg" disabled="disabled" value="<?php echo $campos['hiserie']; ?>" required="required" />
            </div>
          </div>



          <label class="col-md-12 col-sm-12 form-group" for="message">Datos de ingreso</label>
          <div class="col-md-6 col-sm-12  form-group">        
            <div class="">
              <input class="form-control" type="time" data-validate-length-range="6" data-validate-words="2" name="hora-reg" placeholder="HORA"  />
            </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
            <div class="">
              <input class="form-control" type="date" tdata-validate-length-range="6" data-validate-words="2" name="fecha-reg" placeholder="FECHA" />
            </div>
          </div>


          <div class="col-md-12 col-sm-12 form-group">         
            <div class="">
              <label for="message">Reporte de usuario (max 255):</label>
              <textarea class="form-control" name="reporte-reg" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
            </div>
          </div>


          <div class="col-md-12 col-sm-12 form-group">         
            <div class="">
              <label for="message">Informe Técnico (max 255):</label>
              <textarea class="form-control" name="informe-reg" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
            </div>
          </div>



          <!------------------ INICIP HARDWARE ----------------------------> 

          <!------------------ FIN HARDWARE ----------------------------> 

          
          


        </div>



        <div class="ln_solid">
          <div class="form-group">
            <div class="col-md-9 offset-md-5">
              <button type='submit' class="btn btn-primary">Generar hoja de diagnóstico</button>
              <!--<button type='reset' class="btn btn-secondary">Limpiar</button>-->
            </div>
          </div>
        </div>


        <div class="RespuestaAjax"></div>
      </form>




    </div>
  </div>
  <?php } ?>