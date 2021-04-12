<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/estadosCuentaControlador.php";
		$insEm = new estadosCuentaControlador();

		if (isset($_POST['opcion-reg'])) {
			echo $insEm->agregar_estadosCuenta_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo-up']) && isset($_POST['opcion-up'])) {
			echo $insEm->actualizar_estadosCuenta_controlador();
		}

	