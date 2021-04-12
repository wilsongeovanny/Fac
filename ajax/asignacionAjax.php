<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/asignacionControlador.php";
		$insEm = new asignacionControlador();

		if (isset($_POST['codigo-up'])) {
			echo $insEm->agregar_asignacion_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		/*if (isset($_POST['codigo-up']) && isset($_POST['nombre-up'])) {
			echo $insEm->actualizar_asignacion_controlador();
		}*/

