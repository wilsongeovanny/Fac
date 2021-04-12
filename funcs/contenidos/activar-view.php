 <?php 
 require 'funcs/conexion.php';
 require 'funcs/activacion.php';
	//Primer explode para sacar el ultimo y /?
 $a=$_SERVER["REQUEST_URI"];
 $porciones=explode("/", $a);

	//Segundo explode para sacar & de el ultmio /
 $estraer=explode("&", $porciones[3]);

	//Tercer explode para sacar el = el primer val
 $b=explode("=", $estraer[0]);

	//Cuarto explode para sacar el = el segundo val
 $c=explode("=", $estraer[1]);


 $val2=decryption($b[1]);
 $val3=decryption($c[1]);

 
 if(isset($val2) AND isset($val3))
 {
  $usuario = $val2;
  $token = $val3;
  $mensaje = validaIdToken($usuario, $token); 

}

?>
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
 <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
 <!-- Font Awesome -->
 <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
 <!-- NProgress -->
 <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">

 <!-- Custom Theme Style -->
 <link href="../build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
 <div class="container body">
  <div class="main_container">
   <!-- page content -->
   <div class="col-md-12">
    <div class="col-middle">
     <div class="text-center text-center">
      <h2 class="error-number">ACTIVACIÓN</h2>
      <h2><?php echo $mensaje; ?></h2>
      <div>
        <a href="<?php echo SERVERURL; ?>login/" style="font-size:13px; color: #FFF;">Ir a inicio de sesíon</a>
      </div>
      <div class="mid_center">
       <img src="<?php echo SERVERURL; ?>vistas/contenidos/images/Gad.png"  style=" width: 150px height: 900px" class="logo_1"> 
                <!--<h3>Search</h3>
                <form>
                  <div class="  form-group pull-right top_search">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Search for...">
                      <span class="input-group-btn">
                              <button class="btn btn-secondary" type="button">Go!</button>
                          </span>
                    </div>
                  </div>
                </form>-->
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
  </body>
  </html>
