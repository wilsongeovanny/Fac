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


  function cargar(id){
    console.log(id);
    //alert(id);

    a=id;
    //alert(a);

    //$timico=a;
    var data;
    $.ajax({
      url: '../controladores/vistoinforme.php?empleadocedula='+a,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#visto").html(data);        
          }
        })            
  }
</script>
                        <div class="">
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Informe de ingreso de hardware <small></small></h2>
                                
                                <div class="clearfix"></div>
                            </div>










      <form action="<?php echo SERVERURL; ?>ajax/infoingresarHardAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

        <input name="respo-reg" type="hidden" value="<?php echo trim($_SESSION['empleado_gad']); ?>"></input>
        <!--<h2 class="StepTitle">Informe de ingreso de hardware</h2><br><br>-->
        <div class="row">


          <label class="col-md-12 col-sm-12 form-group" for="message">Información</label>
          <div class="col-md-6 col-sm-12  form-group">        
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="tema-reg" placeholder="TEMA DEL INFORME"/>
          </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" name="fecha-reg" type="date" data-validate-words="2"/>
          </div>
          </div> 


          <label class="col-md-12 col-sm-12 form-group" for="message">1. Datos generales</label>
          <div class="col-md-6 col-sm-12  form-group">        
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="servicio-reg" placeholder="TIPO DE SERVICIO"/>
          </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="trabajo-reg" placeholder="LUGAR DE TRABAJO"/>
          </div>
          </div>


          <div class="col-md-12 col-sm-12 form-group">         
          <div class="">
            <label for="message">2. Antecedentes (max 255) :</label>
            <textarea class="form-control" name="antecedente-reg" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
          </div>
          </div>


          <div class="col-md-12 col-sm-12 form-group">         
          <div class="">
            <label for="message">3. Objetivos (max 255) :</label>
            <textarea class="form-control" name="objetivo-reg" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
          </div>
          </div>


          <div class="col-md-12 col-sm-12 form-group">         
          <div class="">
            <label for="message">4. Analisis (max 255) :</label>
            <textarea class="form-control" name="analisis-reg" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
          </div>
          </div>
<!------------------ INICIP HARDWARE ----------------------------> 
          <table>
            <div class="col-md-4 col-sm-12  form-group">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" id="itemtitulo" placeholder="TITÚLO DEL INGRESO" />
            </div>
            <div class="col-md-4 col-sm-12  form-group">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" id="itemserie" placeholder="INGRESE EL # DE SERIE"/>
            </div>
            <div class="col-md-4 col-sm-12  form-group">          
              <div id="divCargo" class="">
                <?php
                require_once "./controladores/infoingresoHardControlador.php";
                $iEs= new infoingresoHardControlador();
                $cEs=$iEs->datos_infoingresoHard_controlador("ColoresHardware",0);
                ?>
                <select class="form-control" id="itemcolor" placeholder="">
                  <option value="0">SELECCIONE EL COLOR</option>
                  <?php
                  while($campos=$cEs->fetch()){
                    ?>
                    <option value="<?php echo $campos['colorhardwarecodigo']; ?>">
                      <?php echo $campos['colorhardwarenombre']; ?>
                    </option>
                    <?php
                  } 

                  ?>
                </select>
              </div>
            </div>


            <div class="col-md-4 col-sm-12  form-group">
              <div class="">
                <?php
                require_once "./controladores/infoingresoHardControlador.php";
                $iEs= new infoingresoHardControlador();
                $cEs=$iEs->datos_infoingresoHard_controlador("TipoHardware",0);
                ?>
                <select class="form-control" id="itemtipo" onchange="cargarMarca(this)" placeholder="">
                  <option value="0">SELECCIONE EL TIPO</option>
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
            <div class="col-md-4 col-sm-12  form-group">        
              <div id="divMarca">
                <?php
                require_once "./controladores/infoingresoHardControlador.php";
                $iEs= new infoingresoHardControlador();
                $cEs=$iEs->datos_infoingresoHard_controlador("MarcaHardware",0);
                ?>
                <select class="form-control" id="itemmarca" onchange="cargarModelo(this)" placeholder="">
                  <option value="0">SELECCIONE EL MARCA</option>
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
            <div class="col-md-4 col-sm-12  form-group">          
              <div id="divModelo">
                <?php
                require_once "./controladores/infoingresoHardControlador.php";
                $iEs= new infoingresoHardControlador();
                $cEs=$iEs->datos_infoingresoHard_controlador("ModeloHardware",0);
                ?>
                <select class="form-control" id="itemmodelo" placeholder="">
                  <option value="0">SELECCIONE EL MODELO</option>
                  <?php
                  while($campos=$cEs->fetch()){
                    ?>
                    <option value="<?php echo $campos['modelohardwarecodigo']; ?>">
                      <?php echo $campos['modelohardwarenombre']; ?>
                    </option>
                    <?php
                  } 

                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-12 col-sm-16 form-group">         
            <div class="">
                <textarea class="form-control" id="itemcarac" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" placeholder="CARACTERISTICAS"></textarea>
              </div>
            </div>
            <div class="col-md-4 col-sm-12  form-group">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" id="itemcable" placeholder="CABLES"/>
            </div>
            <div class="col-md-4 col-sm-12  form-group">
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" id="itemobs" placeholder="OBSERVACIONES"/>
            </div>
            <!--  <label class="col-md-4 col-sm-12 form-group" for="message">Estado de la compra</label> -->
            <div class="col-md-4 col-sm-12  form-group">
            <div class="">
                <?php
                require_once "./controladores/infoingresoHardControlador.php";
                $iEs= new infoingresoHardControlador();
                $cEs=$iEs->datos_infoingresoHard_controlador("Estados",0);
                ?>
                <select class="form-control" id="itemestado" placeholder="SELECCIÓNE EL ESTADO LA GESTIÓN">
                  <option value="0">SELECCIÓNE EL ESTADO LA GESTIÓN</option>
                  <?php
                  while($campos=$cEs->fetch()){
                    ?>
                    <option value="<?php echo $campos['estadoinfoharcodigo']; ?>">
                      <?php echo $campos['estadoinfoharnombre']; ?>
                    </option>
                    <?php
                  } 

                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-4 col-sm-12  form-group">
              <button type="button" id="anadir" name="anadir" class="btn btn-primary">Añadir</button>
              <button class="btn btn-secondary" onclick="limpiar()">Limpiar</button>
            </div>
            <tbody id="itemlist">

            </tbody>
          </table>
<!------------------ FIN HARDWARE ----------------------------> 

          <div class="col-md-12 col-sm-12 form-group">         
            <div class="">
              <label for="message">5. Conclusiones (max 255) :</label>
              <textarea class="form-control" name="conclusion-reg" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
            </div>
          </div>


          <div class="col-md-12 col-sm-12 form-group">         
            <div class="">
              <label for="message">6. Recomendaciones (max 255) :</label>
              <textarea class="form-control" name="recomendacion-reg" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
            </div>
          </div>

<br><br><br><br><br><br><br><br>


  
<!------------------ BUSCAR VISTO BUENO ----------------------------> 
                
                        

                  

           

                  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <h4 class="modal-title" id="bs-example-modal-lg">Empleados de sistemas activos</h4>
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="myModal">
                          <!--<h4>Text in a modal</h4>-->
                                                              <div class="card-box table-responsive">
                                        <!--<p class="text-muted font-13 m-b-30">
                                          The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
                                        </p>-->
                                    <table id="datatable" class="table table-bordered table-bordered" style="width:100%">
                                          <?php 
  require_once "./controladores/empleadosControlador.php";
  $insAdmin= new empleadosControlador();
?>
                                    <?php 
      
        echo $insAdmin->listar_vistoempleadosinfo_controlador();
      ?>  
  
                                    </table>
                                      </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>

                      </div>
                    </div>
                  </div>

       
<!------------------ FIN BUSCAR VISTO BUENO ----------------------------> 


          


        </div>

    <!-- VUELTA -->
                        <div id="visto">
                          <div class="row">
                            <div style="display: block; margin-left: auto; margin-right: auto;" class="col-md-4 col-sm-12  form-group">
                            <label class="label-align">Visto bueno por: <span class="required">:</span></label>           
                            
                              <input class="form-control" disabled="disabled" placeholder="" required="required">
                                </input>
                            
                            </div>
                          </div>
                        </div>


                        <button style="display: block; margin-left: auto; margin-right: auto;" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-search"></i> Buscar empleado</button>

                        <!-- VUELTA -->

<br><br>
        <div class="ln_solid">
            <div style="display: block; margin-left: auto; margin-right: auto;" class="form-group">
                <div class="col-md-9 offset-md-5">
                    <button type='submit' class="btn btn-primary">Registrar</button>
                    <!--<button type='reset' class="btn btn-secondary">Limpiar</button>-->
                </div>
            </div>
        </div>


      <div class="RespuestaAjax"></div>
    </form>




    </div>
    </div>
