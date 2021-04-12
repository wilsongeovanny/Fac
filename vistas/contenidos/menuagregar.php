
<div class="">
  <div class="x_panel">
    <div class="x_title">
      <h2>Agregar nuevo Rol <small></small></h2>
      <div class="clearfix"></div>
    </div>
    <form action="<?php echo SERVERURL; ?>ajax/menuAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
      <!--<span class="section">Agregar nuevo empleado</span>-->
      



      <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre <span class="required">:</span></label>
        <div class="col-md-6 col-sm-6">
          <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="nombre-reg" placeholder="" required="required" />
        </div>
      </div>



      <div class="field item form-group">
        <label class="col-form-label col-md-3 col-sm-3  label-align">Descripción <span class="required">:</span></label>
        <div class="col-md-6 col-sm-6">
          <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="nombre-reg" placeholder="" required="required" />
        </div>
      </div>



                                        <!--<div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Opción <span class="required">:</label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <select class="form-control" name="opcion-reg" placeholder="" required="required">
                                                    <optgroup label="Empresa"> 
                                                        <option value="municipio">Empresa</option>
                                                        <option value="departamentos">Departamentos</option>
                                                        <option value="cargos">Cargos</option>
                                                    </optgroup>
                                                    <optgroup label="Personal">
                                                        <option value="empleados">Empleados</option>
                                                        <option value="estadosEmpleado">Estados empleado</option>
                                                    </optgroup>
                                                    <optgroup label="Ingresos">
                                                        <option value="estadosHardwareingreso">Estados de ingreso</option>
                                                        <option value="estadosHardware">Estados de hardware</option>
                                                        <option value="estadosHardwareasignacion">Estados de re/asignación</option>
                                                        <optgroup label="&nbsp;&nbsp;&nbsp;Informes de Ingreso de Hardware">
                                                            <option value="informeingresohardware">Aprobados</option>
                                                            <option value="informeingresoechazado">Rechazados</option>
                                                        </optgroup>
                                                        <optgroup label="&nbsp;&nbsp;&nbsp;Características">
                                                            <option value="tipohardware">Tipos</option>
                                                            <option value="marcashardware">Marcas</option>
                                                            <option value="modeloshardware">Modelos</option>
                                                            <option value="coloreshardware">Colores</option>
                                                        </optgroup>
                                                    </optgroup>
                                                    <optgroup label="Re / Asignación">
                                                        <optgroup label="&nbsp;&nbsp;&nbsp;Asignación">
                                                            <option value="asignacion">Sin asignar</option>
                                                            <option value="asignados">Asignados</option>
                                                        </optgroup>
                                                        <optgroup label="&nbsp;&nbsp;&nbsp;Reasignación">
                                                            <option value="liberados">Liberados</option>
                                                            <option value="reasignados">Reasignados</option>
                                                        </optgroup>
                                                    </optgroup>
                                                    <optgroup label="Mantenimiento">
                                                        <option value="tiposMantenimiento">Tipos de Mantenimiento</option>
                                                        <option value="estadosMantenimiento">Estados de Mantenimiento</option>
                                                        <option value="estadosHardwareasignacion">Estados de re/asignación</option>
                                                        <optgroup label="&nbsp;&nbsp;&nbsp;Gestionar Mantenimiento">
                                                            <option value="mantenimiento">Hardware</option>
                                                            <option value="reparacion">En reparación</option>
                                                            <option value="dadodebaja">Dado de baja</option>
                                                        </optgroup>
                                                    </optgroup>
                                                </select>
                                            </div>
                                          </div>-->
                                          







                                          <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Modulos <span class="required">:</span></label>
                                            





                                           <!-- <div class="">
                        <ul class="to_do">
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Schedule meeting with new client </p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Create email address for new intern</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Create email address for new intern</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                          </li>
                          <li>
                            <p>
                              <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                          </li>
                        </ul>
                      </div>
                    -->



















                    <div class="col-md-6 col-sm-6  ">
                <!--<div class="x_panel">
                  <div class="x_title">
                    <h2>Bordered table <small>Bordered table subtitle</small></h2>
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
                  </div>-->



                  <?php
                  require_once './core/forced.php';
                  
                  $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM modulo";

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
                          foreach ($datos as $rows) {
                            $contador=$contador+1;
                            $zinc=forced::encryption($rows['MODULOCODIGO']);
                            ?>
                            <tr>
                              <th scope="row"><center><?php echo $contador ?></center></th>
                              <td align="center"><input type="checkbox" class="flat" value="<?php echo($zinc) ?>"></td>
                              <td align="center"><p><?php echo $rows['MODULONOMBRE'] ?></p></td>
                            <?php } ?>
                          </tr>

                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>












              </div>

















              <div class="ln_solid">
                <div class="form-group">
                  <div class="col-md-6 offset-md-3">
                    <button type='submit' class="btn btn-primary">Agregar</button>
                    <button type='reset' class="btn btn-success">Limpiar</button>
                  </div>
                </div>
              </div>
              <div class="RespuestaAjax"></div>
            </form>
          </div>
        </div>
