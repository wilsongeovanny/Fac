<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class tiposMantenimientoModelo extends mainModel{

		//Función para registrar los tipos de mantenimiento
		protected function agregar_tiposMantenimiento_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO tipo_mantenimiento(tipomantecodigo,tipomantenombre) VALUES(:CODIGO,:OPCION)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":OPCION",$datos['OPCION']);
			$query->execute();
			return $query;
		}

		protected function datos_tiposMantenimiento_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM tipo_mantenimiento WHERE tipomantecodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT tipomantecodigo FROM tipo_mantenimiento");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT tipomantecodigo,tipomantenombre FROM tipo_mantenimiento ORDER BY tipomantenombre ASC");
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


		protected function actualizar_tiposMantenimiento_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE tipo_mantenimiento SET tipomantenombre=:OPCION WHERE tipomantecodigo=:CODIGO");
			$query->bindParam("OPCION",$datos['OPCION']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}