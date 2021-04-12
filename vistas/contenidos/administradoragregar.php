  <script type="text/javascript">
    function aminpag(id){

    //alert(id);

    a=id;
    //alert(a);

    //$timico=a;
    var data;
    $.ajax({
      url: '../controladores/admin.php?empleadocedula='+a,
      type: 'GET',
      data: data,         
      success: function(data) {
            //alert("aa");
            $("#admin").html(data);        
          }
        })            
  }
</script>



<div class="x_panel">
  <div class="x_title">
    <h2>Agregar nuevo administrar <small> </small></h2>
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

   <form action="<?php echo SERVERURL; ?>ajax/cuentaAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
    <h2 class="StepTitle">Información Administrador</h2><br>
    <button style="width: 180px; height: 40px" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-search"></i> Buscar empleado</button><br><br>



  <input type="hidden" name="admin" value="admin">
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title" id="bs-example-modal-lg">Empleados del sistema activos</h4>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="myModal">

          <div class="card-box table-responsive">
            <table id="datatable" class="table table-bordered table-bordered" style="width:100%">
              <?php 
              require_once "./controladores/empleadosControlador.php";
              $insAdmin= new empleadosControlador();
              ?>
              <?php 

              echo $insAdmin->listar_adminpag_controlador();
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


  <div id="admin">
    <div class="row">
      <div class="col-md-6 col-sm-12  form-group">
        <label class="label-align">Entidad <span class="required">:</span></label>           
        <div class="">
          <input class="form-control" disabled="disabled" placeholder="">
        </input>
      </div>
    </div>

    <div class="col-md-6 col-sm-12  form-group">
      <label class="label-align">Departamento <span class="required">:</span></label>           
      <input class="form-control" disabled="disabled" placeholder="">
    </input>
  </div>
  <div class="col-md-4 col-sm-12  form-group">
    <label class="label-align">Cargo <span class="required">:</span></label>           
    <div class="">
      <input class="form-control" disabled="disabled" placeholder="">
    </input>
  </div>
</div>
<div class="col-md-4 col-sm-12  form-group">
  <label class="label-align">Empleado <span class="required">:</span></label>           
  <div class="">
    <input class="form-control" disabled="disabled" placeholder="">
  </input>
</div>
</div>
<div class="col-md-4 col-sm-12  form-group">
  <label class="label-align">Empleado <span class="required">:</span></label>           
  <div class="">
    <input class="form-control" disabled="disabled" placeholder="">
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
    <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="usuario-reg" />
  </div>

  <div class="col-md-4 col-sm-12  form-group">
    <label class="label-align">Contraseña <span class="required">:</span></label>
    <input class="form-control" type="password" class='number' name="clave-reg" data-validate-minmax="10,100">
  </div>

  <div class="col-md-4 col-sm-12  form-group">
    <label class="label-align">Repetir Contraseña <span class="required">:</span></label>
    <input class="form-control" type="password" class='number' name="clave1-reg" data-validate-minmax="10,100">
  </div>

  <div class="col-md-4 col-sm-12  form-group">
    <label class="label-align">Seleccionar Rol <span class="required">:</span></label>
    <div class="">

      <?php
      require_once "./controladores/administradorControlador.php";
      $iEs= new administradorControlador();
      $cEs=$iEs->datos_administrador_controlador("Rol",0);
      ?>
      <select class="form-control" name="roles-reg" placeholder="">
        <?php
        while($campos=$cEs->fetch()){
          ?>
          <option value="<?php echo $campos['codigoroles']; ?>">
            <?php echo $campos['rolesnombre']; ?>
          </option>
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
      <select class="form-control" name="estado-reg" placeholder="">
        <?php
        while($campos=$cEs->fetch()){
          ?>
          <option value="<?php echo $campos['estadocuentacodigo']; ?>">
            <?php echo $campos['estadocuentanombre']; ?>
          </option>
          <?php
        } 

        ?>
      </select>
    </div>
  </div>

  <div class="col-md-4 col-sm-12  form-group">
   <label class="label-align">Subir foto <span class="required">:</span></label>  <br>
   <input class="form-control" type="file" data-validate-length-range="6" data-validate-words="2" name="foto-reg" />
   <!--<label class="btn btn-primary" data-toggle-class="btn-primary">
    <input type="file" class="sr-only" id="inputImage" name="foto-reg" accept="image/*"> Seleccionar archivo   <span class="fa fa-upload"></span>
  </label>-->


</div>

<br><br><br><br><br>
<!--<div class="col-md-4 col-sm-12 form-group">
  <label class="label-align">Nivel de cuenta <span class="required">:</label><br><br>
    <div class="">


      <div class="radio">
        <label>
          <input type="radio" value="1" id="optionsRadios1" name="perfil-reg"> <strong>Nivel 1</strong>, Control total del sistema
        </label>
      </div>
      <div class="radio">
        <label>
          <input type="radio" checked="" value="2" id="optionsRadios2" name="perfil-reg"> <strong>Nivel 2</strong>, Permiso para registro y actualización
        </label>
      </div>-->
      <!--<div class="radio">
        <label>
          <input type="radio" checked="" value="option3" id="optionsRadios3" name="optionsRadios"> <strong>Nivel 3</strong>, Permiso para registro
        </label>
      </div>-->


    <!--</div>

  </div>-->








</div>
<!--  --------------------------------------------  -->



<br>




<!--                   PRIVILEGIOS                       -->
<!--<h2 class="StepTitle">Asignación de privilegios</h2><br><br>

<div class="row">


  <div class="col-md-4 col-sm-12 form-group">
    <label class="label-align">Privilegios <span class="required">:</label><br><br>
      <div class="">



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
                <input type="checkbox" name="<?php echo 'pri'.$contador.'-reg'; ?>" value="<?php echo $campos['modulocodigo']; ?>"> <?php echo $campos['modulonombre']; ?>
              </label>
            </div>
            <?php
          } 

          ?>

        </div>

        <input type="hidden" name="<?php echo $contador; ?>">





      </div>




    </div> falta con arriba-->
    <!--  --------------------------------------------  -->





    <!--   con arriba--</div>-->

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
</div>

</div>