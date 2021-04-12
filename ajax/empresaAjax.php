<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/empresaControlador.php";
		$insEm = new empresaControlador();

		if (isset($_POST['ruc-reg']) && isset($_POST['nombre-reg']) && isset($_POST['telefono-reg']) && isset($_POST['correo-reg']) && isset($_POST['direccion-reg'])) {
			echo $insEm->agregar_empresa_controlador($_FILES);
		}

		if (isset($_POST['codigo']) && isset($_POST['nombre-up']) && isset($_POST['ruc-up']) && isset($_POST['nombre-up']) && isset($_POST['telefono-up']) && isset($_POST['correo-up']) && isset($_POST['direccion-up'])) {
			echo $insEm->actualizar_empresa_controlador($_FILES);
		}

	