<?php
require_once "./controladores/mantenimientoControlador.php";
$verificar=$_POST['codigo'];


$iEs= new mantenimientoControlador();
$filesEs=$iEs->datos_mantenimiento_controlador("Tipo",$verificar);

if ($filesEs->rowCount()==1) {
  $campos=$filesEs->fetch();
  
  ?>
  
  
  <div class="">
    <div class="x_panel">
      <div class="x_title">
       <!--<h2>Asignar hardware a empleados <small></small></h2>-->
       <div class="clearfix"></div>
     </div>
     

     <form action="<?php echo SERVERURL; ?>ajax/asignacionAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

      <input type="hidden" name="codigo" value="<?php echo $verificar; ?>">
      <input type="hidden" name="codigo-up" value="<?php echo $campos['hiserie']; ?>">
      <!--<input type="text" name="informe-up" value="<?php echo $campos['icodigo']; ?>">-->

      
      <h2 class="StepTitle">Información del hardware</h2><br>
      <div class="row">
        <div class="col-md-4 col-sm-12  form-group">
          <label class="col-md-3 col-sm-12 form-group" for="message">Cod.Inventario</label>
          <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="serie-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['hiserie']; ?>" disabled="disabled"/>
        </div>
        <div class="col-md-4 col-sm-12  form-group">
          <label class="col-md-3 col-sm-12 form-group" for="message"># de Serie</label>
          <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="serie-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['serireexterno']; ?>" disabled="disabled"/>
        </div>
        <div class="col-md-4 col-sm-12  form-group">
          <label class="col-md-3 col-sm-12 form-group" for="message">Tipo</label>          
          <div class="">
            <input class="form-control" name="color-up" value="<?php echo($campos['tipohardwarenombre']); ?>" placeholder="" disabled="disabled" required="required">
          </input>
        </div>
      </div>
      <div class="col-md-3 col-sm-12  form-group">
        <label class="col-md-3 col-sm-12 form-group" for="message">Marca</label>          
        <div class="">
          <input class="form-control" value="<?php echo($campos['marcahardwarenombre']); ?>" placeholder="" disabled="disabled" required="required">
        </input>                            
      </div>
    </div>
    <div class="col-md-3 col-sm-12  form-group">  
      <label class="col-md-3 col-sm-12 form-group" for="message">Modelo</label>        
      <div class="">
        <input class="form-control" value="<?php echo($campos['modelohardwarenombre']); ?>" placeholder="" disabled="disabled" required="required">
      </input>  
    </div>
  </div>
  <div class="col-md-3 col-sm-12  form-group">
    <label class="col-md-3 col-sm-12 form-group" for="message">Color</label>          
    <div class="">
      <input class="form-control" name="color-up" value="<?php echo($campos['colorhardwarenombre']); ?>" placeholder="" disabled="disabled" required="required">
    </input>
  </div>
</div>
<div class="col-md-3 col-sm-12  form-group">
  <label class="col-md-3 col-sm-12 form-group" for="message">Cable</label>
  <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="cable-up" placeholder="CABLES" required="required" value="<?php echo $campos['hicables']; ?>" disabled="disabled"/>
</div>
<div class="col-md-12 col-sm-12  form-group">
  <label class="col-md-6 col-sm-12 form-group" for="message">Observaciones</label>
  <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="obs-up" placeholder="OBSERVACIONES" required="required" value="<?php echo $campos['hiobservaciones']; ?>" disabled="disabled"/>
</div>
<div class="col-md-12 col-sm-16 form-group">  
  <label class="col-md-4 col-sm-12 form-group" for="message">Caracteristicas</label>       
  <div class="">
    <textarea required="required" class="form-control" name="carac-up" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" placeholder="CARACTERISTICAS" disabled="disabled"><?php echo $campos['hicaracteristicas']; ?></textarea>
  </div>
</div>

<br><br>
</div>
<!--  --------------------------------------------  -->

<h2 class="StepTitle">Información del empleado</h2><br>






<div id="emp">
  <div class="row">
    <div class="col-md-6 col-sm-12  form-group">
      <label class="label-align">Entidad <span class="required">:</span></label>           
      <div class="">
        <input class="form-control" value="<?php echo($campos['empresanombre']); ?>"  disabled="disabled" placeholder="" required="required">
      </input>
    </div>
  </div>

  <div class="col-md-6 col-sm-12  form-group">
    <label class="label-align">Departamento <span class="required">:</span></label>           
    <input class="form-control" value="<?php echo($campos['departamentonombre']); ?>" disabled="disabled" placeholder="" required="required">
  </input>
</div>
<div class="col-md-6 col-sm-12  form-group">
  <label class="label-align">Cargo <span class="required">:</span></label>           
  <div class="">
    <input class="form-control" value="<?php echo($campos['cargonombre']); ?>" disabled="disabled" placeholder="" required="required">
  </input>
</div>
</div>
<div class="col-md-6 col-sm-12  form-group">
  <label class="label-align">Empleado <span class="required">:</span></label>           
  <div class="">
    <input class="form-control" value="<?php echo trim($campos['empleadoapellidos'])." ".trim($campos['empleadonombres']); ?>" disabled="disabled" placeholder="" required="required">
  </input>
</div>
</div>     
</div>

<!--                  QR                      -->
<h2 class="StepTitle">Código QR perteneciemte hardware</h2><br><br>
<div class="row">
  <div class="col-md-12 col-sm-12 form-group">
    <img name="img" align="center" style="width:230px; height:230px; border: 6px solid black; display: block; margin-left: auto; margin-right: auto;" src="../imagenes_qr/<?php echo($campos['hiimagenqr']); ?>" /><br><br>
    <center><td><a title="Descargar QR" style="display: block; margin-left: auto; margin-right: auto;" href="../imagenes_qr/<?php echo $campos['hiimagenqr']; ?>" download="<?php echo $campos['hiimagenqr']; ?>" style="color: blue; font-size:18px;"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a></td></center>
    
  </div>
</div>
<!--  -----------------     QR ----------------  -->
</div> 


<div class="ln_solid">
  <div class="form-group">
    <div class="col-md-9 offset-md-5">
      <a style="width:170px; height:40px; margin-left: auto; margin-right: auto;" class="btn btn-secondary" href="<?php echo SERVERURL; ?>/asignados/"><i class="fa fa-reply-all"></i> Regresar</a>
    </div>
  </div>
</div>
<div class="RespuestaAjax"></div>

</form>



</div>
</div>



<?php } ?>


