<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/infoingresoHardControlador.php";
		$insEm = new infoingresoHardControlador();

		if (isset($_POST['tema-reg']) && isset($_POST['servicio-reg'])) {
			echo $insEm->agregar_infoingresoHard_controlador();
			//echo $insEm->agregar_infoingresoHard_controlador();
		}


		if (isset($_POST['codigo-up']) && isset($_POST['tema-up'])) {
			echo $insEm->actualizar_informe_controlador();
		}


		if (isset($_POST['codigo-up']) && isset($_POST['titulo-up'])) {
			echo $insEm->actualizar_hardware_controlador();
		}

