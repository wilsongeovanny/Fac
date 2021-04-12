<script type="text/javascript">
  function privilegios1(){

    var btns_checked = $(".ch");
    var cadena ="";
    btns_checked.each(function()
    {
      if( $(this).prop('checked') )
      {
        var id_btn_check = $(this).attr("id");
        //alert(id_btn_check);
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
            <h2>Sección Roles de Administrador<small></small></h2>
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
          <!---------------- --------------------> 


          <?php
          require_once "./controladores/rolesControlador.php";

          if (!isset($_POST['codigo'])) {
            $verificar='null';
          }else{
            $verificar=$_POST['codigo'];
          }

          $iEs= new rolesControlador();
          $filesEs=$iEs->datos_roles_controlador("Unico",$verificar);

          if ($filesEs->rowCount()==1) {
            $campos=$filesEs->fetch();
            $cod=$campos['codigoroles'];

            ?>


            <div class="">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Editar el Rol de administrador<small></small></h2>
                  <div class="clearfix"></div>
                </div>
                <form action="<?php echo SERVERURL; ?>ajax/rolAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                  <!--<span class="section">Agregar nuevo empleado</span>-->
                  <input type="hidden" name="codigo" value="<?php echo $verificar ?>">
                  <input type="hidden" name="codigo-up" value="<?php echo $campos['codigoroles']; ?>">

                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre <span class="required">:</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control" data-validate-length-range="6" name="nombre-up" data-validate-words="2" placeholder="" value="<?php echo trim($campos['rolesnombre']); ?>" />
                    </div>
                  </div>

                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Descripción <span class="required">:</span></label>
                    <div class="col-md-6 col-sm-6">
                      <input class="form-control" data-validate-length-range="6" name="descripcion-up" data-validate-words="2" placeholder="" value="<?php echo trim($campos['rolesdescripcion']); ?>"/>
                    </div>
                  </div>

                  <div class="field item form-group">
                    <label class="col-form-label col-md-3 col-sm-3  label-align">Estado <span class="required">:</span></label>
                    <div class="col-md-6 col-sm-6">
                      <?php
                      if (trim($campos['rolesestado'])=='ACTIVO') {
                        ?>
                        <select class="form-control" name="opcion-up" placeholder="">
                          <option value="<?php echo $campos['rolesestado']; ?>"><?php echo $campos['rolesestado']; ?>
                          <option value="DESACTIVO">DESACTIVO</option>
                        </select>
                        <?php 
                      }else if(trim($campos['rolesestado'])=='DESACTIVO'){
                        ?>
                        <select class="form-control" name="opcion-up" placeholder="">
                          <option value="<?php echo $campos['rolesestado']; ?>"><?php echo $campos['rolesestado']; ?>
                          <option value="ACTIVO">ACTIVO</option>
                        </select>
                        <?php 
                      } 
                      ?>

                    </div>
                  </div>







                  <?php
                  require_once './core/forced.php';

                  $consulta="SELECT *,T2.modulocodigo FROM privilegios as T1, modulo as T2 WHERE T1.codigoroles='$cod' AND T1.modulocodigo=T2.modulocodigo";

                  $conexion = forced::conectar();

                  $datos = $conexion->query($consulta);
                  $datos= $datos->fetchAll();
                  ?>

                  <?php
                  $contador=0;
                  $numerosencadena = "";
                  foreach ($datos as $rows) {
                    $contador=$contador+1;
                    $zinc=trim($rows['modulocodigo']);

                    ?>


                            <!--<input type="text" name="dete" value="<?php echo $rows['codigoroles']?>" 
                            <?php if ($campos['codigoroles']==$rows['codigoroles']) {
                              echo 'checked=""';
                            } ?> 
                            >-->



                            <?php 
                            $numerosencadena .=$zinc."&&";
                          } ?>




                          <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3  label-align">Modulos <span class="required">:</span></label>
                            <div class="col-md-6 col-sm-6">


                              <?php
                              require_once './core/forced.php';

                              $consulta="SELECT modulocodigo,modulonombre FROM modulo ORDER BY modulocodigo ASC";

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
                                      $numerosencadena1 = "";
                                      foreach ($datos as $rows) {
                                        $contador=$contador+1;

                                          //$zinc=forced::encryption($rows['modulocodigo']);
                                        $zinc=$rows['modulocodigo'];

                                        ?>

                                        <tr>
                                          <th scope="row"><center><?php echo $contador ?></center></th>
                                          <td align="center" class="flat">
                                            <input onclick="privilegios1();" class="ch" type="checkbox" name="privilegio-up" id="<?php echo trim($rows['modulocodigo'])?>" value="<?php echo trim($rows['modulocodigo'])?>" 
                                            <?php 
                                            $arreglo = explode("&&", $numerosencadena);
                                            for ($i=0; $i <count($arreglo) ; $i++) { 
                                              if ($arreglo[$i]==trim($rows['modulocodigo'])) {
                                                echo 'checked=""';
                                              } 
                                            }


                                            ?> 
                                            >
                                          </td>

                                          <td align="center"><p><?php echo $rows['modulonombre'] ?></p></td>

                                          <?php 
                                          $numerosencadena1 .=$zinc."/";
                                        } ?>
                                      </tr>
                                      <input type="hidden" value="<?php echo($numerosencadena) ?>" name="detemrg"> 
                                      <!--<input type="text" class="flat" name="contador-reg" value="<?php echo($numerosencadena1) ?>">-->
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
                                  <!--<a onclick="privilegios1();" class="btn btn-primary">Edissssstar</a>-->
                                  <button type='submit' class="btn btn-primary">Editar</button>
                                  <a href="<?php echo SERVERURL; ?>/roles/" class="btn btn-secondary">Regresar</a>
                                  <!--<button type='reset' class="btn btn-success">Limpiar</button>-->
                                </div>
                              </div>
                            </div>
                            <div class="RespuestaAjax"></div>
                          </form>
                        </div>
                      </div>
                      <!---------------- --------------------> 
                    <?php }else{ ?>
                      <div class="alert alert-dismissible alert-warning text-center">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i>
                        <h4>¡Lo sentimos!</h4>
                        <p>No podemos mostrar información del rol en este momento</p>
                      </div>
                    <?php } ?>


                  </div>
                </div>

              </div>
            </div>
          </div>