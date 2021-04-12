<script type="text/javascript">
  function privilegios(){

    var btns_checked = $(".flat");
    var cadena ="";
    btns_checked.each(function()
    {
      if( $(this).prop('checked') )
      {
        var id_btn_check = $(this).attr("id");
        alert(id_btn_check);
        cadena+=id_btn_check+"&&";
      }
    }); 

    if(cadena!="")
    {
      cadena=cadena.substring(0,cadena.length-2); 
      var parametros={
        "_token":"procesar_pagos",
        "cadena":cadena
      };

      $.ajax({
        type:'POST',
        url:'../controladores/privilegios.php',
        data:parametros,

        success:function(data){

          $("#emp").html(data);        

        }
      });        
    }else{
      alert("Seleccione por los menos una pago ha procesar porfavor")
    }


  }
</script>


<div class="">
  <div class="x_panel">
    <div class="x_title">
      <h2>Agregar nuevo Rol de administrador<small></small></h2>
      <div class="clearfix"></div>
    </div>
    <form action="<?php echo SERVERURL; ?>ajax/rolAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
      <!--<span class="section">Agregar nuevo empleado</span>-->

      <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre <span class="required">:</span></label>
        <div class="col-md-6 col-sm-6">
          <input class="form-control" data-validate-length-range="6" name="nombre-reg" data-validate-words="2" placeholder="" />
        </div>
      </div>

      <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">Descripción <span class="required">:</span></label>
        <div class="col-md-6 col-sm-6">
          <input class="form-control" data-validate-length-range="6" name="descripcion-reg" data-validate-words="2" placeholder="" />
        </div>
      </div>

      <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">Estado <span class="required">:</span></label>
        <div class="col-md-6 col-sm-6">
          <select class="form-control" name="opcion-reg" placeholder="" required="required">
            <optgroup label="Estados del rol"> 
              <option value="ACTIVO">ACTIVO</option>
              <option value="DESACTIVO">DESACTIVO</option>
            </optgroup>

          </select>
        </div>
      </div>

      <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">Modulos <span class="required">:</span></label>
        <div class="col-md-6 col-sm-6">


          <?php
          require_once './core/forced.php';

          $consulta="SELECT * FROM modulo";

          $conexion = forced::conectar();

          $datos = $conexion->query($consulta);
          $datos= $datos->fetchAll();
          ?>



          <div class="x_content">

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th><center>#<center></th>
                    <th><center>Permisos</center></th>
                    <th><center>Nombres</center></th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  $contador=0;
                  $numerosencadena = "";
                  foreach ($datos as $rows) {
                    $contador=$contador+1;

                    //$zinc=forced::encryption($rows['modulocodigo']);
                    $zinc=$rows['modulocodigo'];
                    
                    ?>

                    <tr>
                      <th scope="row"><center><?php echo $contador ?></center></th>
                      <td align="center" class="flat"><input type="checkbox" value="<?php echo trim($zinc) ?>" onclick="elegirPais(this)"></td>
                      <!--<td align="center"><input type="checkbox" onclick="elegirPais(this)" value="<?php echo($zinc) ?>" class="flat"></td>-->
                      <td align="center"><p><?php echo $rows['modulonombre'] ?></p></td>
                      
                      <?php 
                      $numerosencadena .=$zinc."/";
                    } ?>
                  </tr>
                  <!--<input type="hidden" class="flat" name="contador-reg" value="<?php echo($numerosencadena) ?>">-->
                  <input type="hidden" class="flat" name="contador-reg" value="<?php echo($numerosencadena) ?>">

                  <input type="hidden" id="privilegios" name="privilegios">
                  <!-- NO OCULTO <p>Has visitado <span type="hidden" id="paises" Style="Display:none;"></span></p> -->
                  <span type="hidden" id="paises" Style="Display:none;"></span>
                </tbody>
              </table>

            </div>
          </div>
        </div>





        <div id="emp">
          <div class="row">
          </div> 
        </div>




        <div class="ln_solid">
          <div class="form-group">
            <div class="col-md-6 offset-md-3">
              <!--<button onclick="privilegios();" type='submit' class="btn btn-primary">Registrar</button>-->
              <button type='submit' class="btn btn-primary">Registrar</button>
              <!--<button type='reset' class="btn btn-success">Limpiar</button>-->
            </div>
          </div>
        </div>
        <div class="RespuestaAjax"></div>
      </form>
    </div>
  </div>





<!--<p><input type="checkbox" value="Mexico" onclick="elegirPais(this)"> Mexico</p>
<p><input type="checkbox" value="Brasil" onclick="elegirPais(this)"> Brasil</p>
<p><input type="checkbox" value="Africa" onclick="elegirPais(this)"> Africa</p>

<p>Has visitado <span id="paises"></span></p>-->