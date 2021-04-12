 <?php
 require_once "../core/Consult.php";
 require_once "../vistas/contenidos/phpqrcode/qrlib.php";


      //SI SE ENCUENTRA EN LA BD LA CÉDULA
      $codigo=$_GET['empleadocedula'];

      $consultar=forced::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocedula='$codigo'");
      $consu=$consultar->fetch();
      $empcod=$consu['empleadocodigo'];

      $buscador=forced::ejecutar_consulta_simple("SELECT *,T1.empleadocodigo FROM empleados as T1, cargo as T2, departemento as T3, empresa as T4 WHERE T1.empleadocodigo='$empcod' AND T1.cargocodigo=T2.cargocodigo AND T2.departamentocodigo=T3.departamentocodigo AND T3.empresacodigo=T4.empresacodigo");
      $Datos=$buscador->fetch();
      $empleado=$Datos['empleadocodigo'];
      $correo=$Datos['empleadocorreo'];
      $dni=$Datos['empleadocedula'];
      $nombres=trim($Datos['empleadoapellidos'])." ".trim($Datos['empleadonombres']);
      $cargos=$Datos['cargonombre'];
      $departementos=$Datos['departamentonombre'];
      $empresa=$Datos['empresanombre'];


      
     


      //SI NO SE ENCUENTRA EN LA BD CONCATENAR CON 0 PARA PORDER ENCONTRARLO
      if ($buscador->rowCount()<=0) {
        $cero=0;
        $concatenar= $cero."".$_GET['empleadocedula'];

        $consultar=forced::ejecutar_consulta_simple("SELECT  * FROM empleados WHERE empleadocedula='$concatenar'");
        $consu=$consultar->fetch();
        $empcod=$consu['empleadocodigo'];

        $buscador=forced::ejecutar_consulta_simple("SELECT *,T1.empleadocodigo FROM empleados as T1, cargo as T2, departemento as T3, empresa as T4 WHERE T1.empleadocodigo='$empcod' AND T1.cargocodigo=T2.cargocodigo AND T2.departamentocodigo=T3.departamentocodigo AND T3.empresacodigo=T4.empresacodigo");
        $Datos=$buscador->fetch();
        $empleado=$Datos['empleadocodigo'];
        $correo=$Datos['empleadocorreo'];
        $dni=$Datos['empleadocedula'];
        $nombres=trim($Datos['empleadoapellidos'])." ".trim($Datos['empleadonombres']);
        $cargos=$Datos['cargonombre'];
        $departementos=$Datos['departamentonombre'];
        $empresa=$Datos['empresanombre'];

        
         echo "<div class='row'>";

         echo "<input type='hidden' name='pers-reg' value='".trim($empleado)."' />";
         echo "<input type='hidden' name='correo-reg' value='".trim($correo)."' />";

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

         echo "<div class='col-md-4 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Cargo <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='car-reg' disabled='disabled' placeholder='' required='required' value='".$cargos."' />";
         echo "</div>";
         echo "</br>";

         echo "<div class='col-md-4 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Empleado <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='qr_nom' disabled='disabled' placeholder='' required='required' value='".$nombres."' />";
         echo "</div>";

         echo "<div class='col-md-4 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Correo <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='qr_nom' disabled='disabled' placeholder='' required='required' value='".trim($correo)."' />";
         echo "</div>";

         echo "</div>";


         echo "</br>";



      }else {

         echo "<div class='row'>";

         echo "<input type='hidden' name='pers-reg' value='".trim($empleado)."' />";
         echo "<input type='hidden' name='correo-reg' value='".trim($correo)."' />";

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

         echo "<div class='col-md-4 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Cargo <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='car-reg' disabled='disabled' placeholder='' required='required' value='".$cargos."' />";
         echo "</div>";
         echo "</br>";

         echo "<div class='col-md-4 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Empleado <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='qr_nom' disabled='disabled' placeholder='' required='required' value='".$nombres."' />";
         echo "</div>";

         echo "<div class='col-md-4 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Correo <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='qr_nom' disabled='disabled' placeholder='' required='required' value='".trim($correo)."' />";
         echo "</div>";

         echo "</div>";


         echo "</br>";


      }
    
 ?>