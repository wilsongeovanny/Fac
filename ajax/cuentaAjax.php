<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/administradorControlador.php";
		$insEm = new administradorControlador();

		if (isset($_POST['admin'])) {
			echo $insEm->agregar_administrador_controlador($_FILES);
		}

		/*if (isset($_POST['foto-reg']) && isset($_POST['estado-reg']) && isset($_POST['roles-reg']) && isset($_POST['pers-reg']) && isset($_POST['usuario-reg']) && isset($_POST['perfil-reg']) && isset($_POST['clave-reg']) && isset($_POST['clave1-reg'])) {
			echo $insEm->agregar_administrador_controlador($_FILES);
		}*/

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo'])) {
			echo $insEm->actualizar_administrador_controlador($_FILES);
		}

	