
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
      url: '../controladores/empleados.php?EMPLEADOCODIGO='+opcion.value,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#divEmp").html(data);        
          }
        })            
  }
</script>




<div class="x_panel">
  <div class="x_title">
    <h2>Form Input Grid <small>form input </small></h2>
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

    <form>
      <h2 class="StepTitle">Información Administrador</h2><br><br>
      <div class="row">

        <div class="col-md-6 col-sm-12  form-group">
          <label class="label-align">Selecciones Entidad <span class="required">:</span></label>           
          <div class="">
            <?php
            require_once "./controladores/administradorControlador.php";
            $iEs= new administradorControlador();
            $cEs=$iEs->datos_administrador_controlador("SelectEmpresa",0);
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
            require_once "./controladores/administradorControlador.php";
            $iEs= new administradorControlador();
            $cEs=$iEs->datos_administrador_controlador("SelectDep",0);
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
            require_once "./controladores/administradorControlador.php";
            $iEs= new administradorControlador();
            $cEs=$iEs->datos_administrador_controlador("SelectCargos",0);
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
            require_once "./controladores/administradorControlador.php";
            $iEs= new administradorControlador();
            $cEs=$iEs->datos_administrador_controlador("Empleados",0);
            ?>
            <select class="form-control" name="pers-reg" placeholder="" required="required">
              <?php
              while($campos=$cEs->fetch()){
                ?>
                <option value="<?php echo $campos['EMPLEADOCODIGO']; ?>">
                  <?php echo $campos['EMPLEADOAPELLIDOS']." ".$campos['EMPLEADONOMBRES']; ?>
                </option>
                <?php
              } 
              
              ?>
            </select>
          </div>
        </div>

        
        


                <!--<div class="col-md-4 col-sm-12  form-group">
                  <input type="text" placeholder=".col-md-4" class="form-control">
                </div>

                <div class="col-md-4 col-sm-12  form-group">
                  <input type="text" placeholder=".col-md-4" class="form-control">
                </div>

                <div class="col-md-4 col-sm-12  form-group">
                  <input type="text" placeholder=".col-md-4" class="form-control">
                </div>-->





              </div>   <br>




              <!--                   CUENTA                       -->
              <h2 class="StepTitle">Información Cuenta</h2><br><br>

              <div class="row">

                

               <div class="col-md-4 col-sm-12  form-group">
                <label class="label-align">Usuario <span class="required">:</span></label>
                <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="usuario-reg" required="required" />
              </div>

              <div class="col-md-4 col-sm-12  form-group">
                <label class="label-align">Contraseña <span class="required">:</span></label>
                <input class="form-control" type="password" class='number' name="contraseña-reg" data-validate-minmax="10,100" required='required'>
              </div>

              <div class="col-md-4 col-sm-12  form-group">
                <label class="label-align">Repetir Contraseña <span class="required">:</span></label>
                <input class="form-control" type="password" class='number' name="ccontraseña-reg" data-validate-minmax="10,100" required='required'>
              </div>

              <div class="col-md-4 col-sm-12  form-group">
                <label class="label-align">Perfil <span class="required">:</span></label>
                <div class="">

                  <?php
                  require_once "./controladores/administradorControlador.php";
                  $iEs= new administradorControlador();
                  $cEs=$iEs->datos_administrador_controlador("Perfil",0);
                  ?>
                  <select class="form-control" name="pers-reg" placeholder="" required="required">
                    <?php
                    while($campos=$cEs->fetch()){
                      ?>
                      <option value="<?php echo $campos['PERFILCODIGO']; ?>">
                        <?php echo $campos['PERFILNOMBRE']; ?>
                      </option>
                      <?php
                    } 
                    
                    ?>
                  </select>
                </div>
              </div>


              


                <!-- <div class="col-md-4 col-sm-12  form-group">
                  <label class="label-align">Estado <span class="required">:</span></label>
                  <div class="">
                              <div id="gender" class="btn-group" data-toggle="buttons">
                                <label class="btn btn-secondary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-secondary">
                                  <input type="radio" name="gender" value="male" class="join-btn"> &nbsp; Activo &nbsp;
                                </label>
                                <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-secondary">
                                  <input type="radio" name="gender" value="female" class="join-btn"> Desactivo
                                </label>
                              </div>
                            </div>
                          </div>-->


                          <div class="col-md-4 col-sm-12  form-group">
                            <label class="label-align">Estado <span class="required">:</span></label>
                            <div class="">
                              <?php
                              require_once "./controladores/administradorControlador.php";
                              $iEs= new administradorControlador();
                              $cEs=$iEs->datos_administrador_controlador("Estados",0);
                              ?>
                              <select class="form-control" name="estado-reg" placeholder="" required="required">
                                <?php
                                while($campos=$cEs->fetch()){
                                  ?>
                                  <option value="<?php echo $campos['ESTADOCUENTACODIGO']; ?>">
                                    <?php echo $campos['ESTADOCUENTANOMBRE']; ?>
                                  </option>
                                  <?php
                                } 
                                
                                ?>
                              </select>
                            </div>
                          </div>

                          <div class="col-md-4 col-sm-12  form-group">
                           <label class="label-align">Subir foto <span class="required">:</span></label>  <br>
                           <label class="btn btn-primary" data-toggle-class="btn-primary">
                            <input type="file" class="sr-only" id="inputImage" name="foto-reg" accept="image/*"> Seleccionar archivo   <span class="fa fa-upload"></span>
                          </label>
                          
                        </div>

                        <br><br><br><br><br>
                        <div class="col-md-4 col-sm-12 form-group">
                          <label class="label-align">Nivel de cuenta <span class="required">:</label><br><br>
                            <div class="">


                              <div class="radio">
                                <label>
                                  <input type="radio" value="option1" id="optionsRadios1" name="optionsRadios"> <strong>Nivel 1</strong>, Control total del sistema
                                </label>
                              </div>
                              <div class="radio">
                                <label>
                                  <input type="radio" value="option2" id="optionsRadios2" name="optionsRadios"> <strong>Nivel 2</strong>, Permiso para registro y actualización
                                </label>
                              </div>
                              <div class="radio">
                                <label>
                                  <input type="radio" checked="" value="option3" id="optionsRadios3" name="optionsRadios"> <strong>Nivel 3</strong>, Permiso para registro
                                </label>
                              </div>


                            </div>

                          </div>








                        </div>
                        <!--  --------------------------------------------  -->



                        <br>




                        <!--                   PRIVILEGIOS                       -->
                        <h2 class="StepTitle">Asignación de privilegios</h2><br><br>

                        <div class="row">


                          <div class="col-md-4 col-sm-12 form-group">
                            <label class="label-align">Privilegios <span class="required">:</label><br><br>
                              <div class="">




                      <!--<div class="">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value=""> Option one. select more than one options
                          </label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value=""> Option two. select more than one options
                          </label>
                        </div>
                      </div>-->


                      <div class="">

                        <?php
                        require_once "./controladores/administradorControlador.php";
                        $iEs= new administradorControlador();
                        $cEs=$iEs->datos_administrador_controlador("Modulos",0);
                        ?>
                        <?php
                        $contador=0;
                        while($campos=$cEs->fetch()){
                          $contador=$contador+1;
                          ?>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="<?php echo 'pri'.$contador.'-reg'; ?>" value="<?php echo $campos['MODULOCODIGO']; ?>"> <?php echo $campos['MODULONOMBRE']; ?>
                            </label>
                          </div>
                          <?php
                        } 
                        
                        ?>

                      </div>

                      <input type="hidden" name="<?php echo $contador; ?>">





                    </div>









                    <!--<div class="col-md-4 col-sm-12  form-group">
                  <label class="label-align">Estado <span class="required">:</span></label>
                  <div class="">
                              <?php
                                                    require_once "./controladores/administradorControlador.php";
                                                    $iEs= new administradorControlador();
                                                    $cEs=$iEs->datos_administrador_controlador("Modulos",0);
                                                ?>
                                                <select class="form-control" name="estado-reg" placeholder="" required="required">
                                                    <?php
                                                        while($campos=$cEs->fetch()){
                                                    ?>
                                                            <option value="<?php echo $campos['MODMENUCODIGO']; ?>">
                                                            <?php echo $campos['MODULONOMBRE']; ?>
                                                            </option>
                                                    <?php
                                                        } 
                                                        
                                                    ?>
                                                </select>
                            </div>
                          </div>-->
















                        </div>
                        <!--  --------------------------------------------  -->





                      </div>

                      <div class="ln_solid">
                        <div class="form-group">
                          <div class="col-md-9 offset-md-5">
                            <button type='submit' class="btn btn-primary">Agregar</button>
                            <button type='reset' class="btn btn-secondary">Limpiar</button>
                          </div>
                        </div>
                      </div>
                      <div class="RespuestaAjax"></div>
                    </form>
                  </div>








                </div>