                    <div class="">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Listado del historial de mantenimiento de hardware <small></small></h2>
                               <!--<a href="formAgregarSocio.php" class="btn btn-success pull-right"><i
                                class="fa fa-credit-card"></i> Nuevo Socio</a>-->
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <!--<p class="text-muted font-13 m-b-30">
                                          The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
                                        </p>-->
                                        <?php
                                        require_once './core/forced.php';
                                        $zinc=$campos['hardwareqr'];

                                        $consulta="SELECT *,T1.mantenimientocodigo FROM mantenimiento as T1, diagnostico as T2, responsable_diagnostico as T3, empleados as T4, informacion_ingreso as T5, estado_mantenimiento as T6 WHERE T1.hardwareqr='$zinc' AND T1.diagnosticocodigo=T2.diagnosticocodigo AND T2.respdiagcodigo=T3.respdiagcodigo AND T3.empleadocodigo=T4.empleadocodigo AND T2.ingresocodigo=T5.ingresocodigo AND T1.estadomantenimientocodigo=T6.estadomantenimientocodigo ORDER BY estadomantenimientonombre";



                                        

                                        $conexion = forced::conectar();

                                        $datos = $conexion->query($consulta);
                                        $datos= $datos->fetchAll();
                                        ?>
                                        <!-- <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%"> -->
                                          <table id="datatable" class="table table-bordered table-bordered" style="width:100%">
                                            <thead>
                                              <tr>
                                                <th>#</th>
                                                <th>CODIGÓ DEL MANTENIMIENTO</th>
                                                <th>RESPONSABLE DEL DIAGNOSTICO</th>
                                                <th>HORA DEL DIAGNOSTICO</th>
                                                <th>FECHA DEL DIAGNOSTICO</th>
                                                <th>ESTADO DEL MANTENIMIENTO</th>
                                                <th>ACCIÓN</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php
                                              $contador=0;
                                              foreach ($datos as $rows) {
                                                $contador=$contador+1;
                                                $zinc=$rows['mantenimientocodigo'];
                                                ?>
                                                <tr>
                                                  <td><?php echo $contador; ?></td>
                                                  <td><?php echo $rows['mantenimientocodigo']; ?></td>
                                                  <td><?php echo $rows['empleadoapellidos']." ".$rows['empleadonombres']; ?></td>
                                                  <td><?php echo $rows['ingresohora']; ?></td>
                                                  <td><?php echo $rows['ingresofecha']; ?></td>
                                                  <td><?php echo $rows['estadomantenimientonombre']; ?></td>
                                                  <td>
                                                    <?php
                                                    if (trim($rows['estadomantenimientonombre'])=='EN REPARACION') {
                                                      ?>
                                                      <form method="POST" action="<?php echo SERVERURL.'manteentrega/'?>">
                                                        <input type="hidden" value="<?php echo $zinc; ?>" name="codmant">
                                                        <button style="width:110px; height:38px; display: block; margin-left: auto; margin-right: auto;" type="submit" class="btn btn-primary"> Continuar</button>
                                                      </form>
                                                      <?php
                                                    }else{
                                                      ?>
                                            <!--<a style="color: #ffffff;" class="btn btn-primary"></i> Ver
                                            </a>-->
                                            <form method="POST" action="<?php echo SERVERURL.'mantenimientoreport/'?>">
                                              <input type="hidden" value="<?php echo $zinc; ?>" name="codmant">
                                              <button style="width:110px; height:38px; display: block; margin-left: auto; margin-right: auto;" type="submit" class="btn btn-primary"> Reporte</button>
                                            </form>
                                            <?php 
                                          }
                                          ?>
                                        </td>
                                      <?php } ?>

                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>


