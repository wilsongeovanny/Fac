<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class estadosHardwareingresoModelo extends mainModel{

		//Función para registrar los estados de ingreso de hardware
		protected function agregar_estadosHardwareingreso_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO estado_info_hardware(estadoinfoharcodigo,estadoinfoharnombre) VALUES(:CODIGO,:OPCION)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":OPCION",$datos['OPCION']);
			$query->execute();
			return $query;
		}

		protected function datos_estadosHardwareingreso_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM estado_info_hardware WHERE estadoinfoharcodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT estadoinfoharcodigo FROM estado_info_hardware");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT estadoinfoharcodigo,estadoinfoharnombre FROM estado_info_hardware ORDER BY estadoinfoharnombre ASC");
			}
			$query->execute();
			return $query;
		}

		/*protected function eliminar_empresa_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM empresa WHERE EmpresaCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}*/


		protected function actualizar_estadosHardwareingreso_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE estado_info_hardware SET estadoinfoharnombre=:OPCION WHERE estadoinfoharcodigo=:CODIGO");
			$query->bindParam("OPCION",$datos['OPCION']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}