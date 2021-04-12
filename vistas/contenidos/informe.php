 
<script type="text/javascript">
  function cargar(id){
    console.log(id);
    //alert(id);

    a=id;
    //alert(a);

    //$timico=a;
    var data;
    $.ajax({
      url: '../controladores/visto.php?empleadocodigo='+a,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#visto").html(data);        
          }
        })            
  }
</script>
<?php
  require_once "./controladores/manteEntregarControlador.php";

  //$datos=explode("/", $_GET['views']);

  if (!isset($_POST['codmant'])) {
    $verificar='null';
  }else{
  $verificar=$_POST['codmant'];
  }

  $iEs= new manteEntregarControlador();
  $filesEs=$iEs->datos_manteEntregar_controlador("Informe",$verificar);

  if ($filesEs->rowCount()==1) {
    $campos=$filesEs->fetch();
  
?>


                                    <div class="">
                                    <div class="x_panel">
                                      <div class="x_title">
                                        <h2>INFORME TÉCNICO DE ENTREGA <small></small></h2>
                                        <div class="clearfix"></div>
                                      </div>
      <form action="<?php echo SERVERURL; ?>Reportes/Reporte.php" method="POST" data-form="" class="" autocomplete="off" enctype="multipart/form-data">
        <input name="codqr-reg" type="hidden" value="<?php echo $campos['hardwareqr']; ?>"></input>
        <input name="mant-reg" type="hidden" value="<?php echo $campos['mantenimientocodigo']; ?>"></input>

        <!--<h2 class="StepTitle">Informe de ingreso de hardware</h2><br><br>-->
        <div class="row">



          <label class="col-md-12 col-sm-12 form-group" for="message">Datos del usuario</label>
          <div class="col-md-6 col-sm-12  form-group">        
          <div class="">
            <input class="form-control" data-validate-length-range="6" type="text" data-validate-words="2" name="emple-reg" disabled="disabled" placeholder="" value="<?php echo trim($campos['empleadoapellidos'])." ".trim($campos['empleadonombres']); ?>" required="required" />
            <input class="form-control" data-validate-length-range="6" type="hidden" data-validate-words="2" name="empleado" placeholder="" value="<?php echo trim($campos['empleadoapellidos'])." ".trim($campos['empleadonombres']); ?>" required="required" />
          </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" type="text" data-validate-words="2" name="depar1" disabled="" value="<?php echo $campos['departamentonombre']; ?>" required="required" />
            <input class="form-control" data-validate-length-range="6" type="hidden" data-validate-words="2" name="departamento" value="<?php echo $campos['departamentonombre']; ?>" required="required" />
          </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="cargo-reg" disabled="disabled" value="<?php echo $campos['cargonombre']; ?>" required="required" />
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="hidden" name="cargo" value="<?php echo $campos['cargonombre']; ?>" required="required" />
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
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="hidden" name="tipo" placeholder="" value="<?php echo $campos['tipohardwarenombre']; ?>" required="required" />
          </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="marca-reg" disabled="disabled" value="<?php echo $campos['marcahardwarenombre']; ?>" required="required" />
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="hidden" name="marca" value="<?php echo $campos['marcahardwarenombre']; ?>" required="required" />
          </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="modelo-reg" disabled="disabled" value="<?php echo $campos['modelohardwarenombre']; ?>" required="required" />
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="hidden" name="modelo" value="<?php echo $campos['modelohardwarenombre']; ?>" required="required" />
          </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group"> 
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="color-reg" disabled="disabled" value="<?php echo $campos['colorhardwarenombre']; ?>" required="required" />
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="hidden" name="color" value="<?php echo $campos['colorhardwarenombre']; ?>" required="required" />
          </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group"> 
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="serie-reg" disabled="disabled" value="<?php echo $campos['serireexterno']; ?>" required="required" />
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="hidden" name="serie" value="<?php echo $campos['serireexterno']; ?>" required="required" />
          </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="inv-reg" disabled="disabled" value="<?php echo $campos['hiserie']; ?>" required="required" />
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="hidden" name="inventario" value="<?php echo $campos['hiserie']; ?>" required="required" />
          </div>
          </div>
          


          <label class="col-md-12 col-sm-12 form-group" for="message">Datos de ingreso</label>
          <div class="col-md-6 col-sm-12  form-group">        
          <div class="">
            <input class="form-control" type="time" data-validate-length-range="6" data-validate-words="2" name="hora-reg" disabled="disabled" value="<?php echo $campos['ingresohora']; ?>" placeholder="HORA" required="required" />
            <input class="form-control" type="hidden" data-validate-length-range="6" data-validate-words="2" name="horareg" value="<?php echo $campos['ingresohora']; ?>" placeholder="HORA" required="required" />
          </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" type="date" tdata-validate-length-range="6" data-validate-words="2" name="fecha-reg" disabled="disabled" value="<?php echo $campos['ingresofecha']; ?>" placeholder="FECHA" required="required" />
             <input class="form-control" type="hidden" tdata-validate-length-range="6" data-validate-words="2" name="fechareg" value="<?php echo $campos['ingresofecha']; ?>" placeholder="FECHA" required="required" />
          </div>
          </div>


          <label class="col-md-12 col-sm-12 form-group" for="message">Datos de entrega</label>
          <div class="col-md-6 col-sm-12  form-group">        
          <div class="">
            <input class="form-control" type="time" data-validate-length-range="6" data-validate-words="2" name="hentrega-reg" disabled="disabled" value="<?php echo $campos['entregahora']; ?>" placeholder="HORA" required="required" />
            <input class="form-control" type="hidden" data-validate-length-range="6" data-validate-words="2" name="horaent" value="<?php echo $campos['entregahora']; ?>" placeholder="HORA" required="required" />
          </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" type="date" tdata-validate-length-range="6" data-validate-words="2" name="fentrega-reg" disabled="disabled" value="<?php echo $campos['entregafecha']; ?>" placeholder="FECHA" required="required" />
            <input class="form-control" type="hidden" tdata-validate-length-range="6" data-validate-words="2" name="fechaent" value="<?php echo $campos['entregafecha']; ?>" placeholder="FECHA" required="required" />
          </div>
          </div>


          <!--<div class="col-md-4 col-sm-12 form-group">
            <label>Reporte de usuario</label>
            <input class="form-control" type="time" data-validate-length-range="6" data-validate-words="2" name="hora-reg" placeholder="HORA" required="required" />
          </div>-->

          <div class="col-md-6 col-sm-12 form-group">
            <label>Se entrego equipo por mostrado</label>
            <input class="form-control" type="" tdata-validate-length-range="6" data-validate-words="2" name="" disabled="disabled" value="<?php echo $campos['reportehm']; ?>" placeholder="FECHA" required="required" />

            <input class="form-control" type="hidden" tdata-validate-length-range="6" data-validate-words="2" name="si"  value="<?php echo $campos['reportehm']; ?>" placeholder="FECHA" required="required" />
          </div>

          <div class="col-md-6 col-sm-12 form-group">
            <label>Tpo de mantenimiento</label>
            <input class="form-control" type="text" tdata-validate-length-range="6" data-validate-words="2" name="" disabled="disabled" value="<?php echo $campos['tipomantenombre']; ?>" placeholder="FECHA" required="required" />

            <input class="form-control" type="hidden" tdata-validate-length-range="6" data-validate-words="2" name="mantenimiento" value="<?php echo $campos['tipomantenombre']; ?>" placeholder="FECHA" required="required" />
          </div>


          <div class="col-md-12 col-sm-12 form-group">         
          <div class="">
            <label for="message">Reporte de usuario :</label>
            <textarea required="required" class="form-control" name="reporte-reg" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" disabled="disabled"><?php echo $campos['reporteusuario']; ?></textarea>

            <input class="form-control" type="hidden" tdata-validate-length-range="6" data-validate-words="2" type="hidden" name="reporte" value="<?php echo $campos['reporteservicior']; ?>" placeholder="FECHA" required="required" />
          </div>
          </div>


          <div class="col-md-12 col-sm-12 form-group">         
          <div class="">
            <label for="message">Descripción del servicio realizado :</label>
            <textarea required="required" class="form-control" name="informe-reg" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" disabled="disabled"><?php echo $campos['reporteservicior']; ?></textarea>

             <input class="form-control" type="hidden" tdata-validate-length-range="6" data-validate-words="2" type="hidden" name="descripcion" value="<?php echo $campos['reporteservicior']; ?>" placeholder="FECHA" required="required" />
          </div>
          </div><br><br><br><br><br><br><br><br>


        
        </div>


        <?php
          $respo=$campos['resprepocodigo'];
          require_once './core/forced.php';
          $consultares=forced::ejecutar_consulta_simple("SELECT empleadocodigo FROM responsable_reporte WHERE resprepocodigo='$respo'");
          $Infores=$consultares->fetch();
          $consultares=$Infores['empleadocodigo'];

          $consultaNomres=forced::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocodigo='$consultares'");
          $InfoNomres=$consultaNomres->fetch();
          $consultaNomres=trim($InfoNomres['empleadoapellidos'])." ".trim($InfoNomres['empleadonombres']);

        ?>


                                  <!-- VUELTA -->
                        <div id="">
                          <div class="row">
                            <div style="display: block; margin-left: auto; margin-right: auto;" class="col-md-4 col-sm-12  form-group">
                            <label class="label-align">Responsable: <span class="required">:</span></label>           
                            
                              <input class="form-control" disabled="disabled" value="<?php echo $consultaNomres; ?>" placeholder="" required="required">
                                </input>
                               <input class="form-control" type="hidden" name="responsable" value="<?php echo $consultaNomres; ?>" placeholder="" required="required">
                                </input>
                            
                            </div>



        <?php
          $visto=$campos['vistorepocodigo'];
          require_once './core/forced.php';
          $consultaced=forced::ejecutar_consulta_simple("SELECT empleadocodigo FROM vistobueno_reporte WHERE vistorepocodigo='$visto'");
          $InfoCed=$consultaced->fetch();
          $consultaced=$InfoCed['empleadocodigo'];

          $consultaNom=forced::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocodigo='$consultaced'");
          $InfoNom=$consultaNom->fetch();
          $consultaNom=trim($InfoNom['empleadoapellidos'])." ".trim($InfoNom['empleadonombres']);

        ?>



                            <div style="display: block; margin-left: auto; margin-right: auto;" class="col-md-4 col-sm-12  form-group">
                            <label class="label-align">Visto bueno por: <span class="required">:</span></label>           
                            
                              <input class="form-control" disabled="disabled" value="<?php echo $consultaNom; ?>" placeholder="" required="required">
                                </input>

                                <input class="form-control" type="hidden" name="visto" value="<?php echo $consultaNom; ?>" placeholder="" required="required">
                                </input>
                            
                            </div>
                          </div>
                        </div>



                        <!-- VUELTA -->

        <div class="ln_solid">
            <div class="form-group">
                <div style="display: block; margin-left: auto; margin-right: auto;">
                    <button type='submit' class="btn btn-primary">Imprimir</button>
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
    <p>No podemos mostrar información para el reporte técnico en este momento</p>
</div>
<?php } ?>