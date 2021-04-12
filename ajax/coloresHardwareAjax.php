	<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/coloresHardwareControlador.php";
		$insEm = new coloresHardwareControlador();

		if (isset($_POST['nombre-reg'])) {
			echo $insEm->agregar_coloresHardware_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo']) && isset($_POST['codigo-up']) && isset($_POST['nombre-up'])) {
			echo $insEm->actualizar_coloresHardware_controlador();
		}

	