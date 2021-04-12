<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/estadosHardwareControlador.php";
		$insEm = new estadosHardwareControlador();

		if (isset($_POST['opcion-reg'])) {
			echo $insEm->agregar_estadosHardware_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo']) && isset($_POST['codigo-up']) && isset($_POST['opcion-up'])) {
			echo $insEm->actualizar_estadosHardware_controlador();
		}

	