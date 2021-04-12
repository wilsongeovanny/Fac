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
                            <h2>Sección Municipio <small></small></h2>
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
                          require_once "./controladores/empresaControlador.php";

                          if (!isset($_POST['codigo'])) {
                            $verificar='null';
                          }else{
                            $verificar=$_POST['codigo'];
                          }

                          $iEm= new empresaControlador();
                          $filesEm=$iEm->datos_empresa_controlador("Unico",$verificar);

                          if ($filesEm->rowCount()==1) {
                            $campos=$filesEm->fetch();
                            
                            ?>

                            
                            <div class="">
                              <div class="x_panel">
                                <div class="x_title">
                                  <h2>Editar la empresa <small></small></h2>
                                  <div class="clearfix"></div>
                                </div>
                                
                                <form action="<?php echo SERVERURL; ?>ajax/empresaAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                                  <input type="hidden" name="codigo" value="<?php echo $verificar ?>">
                                  <input type="hidden" name="codigo-up" value="<?php echo $campos['empresacodigo']; ?>">
                                  <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Ruc <span class="required">:</span></label>
                                    <div class="col-md-6 col-sm-6">
                                      <input class="form-control" type="text" class='number' name="ruc-up" data-validate-minmax="10,100" value="<?php echo trim($campos['empresaruc']); ?>">
                                    </div>
                                  </div>
                                  <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre <span class="required">:</span></label>
                                    <div class="col-md-6 col-sm-6">
                                      <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="nombre-up" placeholder="" value="<?php echo trim($campos['empresanombre']); ?>"/>
                                    </div>
                                  </div>
                                  <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Télefono <span class="required">:</span></label>
                                    <div class="col-md-6 col-sm-6">
                                      <input class="form-control" type="text" class='number' name="telefono-up" data-validate-minmax="10,100" value="<?php echo trim($campos['empresatelefono']); ?>">
                                    </div>
                                  </div>
                                  <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Correo <span class="required">:</span></label>
                                    <div class="col-md-6 col-sm-6">
                                      <input class="form-control" name="correo-up" placeholder="" class='email'type="email" value="<?php echo trim($campos['empresacorreo']); ?>"/>
                                    </div>
                                  </div>
                                  <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Dirección <span class="required">:</span></label>
                                    <div class="col-md-6 col-sm-6">
                                      <input class="form-control" data-validate-length-range="6" data-validate-words="1" name="direccion-up" placeholder="" value="<?php echo trim($campos['empresadireccion']); ?>"/>
                                    </div>
                                  </div>
                                  <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Logo <span class="required">:</span></label>
                                    <div class="col-md-6 col-sm-6">
                                      <input class="form-control" type="file" name="foto-up" maxlength="250"/>
                                    </div>
                                  </div>
                                  <br><br>
                                  
                                  <center>
                                    <img src="../imagenes/<?php echo $campos['empresalogo']; ?>" width="250" height="250"><br><br>
                                  </center>
                                  
                                  
                                  <div class="ln_solid">
                                    <div class="form-group">
                                      <div class="col-md-6 offset-md-3">
                                        <button style="width:100px; height:45px; display: block; margin-left: auto; margin-right: auto;" type='submit' class="btn btn-primary">Editar</button>
                                        <!--<a href="<?php echo SERVERURL; ?>/municipio/" class="btn btn-success">Regresar</a>-->
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
                              <p>No podemos mostrar información de la empresa en este momento</p>
                            </div>
                          <?php } ?>




                        </div>
                      </div>




                    </div>
                  </div>
                </div>