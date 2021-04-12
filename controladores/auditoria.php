
<?php
require_once "../core/Consult.php";
require_once "../vistas/contenidos/phpqrcode/qrlib.php";

$estados=$_GET['estado'];
$Consultaestados=forced::ejecutar_consulta_simple("SELECT * FROM estado_empleado WHERE estadoempleadocodigo='$estados'");
$resultados=$Consultaestados->fetch();
$veri=$resultados['estadoempleadonombre'];
if (trim($veri)=='DESACTIVO') {
    # code...

    //SELECT * FROM hardware WHERE empleadocedula='0501478485' AND estadohardwarecodigo='ESTHARD75981311'

      //SI SE ENCUENTRA EN LA BD LA CÉDULA
  $codigo=$_GET['empleadocedula'];
  $consultar=forced::ejecutar_consulta_simple("SELECT  * FROM empleados WHERE empleadocedula='$codigo'");
      $consu=$consultar->fetch();
      $empcod=$consu['empleadocodigo'];
      //$serie=$_GET['SERIE'];
  $buscador=forced::ejecutar_consulta_simple("SELECT *,T1.empleadocodigo FROM empleados as T1, cargo as T2, departemento as T3, empresa as T4 WHERE T1.empleadocodigo='$empcod' AND T1.cargocodigo=T2.cargocodigo AND T2.departamentocodigo=T3.departamentocodigo AND T3.empresacodigo=T4.empresacodigo");
  $Datos=$buscador->fetch();
  $dni=$Datos['empleadocodigo'];
  if ($buscador->rowCount()<=0) {
    $cero=0;
    $concatenar= $cero."".$_GET['empleadocedula'];
    $consultar=forced::ejecutar_consulta_simple("SELECT  * FROM empleados WHERE empleadocedula='$concatenar'");
      $consu=$consultar->fetch();
      $empcod=$consu['empleadocodigo'];
    $buscador=forced::ejecutar_consulta_simple("SELECT *,T1.empleadocodigo FROM empleados as T1, cargo as T2, departemento as T3, empresa as T4 WHERE T1.empleadocodigo='$empcod' AND T1.cargocodigo=T2.cargocodigo AND T2.departamentocodigo=T3.departamentocodigo AND T3.empresacodigo=T4.empresacodigo");
    $Datos=$buscador->fetch();
    $dni=$Datos['empleadocodigo'];









    $esthard=forced::ejecutar_consulta_simple("SELECT * FROM estado_hardware WHERE estadohardwarenombre='ACTIVO'");
    $busqueda1=$esthard->fetch();
    $cod1=$busqueda1['estadohardwarecodigo'];


    $estasig=forced::ejecutar_consulta_simple("SELECT * FROM estado_asignacion_hardware WHERE estadoasigharnombre='ASIGNADO'");
    $busqueda2=$estasig->fetch();
    $cod2=$busqueda2['estadoasigharcodigo'];



    //$verihar=forced::ejecutar_consulta_simple("SELECT * FROM Hardware WHERE empleadocedula='$dni' AND estadohardwarecodigo='$cod1'");
    $verihar=forced::ejecutar_consulta_simple("SELECT *,T1.hardwareqr FROM hardware as T1, empleados as T2, estado_hardware as T3, hardware_ingreso as T4, estado_asignacion_hardware as T5, estado_info_hardware as T6, tipo_hardware as T7, marca_hardware as T8, modelo_hardware as T9, color_hardware as T10, informe_ingreso_hardware as T11 WHERE (T1.empleadocodigo=T2.empleadocodigo AND T2.empleadocodigo='$dni' AND T1.estadohardwarecodigo=T3.estadohardwarecodigo AND T3.estadohardwarenombre='ACTIVO' AND T1.hiserie=T4.hiserie AND T4.estadoasigharcodigo=T5.estadoasigharcodigo AND T5.estadoasigharnombre='ASIGNADO' AND T4.estadoinfoharcodigo=T6.estadoinfoharcodigo AND T6.estadoinfoharnombre='APROBADO' AND T4.tipohardwarecodigo=T7.tipohardwarecodigo AND T4.marcahardwarecodigo=T8.marcahardwarecodigo AND T4.modelohardwarecodigo=T9.modelohardwarecodigo AND T4.colorhardwarecodigo=T10.colorhardwarecodigo AND T4.icodigo=T11.icodigo) OR (T1.empleadocodigo=T2.empleadocodigo AND T2.empleadocodigo='$dni' AND T1.estadohardwarecodigo=T3.estadohardwarecodigo AND T3.estadohardwarenombre='ACTIVO' AND T1.hiserie=T4.hiserie AND T4.estadoasigharcodigo=T5.estadoasigharcodigo AND T5.estadoasigharnombre='REASIGNADO' AND T4.estadoinfoharcodigo=T6.estadoinfoharcodigo AND T6.estadoinfoharnombre='APROBADO' AND T4.tipohardwarecodigo=T7.tipohardwarecodigo AND T4.marcahardwarecodigo=T8.marcahardwarecodigo AND T4.modelohardwarecodigo=T9.modelohardwarecodigo AND T4.colorhardwarecodigo=T10.colorhardwarecodigo AND T4.icodigo=T11.icodigo)");
    if ($verihar->rowCount()>=1) {

      echo "<div class='col-md-12 col-sm-12'  form-group'>";
      echo "<h6 class='StepTitle'>Hardware que fue asignado al empleado</h6><br>";
      echo "</div>";
      $datos= $verihar->fetchAll();

      foreach ($datos as $rows) {
        echo "<div class='col-md-3 col-sm-12'  form-group'>";

        echo "<input type='hidden' name='pers-reg' value='".$dni."' />";
        echo '<img name="nuevo_input"  title=""../imagenes_qr/'.$rows['hiimagenqr'].'" style="width:150px; height:150px; border: 6px solid black; display: block; margin-left: auto; margin-right: auto;" style="width:210px; height:210;" src="../imagenes_qr/'.$rows['hiimagenqr'].'" />';
        echo "</div>";

      }
      echo "</br></br></br></br></br></br></br></br></br></br>";

      echo "<div class='col-md-12 col-sm-12'  form-group'>";
      echo "<h6 class='StepTitle'>Información para la auditoria</h6><br>";
      echo "</div>";

      echo "<input type='hidden' name='pers-reg' value='".$dni."' />";
      echo "<input type='hidden' name='estado-up' value='".$estados."' />";
      echo "<input type='hidden' name='veri-up' value='".$veri."' />";
      echo "<input type='hidden' name='pers-reg' value='".$cod1."' />";

      echo "<div class='col-md-6 col-sm-12'  form-group'>";
      echo "<label class='label-align'>Tema<span class='required'>:</span></label> ";
      echo "<input class='form-control' type='text' name='tema-reg' placeholder='TEMA' value='' />";
      echo "</div>";
      echo "</br></br></br></br>";

      echo "<div class='col-md-6 col-sm-12'  form-group'>";
      echo "<label class='label-align'>Fecha<span class='required'>:</span></label> ";
      echo "<input class='form-control' type='date' name='aufe-reg' placeholder='' value='' />";
      echo "</div>";
      echo "</br>";

      echo "<div class='col-md-12 col-sm-12'  form-group'>";
      echo "<label class='label-align'>Descripción <span class='required'>:</span></label> ";
      echo "<textarea class='form-control' name='descri-up' data-parsley-trigger='keyup' data-parsley-minlength='20' data-parsley-maxlength='100' data-parsley-minlength-message='Come on! You need to enter at least a 20 caracters long comment..' data-parsley-validation-threshold='10' placeholder='DESCRIPCION'></textarea>";
      echo "</div>";
      echo "</br>";



    }else{
      echo "<input type='text' name='estado-up' value='".$estados."' />";
    }







  }else {

    $esthard=forced::ejecutar_consulta_simple("SELECT * FROM estado_hardware WHERE estadohardwarenombre='ACTIVO'");
    $busqueda1=$esthard->fetch();
    $cod1=$busqueda1['estadohardwarecodigo'];


    $estasig=forced::ejecutar_consulta_simple("SELECT * FROM estado_asignacion_hardware WHERE estadoasigharnombre='ASIGNADO'");
    $busqueda2=$estasig->fetch();
    $cod2=$busqueda2['estadoasigharcodigo'];



    //$verihar=forced::ejecutar_consulta_simple("SELECT * FROM Hardware WHERE empleadocedula='$dni' AND estadohardwarecodigo='$cod1'");

    $ami="SELECT COUNT(*) hardware FROM hardware as T1, empleados as T2, estado_hardware as T3, hardware_ingreso as T4, estado_asignacion_hardware as T5, estado_info_hardware as T6, tipo_hardware as T7, marca_hardware as T8, modelo_hardware as T9, color_hardware as T10, informe_ingreso_hardware as T11 WHERE (T1.empleadocodigo=T2.empleadocodigo AND T2.empleadocodigo='$dni' AND T1.estadohardwarecodigo=T3.estadohardwarecodigo AND T3.estadohardwarenombre='ACTIVO' AND T1.hiserie=T4.hiserie AND T4.estadoasigharcodigo=T5.estadoasigharcodigo AND T5.estadoasigharnombre='ASIGNADO' AND T4.estadoinfoharcodigo=T6.estadoinfoharcodigo AND T6.estadoinfoharnombre='APROBADO' AND T4.tipohardwarecodigo=T7.tipohardwarecodigo AND T4.marcahardwarecodigo=T8.marcahardwarecodigo AND T4.modelohardwarecodigo=T9.modelohardwarecodigo AND T4.colorhardwarecodigo=T10.colorhardwarecodigo AND T4.icodigo=T11.icodigo) OR (T1.empleadocodigo=T2.empleadocodigo AND T2.empleadocodigo='$dni' AND T1.estadohardwarecodigo=T3.estadohardwarecodigo AND T3.estadohardwarenombre='ACTIVO' AND T1.hiserie=T4.hiserie AND T4.estadoasigharcodigo=T5.estadoasigharcodigo AND T5.estadoasigharnombre='REASIGNADO' AND T4.estadoinfoharcodigo=T6.estadoinfoharcodigo AND T6.estadoinfoharnombre='APROBADO' AND T4.tipohardwarecodigo=T7.tipohardwarecodigo AND T4.marcahardwarecodigo=T8.marcahardwarecodigo AND T4.modelohardwarecodigo=T9.modelohardwarecodigo AND T4.colorhardwarecodigo=T10.colorhardwarecodigo AND T4.icodigo=T11.icodigo)";
    //$fila = $ami->fetch_assoc();


    $conexion = forced::conectar();

    $fila = $conexion->query($ami);
    $fila= $fila->fetchColumn();

    //$datos=

    if ($fila>=1) {


      $verihar=forced::ejecutar_consulta_simple("SELECT *,T1.hardwareqr FROM hardware as T1, empleados as T2, estado_hardware as T3, hardware_ingreso as T4, estado_asignacion_hardware as T5, estado_info_hardware as T6, tipo_hardware as T7, marca_hardware as T8, modelo_hardware as T9, color_hardware as T10, informe_ingreso_hardware as T11 WHERE (T1.empleadocodigo=T2.empleadocodigo AND T2.empleadocodigo='$dni' AND T1.estadohardwarecodigo=T3.estadohardwarecodigo AND T3.estadohardwarenombre='ACTIVO' AND T1.hiserie=T4.hiserie AND T4.estadoasigharcodigo=T5.estadoasigharcodigo AND T5.estadoasigharnombre='ASIGNADO' AND T4.estadoinfoharcodigo=T6.estadoinfoharcodigo AND T6.estadoinfoharnombre='APROBADO' AND T4.tipohardwarecodigo=T7.tipohardwarecodigo AND T4.marcahardwarecodigo=T8.marcahardwarecodigo AND T4.modelohardwarecodigo=T9.modelohardwarecodigo AND T4.colorhardwarecodigo=T10.colorhardwarecodigo AND T4.icodigo=T11.icodigo) OR (T1.empleadocodigo=T2.empleadocodigo AND T2.empleadocodigo='$dni' AND T1.estadohardwarecodigo=T3.estadohardwarecodigo AND T3.estadohardwarenombre='ACTIVO' AND T1.hiserie=T4.hiserie AND T4.estadoasigharcodigo=T5.estadoasigharcodigo AND T5.estadoasigharnombre='REASIGNADO' AND T4.estadoinfoharcodigo=T6.estadoinfoharcodigo AND T6.estadoinfoharnombre='APROBADO' AND T4.tipohardwarecodigo=T7.tipohardwarecodigo AND T4.marcahardwarecodigo=T8.marcahardwarecodigo AND T4.modelohardwarecodigo=T9.modelohardwarecodigo AND T4.colorhardwarecodigo=T10.colorhardwarecodigo AND T4.icodigo=T11.icodigo)");

      echo "<div class='col-md-12 col-sm-12' form-group'>";
      echo "<h6 class='StepTitle'>Hardware que fue asignado al empleado</h6><br>";
      echo "</div>";
      $data= $verihar->fetchAll();



      $contador=0;
      foreach ($data as $rows) {
        $contador=$contador+1;
        echo "<div class='col-md-3 col-sm-12'  form-group'>";

        echo "<input type='hidden' name='pers-reg' value='".$dni."' />";
        echo '<img name="nuevo_input"  title=""../imagenes_qr/'.$rows['hiimagenqr'].'" style="width:150px; height:150px; border: 6px solid black; display: block; margin-left: auto; margin-right: auto;" style="width:210px; height:210;" src="../imagenes_qr/'.$rows['hiimagenqr'].'" />';
        echo "</div>";

      }

      echo "</br></br></br></br></br></br></br></br></br></br>";

      echo "<div class='col-md-12 col-sm-12'  form-group'>";
      echo "<h6 class='StepTitle'>Información para la auditoria</h6><br>";
      echo "</div>";

      echo "<input type='hidden' name='pers-reg' value='".$dni."' />";
      echo "<input type='hidden' name='estado-up' value='".$estados."' />";
      echo "<input type='hidden' name='veri-up' value='".$veri."' />";
      echo "<input type='hidden' name='pers-reg' value='".$cod1."' />";

      echo "<div class='col-md-6 col-sm-12'  form-group'>";
      echo "<label class='label-align'>Tema<span class='required'>:</span></label> ";
      echo "<input class='form-control' type='text' name='tema-reg' placeholder='TEMA' value='' />";
      echo "</div>";
      echo "</br></br></br></br>";

      echo "<div class='col-md-6 col-sm-12'  form-group'>";
      echo "<label class='label-align'>Fecha<span class='required'>:</span></label> ";
      echo "<input class='form-control' type='date' name='aufe-reg' placeholder='' value='' />";
      echo "</div>";
      echo "</br>";

      echo "<div class='col-md-12 col-sm-12'  form-group'>";
      echo "<label class='label-align'>Descripción <span class='required'>:</span></label> ";
      echo "<textarea class='form-control' name='descri-up' data-parsley-trigger='keyup' data-parsley-minlength='20' data-parsley-maxlength='100' data-parsley-minlength-message='Come on! You need to enter at least a 20 caracters long comment..' data-parsley-validation-threshold='10' placeholder='DESCRIPCION'></textarea>";
      echo "</div>";
      echo "</br>";



    }else{
      echo "<input type='hidden' name='estado-up' value='".$estados."' />";
    }
  }

}elseif(trim($veri)=='ACTIVO'){
  echo "<input type='hidden' name='estado-up' value='".$estados."' />";
}

?>  
