<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/privilegiosControlador.php";
		$insEm = new privilegiosControlador();

		if (isset($_POST['modulo-reg']) && isset($_POST['menu-reg'])) {
			echo $insEm->agregar_privilegios_controlador();
		}

		if (isset($_POST['codigo-up']) && isset($_POST['modulo-up']) && isset($_POST['menu-up'])) {
			echo $insEm->actualizar_privilegios_controlador();
		}

	