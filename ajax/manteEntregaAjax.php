<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	

		require_once "../controladores/manteEntregarControlador.php";
		$insEm = new manteEntregarControlador();

		if (!isset($_POST['depa-reg'])) {
			//alert('HOLAS');
			echo $insEm->agregar_manteEntregar_controlador();
		}

		/*if (isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])) {
			echo $insEm->eliminar_empresa_controlador();
		}*/

		if (isset($_POST['codigo-up']) && isset($_POST['emple-up'])) {
			echo $insEm->actualizar_manteEntregar_controlador();
		}

	