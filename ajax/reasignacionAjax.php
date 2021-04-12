<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/reasignacionControlador.php";
		$insEm = new reasignacionControlador();

		if (isset($_POST['codigo-up'])) {
			echo $insEm->actualizar_hardware_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		/*if (isset($_POST['codigo-up']) && isset($_POST['nombre-up'])) {
			echo $insEm->actualizar_asignacion_controlador();
		}*/

