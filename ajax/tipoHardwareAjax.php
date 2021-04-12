<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/tipoHardwareControlador.php";
		$insEm = new tipoHardwareControlador();

		if (isset($_POST['nombre-reg'])) {
			echo $insEm->agregar_tipoHardware_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo-up']) && isset($_POST['codigo-up']) && isset($_POST['nombre-up']) && isset($_POST['nombre-up'])) {
			echo $insEm->actualizar_tipoHardware_controlador();
		}

	