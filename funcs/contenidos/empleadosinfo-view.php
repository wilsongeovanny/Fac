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
                    <h2>Sección Empleados <small></small></h2>
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
                  require_once "./controladores/empleadosControlador.php";

                  if (!isset($_POST['codigo'])) {
                    $verificar='null';
                  }else{
                    $verificar=$_POST['codigo'];
                  }

                  $iEs= new empleadosControlador();
                  $filesEs=$iEs->datos_empleados_controlador("Empleado",$verificar);

                  if ($filesEs->rowCount()==1) {
                    $campos=$filesEs->fetch();
                    
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
                        a=opcion;
                        alert(a);
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

                      function auditoria(opcion){
        //console.log(id);
        //alert(id);

        //a=id;
        //alert(a);

        
        
        var tu_variable = $(opcion).val();
        //alert(tu_variable);
        //$timico=a;
        var data;
        $.ajax({
          url: '../controladores/auditoria.php?estado='+tu_variable,
          type: 'GET',
          data: data,         
          success: function(data) {
                //alert("aa");
                $("#auditoria").html(data);        
              }
            })            
      }
    </script>


    <div class="">
      <div class="x_panel">
        <div class="x_title">
          <h2>Editar información del empleado <small></small></h2>
          <div class="clearfix"></div>
        </div>

        <form action="<?php echo SERVERURL; ?>ajax/empleadosAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
          <input type="hidden" name="codigo" value="<?php echo $verificar ?>">
          <input type="hidden" name="codigo-up" value="<?php echo $campos['empleadocodigo']; ?>">
          <input name="respo-reg" type="hidden" value="<?php echo ($_SESSION['empleado_gad']); ?>"></input>
          <!--- CARGO --->
          <h6 class="StepTitle">Información general</h6><br>
          <div class="row">

            <div class="col-md-4 col-sm-12  form-group">
             <label class="label-align">Selecciones Entidad<span class="required">:</span></label>           
             <div class="">
               <?php
               $iEs= new empleadosControlador();
               $cEs=$iEs->datos_empleados_controlador("SelectEmpresa",$campos['cargocodigo']);
               ?>
               <select class="form-control" name="emp-up" onchange="cargarDep(this)" placeholder="">
                <?php
                while($campos1=$cEs->fetch()){
                  ?>
                  <option <?php if ($campos['empresacodigo']==$campos1['empresacodigo']) echo('selected')?> value="<?php echo($campos1['empresacodigo']); ?>"><?php echo($campos1['empresanombre']); ?></option>

                  <?php
                } 
                
                ?>
              </select>
            </div>
          </div>
          <div class="col-md-4 col-sm-12  form-group">
           <label class="label-align">Seleccione Departamento<span class="required">:</span></label>           
           <div id="divDep" class="">
            <select class="form-control" name="dep-reg" onchange="cargarCargo(this)" placeholder="">
              <?php
                                /*require_once "./controladores/materiaControlador.php";
                                $iEs= new materiaControlador();*/ //YA LLAMAMOS A new y requiere
                                $iEs= new empleadosControlador();
                                $cEs=$iEs->datos_empleados_controlador("SelectDep",0);
                                while($campos1=$cEs->fetch()){
                                  ?>
                                  <option <?php if ($campos['departamentocodigo']==$campos1['departamentocodigo']) echo('selected')?> value="<?php echo($campos1['departamentocodigo']); ?>"><?php echo($campos1['departamentonombre']); ?></option>
                                  <?php
                                } 
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4 col-sm-12  form-group">
                           <label class="label-align">Seleccione Cargo<span class="required">:</span></label>           
                           <div id="divCargo" class="">
                            <select class="form-control" name="car-reg" placeholder="">
                              <?php
                                  /*require_once "./controladores/materiaControlador.php";
                                  $iEs= new materiaControlador();*/ //YA LLAMAMOS A new y requiere
                                  $iEs= new empleadosControlador();
                                  $cEs=$iEs->datos_empleados_controlador("SelectCargos",0);
                                  while($campos1=$cEs->fetch()){
                                    ?>
                                    <option <?php if ($campos['cargocodigo']==$campos1['cargocodigo']) echo('selected')?> value="<?php echo($campos1['cargocodigo']); ?>"><?php echo($campos1['cargonombre']); ?></option>
                                    <?php
                                  } 
                                  ?>
                                </select>
                              </div>
                            </div>
                          </div> <br>
                          <!--- CARGO --->



                          <!--- EMPLEADO --->
                          <h6 class="StepTitle">Información del empleado</h6><br>
                          <div class="row">
                            <div class="col-md-4 col-sm-12  form-group">
                              <label class="label-align">Cédula<span class="required">:</span></label>
                              <input class="form-control" type="text" class='number' name="cedula-up" data-validate-minmax="10,100" value="<?php echo trim($campos['empleadocedula']); ?>"/>
                            </div>
                            <div class="col-md-4 col-sm-12  form-group">
                              <label class="label-align">Apellidos<span class="required">:</span></label>
                              <input class="form-control" type="text" class="text" name="apellidos-up" data-validate-length-range="6" data-validate-words="2" placeholder="INGA LEMA" value="<?php echo trim($campos['empleadoapellidos']); ?>"/>
                            </div>
                            <div class="col-md-4 col-sm-12  form-group">
                              <label class="label-align">Nombres<span class="required">:</span></label>
                              <input class="form-control" type="text" class="text" name="nombres-up" data-validate-length-range="6" data-validate-words="2" placeholder="ALEX MAURICIO" value="<?php echo trim($campos['empleadonombres']); ?>"/>
                            </div>

                            <div class="col-md-4 col-sm-12  form-group">
                              <label class="label-align">Télefono<span class="required">:</span></label>
                              <input class="form-control" type="text" class="number" name="telefono-up" data-validate-minmax="10,100" value="<?php echo trim($campos['empleadotelefono']); ?>">
                            </div>
                            <div class="col-md-4 col-sm-12  form-group">
                              <label class="label-align">Celular<span class="required">:</span></label>
                              <input class="form-control" type="text" class="number" name="celular-up" data-validate-minmax="10,100" value="<?php echo trim($campos['empleadocelular']); ?>"/>
                            </div>
                            <div class="col-md-4 col-sm-12  form-group">
                              <label class="label-align">Correo<span class="required">:</span></label>
                              <input class="form-control" type="email" class="email" name="correo-up" placeholder="@gmail-com" value="<?php echo trim($campos['empleadocorreo']); ?>"/>
                            </div>

                            <div class="col-md-4 col-sm-12  form-group">
                              <label class="label-align">Fecha<span class="required">:</span></label>
                              <input class="form-control" type="date" class="date" name="fecha-up" value="<?php echo $campos['empleadofecha']; ?>">
                            </div>
                            
                            


                            <div class="col-md-4 col-sm-12  form-group">
                              <label class="label-align">Seleccione Estado<span class="required">:</span></label>           
                              <div id="" class="">
                                <select class="form-control" name="nulo-up" onchange="auditoria(this)" placeholder="">
                                  <?php
                                  $zinc=trim($campos['empleadocedula']);
                              /*require_once "./controladores/materiaControlador.php";
                              $iEs= new materiaControlador();*/ //YA LLAMAMOS A new y requiere
                              $iEs= new empleadosControlador();
                              $cEs=$iEs->datos_empleados_controlador("Estados",0);
                              while($campos1=$cEs->fetch()){
                                ?>
                                <option <?php if (trim($campos['estadoempleadocodigo'])==trim($campos1['estadoempleadocodigo'])) echo('selected')?> value="<?php echo trim($campos1['estadoempleadocodigo'])."&empleadocedula=".$zinc ?>"><?php echo(trim($campos1['estadoempleadonombre'])); ?></option>
                                <?php
                              } 
                              ?>
                            </select>
                          </div>
                        </div>


                        <select name="estemrg-up" type="hidden" style="visibility:hidden">
                          <?php
                          $iEs= new empleadosControlador();
                          $cEs=$iEs->datos_empleados_controlador("Estados",0);
                          while($campos1=$cEs->fetch()){
                            ?>
                            <option <?php if ($campos['estadoempleadocodigo']==$campos1['estadoempleadocodigo']) echo('selected')?> value="<?php echo $campos1['estadoempleadocodigo'];?>"><?php echo($campos1['estadoempleadonombre']); ?></option>
                            <?php
                          } 
                          ?>
                        </select>


                     <!-- <div class="col-md-4 col-sm-12  form-group">
                       <label class="label-align">Generar auditoria de hardware<span class="required">:</span></label>  <br>
                          
                            <button type="button" onclick="auditoria('<?php echo $campos['empleadocedula']?>')" class="btn btn-primary">Generar Auditoria</button>
                            
                       
                          </div>--><br>
                        </div><br>

                        


                        <!---- DIV PARA MORSTRAR AUDITORIA -->
                        <div class="row" id="auditoria">
                          
                          
                         
                        </div>
                        <!---- DIV PARA MORSTRAR AUDITORIA -->



                        

                        <!--- EMPLEADO --->

                        

                        <div class="ln_solid">
                         <div class="form-group">
                           <div class="col-md-9 offset-md-5">
                             <button type='submit' class="btn btn-primary">Editar</button>
                             <!--<a href="<?php echo SERVERURL; ?>/empleados/" class="btn btn-secondary">Regresar</a>-->
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
                <p>No podemos mostrar información del empleado en este momento</p>
              </div>
            <?php } ?>





          </div>
        </div>




      </div>
    </div>
  </div>