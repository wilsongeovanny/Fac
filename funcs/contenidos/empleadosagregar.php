 <?php
 require_once "./controladores/empleadosControlador.php";
 $iEs= new empleadosControlador();
 $cEs=$iEs->datos_empleados_controlador("Conteo",0);

    if (true) { //Son mas de un servicio
        # code...
      
      ?>
      <script type="text/javascript">
        function cargarDep(opcion){
          var data;
          $.ajax({
            url: '../controladores/departamentos.php?departamentocodigo='+opcion.value,
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
            url: '../controladores/cargos.php?cargocodigo='+opcion.value,
            type: 'GET',
            data: data,         
            success: function(data) {
            //alert("aa");
            $("#divCargo").html(data);        
          }
        })            
        }
      </script>

      


      <div class="x_panel">
        <div class="x_title">
          <h2>Agregar nuevo empleado <small></small></h2>
              <!--<ul class="nav navbar-right panel_toolbox">
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
              </ul>-->
              <div class="clearfix"></div>
            </div>
            <div class="x_content"><br>

              <form action="<?php echo SERVERURL; ?>ajax/empleadosAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                <h6 class="StepTitle">Información general</h6><br>
                <div class="row">

                  <div class="col-md-4 col-sm-12  form-group">
                   <label class="label-align">Selecciones Entidad<span class="required">:</span></label>           
                   <div class="">
                     <?php
                                //require_once "./controladores/empleadosControlador.php";
                     $iEs= new empleadosControlador();
                     $cEs=$iEs->datos_empleados_controlador("SelectEmpresa",0);
                     ?>
                     <select class="form-control" name="emp-reg" onchange="cargarDep(this)" placeholder="">
                      <?php
                      while($campos=$cEs->fetch()){
                        ?>
                        <option value="<?php echo $campos['empresacodigo']; ?>">
                          <?php echo $campos['empresanombre']; ?>
                        </option>
                        <?php
                      } 
                      
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4 col-sm-12  form-group">
                 <label class="label-align">Seleccione Departamento<span class="required">:</span></label>           
                 <div id="divDep" class="">
                  <?php
                                //require_once "./controladores/empleadosControlador.php";
                  $iEs= new empleadosControlador();
                  $cEs=$iEs->datos_empleados_controlador("SelectDep",0);
                  ?>
                  <select class="form-control" name="dep-reg" onchange="cargarCargo(this)" placeholder="">
                    <?php
                    while($campos=$cEs->fetch()){
                      ?>
                      <option value="<?php echo $campos['departamentocodigo']; ?>">
                        <?php echo $campos['departamentonombre']; ?>
                      </option>
                      <?php
                    } 
                    
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4 col-sm-12  form-group">
               <label class="label-align">Seleccione Cargo<span class="required">:</span></label>           
               <div id="divCargo" class="">
                <?php
                                //require_once "./controladores/empleadosControlador.php";
                $iEs= new empleadosControlador();
                $cEs=$iEs->datos_empleados_controlador("SelectCargos",0);
                ?>
                <select class="form-control" name="car-reg" placeholder="">
                  <?php
                  while($campos=$cEs->fetch()){
                    ?>
                    <option value="<?php echo $campos['cargocodigo']; ?>">
                      <?php echo $campos['cargonombre']; ?>
                    </option>
                    <?php
                  } 
                  
                  ?>
                </select>
              </div>
            </div>
          </div> <br>




          <!--                   CUENTA                       -->
          <h6 class="StepTitle">Información del empleado</h6><br>
          <div class="row">
            <div class="col-md-4 col-sm-12  form-group">
              <label class="label-align">Cédula<span class="required">:</span></label>
              <input class="form-control" type="number" class='number' name="cedula-reg" data-validate-minmax="10,100">
            </div>
            <div class="col-md-4 col-sm-12  form-group">
              <label class="label-align">Apellidos<span class="required">:</span></label>
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="apellidos-reg" placeholder="INGA LEMA" />
            </div>
            <div class="col-md-4 col-sm-12  form-group">
              <label class="label-align">Nombres<span class="required">:</span></label>
              <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="nombres-reg" placeholder="ALEX MAURICIO" />
            </div>

            <div class="col-md-4 col-sm-12  form-group">
              <label class="label-align">Télefono<span class="required">:</span></label>
              <input class="form-control" type="number" class='text' name="telefono-reg" data-validate-minmax="10,100" >
            </div>
            <div class="col-md-4 col-sm-12  form-group">
              <label class="label-align">Celular<span class="required">:</span></label>
              <input class="form-control" type="number" class='number' name="celular-reg" data-validate-minmax="10,100" >
            </div>
            <div class="col-md-4 col-sm-12  form-group">
              <label class="label-align">Correo<span class="required">:</span></label>
              <input class="form-control" name="correo-reg" placeholder="@gmail-com" class='email'  type="text" />
            </div>

            <div class="col-md-4 col-sm-12  form-group">
              <label class="label-align">Fecha<span class="required">:</span></label>
              <input class="form-control" class='date' type="date" name="fecha-reg" >
            </div>

            <div class="col-md-4 col-sm-12  form-group">
              <label class="label-align">Seleccione Estado<span class="required">:</span></label>           
              <div id="" class="">
                <?php
                            //require_once "./controladores/empleadosControlador.php";
                $iEs= new empleadosControlador();
                $cEs=$iEs->datos_empleados_controlador("Estados",0);
                ?>
                <select class="form-control" name="estado-reg" placeholder="">
                  <?php
                  while($campos=$cEs->fetch()){
                    ?>
                    <option value="<?php echo $campos['estadoempleadocodigo']; ?>">
                      <?php echo $campos['estadoempleadonombre']; ?>
                    </option>
                    <?php
                  } 
                  
                  ?>
                </select>
              </div>
            </div>

          </div><br>

          <div class="ln_solid">
           <div class="form-group">
             <div class="col-md-9 offset-md-5">
               <button type='submit' class="btn btn-primary">Registrar</button>
               <!--<button type='reset' class="btn btn-secondary">Limpiar</button>-->
             </div>
           </div>
         </div>
         <div class="RespuestaAjax"></div>
       </form>

     </div><br>
     <!--  --------------------------------------------  -->



   </div>

 </div>


<?php }else{ ?>
  <div class="alert alert-dismissible alert-primary text-center">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <i class="zmdi zmdi-alert-octagon zmdi-hc-5x"></i>
    <h4>¡Lo sentimos!</h4>
    <p>Lo sentimos ya no se puede registar más empleados</p>
  </div>
  <?php } ?>