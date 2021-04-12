                    <div class="">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Listado de los modulos del sistema <small></small></h2>
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
                                        <table id="datatable" class="table table-bordered" style="width:100%">
                                          <?php 
                                          require_once "./controladores/modulosControlador.php";
                                          $insAdmin= new modulosControlador();
                                          ?>
                                          <?php 
                                          
                                          echo $insAdmin->listar_modulos_controlador();
                                          ?>  
                                          <div class="modal fade editar-modal-lg" id="editar" tabindex="-1" role="dialog" aria-hidden="true">

                                            <div class="modal-dialog modal-lg">
                                              <div class="modal-content">

                                                <div class="modal-header">
                                                  <h4 class="modal-title" id="myModalLabel">Editar menú</h4>
                                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  <form action="<?php echo SERVERURL; ?>ajax/menuAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                                                        <!--
                                                        <div class="field item form-group">
                                                          <label class="col-form-label col-md-3 col-sm-3  label-align">Seleccionar Tipo Cuenta <span class="required">:</label>
                                                          <div class="col-md-6 col-sm-6 ">
                                                                <select class="form-control" name="name" placeholder="ejem. INGA LEMA" required="required">
                                                                        <option value="AK">Administrador</option>
                                                                </select>
                                                          </div>
                                                        </div>
                                                      -->
                                                      <div class="field item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre <span class="required">:</span></label>
                                                        <div class="col-md-6 col-sm-6">
                                                          <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="name-up" id="name-up" placeholder="" required="required" />
                                                        </div>
                                                      </div>
                                                      <div class="field item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre <span class="required">:</span></label>
                                                        <div class="col-md-6 col-sm-6">
                                                          <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="codigo-up" id="codigo-up" placeholder="" required="required" />
                                                        </div>
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <button type="button" class="btn btn-primary">Editar</button>
                                                      </div>
                                                      <div class="RespuestaAjax"></div>
                                                    </form>
                                                  </div>
                                                  

                                                </div>
                                              </div>





                                              
                                            </div>
                                          </table>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>


