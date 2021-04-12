<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/manteIngresarControlador.php";
		$insEm = new manteIngresarControlador();

		if (!isset($_POST['depa-reg'])) {
			//alert('HOLAS');
			echo $insEm->agregar_manteIngresar_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo-up']) && isset($_POST['emple-up'])) {
			echo $insEm->actualizar_manteIngresar_controlador();
		}

	