 <?php
 require_once "../core/Consult.php";
 require_once "../vistas/contenidos/phpqrcode/qrlib.php";


      //SI SE ENCUENTRA EN LA BD LA CÉDULA
      $codigo=$_GET['EMPLEADOCEDULA'];
      $consultar=forced::ejecutar_consulta_simple("SELECT  * FROM empleados WHERE EMPLEADOCEDULA='$codigo'");
      $consu=$consultar->fetch();
      $empcod=$consu['EMPLEADOCODIGO'];

      $buscador=forced::ejecutar_consulta_simple("SELECT SQL_CALC_FOUND_ROWS *,T1.EMPLEADOCODIGO FROM empleados as T1, cargo as T2, departemento as T3, empresa as T4 WHERE T1.EMPLEADOCODIGO='$empcod' AND T1.CARGOCODIGO=T2.CARGOCODIGO AND T2.DEPARTAMENTOCODIGO=T3.DEPARTAMENTOCODIGO AND T3.EMPRESACODIGO=T4.EMPRESACODIGO");
      $Datos=$buscador->fetch();
      $dni=$Datos['EMPLEADOCODIGO'];
      $nombres=$Datos['EMPLEADOAPELLIDOS']." ".$Datos['EMPLEADONOMBRES'];
      $cargos=$Datos['CARGONOMBRE'];
      $departementos=$Datos['DEPARTAMENTONOMBRE'];
      $empresa=$Datos['EMPRESANOMBRE'];


      
     


      //SI NO SE ENCUENTRA EN LA BD CONCATENAR CON 0 PARA PORDER ENCONTRARLO
      if ($buscador->rowCount()<=0) {
        $cero=0;
        $concatenar= $cero."".$_GET['EMPLEADOCEDULA'];
        $consultar=forced::ejecutar_consulta_simple("SELECT  * FROM empleados WHERE EMPLEADOCEDULA='$concatenar'");
        $consu=$consultar->fetch();
        $empcod=$consu['EMPLEADOCODIGO'];

        $buscador=forced::ejecutar_consulta_simple("SELECT SQL_CALC_FOUND_ROWS *,T1.EMPLEADOCODIGO FROM empleados as T1, cargo as T2, departemento as T3, empresa as T4 WHERE T1.EMPLEADOCODIGO='$empcod' AND T1.CARGOCODIGO=T2.CARGOCODIGO AND T2.DEPARTAMENTOCODIGO=T3.DEPARTAMENTOCODIGO AND T3.EMPRESACODIGO=T4.EMPRESACODIGO");
        $Datos=$buscador->fetch();
        $dni=$Datos['EMPLEADOCODIGO'];
        $nombres=$Datos['EMPLEADOAPELLIDOS']." ".$Datos['EMPLEADONOMBRES'];
        $cargos=$Datos['CARGONOMBRE'];
        $departementos=$Datos['DEPARTAMENTONOMBRE'];
        $empresa=$Datos['EMPRESANOMBRE'];


        
         echo "<div class='row'>";

         echo "<input type='hidden' name='vnombre-reg' value='".$dni."' />";

         echo "<div style='display: block; margin-left: auto; margin-right: auto;' class='col-md-4 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Visto bueno por: <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='qr_nom' disabled='disabled' placeholder='' required='required' value='".$nombres."' />";
         echo "</div>";

         echo "</div>";

         echo "<br>";



      }else {
     

         echo "<div class='row'>";

         echo "<input type='hidden' name='vnombre-reg' value='".$dni."' />";

         echo "<div style='display: block; margin-left: auto; margin-right: auto;' class='col-md-4 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Visto bueno por: <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='qr_nom' disabled='disabled' placeholder='' required='required' value='".$nombres."' />";
         echo "</div>";

         echo "</div>";

         echo "<br>";


      }
    
 ?>