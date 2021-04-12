<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <link href="<?php echo SERVERURL; ?>vistas/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo SERVERURL; ?>vistas/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo SERVERURL; ?>vistas/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Datatables -->
    
    <link href="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SERVERURL; ?>vistas/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo SERVERURL; ?>vistas/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <?php include "./vistas/<modulos/perfil.php"; ?>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <?php include "./vistas/modulos/navlateral.php"; ?>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <?php require_once './vistas/modulos/buttons.php'; ?>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <?php require_once '../modulos/navbar.php'; ?>
            <!-- /top navigation -->

            <!-- page content -->
            <?php require_once './vistas/production/clientes.php'; ?>
            <!-- /page content -->

            <!-- footer content -->
            <?php require_once '../modulos/footer.php'; ?>
            <!-- /footer content -->
        </div>
    </div>


    <!-- Inicio Script -->
    <?php require_once '../modulos/script.php'; ?>
    <!-- Fin Script -->

</body>

</html>
