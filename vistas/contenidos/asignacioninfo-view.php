 
<script type="text/javascript">
  function cargar(id){
    console.log(id);
    //alert(id);

    a=id;
    //alert(a);

    $timico=a;
    var data;
    $.ajax({
      url: '../controladores/emp.php?empleadocedula='+a,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#emp").html(data);        
          }
        })            
  }
</script>

<?php
require_once "./controladores/asignacionControlador.php";
if (!isset($_POST['codigo'])) {
  $verificar='null';
}else{
  $verificar=$_POST['codigo'];
}


$iEs= new asignacionControlador();
$filesEs=$iEs->datos_asignacion_controlador("Tipo",$verificar);

if ($filesEs->rowCount()==1) {
  $campos=$filesEs->fetch();


  
  ?>
  
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
              <h2>Información del Hardware  <small>Sin asignar</small></h2>
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
                <input type="hidden" name="codigo-up" value="<?php echo $campos['hiserie']; ?>">
                <!--<input type="text" name="informe-up" value="<?php echo $campos['icodigo']; ?>">-->

                
                <h2 class="StepTitle">Información del hardware a asignar</h2><br>
                <div class="row">
                  <div class="col-md-4 col-sm-12  form-group">
                    <label class="col-md-4 col-sm-12 form-group" for="message">Cod.Inventario</label>
                    <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="serie-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['hiserie']; ?>" disabled="disabled"/>
                  </div>
                  <div class="col-md-4 col-sm-12  form-group">
                    <label class="col-md-4 col-sm-12 form-group" for="message"># de Serie</label>
                    <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="serie-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['serireexterno']; ?>" disabled="disabled"/>
                  </div>
                  <div class="col-md-4 col-sm-12  form-group">
                    <label class="col-md-4 col-sm-12 form-group" for="message">Tipo</label>          
                    <div class="">
                      <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="tipo-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['tipohardwarenombre']; ?>" disabled="disabled"/>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-12  form-group">
                    <label class="col-md-3 col-sm-12 form-group" for="message">Marca</label>          
                    <div class="">
                      <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="marca-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['marcahardwarenombre']; ?>" disabled="disabled"/>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-12  form-group">  
                    <label class="col-md-3 col-sm-12 form-group" for="message">Modelo</label>        
                    <div class="">
                      <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="modelo-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['modelohardwarenombre']; ?>" disabled="disabled"/>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-12  form-group">
                    <label class="col-md-3 col-sm-12 form-group" for="message">Color</label>          
                    <div class="">
                      <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="color-up" placeholder="INGRESE EL # DE SERIE" required="required" value="<?php echo $campos['colorhardwarenombre']; ?>" disabled="disabled"/>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-12  form-group">
                    <label class="col-md-3 col-sm-12 form-group" for="message">Cable</label>
                    <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="cable-up" placeholder="CABLES" required="required" value="<?php echo $campos['hicables']; ?>" disabled="disabled"/>
                  </div>
                  <div class="col-md-12 col-sm-12  form-group">
                    <label class="col-md-12 col-sm-12 form-group" for="message">Observaciones</label>
                    <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="obs-up" placeholder="OBSERVACIONES" required="required" value="<?php echo $campos['hiobservaciones']; ?>" disabled="disabled"/>
                  </div>
                  <div class="col-md-12 col-sm-16 form-group">  
                    <label class="col-md-4 col-sm-12 form-group" for="message">Caracteristicas</label>       
                    <div class="">
                      <textarea required="required" class="form-control" name="carac-up" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" placeholder="CARACTERISTICAS" disabled="disabled"><?php echo $campos['hicaracteristicas']; ?></textarea>
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
                          <?php
                          require_once './core/forced.php';
                          $inv=$campos['hiserie'];
                          $ser=$campos['serireexterno'];

                          $consulta="SELECT *,T3.empleadocodigo FROM cargo as T1, estado_empleado as T2, empleados as T3, departemento as T4 WHERE T1.cargocodigo=T3.cargocodigo AND T2.estadoempleadocodigo=T3.estadoempleadocodigo AND T2.estadoempleadonombre='ACTIVO' AND T4.departamentocodigo=T1.departamentocodigo ORDER BY empleadonombres";

                          $conexion = forced::conectar();

                          $datos = $conexion->query($consulta);
                          $datos= $datos->fetchAll();
                          ?>

                          <table id="datatable" class="table table-bordered table-bordered" style="width:100%">
                            <thead>
                              <tr>
                                <th>CÉDULA</th>
                                <th>NOMBRES</th>
                                <th>APELLIDOS</th>
                                <th>DEPARTAMENTO</th>
                                <th>CARGO</th>
                                <th>ACCIÓN</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              foreach ($datos as $rows) {
                                  //$zinc=$rows['empleadocodigo'];
                                ?>
                                <tr>
                                  <td><?php echo $rows['empleadocedula']; ?></td>
                                  <td><?php echo $rows['empleadonombres']; ?></td>
                                  <td><?php echo $rows['empleadoapellidos']; ?></td>
                                  <td><?php echo $rows['departamentonombre']; ?></td>
                                  <td><?php echo $rows['cargonombre']; ?></td>
                                  <td>
                                    <a style="color: #ffffff;" class="btn btn-primary" 
                                    onclick="cargar('<?php echo $rows['empleadocedula']."&inv=".$inv."&serie=".$ser ?>')"></i> Seleccionar
                                  </a>
                                </td>
                              <?php } ?>

                            </tr>
                          </tbody>
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
                    <label class="label-align">Entidad <span class="required">:</span></label>           
                    <div class="">
                      <input class="form-control" disabled="disabled" placeholder="" required="required">
                    </input>
                  </div>
                </div>

                <div class="col-md-6 col-sm-12  form-group">
                  <label class="label-align">Departamento <span class="required">:</span></label>           
                  <input class="form-control" disabled="disabled" placeholder="" required="required">
                </input>
              </div>
              <div class="col-md-6 col-sm-12  form-group">
                <label class="label-align">Cargo <span class="required">:</span></label>           
                <div class="">
                  <input class="form-control" disabled="disabled" placeholder="" required="required">
                </input>
              </div>
            </div>
            <div class="col-md-6 col-sm-12  form-group">
              <label class="label-align">Empleado <span class="required">:</span></label>           
              <div class="">
                <input class="form-control" disabled="disabled" placeholder="" required="required">
              </input>
            </div>
          </div>     
        </div>

        <!--                  QR                      -->
        <h2 class="StepTitle">Generar código QR al hardware</h2><br><br>
        <div class="row">
          <div class="col-md-12 col-sm-12 form-group">
            <button style="width:230px; height:230px; display: block; margin-left: auto; margin-right: auto;" type="button" class="btn btn-default btn-lg"><strong>CÓDIGO QR</strong></button>
            
          </div>
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