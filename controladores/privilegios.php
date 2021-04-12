<?php
require_once "../core/Consult.php";
//require_once('../connections/conexion.php');

if($_POST["_token"]==="procesar_pagos"){

	$contador=0;
	$arreglo_cadena_privilegios = $_POST["cadena"];

	echo "<input type='hidden' name='detalles' value='".$arreglo_cadena_privilegios."' />";

}

/*if($_POST["_token"]==="procesar_pagos"){

	$contador=0;
	$arreglo_cadena_privilegios = explode("&&", $_POST["cadena"]);
	for ($i=0; $i <count($arreglo_cadena_privilegios) ; $i++) { 

		$insertaud=forced::ejecutar_consulta_simple("INSERT INTO privilegios(CODIGOPRIVILEGIOS, MODULOCODIGO) VALUES ('ssssss[$i]','$arreglo_cadena_privilegios[$i]')");

		if ($insertaud->rowCount()>=1) {


			echo "<input type='text' name='contador-reg' value='sddfdsfgffgfgfgfg' />";

		}

	}

}*/

?>


