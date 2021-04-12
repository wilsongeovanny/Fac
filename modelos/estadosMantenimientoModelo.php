<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class estadosMantenimientoModelo extends mainModel{

		//Función para registrar estados de mantenimiento
		protected function agregar_estadosMantenimiento_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO estado_mantenimiento(estadomantenimientocodigo,estadomantenimientonombre) VALUES(:CODIGO,:OPCION)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":OPCION",$datos['OPCION']);
			$query->execute();
			return $query;
		}

		protected function datos_estadosMantenimiento_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM estado_mantenimiento WHERE estadomantenimientocodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT estadomantenimientocodigo FROM estado_mantenimiento");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT estadomantenimientocodigo,estadomantenimientonombre FROM estado_mantenimiento ORDER BY estadomantenimientonombre ASC");
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


		protected function actualizar_estadosMantenimiento_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE estado_mantenimiento SET estadomantenimientonombre=:OPCION WHERE estadomantenimientocodigo=:CODIGO");
			$query->bindParam("OPCION",$datos['OPCION']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}