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
            <h2>Historial de Mantenimiento de Hardware</h2>
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

            $dad=$campos['estadohardwarenombre'];


            $aa=$campos['hardwareqr']
            
            ?>
            <!-- page content -->
            <div class="x_content">



              <div style="margin-left: 3%; margin-top: 10px; margin-bottom: 50px;" class="col-md-5 col-sm-5 " style="border:0px solid #e5e5e5;">

                <h3 class="prod_title">Información del hardware perteneciente a "<?php echo $campos['empleadoapellidos']." ".$campos['empleadonombres']; ?>"</h3>
                
                <div class="row invoice-info">
                  <div class="col-sm-3 invoice-col">
                    Persona
                    <address>
                      <strong><?php echo $campos['empleadoapellidos']." ".$campos['empleadonombres']; ?>.</strong>
                      <br><?php echo trim($campos['empleadocorreo']); ?>.
                      <br><?php echo $campos['empleadocelular']; ?>.
                      <br><?php echo $campos['empleadotelefono']; ?>.
                      <br><?php echo $campos['empleadofecha']; ?>.
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 invoice-col">
                    Empresa, departamento, cargo.
                    <address>
                      <strong><?php echo $campos['empresanombre']; ?>.</strong>
                      <br><?php echo $campos['departamentonombre']; ?>.
                      <br><?php echo $campos['cargonombre']; ?>.
                      <br><?php echo $campos['empresacorreo']; ?>.
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 invoice-col">
                    <b>Hardware</b>
                    <br>
                    <b>Cod. Inventario: <?php echo $campos['hiserie']; ?>.</b>
                    <br>
                    <b>Serie: <?php echo $campos['serireexterno']; ?>.</b>
                    <br>
                    <b>Tipo:</b> <?php echo $campos['tipohardwarenombre']; ?>.
                    <br>
                    <b>Marca:</b> <?php echo $campos['marcahardwarenombre']; ?>.
                    <br>
                    <b>Modelo:</b> <?php echo $campos['modelohardwarenombre']; ?>.
                    <br>
                    <b>Color:</b> <?php echo $campos['colorhardwarenombre']; ?>.
                  </div>
                  <!-- /.col -->
                  <!-- /.col -->
                  <div class="col-sm-3 invoice-col">
                    <b>Mantenimiento</b>
                    <br>
                    <b>Código QR: <?php echo $campos['hardwareqr']; ?>.</b>
                    <br>
                    <!--<b>Fecha del ultimo mantenimiento:</b> <?php echo $campos['modelohardwarenombre']; ?>.-->
                    <b>ESTADO:</b> <?php echo $campos['estadohardwarenombre']; ?>.
                  </div>
                  <!-- /.col -->
                </div>
                <br />

                


              </div>


              <div class="col-md-5 col-sm-5 ">
                <div class="product-image">
                  <img style="width:190px; height:190px; margin-left: 45%; margin-top: 70px; margin-bottom: 10px; border: 6px solid black;" src="../imagenes_qr/<?php echo $campos['hiimagenqr']; ?>" alt="..." />
                </div>
                <div style="margin-left: 25%; margin-top: 50px; margin-bottom: 50px;" class="product_gallery">
                        <!--<a>
                          <img src="<?php echo SERVERURL; ?>vistas/contenidos/images/prod-2.jpg" alt="..." />
                        </a>-->
                      </div>
                    </div>
                    
                    <div class="col-md-12">

                      <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Listas</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Hoja de diagnóstico</a>
                        </li>
                        <!--<li class="nav-item">
                          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Informe de entrega</a>
                        </li>-->
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                          <?php require_once 'historial.php' ?>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                         <?php require_once 'manteingresar.php' ?>
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
        <p>No hemos podido encontra información del historial de mantenimiento, por favor intente nuevamente</p>
      </div>
    <?php } ?>
  </div>
</div>
</div>
</div>
</div>