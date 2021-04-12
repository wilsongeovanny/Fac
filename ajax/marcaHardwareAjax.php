<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/marcasHardwareControlador.php";
		$insEm = new marcasHardwareControlador();

		if (isset($_POST['opcion-reg']) &&isset($_POST['nombre-reg'])) {
			echo $insEm->agregar_marcasHardware_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo-up']) && isset($_POST['codigo-up']) && isset($_POST['opcion-up']) && isset($_POST['nombre-up'])) {
			echo $insEm->actualizar_marcasHardware_controlador();
		}

	