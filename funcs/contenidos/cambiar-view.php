<?php 

  //Primer explode para sacar el ultimo y /?
$a=$_SERVER["REQUEST_URI"];
$porciones=explode("/", $a);

  //Segundo explode para sacar & de el ultmio /
$estraer=explode("&", $porciones[3]);

  //Tercer explode para sacar el = el primer val
$b=explode("=", $estraer[0]);

  //Cuarto explode para sacar el = el segundo val
$c=explode("=", $estraer[1]);


$val=$b[1];
$val1=$c[1];


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
  <link href="<?php echo SERVERURL; ?>vistas/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo SERVERURL; ?>vistas/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="<?php echo SERVERURL; ?>vistas/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <link href="<?php echo SERVERURL; ?>vistas/vendors/animate.css/animate.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="<?php echo SERVERURL; ?>vistas/build/css/custom.min.css" rel="stylesheet">

</head>

<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <img src="<?php echo SERVERURL; ?>vistas/contenidos/images/Gad.png"  style=" width: 150px height: 900px" class="logo_1"> 
          <br>
          <br>
          <form action="" method="POST" autocomplete="off" class="logInForm">
            <h1>Cambio de Contraseña</h1>
            <input type="hidden" id="val-rec" name="val-rec" value="<?php echo $val; ?>">
            <input type="hidden" id="val1-rec" name="val1-rec" value="<?php echo $val1; ?>">
            <div>
              <input type="password" class="form-control" name="contraseña-rec" placeholder="Contraseña" required="" />
            </div>
            <div>
              <input type="password" class="form-control" name="ccontraseña-rec" placeholder="Confirmar contraseña" required="" />
            </div>
            <div>

              <button class="btn btn-defaul" style="background-color: #fefefe;" type="submit">Cambiar</button>
            </div>

            <div class="clearfix"></div>

            <div class="separator">

              <div class="clearfix"></div>
              <br />

              <div>
                <h1><!--<i class="fa fa-paw"></i>--> GAD - Municipal de Latacunga!</h1>
                <!--<p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>-->
              </div>
            </div>
            
          </form>
        </section>
      </div>

      <?php
      if (isset($_POST['contraseña-rec']) && isset($_POST['ccontraseña-rec'])) {
        require_once "./controladores/administradorControlador.php";
        $login = new administradorControlador();
        echo $login->recuperar_contrasenia_controlador();
      }
      ?>


    </div>
  </body>
  </html>
