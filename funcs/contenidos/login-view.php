<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src='https://www.google.com/recaptcha/api.js'></script>
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
          <?php


                if (isset($_POST['usuario']) && isset($_POST['clave'])) {
                  require_once "./controladores/loginControlador.php";
                  $login = new loginControlador();
                  echo $login->iniciar_sesion_controlador();
                }

          ?>
          <form action="" method="POST" autocomplete="off" class="logInForm">
            <h1>Inicio de Sesión</h1>
            <div>
              <input type="text" class="form-control" id="UserName" name="usuario" placeholder="Usuario" required="" />
            </div>
            <div>
              <input type="password" class="form-control" id="UserPass" name="clave" placeholder="Contraseña" required="" />
            </div>
            <div>
              <div style="display: block; margin-left: 4%; margin-right: 50%;" class="g-recaptcha col-md-3" data-sitekey="6LdeNnAaAAAAAM8GU1vqjVYRAyq5pv3zvssSqPQY"></div>
            </div><br><br><br><br><br>
            <div>
              <button class="btn btn-defaul" style="background-color: #fefefe;" type="submit">Ingresar al Sistema</button>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">Olvidaste tu contraseña?
                <a href="#signup" class="to_register"> Recupérala aquí </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <h1>GAD - Municipal de Latacunga!</h1>
              </div>
            </div>

          </form>
          <?php echo resultBlock($errors); ?>
        </section>
      </div>



      <div id="register" class="animate form registration_form">
        <section class="login_content">
          <img src="<?php echo SERVERURL; ?>vistas/contenidos/images/Gad.png"  style=" width: 150px height: 900px" class="logo_1">
          <br>
          <br>
          <form action="" method="POST" autocomplete="off" class="RecuperarInForm">
            <h1>Recuperar Contraseña</h1>
            <div>
              <input type="email" name="usuario-rec" class="form-control" placeholder="Correo" required="" />
            </div>
            <div>
              <button class="btn btn-defaul" style="background-color: #fefefe;" type="submit">Enviar correo de recuperación</button>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">Quieres iniciar sesión ?
                <a href="#signin" class="to_register"> Iniciar sesión </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <h1>GAD - Municipal de Latacunga!</h1>
              </div>
            </div>
          </form>
        </section>
      </div>
      <?php
      if (isset($_POST['usuario-rec'])) {
        require_once "./controladores/administradorControlador.php";
        $Oc = new administradorControlador();
        echo $Oc->enviar_email_controlador();
      }
      ?>

    </div>
  </div>
</body>
</html>
<script type="text/javascript" language="javascript" onclick="true">
    document.oncontextmenu = function(){return false}
</script>
