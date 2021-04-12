<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Procesos de Control de Hardware</h3>
            </div>

            <!--<div class="title_right">
                <div class="col-md-5 col-sm-5 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>-->
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Sección Departamentos <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <!--<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Settings 1</a>
                                    <a class="dropdown-item" href="#">Settings 2</a>
                                </div>
                            </li>-->
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Listar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Agregar</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <?php require_once 'departamentoslist.php' ?>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">



                            <div class="">
                                <div class="x_panel">
                                  <div class="x_title">
                                    <h2>Agregar nuevo departamento <small></small></h2>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <!--  INICIO DE FORM AGREGAR CLIENTE -->
                                <form class="" action="" method="post" novalidate>
                                    <!--<span class="section">Agregar nuevo empleado</span>-->
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align">Seleccionar Entidad <span class="required">:</label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <select class="form-control" name="name" placeholder="ejem. INGA LEMA" required="required">
                                                    <option value="AK">Municipio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Nombre Departamento <span class="required">:</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" data-validate-length-range="6" data-validate-words="1" name="name" placeholder="ejem. ALEX MAURICIO" required="required" />
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
                                    </form>
                                    <!--  FIN DE FORM AGREGAR CLIENTE --> 

                                </div>
                            </div>

                        </div>

                    </div>



                </div>

                
            </div>
        </div>
    </div>
</div>
</div>