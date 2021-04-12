<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class estadosEmpleadoModelo extends mainModel{
		//Función para registrar los estados del empleado
		protected function agregar_estadosEmpleado_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO estado_empleado(estadoempleadocodigo,estadoempleadonombre) VALUES(:CODIGO,:OPCION)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":OPCION",$datos['OPCION']);
			$query->execute();
			return $query;
		}
		
		protected function datos_estadosEmpleado_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM estado_empleado WHERE estadoempleadocodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT estadoempleadocodigo FROM estado_empleado");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT estadoempleadocodigo,estadoempleadonombre FROM estado_empleado ORDER BY estadoempleadonombre ASC");
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


		protected function actualizar_estadosEmpleado_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE estado_empleado SET estadoempleadonombre=:OPCION WHERE estadoempleadocodigo=:CODIGO");
			$query->bindParam("OPCION",$datos['OPCION']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}