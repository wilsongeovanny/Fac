

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Perfil del Adminstrador</h3>
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

    if (!isset($codigo_cuenta)) {
      $verificar='null';
    }else{
      $verificar=mainModel::encryption($codigo_cuenta)    ;
    }
            //echo "$verificar";
    $iEs= new administradorControlador();
    $filesEs=$iEs->datos_administrador_controlador("Unico",$verificar);

    if ($filesEs->rowCount()==1) {
      $campos=$filesEs->fetch();

      ?>

      <div class="row">
        <div class="col-md-12 col-sm-12 ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Información del Perfil <small></small></h2>
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
                    <img class="img-responsive avatar-view" src="<?php echo SERVERURL; ?>cuenta/<?php echo($campos['CUENTAFOTO']); ?>" style="width: 20    0px; height: 200px;" alt="Avatar" title="Change the avatar">
                  </div>
                </div>
                <h3><?php echo $_SESSION['usuario_gad']; ?></h3>

                <ul class="list-unstyled user_data">
                  <li><i class="fa fa-user user-profile-icon"></i> <?php echo $campos['EMPLEADOAPELLIDOS']." ".$campos['EMPLEADONOMBRES']; ?>
                </li>

                <li>
                  <i class="fa fa-user user-profile-icon"></i> <?php echo($campos['DEPARTAMENTONOMBRE']); ?>
                </li>

                <li>
                  <i class="fa fa-user user-profile-icon"></i> <?php echo($campos['CARGONOMBRE']); ?>
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
                  <form action="<?php echo SERVERURL; ?>ajax/empleadosAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                    <input type="text" name="codigo" value="<?php echo mainModel::encryption($campos['EMPLEADOCEDULA']) ?>">
                    <input type="text" name="codigo-up" value="<?php echo $campos['EMPLEADOCEDULA'] ?>">
                    <input class="form-control" type="date" class="date" name="fecha-up" value="<?php echo $campos['EMPLEADOFECHA']; ?>">
                    <input class="form-control" type="text" class="date" name="estemrg-up" value="<?php echo $campos['ESTADOEMPLEADOCODIGO']; ?>">
                    <input class="form-control" type="text" class="date" name="emp-up" value="<?php echo $campos['EMPRESACODIGO']; ?>">
                    <input class="form-control" type="text" class="date" name="dep-reg" value="<?php echo $campos['DEPARTAMENTOCODIGO']; ?>">
                    <input class="form-control" type="text" class="date" name="car-reg" value="<?php echo $campos['CARGOCODIGO']; ?>">

                    
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Cédula <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="cedula-name" name="cedula-up" value="<?php echo($campos['EMPLEADOCEDULA']); ?>" class="form-control ">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Apellidos <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="apellidos-name" name="apellidos-up" value="<?php echo($campos['EMPLEADOAPELLIDOS']); ?>" class="form-control ">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nombres <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="name-name" name="nombres-up" value="<?php echo($campos['EMPLEADONOMBRES']); ?>" class="form-control ">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Teléfono <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="telefono-name" name="telefono-up" value="<?php echo($campos['EMPLEADOTELEFONO']); ?>" class="form-control ">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Celular <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="telefono-name" name="celular-up" value="<?php echo($campos['EMPLEADOCELULAR']); ?>" class="form-control ">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Correo <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="telefono-name" name="correo-up" value="<?php echo($campos['EMPLEADOCORREO']); ?>" class="form-control ">
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
