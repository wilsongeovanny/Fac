<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/perfilControlador.php";
		$insEm = new perfilControlador();

		if (isset($_POST['nombre-reg'])) {
			echo $insEm->agregar_perfil_controlador();
		}

		if (isset($_POST['codigo-up']) && isset($_POST['nombre-up'])) {
			echo $insEm->actualizar_perfil_controlador();
		}

	