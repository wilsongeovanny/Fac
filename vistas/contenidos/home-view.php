        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Procesos de Control de Hardware</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5  form-group pull-right top_search">
                  <div class="input-group">
                    <!--<input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>-->
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="x_panel">
                <div class="x_content">
                  <div class="col-md-12 col-sm-12  text-center">
                    <ul class="pagination pagination-split">
                      <li><a href="#">Bitacora de Administradores</a></li>
                    </ul>
                  </div>

                  <div class="clearfix"></div>

                  <?php
                  require_once './core/forced.php';

                  $consulta="SELECT *,T1.bitacoracodigo FROM bitacora as T1, cuenta as T2, empleados as T3, cargo T4, departemento as T5, empresa as T6, roles as T7 WHERE bitacorahorafinal!='Sin registro' AND T1.cuentacodigo=T2.cuentacodigo AND T2.empleadocodigo=T3.empleadocodigo AND T3.cargocodigo=T4.cargocodigo AND T4.departamentocodigo=T5.departamentocodigo AND T5.empresacodigo=T6.empresacodigo AND T2.codigoroles=T7.codigoroles order by bitacorafecha LIMIT 20";

                  $conexion = forced::conectar();

                  $datos = $conexion->query($consulta);
                  $datos= $datos->fetchAll();


                  foreach ($datos as $rows) {
                    ?>

                    <div class="col-md-4 col-sm-4  profile_details">
                      <div class="well profile_view">
                        <div class="col-sm-12">
                          <h4 class="brief"><i><?php echo($rows['cuentausuario']); ?></i></h4>
                          <div class="left col-sm-7">
                            <h2><?php echo trim($rows['empleadoapellidos'])." ".trim($rows['empleadonombres']); ?></h2>
                            <p><strong><?php echo($rows['departamentonombre']); ?> </strong>/ <strong><?php echo($rows['cargonombre']); ?> </strong></p>
                            <ul class="list-unstyled">
                              <li><i class="fa fa-building"></i> Rol: <?php echo($rows['rolesnombre']); ?></li>
                              <li><i class="fa fa-phone"></i> Celular #: <?php echo($rows['empleadocelular']); ?></li>
                              <li><i class="fa fa-calendar"></i> Fecha : <?php echo($rows['bitacorafecha']); ?></li>
                              <li><i class="fa fa-clock-o"></i> Hora Inicio : <?php echo($rows['bitacorahorainicio']); ?></li>
                              <li><i class="fa fa-clock-o"></i> Hora Final : <?php echo($rows['bitacorahorainicio']); ?></li>







                            </ul>
                          </div>
                          <div class="right col-sm-5 text-center">
                            <img src="<?php echo SERVERURL.'cuenta/'.$rows['cuentafoto'] ?>" alt="" class="img-circle img-fluid">
                          </div>
                        </div>
                        <div style="display:inline" class=" bottom text-center">
                          <!--<div class=" col-sm-6 emphasis">
                            <p class="ratings">
                              <a><?php echo($rows['empleadocorreo']); ?></a>
                            </p>
                          </div>-->
                          <div class="col-sm-12 emphasis">
                            <!--<button type="button" class="btn btn-primary btn-sm"> <i class="fa fa-user">
                            </i> <i class="fa fa-comments-o"></i> Empleado</button>-->
                            
                            <form method="POST" action="<?php echo SERVERURL; ?>empleadosinfo/">
                              <input type="hidden" value="<?php echo trim($rows['empleadocodigo']); ?>" name="codigo">
                              <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-user" style="display:inline">
                              </i> Empleado</button>
                            </form>

                            <form method="POST" action="<?php echo SERVERURL; ?>administradorinfo/">
                              <input type="hidden" value="<?php echo trim($rows['cuentacodigo']); ?>" name="codigo">
                              <button type="submit" class="btn btn-secondary btn-sm" style="display:inline">
                                <i class="fa fa-user"> </i> Cuenta
                              </button>
                            </form>


                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>



                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->