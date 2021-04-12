 <?php
 require_once "../core/Consult.php";
 require_once "../vistas/contenidos/phpqrcode/qrlib.php";


      //SI SE ENCUENTRA EN LA BD LA CÉDULA
      $codigo=trim($_GET['empleadocedula']);
      $serie=trim($_GET['serie']);
      $inv=trim($_GET['inv']);

      $consultar=forced::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocedula='$codigo'");
      $consu=$consultar->fetch();
      $empcod=$consu['empleadocodigo'];

      $buscador=forced::ejecutar_consulta_simple("SELECT *,T1.empleadocodigo FROM empleados as T1, cargo as T2, departemento as T3, empresa as T4 WHERE T1.empleadocodigo='$empcod' AND T1.cargocodigo=T2.cargocodigo AND T2.departamentocodigo=T3.departamentocodigo AND T3.empresacodigo=T4.empresacodigo");
      $Datos=$buscador->fetch();
      $empleado=$Datos['empleadocodigo'];
      $dni=trim($Datos['empleadocedula']);
      $nom=trim($Datos['empleadonombres']);
      $ap=trim($Datos['empleadoapellidos']);
      $nombres=$nom." ".$ap;
      $cargos=$Datos['cargonombre'];
      $departementos=trim($Datos['departamentonombre']);
      $empresa=$Datos['empresanombre'];


      
     


      //SI NO SE ENCUENTRA EN LA BD CONCATENAR CON 0 PARA PORDER ENCONTRARLO
      if ($buscador->rowCount()<=0) {
        $cero=0;
        $concatenar= $cero."".$_GET['empleadocedula'];
        $serie=$_GET['serie'];

        $consultar=forced::ejecutar_consulta_simple("SELECT  * FROM empleados WHERE empleadocedula='$codigo'");
        $consu=$consultar->fetch();
        $empcod=$consu['empleadocodigo'];

        $buscador=forced::ejecutar_consulta_simple("SELECT *,T1.empleadocodigo FROM empleados as T1, cargo as T2, departemento as T3, empresa as T4 WHERE T1.empleadocodigo='$empcod' AND T1.cargocodigo=T2.cargocodigo AND T2.departamentocodigo=T3.departamentocodigo AND T3.empresacodigo=T4.empresacodigo");
        $Datos=$buscador->fetch();
        $empleado=$Datos['empleadocodigo'];
        $dni=trim($Datos['empleadocedula']);
        $nom=trim($Datos['empleadonombres']);
        $ap=trim($Datos['empleadoapellidos']);
        $nombres=$nom." ".$ap;
        $cargos=$Datos['cargonombre'];
        $departementos=trim($Datos['departamentonombre']);
        $empresa=$Datos['empresanombre'];



       $f= date('08:12:41/2021-02-01');
       $fg= date('2021-02-25');

       $dir = '../temp/';

       //$codigo=forced::encryption($c1);
       //$codigo=$f."/".$serie."/".$inv."/".$dni."/".$nombres."/".$departementos;
       $codigo=$f."/".$inv."/".$dni."/".$nombres."/".$departementos;
       $imagen=$fg."_".$inv."_".$dni;
                          
       if(!file_exists($dir))
        mkdir($dir);
                          
       $filename = $dir.'test.png';
                          
       $tamanio = 15;
       $level = 'H';
       $frameSize = 1;
       $contenido = $codigo;

       QRcode::png($contenido, $filename, $level, $tamanio, $frameSize);



        
         echo "<div class='row'>";

         echo "<input type='hidden' name='pers-reg' value='".$empleado."' />";

         echo "<div class='col-md-6 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Entidad <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='emp-reg' disabled='disabled' placeholder='' required='required' value='".$empresa."' />";
         echo "</div>";
         echo "</br></br></br></br>";

         echo "<div class='col-md-6 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Departemento <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='dep-reg' disabled='disabled' placeholder='' required='required' value='".$departementos."' />";
         echo "</div>";
         echo "</br>";

         echo "<div class='col-md-6 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Cargo <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='car-reg' disabled='disabled' placeholder='' required='required' value='".$cargos."' />";
         echo "</div>";
         echo "</br>";

         echo "<div class='col-md-6 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Empleado <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='qr_nom' disabled='disabled' placeholder='' required='required' value='".$nombres."' />";
         echo "</div>";

         echo "</div>";


         echo "</br>";

         echo "<h2 class='StepTitle'>Generar código QR al hardware</h2><br><br>";
         echo "<div class='row'>";

         echo "<div class='col-md-12 col-sm-12'  form-group'>";
         echo '<img name="img" align="center" style="width:230px; height:230px; border: 6px solid black; display: block; margin-left: auto; margin-right: auto;" src="../temp/'.$filename.'?'.$f.'" /> ';
         echo "<input type='hidden' name='codqr-up' value='".$contenido."' />";
         echo "<input type='hidden' name='codimg-up' value='".$imagen."' />";
         echo "</div>";

         echo "</div>";

         echo "</br>";



      }else {


       $f= date('12:12:41/2021-02-01');
       $fg= date('hisYmd');

       $dir = '../temp/';

       //$codigo=forced::encryption($c1);
       //$codigo=$f."/".$serie."/".$dni."/".$nombres."/".$departementos;
       $codigo=$f."/".$inv."/".$dni."/".$nombres."/".$departementos;
       $imagen=$fg."_".$inv."_".$dni;
                          
       if(!file_exists($dir))
        mkdir($dir);
                          
       $filename = $dir.'test.png';
                          
       $tamanio = 15;
       $level = 'H';
       $frameSize = 1;
       $contenido = $codigo;

       QRcode::png($contenido, $filename, $level, $tamanio, $frameSize);



        

         echo "<div class='row'>";

         echo "<input type='hidden' name='pers-reg' value='".$empleado."' />";

         echo "<div class='col-md-6 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Entidad <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='emp-reg' disabled='disabled' placeholder='' required='required' value='".$empresa."' />";
         echo "</div>";
         echo "</br></br></br></br>";

         echo "<div class='col-md-6 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Departemento <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='dep-reg' disabled='disabled' placeholder='' required='required' value='".$departementos."' />";
         echo "</div>";
         echo "</br>";

         echo "<div class='col-md-6 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Cargo <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='car-reg' disabled='disabled' placeholder='' required='required' value='".$cargos."' />";
         echo "</div>";
         echo "</br>";

         echo "<div class='col-md-6 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Empleado <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='qr_nom' disabled='disabled' placeholder='' required='required' value='".$nombres."' />";
         echo "</div>";

         echo "</div>";


         echo "</br>";

         echo "<h2 class='StepTitle'>Generar código QR al hardware</h2><br><br>";
         echo "<div class='row'>";

         echo "<div class='col-md-12 col-sm-12'  form-group'>";
         echo '<img name="img" align="center" style="width:230px; height:230px; border: 6px solid black; display: block; margin-left: auto; margin-right: auto;" src="../temp/'.$filename.'?'.$f.'" /> ';
         echo "<input type='hidden' name='codqr-up' value='".$contenido."' />";
         echo "<input type='hidden' name='codimg-up' value='".$imagen."' />";
         echo "</div>";

         echo "</div>";

         echo "</br>";


      }
    
 ?>