<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/rolesControlador.php";
		$insEm = new rolesControlador();

		if (isset($_POST['nombre-reg']) && isset($_POST['descripcion-reg']) && isset($_POST['opcion-reg']) && isset($_POST['privilegios'])) {
			echo $insEm->agregar_roles_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo']) && isset($_POST['codigo-up']) && isset($_POST['nombre-up']) && isset($_POST['descripcion-up']) && isset($_POST['opcion-up']) && isset($_POST['detemrg'])) {
			echo $insEm->actualizar_roles_controlador();
		}

