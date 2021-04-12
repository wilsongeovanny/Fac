 
<script type="text/javascript">
  function cargar(id){
    console.log(id);
    //alert(id);

    a=id;
    alert(a);

    $timico=a;
    var data;
    $.ajax({
      url: '../controladores/emp.php?empleadocedula='+a,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#emp").html(data);        
          }
        })            
  }
</script>

<?php
require_once "./controladores/mantenimientoControlador.php";
if (!isset($_POST['codigo'])) {
  $verificar='null';
}else{
  $verificar=$_POST['codigo'];
}

$iEs= new mantenimientoControlador();
$filesEs=$iEs->datos_mantenimiento_controlador("Tipo",$verificar);

if ($filesEs->rowCount()==1) {
  $campos=$filesEs->fetch();

  $bus=$campos['hiserie']; 
  
  ?>   



  
  <div class="">
    <div class="x_panel">
      <div class="x_title">
       <!--<h2>Asignar hardware a empleados <small></small></h2>-->
       <div class="clearfix"></div>
     </div>
     

     <form action="" method="POST" data-form="" class="" autocomplete="off" enctype="multipart/form-data">

      
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
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="tipo-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['tipohardwarenombre']; ?>" disabled="disabled"/>
          </div>
        </div>
        <div class="col-md-3 col-sm-12  form-group">
          <label class="col-md-3 col-sm-12 form-group" for="message">Marca</label>          
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="marca-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['marcahardwarenombre']; ?>" disabled="disabled"/>
          </div>
        </div>
        <div class="col-md-3 col-sm-12  form-group">  
          <label class="col-md-3 col-sm-12 form-group" for="message">Modelo</label>        
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="modelo-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['modelohardwarenombre']; ?>" disabled="disabled"/>
          </div>
        </div>
        <div class="col-md-3 col-sm-12  form-group">
          <label class="col-md-3 col-sm-12 form-group" for="message">Color</label>          
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="color-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['colorhardwarenombre']; ?>" disabled="disabled"/>
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

        
      </div>
      
      <br>

      <?php
      require_once './core/forced.php';
      $zinc=$campos['hiserie'];
      $consulta="SELECT * FROM hardware_ingreso as T1, auditoria_hardware as T2, responsable_auditoria as T3, empleados as T4, cargo as T5, departemento as T6, empresa as T7 WHERE T1.hiserie='$zinc' AND T1.hiserie=T2.hiserie AND T2.codigoauditoria=T3.codigoauditoria AND T2.empleadocodigo=T4.empleadocodigo AND T4.cargocodigo=T5.cargocodigo AND T5.departamentocodigo=T6.departamentocodigo AND T6.empresacodigo=T7.empresacodigo";

      $conexion = forced::conectar();

      $datos = $conexion->query($consulta);
      $datos= $datos->fetchAll();
      ?>
      <?php
      $contador=0;
      foreach ($datos as $rows) {
        $contador=$contador+1;
                          //$zinc=$rows['empleadocodigo'];
        ?>
        <!--  --------------------------------------------  -->

        <h2 class="StepTitle">Auditoria # <?php echo $contador; ?></h2><br>

        <div class="row">


          <div class="col-md-4 col-sm-12  form-group">
            <label class="label-align">Entidad<span class="required">:</span></label>
            <input class="form-control" type="text" class='number' name="cedula-up" data-validate-minmax="10,100" required='required' value="<?php echo $rows['empresanombre']; ?>"/ disabled="disabled">
          </div>
          <div class="col-md-4 col-sm-12  form-group">
            <label class="label-align">Departamento<span class="required">:</span></label>
            <input class="form-control" type="text" class="text" name="apellidos-up" data-validate-length-range="6" data-validate-words="2" placeholder="INGA LEMA" required="required" value="<?php echo $rows['departamentonombre']; ?>"/ disabled="disabled">
          </div>
          <div class="col-md-4 col-sm-12  form-group">
            <label class="label-align">Cargo<span class="required">:</span></label>
            <input class="form-control" type="text" class="number" name="telefono-up" data-validate-minmax="10,100" required='required' value="<?php echo $rows['cargonombre']; ?>"/ disabled="disabled">
          </div>


          <div class="col-md-4 col-sm-12  form-group">
            <label class="label-align">Cédula<span class="required">:</span></label>
            <input class="form-control" type="text" class='number' name="cedula-up" data-validate-minmax="10,100" required='required' value="<?php echo $rows['empleadocedula']; ?>" disabled="disabled"/>
          </div>
          <div class="col-md-4 col-sm-12  form-group">
            <label class="label-align">Nombres<span class="required">:</span></label>
            <input class="form-control" type="text" class="text" name="apellidos-up" data-validate-length-range="6" data-validate-words="2" placeholder="INGA LEMA" required="required" value="<?php echo $rows['empleadoapellidos']." ".$rows['empleadonombres']; ?>" disabled="disabled"/>
          </div>
          

          <div class="col-md-4 col-sm-12  form-group">
            <label class="label-align">Télefono<span class="required">:</span></label>
            <input class="form-control" type="text" class="number" name="telefono-up" data-validate-minmax="10,100" required='required' value="<?php echo $rows['empleadotelefono']; ?>" disabled="disabled"/>
          </div>


          <div class="col-md-4 col-sm-12  form-group">
            <label class="col-md-3 col-sm-12 form-group" for="message"># de Auditoria</label>
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="serie-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $rows['auditoriacodigo']; ?>" disabled="disabled"/>
          </div>
          <div class="col-md-4 col-sm-12  form-group">
            <label class="col-md-3 col-sm-12 form-group" for="message">Tema</label>          
            <div class="">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="tipo-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $rows['auditoriatema']; ?>" disabled="disabled"/>
            </div>
          </div>
          <div class="col-md-4 col-sm-12  form-group">
            <label class="col-md-3 col-sm-12 form-group" for="message">Fecha</label>          
            <div class="">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="marca-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $rows['auditoriafecha']; ?>" disabled="disabled"/>
            </div>
          </div>
          <div class="col-md-12 col-sm-16 form-group">  
            <label class="col-md-4 col-sm-12 form-group" for="message">Descripción</label>       
            <div class="">
              <textarea required="required" class="form-control" name="carac-up" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" placeholder="CARACTERISTICAS" disabled="disabled"><?php echo $rows['auditoriadescripcion']; ?></textarea>
            </div>
          </div>


          
          <?php
          $codigo=$rows['codigoauditoria'];
          $query1= forced::ejecutar_consulta_simple("SELECT * FROM responsable_auditoria WHERE codigoauditoria='$codigo'");
          $RespoAud=$query1->fetch();
          $responsable=$RespoAud['empleadocodigo'];

          $query2= forced::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocodigo='$responsable'");
          $CodRespo=$query2->fetch();
          $nombres=$CodRespo['empleadonombres'];
          $apellidos=$CodRespo['empleadoapellidos'];
          echo "<div style='display: block; margin-left: auto; margin-right: auto;' class='col-md-4 col-sm-12  form-group'>
          <label class='col-md-3 col-sm-12 form-group' for='message'>Responsable</label>          
          <div class=''>
          <input class='form-control' data-validate-length-range='6' data-validate-words='2' name='marca-up' placeholder='INGRESE EL # DE SERIE' required='required' value='".trim($apellidos).' '.trim($nombres)."' disabled='disabled'/>
          </div>
          </div>";

          ?>


        </div>
        <br>
        <!--------------------------------------------------->
      <?php } ?>
      
      





      <div class="ln_solid">
        <div class="form-group">
          <div class="col-md-9 offset-md-5">


            <!--<a style="" method="post" name="Cod" height:36px;" href="<?php echo SERVERURL; ?>Reportes/Auditoria.php?Cod=<?php echo $bus ?>" title="Visualizar Informe" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>-->


            <a class="btn btn-secondary" href="<?php echo SERVERURL; ?>/liberados/"><i class="fa fa-reply-all"></i> Regresar</a>
          </div>
        </div>
      </div>
      <div class="RespuestaAjax"></div>

    </form>



  </div>
</div>



<?php } ?>



