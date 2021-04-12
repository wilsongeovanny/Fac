                    <div class="">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Listado de Hardware en reparación<small></small></h2>
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
                                        <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                                          <?php 
                                          require_once "./controladores/mantenimientoControlador.php";
                                          $insAdmin= new mantenimientoControlador();
                                          ?>
                                          <?php 
                                          
                                          echo $insAdmin->listar_dadodebaja_controlador();
                                          ?>  
                                          
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>


