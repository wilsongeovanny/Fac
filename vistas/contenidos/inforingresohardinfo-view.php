<script type="text/javascript">
  function cargarMarca(opcion){
    var data;
    $.ajax({
      url: '../controladores/marcaitem.php?marcahardwarecodigo='+opcion.value,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#divMarca").html(data);        
          }
        })            
  }

  function cargarModelo(opcion){
    var data;
    $.ajax({
      url: '../controladores/modeloitem.php?modelohardwarecodigo='+opcion.value,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#divModelo").html(data);      
          }
        })            
  }
</script>


<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Procesos de Control de Hardware</h3>
      </div>

      <div class="title_right">
        <div class="col-md-5 col-sm-5  form-group row pull-right top_search">
          <div class="input-group">
            <!--<input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-secondary" type="button">Go!</button>
            </span>-->
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">

      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Sección Informe de Ingreso de Hardware <small></small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a>
                  </li>
                  <li><a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>



          <?php
          require_once "./controladores/infoingresoHardControlador.php";

          if (!isset($_POST['codigo'])) {
            $verificar='null';
          }else{
            $verificar=$_POST['codigo'];
          }


          $iEs= new infoingresoHardControlador();
          $filesEs=$iEs->datos_infoingresoHard_controlador("Tipo",$verificar);

          if ($filesEs->rowCount()==1) {
            $campos=$filesEs->fetch();

            ?>


            <div class="">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Editar el informe de ingreso de hardware <small></small></h2>
                  <div class="clearfix"></div>
                </div>






                <form action="<?php echo SERVERURL; ?>ajax/infoingresarHardAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                  <input type="hidden" name="codigo" value="<?php echo $verificar; ?>">
                  <input type="hidden" name="codigo-up" value="<?php echo $campos['hiserie']; ?>">
                  <input type="hidden" name="informe-up" value="<?php echo $campos['icodigo']; ?>">
                  <input name="respo-reg" type="hidden" value="<?php echo trim($_SESSION['empleado_gad']); ?>"></input>
                  <!--<h2 class="StepTitle">Informe de ingreso de hardware</h2><br><br>-->
                  <div class="row">


                    <label class="col-md-12 col-sm-12 form-group" for="message">Información</label>
                    <div class="col-md-6 col-sm-12  form-group">        
                      <div class="">
                        <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="tema-up" placeholder="TEMA DEL INFORME" value="<?php echo trim($campos['itema']); ?>" />
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12  form-group">         
                      <div class="">

                        <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="fecha-up" disabled="disabled" value="<?php echo trim($campos['hifecha']); ?>" />
                      </div>
                    </div> 


                    <label class="col-md-12 col-sm-12 form-group" for="message">1. Datos generales</label>
                    <div class="col-md-6 col-sm-12  form-group">        
                      <div class="">
                        <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="servicio-up" placeholder="TIPO DE SERVICIO" value="<?php echo trim($campos['itiposervicio']); ?>" />
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12  form-group">         
                      <div class="">
                        <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="trabajo-up" placeholder="LUGAR DE TRABAJO" value="<?php echo trim($campos['ilugartrabajo']); ?>"/>
                      </div>
                    </div>


                    <div class="col-md-12 col-sm-12 form-group">         
                      <div class="">
                        <label for="message">2. Antecedentes (max 255) :</label>
                        <textarea class="form-control" name="antecedente-up" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"><?php echo trim($campos['iantecedentes']); ?></textarea>
                      </div>
                    </div>


                    <div class="col-md-12 col-sm-12 form-group">         
                      <div class="">
                        <label for="message">3. Objetivos (max 255) :</label>
                        <textarea class="form-control" name="objetivo-up" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"><?php echo trim($campos['iobjetivos']); ?></textarea>
                      </div>
                    </div>


                    <div class="col-md-12 col-sm-12 form-group">         
                      <div class="">
                        <label for="message">4. Analisis (max 255) :</label>
                        <textarea class="form-control" name="analisis-up" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"><?php echo trim($campos['ianalisis']); ?></textarea>
                      </div>
                    </div>
                    <!------------------ INICIP HARDWARE ----------------------------> 

                    <!------------------ FIN HARDWARE ----------------------------> 

                    <div class="col-md-12 col-sm-12 form-group">         
                      <div class="">
                        <label for="message">5. Conclusiones (max 255) :</label>
                        <textarea class="form-control" name="conclusion-up" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"><?php echo trim($campos['iconclusiones']); ?></textarea>
                      </div>
                    </div>


                    <div class="col-md-12 col-sm-12 form-group">         
                      <div class="">
                        <label for="message">6. Recomendaciones (max 255) :</label>
                        <textarea class="form-control" name="recomendacion-up" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"><?php echo trim($campos['irecomendaciones']); ?></textarea>
                      </div>
                    </div>


                    <div style="display: block; margin-left: auto; margin-right: auto;" class="col-md-6 col-sm-12  form-group">  
                     <label class="col-md-6 col-sm-12 form-group" for="message">Visto bueno por</label>      
                     <div class="">
                      <?php
                      require_once "./controladores/infoingresoHardControlador.php";
                      $iEs= new infoingresoHardControlador();
                      $cEs=$iEs->datos_infoingresoHard_controlador("Empleados",0);
                      ?>
                      <select class="form-control" name="vnombre-up" required="required">
                        <option value="0">SELECCIONE NOMBRES</option>
                        <?php
                        while($campos1=$cEs->fetch()){
                          ?>

                          <option <?php if (trim($campos['irespovisto'])==trim($campos1['empleadocodigo'])) echo('selected')?> value="<?php echo trim($campos1['empleadocodigo']); ?>"><?php echo trim($campos1['empleadoapellidos'])." ".trim($campos1['empleadonombres']); ?></option>
                          <?php
                        } 

                        ?>
                      </select>
                    </div>
                  </div>


                </div>



                <div class="ln_solid">
                  <div class="form-group">
                    <div class="col-md-9 offset-md-5">
                      <button style="font-size:16px; border:800px; width:127px; height:40px;" method="post" type='submit' class="btn btn-primary"><i class="fa fa-refresh"></i> Editar</button>
                      <a style="font-size:16px; border:800px; width:127px; height:40px;" class="btn btn-secondary" href="<?php echo SERVERURL; ?>/informeingresohardware/"><i class="fa fa-reply-all"></i> Regresar</a>
                    </div>
                  </div>
                </div>


                <div class="RespuestaAjax"></div>
              </form>



            </div>
          </div>


        <?php }else{ ?>
          <div class="alert alert-dismissible alert-warning text-center">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i>
            <h4>¡Lo sentimos!</h4>
            <p>No podemos mostrar información de la empresa en este momento</p>
          </div>
        <?php } ?>

      </div>
    </div>




  </div>
</div>
</div>