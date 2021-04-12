<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class estadosHardwareModelo extends mainModel{


		//Función para la asignación o reasignación de hardware
		protected function agregar_estadosHardware_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO estado_asignacion_hardware(estadoasigharcodigo,estadoasigharnombre) VALUES(:CODIGO,:OPCION)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":OPCION",$datos['OPCION']);
			$query->execute();
			return $query;
		}

		protected function datos_estadosHardware_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM estado_asignacion_hardware WHERE estadoasigharcodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT estadoasigharcodigo FROM estado_asignacion_hardware");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT estadoasigharcodigo,estadoasigharnombre FROM estado_asignacion_hardware ORDER BY estadoasigharnombre ASC");
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


		protected function actualizar_estadosHardware_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE estado_asignacion_hardware SET estadoasigharnombre=:OPCION WHERE estadoasigharcodigo=:CODIGO");
			$query->bindParam("OPCION",$datos['OPCION']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}