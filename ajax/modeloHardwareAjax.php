<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/modelosHardwareControlador.php";
		$insEm = new modelosHardwareControlador();

		if (isset($_POST['tipo-reg']) &&isset($_POST['marca-reg'])) {
			echo $insEm->agregar_modelosHardware_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo']) && isset($_POST['codigo-up']) && isset($_POST['tipo-up']) && isset($_POST['marca-reg']) && isset($_POST['nombre-up'])) {
			echo $insEm->actualizar_modelosHardware_controlador();
		}

	