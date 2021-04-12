

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Cuenta del Adminstrador</h3>
      </div>

      <div class="title_right">
        <div class="col-md-5 col-sm-5  form-group pull-right top_search">
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



            <?php
            require_once "./controladores/administradorControlador.php";
            require_once './core/cambio.php';

            if (!isset($codigo_cuenta)) {
              $verificar='null';
            }else{
              $verificar=($codigo_cuenta)    ;
            }
            //echo "$verificar";
            $iEs= new administradorControlador();
            $filesEs=$iEs->datos_administrador_controlador("Unico",$verificar);

            if ($filesEs->rowCount()==1) {
              $campos=$filesEs->fetch();
              $contrasenia1=trim($campos['cuentaclave']);
              $contrasenia=cambio::decryption($contrasenia1);
              ?>

              <div class="row">
                <div class="col-md-12 col-sm-12 ">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Información del Administrador <small></small></h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                          </div>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div class="col-md-3 col-sm-3  profile_left">
                        <div class="profile_img">
                          <div id="crop-avatar">
                            <!-- Current avatar -->
                            <img class="img-responsive avatar-view" src="<?php echo SERVERURL; ?>cuenta/<?php echo($campos['cuentafoto']); ?>" style="width: 20    0px; height: 200px;" alt="Avatar" title="Change the avatar">
                          </div>
                        </div>
                        <h3><?php echo $_SESSION['usuario_gad']; ?></h3>

                        <ul class="list-unstyled user_data">
                          <li><i class="fa fa-user user-profile-icon"></i> <?php echo $campos['empleadoapellidos']." ".$campos['empleadonombres']; ?>
                        </li>

                        <li>
                          <i class="fa fa-user user-profile-icon"></i> <?php echo($campos['departamentonombre']); ?>
                        </li>

                        <li>
                          <i class="fa fa-user user-profile-icon"></i> <?php echo($campos['cargonombre']); ?>
                        </li>
                      </ul>

                      
                      <br />

                      <!-- start skills -->


                      <!-- end of skills -->

                    </div>















                    <div class="row">
                      <div class="col-md-12 col-sm-12 ">
                        
                        
                        <div class="x_content">
                          <br />
                          <form action="<?php echo SERVERURL; ?>ajax/cuentaAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="codigo" value="<?php echo $verificar ?>">
                            <input type="hidden" name="codigo-up" value="<?php echo $campos['cuentacodigo']; ?>">
                            <input type="hidden" name="estado-up" value="<?php echo $campos['estadocuentacodigo']; ?>">
                            <input type="hidden" name="roles-up" value="<?php echo $campos['codigoroles']; ?>">
                            <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Usuario <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                <input type="text" id="first-name" name="usuario-up" value="<?php echo trim($campos['cuentausuario']); ?>" class="form-control ">
                              </div>
                            </div>
                            <div class="item form-group">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Foto <span class="required">*</span>
                              </label>
                              <div class="col-md-6 col-sm-6 ">
                                <input type="file" id="last-name" name="foto-up" class="form-control">
                              </div>
                            </div>
                            <div class="item form-group">
                              <label for="clave-name" class="col-form-label col-md-3 col-sm-3 label-align">Contraseña </label>
                              <div class="col-md-6 col-sm-6 ">
                                <input id="clave-name" class="form-control" type="password" name="clave-up" value="<?php echo $contrasenia; ?>">
                              </div>
                            </div>
                            <div class="item form-group">
                              <label for="clave1-name" class="col-form-label col-md-3 col-sm-3 label-align">Confirmar contraseña </label>
                              <div class="col-md-6 col-sm-6 ">
                                <input id="clave1-name" class="form-control" type="password" name="clave1-up" value="<?php echo $contrasenia; ?>">
                              </div>
                            </div>

                            

                            <div class="ln_solid"></div>
                            <div class="item form-group">
                              <div class="col-md-6 col-sm-6 offset-md-3">
                                <button class="btn btn-primary" type="submit">Editar</button>
                                                <!--<button class="btn btn-primary" type="reset">Reset</button>
                                                  <button type="submit" class="btn btn-success">Submit</button>-->
                                                </div>
                                              </div>
                                              <div class="RespuestaAjax"></div>
                                            </form>
                                          </div>
                                          
                                        </div>
                                      </div>




















                                    </div>
                                  <?php }else{ ?>
                                    <div class="alert alert-dismissible alert-warning text-center">
                                      <button type="button" class="close" data-dismiss="alert">×</button>
                                      <i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i>
                                      <h4>¡Lo sentimos!</h4>
                                      <p>No podemos mostrar información de la cuenta en este momento</p>
                                    </div>
                                  <?php } ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- /page content -->
