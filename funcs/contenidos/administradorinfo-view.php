        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Procesos de Control de Hardware</h3>
              </div>


            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Sección Administrador <small></small></h2>
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
                  require_once "./controladores/administradorControlador.php";
                  require_once './core/cambio.php';
                  if (!isset($_POST['codigo'])) {
                    $verificar='null';
                  }else{
                    $verificar=$_POST['codigo'];
                  }

                  $iEs= new administradorControlador();
                  $filesEs=$iEs->datos_administrador_controlador("Unico",$verificar);

                  if ($filesEs->rowCount()==1) {
                    $campos=$filesEs->fetch();
                    $contrasenia1=trim($campos['cuentaclave']);
                    $contrasenia=cambio::decryption($contrasenia1);
                    ?>



                    <div class="">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Editar información de la cuenta <small></small></h2>
                          <div class="clearfix"></div>
                        </div>

                        <form action="<?php echo SERVERURL; ?>ajax/cuentaAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                          <input type="hidden" name="codigo" value="<?php echo $verificar ?>">
                          <input type="hidden" name="codigo-up" value="<?php echo $campos['cuentacodigo']; ?>">
                          <!--- CARGO --->
                          <h6 class="StepTitle">Información general</h6><br>
                          <input type="hidden" name="admin" value="admin">



                          <div id="admin">
                            <div class="row">
                              <div class="col-md-6 col-sm-12  form-group">
                                <label class="label-align">Entidad <span class="required">:</span></label>           
                                <div class="">
                                  <input class="form-control" disabled="disabled" value="<?php echo($campos['empresanombre']); ?>" placeholder="">
                                </input>
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-12  form-group">
                              <label class="label-align">Departamento <span class="required">:</span></label>           
                              <input class="form-control" disabled="disabled" value="<?php echo($campos['departamentonombre']); ?>" placeholder="">
                            </input>
                          </div>
                          <div class="col-md-4 col-sm-12  form-group">
                            <label class="label-align">Cargo <span class="required">:</span></label>           
                            <div class="">
                              <input class="form-control" disabled="disabled" value="<?php echo($campos['cargonombre']); ?>" placeholder="">
                            </input>
                          </div>
                        </div>
                        <div class="col-md-4 col-sm-12  form-group">
                          <label class="label-align">Empleado <span class="required">:</span></label>           
                          <div class="">
                            <input class="form-control" disabled="disabled" value="<?php echo trim($campos['empleadoapellidos'])." ".trim($campos['empleadonombres']); ?>" placeholder="">
                          </input>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-12  form-group">
                        <label class="label-align">Correo <span class="required">:</span></label>           
                        <div class="">
                          <input class="form-control" disabled="disabled" value="<?php echo trim($campos['empleadocorreo']); ?>" placeholder="">
                        </input>
                      </div>
                    </div>     
                  </div>



                </div>   <br>




                <!--                   CUENTA                       -->
                <h2 class="StepTitle">Información Cuenta</h2><br>

                <div class="row">




                  <div class="col-md-4 col-sm-12  form-group">
                    <label class="label-align">Usuario <span class="required">:</span></label>
                    <input class="form-control" data-validate-length-range="6" data-validate-words="2" value="<?php echo trim($campos['cuentausuario']); ?>" name="usuario-up" />
                  </div>

                  <div class="col-md-4 col-sm-12  form-group">
                    <label class="label-align">Contraseña <span class="required">:</span></label>
                    <input class="form-control" type="password" class='number' name="clave-up" value="<?php echo trim($contrasenia); ?>" data-validate-minmax="10,100">
                  </div>

                  <div class="col-md-4 col-sm-12  form-group">
                    <label class="label-align">Repetir Contraseña <span class="required">:</span></label>
                    <input class="form-control" type="password" class='number' name="clave1-up" value="<?php echo trim($contrasenia); ?>" data-validate-minmax="10,100">
                  </div>

                  <div class="col-md-4 col-sm-12  form-group">
                    <label class="label-align">Seleccionar Rol <span class="required">:</span></label>
                    <div class="">

                      <?php
                      require_once "./controladores/administradorControlador.php";
                      $iEs= new administradorControlador();
                      $cEs=$iEs->datos_administrador_controlador("Rol",0);
                      ?>
                      <select class="form-control" name="roles-up" onchange="cargarDep(this)" placeholder="">
                        <?php
                        while($campos1=$cEs->fetch()){
                          ?>
                          <option <?php if ($campos['codigoroles']==$campos1['codigoroles']) echo('selected')?> value="<?php echo($campos1['codigoroles']); ?>"><?php echo($campos1['rolesnombre']); ?></option>

                          <?php
                        } 

                        ?>
                      </select>                      
                    </div>
                  </div>




                  <div class="col-md-4 col-sm-12  form-group">
                    <label class="label-align">Estado <span class="required">:</span></label>
                    <div class="">
                      <?php
                      require_once "./controladores/administradorControlador.php";
                      $iEs= new administradorControlador();
                      $cEs=$iEs->datos_administrador_controlador("Estados",0);
                      ?>
                      <select class="form-control" name="estado-up" placeholder="">
                        <?php
                        while($campos1=$cEs->fetch()){
                          ?>
                          <option <?php if ($campos['estadocuentacodigo']==$campos1['estadocuentacodigo']) echo('selected')?> value="<?php echo($campos1['estadocuentacodigo']); ?>"><?php echo($campos1['estadocuentanombre']); ?></option>
                          <?php
                        } 

                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4 col-sm-12  form-group">
                   <label class="label-align">Subir foto <span class="required">:</span></label>  <br>
                   <input class="form-control" type="file" data-validate-length-range="6" data-validate-words="2" name="foto-up" />
   <!--<label class="btn btn-primary" data-toggle-class="btn-primary">
    <input type="file" class="sr-only" id="inputImage" name="foto-reg" accept="image/*"> Seleccionar archivo   <span class="fa fa-upload"></span>
  </label>-->
</div>
<br><br><br><br><br><br>
<div class="col-md-12 col-sm-12  form-group">
  <center>
    <img style="" src="<?php echo SERVERURL.'cuenta/'.$campos['cuentafoto'] ?>" class="img-circle" width="150" height="150"><br><br>
    <a title="Descargar Foto" href="<?php echo SERVERURL.'cuenta/'.$campos['cuentafoto'] ?>" download="<?php echo $campos['cuentafoto']; ?>" style="color: blue; font-size:18px;"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
  </center>
</div>




<!--<div class="col-md-4 col-sm-12 form-group">
  <label class="label-align">Nivel de cuenta <span class="required">:</label><br><br>
    <div class="">


      <div class="radio">
        <label>
          <input type="radio" value="1" id="optionsRadios1" name="perfil-up"> <strong>Nivel 1</strong>, Control total del sistema
        </label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" checked="" value="2" id="optionsRadios2" name="perfil-up"> <strong>Nivel 2</strong>, Permiso para registro y actualización
        </label>
      </div>



    </div>

  </div>-->








</div>
<!--  --------------------------------------------  -->



<br>





<div class="ln_solid">
 <div class="form-group">
   <div class="col-md-9 offset-md-5">
     <button type='submit' class="btn btn-primary">Editar</button>
     <a href="<?php echo SERVERURL; ?>/administrador/" class="btn btn-secondary">Regresar</a>
   </div>
 </div>
</div>
<div class="RespuestaAjax"></div>
</div>
</form>
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