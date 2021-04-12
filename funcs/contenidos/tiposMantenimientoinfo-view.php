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
                    <h2>Sección tipos de Mantenimiento <small></small></h2>
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
                  require_once "./controladores/tiposMantenimientoControlador.php";

                  $datos=explode("/", $_GET['views']);

                  $iEs= new tiposMantenimientoControlador();
                  $filesEs=$iEs->datos_tiposMantenimiento_controlador("Unico",$datos[1]);

                  if ($filesEs->rowCount()==1) {
                    $campos=$filesEs->fetch();
                    
                    ?>

                    
                    <div class="">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Editar el tipo de mantenimiento <small></small></h2>
                          <div class="clearfix"></div>
                        </div>
                        
                        <form action="<?php echo SERVERURL; ?>ajax/tiposMantenimientoAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                                                        <!--
                                                        <div class="field item form-group">
                                                          <label class="col-form-label col-md-3 col-sm-3  label-align">Seleccionar Tipo Cuenta <span class="required">:</label>
                                                          <div class="col-md-6 col-sm-6 ">
                                                                <select class="form-control" name="name" placeholder="ejem. INGA LEMA" required="required">
                                                                        <option value="AK">Administrador</option>
                                                                </select>
                                                          </div>
                                                        </div>
                                                      -->
                                                      <input type="hidden" name="codigo" value="<?php echo $datos[1] ?>">
                                                      <input type="hidden" name="codigo-up" value="<?php echo $campos['ESTADOMANTENIMIENTOCODIGO']; ?>">

                                                      <div class="field item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3  label-align">Tipo<span class="required">:</label>
                                                          <div class="col-md-6 col-sm-6 ">
                                                           
                                                            <select class="form-control" name="opcion-up" onchange="cargarDep(this)" placeholder="" required="required">
                                                             
                                                              <option value="<?php echo ($campos['TIPOMANTENOMBRE']);?>">"<?php echo ($campos['TIPOMANTENOMBRE']);?>"</option>
                                                              <option value="PREVENTIVO">PREVENTIVO</option>
                                                              <option value="CORRECTIVO">CORRECTIVO</option>
                                                              <option value="DE BAJA">DE BAJA</option>
                                                              
                                                            </select>
                                                          </div>
                                                        </div>
                                                        
                                                        <div class="ln_solid">
                                                          <div class="form-group">
                                                            <div class="col-md-6 offset-md-3">
                                                              <button type='submit' class="btn btn-primary">Actualizar</button>
                                                              <a href="<?php echo SERVERURL; ?>/tiposMantenimiento/" class="btn btn-secondary">Regresar</a>
                                                              <!--<button type='reset' class="btn btn-success">Limpiar</button>-->
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
                                                    <p>No podemos mostrar información del estado en este momento</p>
                                                  </div>
                                                <?php } ?>





                                              </div>
                                            </div>




                                          </div>
                                        </div>
                                      </div>