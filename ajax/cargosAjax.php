<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/cargosControlador.php";
		$insEm = new cargosControlador();

		if (isset($_POST['emp-reg']) && isset($_POST['dep-reg']) && isset($_POST['nombre-reg'])) {
			echo $insEm->agregar_cargos_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo-up']) && isset($_POST['nombre-up']) && isset($_POST['emp-up']) && isset($_POST['dep-reg']) && isset($_POST['nombre-up'])) {
			echo $insEm->actualizar_cargos_controlador();
		}

	