<?php //no se cierra si es codigo php puro
require_once "./core/configGeneral.php";
//require "vistas/plantilla.php";  
require_once "./controladores/vistasControlador.php";

	$plantilla = new vistasControlador();
	$plantilla->obtener_plantilla_controlador();