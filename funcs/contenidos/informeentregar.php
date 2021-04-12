 
<script type="text/javascript">
  function cargar(id){
    console.log(id);
    //alert(id);

    a=id;
    //alert(a);

    //$timico=a;
    var data;
    $.ajax({
      url: '../controladores/visto.php?EMPLEADOCODIGO='+a,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#visto").html(data);        
          }
        })            
  }
</script>
<?php
  require_once "./controladores/manteEntregarControlador.php";

  //$datos=explode("/", $_GET['views']);

  $verificar=$_POST['codmant'];

  $iEs= new manteEntregarControlador();
  $filesEs=$iEs->datos_manteEntregar_controlador("Unico",$verificar);

  if ($filesEs->rowCount()==1) {
    $campos=$filesEs->fetch();
  ?>


                                    <div class="">
                                    <div class="x_panel">
                                      <div class="x_title">
                                        <h2>INFORME TÉCNICO DE ENTREGA <small></small></h2>
                                        <div class="clearfix"></div>
                                      </div>
      <form action="<?php echo SERVERURL; ?>ajax/manteEntregaAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <input name="codqr-reg" type="hidden" value="<?php echo $campos['HARDWAREQR']; ?>"></input>
        <input name="mant-reg" type="hidden" value="<?php echo $campos['MANTENIMIENTOCODIGO']; ?>"></input>

        <!--<h2 class="StepTitle">Informe de ingreso de hardware</h2><br><br>-->
        <div class="row">



          <label class="col-md-12 col-sm-12 form-group" for="message">Datos del usuario</label>
          <div class="col-md-6 col-sm-12  form-group">        
          <div class="">
            <input class="form-control" data-validate-length-range="6" type="text" data-validate-words="2" name="emple-reg" disabled="disabled" placeholder="" value="<?php echo $campos['EMPLEADOAPELLIDOS']." ".$campos['EMPLEADONOMBRES']; ?>" required="required" />
          </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" type="text" data-validate-words="2" name="depar-reg" disabled="disabled" value="<?php echo $campos['DEPARTAMENTONOMBRE']; ?>" required="required" />
          </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="cargo-reg" disabled="disabled" value="<?php echo $campos['CARGONOMBRE']; ?>" required="required" />
          </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="number" name="telefono-reg" value="<?php echo $campos['EMPLEADOCELULAR']; ?>" disabled="disabled" placeholder="TÉLEFONO" required="required" />
          </div>
          </div>


          <label class="col-md-12 col-sm-12 form-group" for="message">Datos del hardware</label>
          <div class="col-md-6 col-sm-12  form-group">        
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="tipo-reg" disabled="disabled" placeholder="" value="<?php echo $campos['TIPOHARDWARENOMBRE']; ?>" required="required" />
          </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="marca-reg" disabled="disabled" value="<?php echo $campos['MARCAHARDWARENOMBRE']; ?>" required="required" />
          </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="modelo-reg" disabled="disabled" value="<?php echo $campos['MODELOHARDWARENOMBRE']; ?>" required="required" />
          </div>
          </div> 
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" data-validate-length-range="6" data-validate-words="2" type="text" name="serie-reg" disabled="disabled" value="<?php echo $campos['HISERIE']; ?>" required="required" />
          </div>
          </div> 


          <label class="col-md-12 col-sm-12 form-group" for="message">Datos de ingreso</label>
          <div class="col-md-6 col-sm-12  form-group">        
          <div class="">
            <input class="form-control" type="time" data-validate-length-range="6" data-validate-words="2" name="hora-reg" disabled="disabled" value="<?php echo $campos['INGRESOHORA']; ?>" placeholder="HORA" required="required" />
          </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" type="date" tdata-validate-length-range="6" data-validate-words="2" name="fecha-reg" disabled="disabled" value="<?php echo $campos['INGRESOFECHA']; ?>" placeholder="FECHA" required="required" />
          </div>
          </div>


          <label class="col-md-12 col-sm-12 form-group" for="message">Datos de entrega</label>
          <div class="col-md-6 col-sm-12  form-group">        
          <div class="">
            <input class="form-control" type="time" data-validate-length-range="6" data-validate-words="2" name="hentrega-reg" placeholder="HORA" required="required" />
          </div>
          </div>
          <div class="col-md-6 col-sm-12  form-group">         
          <div class="">
            <input class="form-control" type="date" tdata-validate-length-range="6" data-validate-words="2" name="fentrega-reg" placeholder="FECHA" required="required" />
          </div>
          </div>


          <!--<div class="col-md-4 col-sm-12 form-group">
            <label>Reporte de usuario</label>
            <input class="form-control" type="time" data-validate-length-range="6" data-validate-words="2" name="hora-reg" placeholder="HORA" required="required" />
          </div>-->

          <div class="col-md-6 col-sm-12 form-group">
            <label>Se entrego equipo por mostrado</label>
            <select class="form-control" name="opcion-reg" placeholder="" required="required">
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
          </div>

          <div class="col-md-6 col-sm-12 form-group">
            <label>Reporte de usuario</label>
            <?php
                require_once "./controladores/manteEntregarControlador.php";
                $iEs= new manteEntregarControlador();
                $cEs=$iEs->datos_manteEntregar_controlador("SelecTipo",0);
            ?>
            <select class="form-control" name="tipo-reg" placeholder="" required="required">
                <?php
                    while($campos=$cEs->fetch()){
                ?>
                        <option value="<?php echo $campos['TIPOMANTECODIGO']; ?>">
                        <?php echo $campos['TIPOMANTENOMBRE']; ?>
                        </option>
                <?php
                    } 
                                                        
                ?>
            </select>
          </div>


          <div class="col-md-12 col-sm-12 form-group">         
          <div class="">
            <label for="message">Reporte de usuario :</label>
            <textarea required="required" class="form-control" name="reporte-reg" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
          </div>
          </div>


          <div class="col-md-12 col-sm-12 form-group">         
          <div class="">
            <label for="message">Descripción del servicio realizado :</label>
            <textarea required="required" class="form-control" name="informe-reg" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
          </div>
          </div><br><br><br><br><br><br><br><br>


  
<!------------------ BUSCAR VISTO BUENO ----------------------------> 
                
                        

                  

           

                  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <h4 class="modal-title" id="bs-example-modal-lg">Empleados de sistemas activos</h4>
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="myModal">
                          <!--<h4>Text in a modal</h4>-->
                                                              <div class="card-box table-responsive">
                                        <!--<p class="text-muted font-13 m-b-30">
                                          The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
                                        </p>-->
                                    <table id="datatable" class="table table-bordered table-bordered" style="width:100%">
                                          <?php 
  require_once "./controladores/empleadosControlador.php";
  $insAdmin= new empleadosControlador();
?>
                                    <?php 
      
        echo $insAdmin->listar_vistoempleados_controlador();
      ?>  
  
                                    </table>
                                      </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>

                      </div>
                    </div>
                  </div>

       
<!------------------ FIN BUSCAR VISTO BUENO ----------------------------> 

          



        </div>


                                  <!-- VUELTA -->
                        <div id="visto">
                          <div class="row">
                            <div style="display: block; margin-left: auto; margin-right: auto;" class="col-md-4 col-sm-12  form-group">
                            <label class="label-align">Visto bueno por: <span class="required">:</span></label>           
                            
                              <input class="form-control" disabled="disabled" placeholder="" required="required">
                                </input>
                            
                            </div>
                          </div>
                        </div>


                        <button style="display: block; margin-left: auto; margin-right: auto;" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-search"></i> Buscar empleado</button>

                        <!-- VUELTA -->

        <div class="ln_solid">
            <div class="form-group">
                <div style="display: block; margin-left: auto; margin-right: auto;">
                    <button type='submit' class="btn btn-primary">Agregar</button>
                    <button type='reset' class="btn btn-secondary">Limpiar</button>
                </div>
            </div>
        </div>


      <div class="RespuestaAjax"></div>
    </form>  
                                    </div>
                                  </div>
<?php }else{ ?>
<div class="alert alert-dismissible alert-primary text-center">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <i class="zmdi zmdi-alert-octagon zmdi-hc-5x"></i>
    <h4>¡Lo sentimos!</h4>
    <p>No podemos mostrar información para el reporte técnico en este momento</p>
</div>
<?php } ?>