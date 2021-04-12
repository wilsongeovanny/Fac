<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";

		require_once "../controladores/loginControlador.php";
		$logout= new loginControlador();
		echo $logout->cerrar_sesion_controlador();
