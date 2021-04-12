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
                    <h2>Sección Hardware de Ingreso<small></small></h2>
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
                          <h2>Editar información del hardware de ingreso <small></small></h2>
                          <div class="clearfix"></div>
                        </div>
                        





                        <form action="<?php echo SERVERURL; ?>ajax/infoingresarHardAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                          <input type="hidden" name="codigo" value="<?php echo $verificar; ?>">
                          <input type="hidden" name="codigo-up" value="<?php echo $campos['hiserie']; ?>">
                          <input type="hidden" name="informe-up" value="<?php echo $campos['icodigo']; ?>">

                          <!--<h2 class="StepTitle">Informe de ingreso de hardware</h2><br><br>-->
                          <div class="row">


                            <input class="form-control" type="hidden" data-validate-length-range="6" data-validate-words="2" name="fecha-up" disabled="disabled" value="<?php echo $campos['hifecha']; ?>" required="required" />
                            <!------------------ INICIP HARDWARE ----------------------------> 
                            <!--<table>-->
                              <div class="col-md-4 col-sm-12  form-group">
                                <label class="col-md-4 col-sm-12 form-group" for="message">Titúlo de ingreso</label>
                                <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="titulo-up" placeholder="TITÚLO DEL INGRESO" value="<?php echo trim($campos['hititulo']); ?>" />
                              </div>
                              <div class="col-md-4 col-sm-12  form-group">
                                <label class="col-md-4 col-sm-12 form-group" for="message">Tipo de hardware</label>          
                                <div class="">
                                  <?php
                                  require_once "./controladores/infoingresoHardControlador.php";
                                  $iEs= new infoingresoHardControlador();
                                  $cEs=$iEs->datos_infoingresoHard_controlador("TipoHardware",0);
                                  ?>
                                  <select class="form-control" name="tipo-up" placeholder="">
                                    <option value="0">SELECCIONE EL TIPO</option>
                                    <?php
                                    while($campos1=$cEs->fetch()){
                                      ?>
                                      <option <?php if (trim($campos['tipohardwarecodigo'])==trim($campos1['tipohardwarecodigo'])) echo('selected')?> value="<?php echo trim($campos1['tipohardwarecodigo']); ?>"><?php echo trim($campos1['tipohardwarenombre']); ?></option>
                                      <?php
                                    } 

                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4 col-sm-12  form-group">
                                <label class="col-md-4 col-sm-12 form-group" for="message">Marca de hardware</label>          
                                <div class="">
                                  <?php
                                  require_once "./controladores/infoingresoHardControlador.php";
                                  $iEs= new infoingresoHardControlador();
                                  $cEs=$iEs->datos_infoingresoHard_controlador("MarcaHardware",0);
                                  ?>
                                  <select class="form-control" name="marca-up" placeholder="">
                                    <option value="0">SELECCIONE EL TIPO</option>
                                    <?php
                                    while($campos1=$cEs->fetch()){
                                      ?>
                                      <option <?php if (trim($campos['marcahardwarecodigo'])==trim($campos1['marcahardwarecodigo'])) echo('selected')?> value="<?php echo trim($campos1['marcahardwarecodigo']); ?>"><?php echo trim($campos1['marcahardwarenombre']); ?></option>
                                      <?php
                                    } 

                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4 col-sm-12  form-group">  
                                <label class="col-md-4 col-sm-12 form-group" for="message">Modelo de hardware</label>        
                                <div class="">
                                  <?php
                                  require_once "./controladores/infoingresoHardControlador.php";
                                  $iEs= new infoingresoHardControlador();
                                  $cEs=$iEs->datos_infoingresoHard_controlador("ModeloHardware",0);
                                  ?>
                                  <select class="form-control" name="modelo-up" placeholder="">
                                    <option value="0">SELECCIONE EL MODELO</option>
                                    <?php
                                    while($campos1=$cEs->fetch()){
                                      ?>
                                      <option <?php if (trim($campos['modelohardwarecodigo'])==trim($campos1['modelohardwarecodigo'])) echo('selected')?> value="<?php echo trim($campos1['modelohardwarecodigo']); ?>"><?php echo trim($campos1['modelohardwarenombre']); ?></option>
                                      <?php
                                    } 

                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4 col-sm-12  form-group">
                                <label class="col-md-4 col-sm-12 form-group" for="message"># de Serie de hardware</label>
                                <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" disabled="disabled" placeholder="INGRESE EL # DE SERIE" value="<?php echo trim($campos['serireexterno']); ?>" />
                                <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="hidden" name="externo-up" placeholder="INGRESE EL # DE SERIE" value="<?php echo trim($campos['serireexterno']); ?>" />
                              </div>
                              <div class="col-md-4 col-sm-12  form-group">
                                <label class="col-md-4 col-sm-12 form-group" for="message">Código de inventario</label>
                                <input class="form-control" data-validate-length-range="6" data-validate-words="2" disabled="disabled" name="inventario-up" placeholder="INVENTARIO" value="<?php echo trim($campos['hiserie']); ?>" />
                              </div>
                              <div class="col-md-4 col-sm-12  form-group">
                                <label class="col-md-4 col-sm-12 form-group" for="message">Color de hardware</label>          
                                <div class="">
                                  <?php
                                  require_once "./controladores/infoingresoHardControlador.php";
                                  $iEs= new infoingresoHardControlador();
                                  $cEs=$iEs->datos_infoingresoHard_controlador("ColoresHardware",0);
                                  ?>
                                  <select class="form-control" name="color-up" placeholder="">
                                    <option value="0">SELECCIONE EL COLOR</option>
                                    <?php
                                    while($campos1=$cEs->fetch()){
                                      ?>
                                      <option <?php if (trim($campos['colorhardwarecodigo'])==trim($campos1['colorhardwarecodigo'])) echo('selected')?> value="<?php echo trim($campos1['colorhardwarecodigo']); ?>"><?php echo trim($campos1['colorhardwarenombre']); ?></option>
                                      <?php
                                    } 

                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-12 col-sm-16 form-group">  
                                <label class="col-md-4 col-sm-12 form-group" for="message">Caracteristicas de hardware</label>       
                                <div class="">
                                  <textarea class="form-control" name="carac-up" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" placeholder="CARACTERISTICAS"><?php echo trim($campos['hicaracteristicas']); ?></textarea>
                                </div>
                              </div>
                              <div class="col-md-4 col-sm-12  form-group">
                                <label class="col-md-4 col-sm-12 form-group" for="message">Cable de hardware</label>
                                <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="cable-up" placeholder="CABLES" value="<?php echo trim($campos['hicables']); ?>" />
                              </div>
                              <div class="col-md-4 col-sm-12  form-group">
                                <label class="col-md-4 col-sm-12 form-group" for="message">Observaciones</label>
                                <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="obs-up" placeholder="OBSERVACIONES" value="<?php echo trim($campos['hiobservaciones']); ?>" />
                              </div>
                              <div class="col-md-4 col-sm-12  form-group">
                                <label class="col-md-4 col-sm-12 form-group" for="message">Estado de ingreso</label>
                                <div class="">
                                  <?php
                                  require_once "./controladores/infoingresoHardControlador.php";
                                  $iEs= new infoingresoHardControlador();
                                  $cEs=$iEs->datos_infoingresoHard_controlador("Estados",0);
                                  ?>
                                  <select class="form-control" name="estado-up" placeholder="SELECCIÓNE EL ESTADO LA GESTIÓN">
                                    <option value="0">SELECCIÓNE EL ESTADO LA GESTIÓN</option>
                                    <?php
                                    while($campos1=$cEs->fetch()){
                                      ?>
                                      <option <?php if (trim($campos['estadoinfoharcodigo'])==trim($campos1['estadoinfoharcodigo'])) echo('selected')?> value="<?php echo trim($campos1['estadoinfoharcodigo']); ?>"><?php echo trim($campos1['estadoinfoharnombre']); ?></option>
                                      <?php
                                    } 

                                    ?>
                                  </select>
                                </div>
                              </div>

                              <!------------------ FIN HARDWARE ----------------------------> 


                              


                            </div>



                            <div class="ln_solid">
                              <div class="form-group">
                                <div class="col-md-9 offset-md-5">
                                  <button style="font-size:16px; border:800px; width:127px; height:40px;" type='submit' class="btn btn-primary"><i class="fa fa-refresh"></i> Editar</button>
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
                        <p>No podemos mostrar información del ingreso del hardware de ingreso en este momento</p>
                      </div>
                    <?php } ?>





                  </div>
                </div>




              </div>
            </div>
          </div>