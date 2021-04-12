<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/empleadosControlador.php";
		$insEm = new empleadosControlador();

		if (isset($_POST['cedula-reg']) && isset($_POST['nombres-reg']) && isset($_POST['apellidos-reg']) && isset($_POST['telefono-reg']) && isset($_POST['celular-reg']) && isset($_POST['correo-reg']) && isset($_POST['fecha-reg']) && isset($_POST['emp-reg']) && isset($_POST['dep-reg']) && isset($_POST['car-reg']) && isset($_POST['estado-reg'])) {
			echo $insEm->agregar_empleados_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo-up']) && isset($_POST['nombres-up'])) {
			echo $insEm->actualizar_empleados_controlador();
		}

	