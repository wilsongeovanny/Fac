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
            <h2>Sección de reasignación de hardware</h2>
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


          <?php
          require_once "./controladores/mantenimientoControlador.php";
          if (!isset($_POST['codigo'])) {
            $verificar='null';
          }else{
            $verificar=$_POST['codigo'];
          }

          $iEs= new mantenimientoControlador();
          $filesEs=$iEs->datos_mantenimiento_controlador("Tipo",$verificar);

          if ($filesEs->rowCount()==1) {
            $campos=$filesEs->fetch();
            
            ?>
            <!-- page content -->
            <div class="x_content">



              <div class="col-md-12">

                <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Reasignación</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Auditorias</a>
                  </li>
                        <!--<li class="nav-item">
                          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Informe de entrega</a>
                        </li>-->
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                          <?php require_once 'reasignados.php' ?>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                         <?php require_once 'auditoriainforeasig.php' ?>
                       </div>
                       <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        
                       </div>
                     </div>

                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
       <!-- /page content -->

     <?php }else{ ?>
      <div class="alert alert-dismissible alert-warning text-center">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i>
        <h4>¡Lo sentimos!</h4>
        <p>No hemos podido encontrar información de la auditoria</p>
      </div>
    <?php } ?>
  </div>
</div>
</div>
</div>
</div>