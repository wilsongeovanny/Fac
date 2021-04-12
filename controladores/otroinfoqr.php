 
<script type="text/javascript">
  function cargarDep(opcion){
    var data;
    $.ajax({
      url: '../controladores/departamentos.php?DEPARTAMENTOCODIGO='+opcion.value,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#divDep").html(data);        
          }
        })            
  }


  function cargar(id){
    console.log(id);
    //alert(id);

    a=id;
    //Salert(a);

    //$timico=a;
    var data;
    $.ajax({
      url: '../controladores/emp.php?EMPLEADOCEDULA='+a,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#emp").html(data);        
          }
        })            
  }


  function cargarCargo(opcion){
    var data;
    $.ajax({
      url: '../controladores/cargos.php?CARGOCODIGO='+opcion.value,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#divCargo").html(data);        
          }
        })            
  }

  function cargarEmp(opcion){
    var data;
    $.ajax({
      url: '../controladores/empleados.php?EMPLEADOCEDULA='+opcion.value,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#divEmp").html(data);        
          }
        })            
  }

  function cargarQR(opcion){
    var data;
    $.ajax({
      url: '../controladores/QR.php?EMPLEADOCEDULA='+opcion.value,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#divQR").html(data);        
          }
        })            
  }


</script>

<?php
  require_once "./controladores/asignacionControlador.php";
  $verificar=$_POST['codigo'];


  $iEs= new asignacionControlador();
  $filesEs=$iEs->datos_asignacion_controlador("Tipo",$verificar);

  if ($filesEs->rowCount()==1) {
    $campos=$filesEs->fetch();
  
?>
   
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Form Wizards</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5  form-group row pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-secondary" type="button">Go!</button>
                          </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Wizards <small>Sessions</small></h2>
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



                
                  <div class="">
                    <div class="x_panel">
                      <div class="x_title">
                       <!--<h2>Asignar hardware a empleados <small></small></h2>-->
                    <div class="clearfix"></div>
                  </div>
                        

                        <form action="<?php echo SERVERURL; ?>ajax/asignacionAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

                        <input type="hidden" name="codigo" value="<?php echo $verificar; ?>">
                        <input type="hidden" name="codigo-up" value="<?php echo $campos['HISERIE']; ?>">
                          <!--<input type="text" name="informe-up" value="<?php echo $campos['ICODIGO']; ?>">-->

                        
                        <h2 class="StepTitle">Información del hardware</h2><br>
                        <div class="row">
                        <div class="col-md-3 col-sm-12  form-group">
                          <label class="col-md-3 col-sm-12 form-group" for="message"># de Serie</label>
                          <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="serie-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['HISERIE']; ?>" disabled="disabled"/>
                        </div>
                          <div class="col-md-3 col-sm-12  form-group">
                            <label class="col-md-3 col-sm-12 form-group" for="message">Tipo</label>          
                            <div class="">
                              <?php
                              require_once "./controladores/asignacionControlador.php";
                              $iEs= new asignacionControlador();
                              $cEs=$iEs->datos_asignacion_controlador("TipoHardware",0);
                              ?>
                              <select class="form-control" name="tipo-up" disabled="disabled" placeholder="" required="required">
                                <option value="0">SELECCIONE EL TIPO</option>
                                <?php
                                while($campos1=$cEs->fetch()){
                                  ?>
                                  <option <?php if ($campos['TIPOHARDWARECODIGO']==$campos1['TIPOHARDWARECODIGO']) echo('selected')?> value="<?php echo($campos1['TIPOHARDWARECODIGO']); ?>"><?php echo($campos1['TIPOHARDWARENOMBRE']); ?></option>
                                  <?php
                                } 

                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3 col-sm-12  form-group">
                          <label class="col-md-3 col-sm-12 form-group" for="message">Marca</label>          
                          <div class="">
                            <?php
                            require_once "./controladores/asignacionControlador.php";
                            $iEs= new asignacionControlador();
                            $cEs=$iEs->datos_asignacion_controlador("MarcaHardware",0);
                            ?>
                            <select class="form-control" name="marca-up" placeholder="" disabled="disabled" required="required">
                              <option value="0">SELECCIONE EL TIPO</option>
                              <?php
                              while($campos1=$cEs->fetch()){
                                ?>
                                <option <?php if ($campos['MARCAHARDWARECODIGO']==$campos1['MARCAHARDWARECODIGO']) echo('selected')?> value="<?php echo($campos1['MARCAHARDWARECODIGO']); ?>"><?php echo($campos1['MARCAHARDWARENOMBRE']); ?></option>
                                <?php
                              } 

                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-12  form-group">  
                          <label class="col-md-3 col-sm-12 form-group" for="message">Modelo</label>        
                          <div class="">
                            <?php
                            require_once "./controladores/asignacionControlador.php";
                            $iEs= new asignacionControlador();
                            $cEs=$iEs->datos_asignacion_controlador("ModeloHardware",0);
                            ?>
                            <select class="form-control" name="modelo-up" placeholder="" disabled="disabled" required="required">
                              <option value="0">SELECCIONE EL MODELO</option>
                              <?php
                              while($campos1=$cEs->fetch()){
                                ?>
                                <option <?php if ($campos['MODELOHARDWARECODIGO']==$campos1['MODELOHARDWARECODIGO']) echo('selected')?> value="<?php echo($campos1['MODELOHARDWARECODIGO']); ?>"><?php echo($campos1['MODELOHARDWARENOMBRE']); ?></option>
                                <?php
                              } 

                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-12  form-group">
                          <label class="col-md-3 col-sm-12 form-group" for="message">Color</label>          
                          <div class="">
                            <?php
                            require_once "./controladores/infoingresoHardControlador.php";
                            $iEs= new asignacionControlador();
                            $cEs=$iEs->datos_asignacion_controlador("ColoresHardware",0);
                            ?>
                            <select class="form-control" name="color-up" placeholder="" disabled="disabled" required="required">
                              <option value="0">SELECCIONE EL COLOR</option>
                              <?php
                              while($campos1=$cEs->fetch()){
                                ?>
                                <option <?php if ($campos['COLORHARDWARECODIGO']==$campos1['COLORHARDWARECODIGO']) echo('selected')?> value="<?php echo($campos1['COLORHARDWARECODIGO']); ?>"><?php echo($campos1['COLORHARDWARENOMBRE']); ?></option>
                                <?php
                              } 

                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3 col-sm-12  form-group">
                          <label class="col-md-3 col-sm-12 form-group" for="message">Cable</label>
                          <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="cable-up" placeholder="CABLES" required="required" value="<?php echo $campos['HICABLES']; ?>" disabled="disabled"/>
                        </div>
                        <div class="col-md-6 col-sm-12  form-group">
                          <label class="col-md-6 col-sm-12 form-group" for="message">Observaciones</label>
                          <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="obs-up" placeholder="OBSERVACIONES" required="required" value="<?php echo $campos['HIOBSERVACIONES']; ?>" disabled="disabled"/>
                        </div>
                        <div class="col-md-12 col-sm-16 form-group">  
                          <label class="col-md-4 col-sm-12 form-group" for="message">Caracteristicas</label>       
                          <div class="">
                            <textarea required="required" class="form-control" name="carac-up" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" placeholder="CARACTERISTICAS" disabled="disabled"><?php echo $campos['HICARACTERISTICAS']; ?></textarea>
                          </div>
                        </div>

                        <br><br>
                        </div>
                        <!--  --------------------------------------------  -->

                        <h2 class="StepTitle">Información del empleado a asignar</h2><br>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Buscar empleado &nbsp;<i class="fa fa-search"></i></button>

                        <br><br>

                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                              <div class="modal-header">
                                <h4 class="modal-title" id="bs-example-modal-lg">Empleados activos</h4>
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                </button>
                              </div>
                              <div class="myModal">
                                <div class="card-box table-responsive">

                                  <table id="datatable" class="table table-bordered table-bordered" style="width:100%">
                                    <?php 
                                      require_once "./controladores/empleadosControlador.php";
                                      $insAdmin= new empleadosControlador();
                                    ?>
                                    <?php       
                                      echo $insAdmin->listar_asigempleados_controlador();
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


                        <div id="emp">
                        <div class="row">
                            <div class="col-md-6 col-sm-12  form-group">
                              <label class="label-align">Seleccione Entidad <span class="required">:</span></label>           
                              <div class="">
                                <?php
                                require_once "./controladores/asignacionControlador.php";
                                $iEs= new asignacionControlador();
                                $cEs=$iEs->datos_asignacion_controlador("SelectEmpresa",0);
                                ?>
                                <select class="form-control" name="emp-reg" onchange="cargarDep(this)" placeholder="" required="required">
                                  <?php
                                  while($campos=$cEs->fetch()){
                                    ?>
                                    <option value="<?php echo $campos['EMPRESACODIGO']; ?>">
                                      <?php echo $campos['EMPRESANOMBRE']; ?>
                                    </option>
                                    <?php
                                  } 
                                  
                                  ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-12  form-group">
                              <label class="label-align">Seleccione Departamento <span class="required">:</span></label>           
                              <div id="divDep" class="">

                                <?php
                                require_once "./controladores/asignacionControlador.php";
                                $iEs= new asignacionControlador();
                                $cEs=$iEs->datos_asignacion_controlador("SelectDep",0);
                                ?>
                                <select class="form-control" name="dep-reg" onchange="cargarCargo(this)" placeholder="" required="required">
                                  <?php
                                  while($campos=$cEs->fetch()){
                                    ?>
                                    <option value="<?php echo $campos['DEPARTAMENTOCODIGO']; ?>">
                                      <?php echo $campos['DEPARTAMENTONOMBRE']; ?>
                                    </option>
                                    <?php
                                  } 
                                  
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12  form-group">
                              <label class="label-align">Seleccione Cargo <span class="required">:</span></label>           
                              <div id="divCargo" class="">

                                <?php
                                require_once "./controladores/asignacionControlador.php";
                                $iEs= new asignacionControlador();
                                $cEs=$iEs->datos_asignacion_controlador("SelectCargos",0);
                                ?>
                                <select class="form-control" name="car-reg" onchange="cargarEmp(this)" placeholder="" required="required">
                                  <?php
                                  while($campos=$cEs->fetch()){
                                    ?>
                                    <option value="<?php echo $campos['CARGOCODIGO']; ?>">
                                      <?php echo $campos['CARGONOMBRE']; ?>
                                    </option>
                                    <?php
                                  } 
                                  
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12  form-group">
                              <label class="label-align">Seleccione Empleado <span class="required">:</span></label>           
                              <div id="divEmp" class="">

                                <?php
                                require_once "./controladores/asignacionControlador.php";
                                $iEs= new asignacionControlador();
                                $cEs=$iEs->datos_asignacion_controlador("Empleados",0);
                                ?>
                                <select class="form-control" name="pers-reg" placeholder="" required="required">
                                  <?php
                                  while($campos=$cEs->fetch()){
                                    ?>
                                    <option value="<?php echo $campos['EMPLEADOCEDULA']; ?>">
                                      <?php echo $campos['EMPLEADOAPELLIDOS']." ".$campos['EMPLEADONOMBRES']; ?>
                                    </option>
                                    <?php
                                  } 
                                  
                                  ?>
                                </select>
                              </div>
                            </div>     
                         </div>

                        <!--                  QR                      -->
                        <h2 class="StepTitle">Generar código QR al hardware</h2><br><br>
                          <div class="row">
                          <center><div>
                            <div id="">
                              <button style="width:230px; height:230px; margin-left: 265%; margin-top: 10px; margin-bottom: 20px;"type="button" name="codqr" value"<?php echo $campos['HISERIE']; ?>" onclick="cargarQR(this)" class="btn btn-default btn-lg"><strong>GENERAR CÓDIGO QR</strong></button>
                            </div>
                            
                          </div></center>
                        </div>
                        <!--  -----------------     QR ----------------  -->
                        </div> 


                      <div class="ln_solid">
                        <div class="form-group">
                          <div class="col-md-9 offset-md-5">
                            <button type='submit' class="btn btn-primary"><i class="fa fa-sign-out"></i> Asignar</button>
                            <a class="btn btn-secondary" href="<?php echo SERVERURL; ?>/asignacion/"><i class="fa fa-reply-all"></i> Regresar</a>
                          </div>
                        </div>
                      </div>
                      <div class="RespuestaAjax"></div>

                        </form>



                      </div>
                      </div>



<?php } ?>



                </div>
              </div>


            </div>
          </div>
        </div>