<?php session_start(['name'=>'SBP']); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GAD - Procesos de Control de Hardware</title>
    <link rel="icon" href="<?php echo SERVERURL; ?>vistas/contenidos/images/descargar.jpg">
    <!-- Bootstrap -->
    <link href="<?php echo SERVERURL; ?>vistas/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo SERVERURL; ?>vistas/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo SERVERURL; ?>vistas/vendors/nprogress/nprogress.css" rel="stylesheet">

    <!--  HOME -->

    <!-- iCheck -->
    <link href="<?php echo SERVERURL; ?>vistas/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    
    <!-- bootstrap-progressbar -->
    <link href="<?php echo SERVERURL; ?>vistas/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo SERVERURL; ?>vistas/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo SERVERURL; ?>vistas/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- FIN HOME -->


    <!-- Datatables -->
    <link href="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">


    <!-- Switchery -->
    <link href="<?php echo SERVERURL; ?>vistas/vendors/switchery/dist/switchery.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo SERVERURL; ?>vistas/build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/css/sweetalert2.css">
    <?php include "./vistas/modulos/script1.php"; ?> 
</head>
<?php  
$peticionAjax=false;
require_once "./controladores/vistasControlador.php";

$vt = new vistasControlador();
$vistasR=$vt->obtener_vistas_controlador();

if($vistasR=="login" || $vistasR=="cambiar" || $vistasR=="activar" || $vistasR=="404"):
    if ($vistasR=="login") {
        require_once "./vistas/contenidos/login-view.php";
    }else if($vistasR=="cambiar"){
        require_once "./vistas/contenidos/cambiar-view.php";
    }else if($vistasR=="activar"){
        require_once "./vistas/contenidos/activar-view.php";
    }else{
        require_once "./vistas/contenidos/404-view.php";
    }
else:

    //session_start(['name'=>'SBP']);

    require_once "./controladores/loginControlador.php";

    $lc = new loginControlador();
    if (!isset($_SESSION['codigo_gad']) || !isset($_SESSION['estado_gad']) || !isset($_SESSION['rol_gad']) || !isset($_SESSION['empleado_gad']) || !isset($_SESSION['usuario_gad']) || !isset($_SESSION['foto']) ) {
        echo $lc->forzar__cierre_sesion_controlador();
    }
    
    ?>
    <body class="nav-md">

        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="<?php echo SERVERURL; ?>home/"" class="site_title"><i class="fa fa-laptop"></i> <span>Mantenimiento!</span></a>
                        </div>

                        <div class="clearfix"></div>




                        <!-- menu profile quick info -->
                        <?php include './vistas/modulos/perfil.php'; ?>
                        <!-- /menu profile quick info -->

                        <br />

                        <!-- sidebar menu -->
                        <?php include './vistas/modulos/navlateral.php'; ?>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                        <?php include './vistas/modulos/buttons.php'; ?>
                        <!-- /menu footer buttons -->
                    </div>
                </div>

                <!-- top navigation -->
                <?php include './vistas/modulos/navbar.php'; ?>
                <!-- /top navigation -->

                <!-- page content -->
                <?php require_once $vistasR; ?>
                <!-- /page content -->

                <!-- footer content -->
                <?php include './vistas/modulos/footer.php'; ?>
                <!-- /footer content -->
            </div>
        </div>



        <!-- Inicio Script -->
        <?php include "./vistas/modulos/script.php"; ?> 
        <!-- Fin Script -->

        <?php 
       include "./vistas/modulos/logoutScript.php";
    endif; 
    ?>

</body>

</html>
