<!-- <?php
 	//echo"<script>alert('LA MATERIA HA SIDO AGREGADA CON EXITO'); window.location='Materias.php';</script>";
     echo "La variable seleccionada es: ";
     echo "<input name='nuevo_input' value='".$_POST['tu_variable']."' />";
 ?>-->


                         <?php
  
                          require_once "../vistas/contenidos/phpqrcode/qrlib.php";

                          
                          $dir = 'temp/';


                          $codigo=$_POST['codigo-gen'];
                          
                          if(!file_exists($dir))
                            mkdir($dir);
                          
                          $filename = $dir.'test.png';
                          
                          $tamanio = 15;
                          $level = 'H';
                          $frameSize = 1;
                          $contenido = $codigo;

                          QRcode::png($contenido, $filename, $level, $tamanio, $frameSize);
                          
                          echo '<img src="../'.$filename.'" />';