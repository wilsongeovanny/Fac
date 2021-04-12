<?php
    require_once "../core/forced.php";
    require_once "../vistas/contenidos/phpqrcode/qrlib.php";


      $informe=forced::ejecutar_consulta_simple("SELECT HARDWAREQR FROM hardware");
      $numero1=($informe->rowCount())+1;
      $codinfo=forced::generar_codigo_aleatorio("HARDWARE",7,$numero1);
      $consulta1=forced::ejecutar_consulta_simple("SELECT HARDWAREQR FROM hardware WHERE HARDWAREQR='$codinfo'");
      $c1=$codinfo;
                          
      
      $dir = '../temp/';

      //$codigo=forced::encryption($c1);
      $codigo=$c1;
                          
      if(!file_exists($dir))
        mkdir($dir);
                          
      $filename = $dir.'test.png';
                          
      $tamanio = 15;
      $level = 'H';
      $frameSize = 1;
      $contenido = $codigo;

      QRcode::png($contenido, $filename, $level, $tamanio, $frameSize);
                          
      echo '<img name="nuevo_input"  style="margin-left: 271%; margin-top: 10px; margin-bottom: 20px; width:230px; height:230px; border: 10px solid black;" style="width:210px; height:210;" src="../temp/'.$filename.'" />';


      echo "<input type='hidden' name='codqr-up' value='".$codigo."' />";