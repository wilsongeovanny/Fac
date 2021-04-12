<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class estadosHardwarevidaModelo extends mainModel{

		//Función para registrar los estados de hardware
		protected function agregar_estadosHardwarevida_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO estado_hardware(estadohardwarecodigo,estadohardwarenombre) VALUES(:CODIGO,:OPCION)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":OPCION",$datos['OPCION']);
			$query->execute();
			return $query;
		}

		protected function datos_estadosHardwarevida_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM estado_hardware WHERE estadohardwarecodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT estadohardwarecodigo FROM estado_hardware");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT estadohardwarecodigo,estadohardwarenombre FROM estado_hardware ORDER BY estadohardwarenombre ASC");
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


		protected function actualizar_estadosHardwarevida_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE estado_hardware SET estadohardwarenombre=:OPCION WHERE estadohardwarecodigo=:CODIGO");
			$query->bindParam("OPCION",$datos['OPCION']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}