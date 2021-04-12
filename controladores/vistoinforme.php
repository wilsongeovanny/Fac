 <?php
 require_once "../core/Consult.php";
 require_once "../vistas/contenidos/phpqrcode/qrlib.php";


      //SI SE ENCUENTRA EN LA BD LA CÉDULA
      $codigo=$_GET['empleadocedula'];
      $consultar=forced::ejecutar_consulta_simple("SELECT  * FROM empleados WHERE empleadocedula='$codigo'");
      $consu=$consultar->fetch();
      $empcod=$consu['empleadocodigo'];

      $buscador=forced::ejecutar_consulta_simple("SELECT *,T1.empleadocodigo FROM empleados as T1, cargo as T2, departemento as T3, empresa as T4 WHERE T1.empleadocodigo='$empcod' AND T1.cargocodigo=T2.cargocodigo AND T2.departamentocodigo=T3.departamentocodigo AND T3.empresacodigo=T4.empresacodigo");
      $Datos=$buscador->fetch();
      $dni=$Datos['empleadocodigo'];
      $nombres=trim($Datos['empleadonombres'])." ".trim($Datos['empleadoapellidos']);
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
        $dni=$Datos['empleadocodigo'];
        $nombres=trim($Datos['empleadonombres'])." ".trim($Datos['empleadoapellidos']);
        $cargos=$Datos['cargonombre'];
        $departementos=$Datos['departamentonombre'];
        $empresa=$Datos['empresanombre'];


        
         echo "<div class='row'>";

         echo "<input type='hidden' name='vnombre-up' value='".$dni."' />";

         echo "<div style='display: block; margin-left: auto; margin-right: auto;' class='col-md-4 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Visto bueno por: <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='qr_nom' disabled='disabled' placeholder='' required='required' value='".$nombres."' />";
         echo "</div>";

         echo "</div>";

         echo "<br>";



      }else {
     

         echo "<div class='row'>";

         echo "<input type='hidden' name='vnombre-up' value='".$dni."' />";

         echo "<div style='display: block; margin-left: auto; margin-right: auto;' class='col-md-4 col-sm-12'  form-group'>";
         echo "<label class='label-align'>Visto bueno por: <span class='required'>:</span></label> ";
         echo "<input class='form-control' name='qr_nom' disabled='disabled' placeholder='' required='required' value='".$nombres."' />";
         echo "</div>";

         echo "</div>";

         echo "<br>";


      }
    
 ?>