                    <div class="">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Listado de hardware <small></small></h2>
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
                                        $zinc=$campos['empleadocodigo'];
                                        
                                        $consulta="SELECT *,T1.hiserie FROM hardware as T1, empleados as T2, hardware_ingreso as T3, tipo_hardware as T4, marca_hardware as T5, modelo_hardware as T6, color_hardware as T7, estado_hardware as T8, estado_asignacion_hardware as T9 WHERE (T2.empleadocodigo='$zinc' AND T1.empleadocodigo=T2.empleadocodigo AND T1.hiserie=T3.hiserie AND T3.tipohardwarecodigo=T4.tipohardwarecodigo AND T3.marcahardwarecodigo=T5.marcahardwarecodigo AND T3.modelohardwarecodigo=T6.modelohardwarecodigo AND T3.colorhardwarecodigo=T7.colorhardwarecodigo AND T1.estadohardwarecodigo=T8.estadohardwarecodigo AND T8.estadohardwarenombre='ACTIVO' AND T3.estadoasigharcodigo=T9.estadoasigharcodigo AND T9.estadoasigharnombre='ASIGNADO') OR (T2.empleadocodigo='$zinc' AND T1.empleadocodigo=T2.empleadocodigo AND T1.hiserie=T3.hiserie AND T3.tipohardwarecodigo=T4.tipohardwarecodigo AND T3.marcahardwarecodigo=T5.marcahardwarecodigo AND T3.modelohardwarecodigo=T6.modelohardwarecodigo AND T3.colorhardwarecodigo=T7.colorhardwarecodigo AND T1.estadohardwarecodigo=T8.estadohardwarecodigo AND T8.estadohardwarenombre='ACTIVO' AND T3.estadoasigharcodigo=T9.estadoasigharcodigo AND T9.estadoasigharnombre='REASIGNADO')";



                                        

                                        $conexion = forced::conectar();

                                        $datos = $conexion->query($consulta);
                                        $datos= $datos->fetchAll();
                                        ?>
                                        <!-- <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%"> -->
                                          <table id="datatable-buttons" class="table table-bordered table-bordered" style="width:100%">
                                            <thead>
                                              <tr>
                                                <th>#</th>
                                                <th>SERIE DEL HARDWARE</th>
                                                <th>CODIGO QR</th>
                                                <th>TIPO HARDWARE</th>
                                                <th>MARCA DE HARDWARE</th>
                                                <th>MODELO DE HARDWARE</th>
                                                <th>COLOR DE HARDWARE</th>
                                                <th>FECHA DE INGRESO</th>
                                                <th>VER</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php
                                              $contador=0;
                                              foreach ($datos as $rows) {
                                                $contador=$contador+1;
                                                $a=trim($rows['hiserie']);
                                                ?>
                                                <tr>
                                                  <td><?php echo $contador; ?></td>
                                                  <td><?php echo $rows['hiserie']; ?></td>
                                                  <td><?php echo $rows['hardwareqr']; ?></td>
                                                  <td><?php echo $rows['tipohardwarenombre']; ?></td>
                                                  <td><?php echo $rows['marcahardwarenombre']; ?></td>
                                                  <td><?php echo $rows['modelohardwarenombre']; ?></td>
                                                  <td><?php echo $rows['colorhardwarenombre']; ?></td>
                                                  <td><?php echo $rows['hifecha']; ?></td>
                                                  <td>
                                                    <?php
                                                    if (trim($rows['estadoasigharnombre'])=='ASIGNADO') {
                                                      ?>
                                                      <form method="POST" action="<?php echo SERVERURL.'asignadosinfo/'?>">
                                                        <input type="hidden" name="codigo" value="<?php echo $a ; ?>">
                                                        <button style="width:110px; height:38px; display: block; margin-left: auto; margin-right: auto;" type="submit" class="btn btn-primary"> Asignado</button>
                                                      </form>
                                                      <?php
                                                    }elseif (trim($rows['estadoasigharnombre'])=='REASIGNADO'){
                                                      ?>
                                            <!--<a style="color: #ffffff;" class="btn btn-primary"></i> Ver
                                            </a>-->
                                            <form method="POST" action="<?php echo SERVERURL.'reasignadosempinfo/'?>">
                                              <input type="hidden" name="codigo" value="<?php echo $a ; ?>">
                                              <button style="width:110px; height:38px; display: block; margin-left: auto; margin-right: auto;" type="submit" class="btn btn-primary"> Reasignado</button>
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


