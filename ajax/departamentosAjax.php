<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/departamentosControlador.php";
		$insEm = new departamentosControlador();

		if (isset($_POST['opcion-reg']) && isset($_POST['nombre-reg'])) {
			echo $insEm->agregar_departamentos_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo']) && isset($_POST['codigo-up']) && isset($_POST['opcion-up']) && isset($_POST['nombre-up'])) {
			echo $insEm->actualizar_departamentos_controlador();
		}

	