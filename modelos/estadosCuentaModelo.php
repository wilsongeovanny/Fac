<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class estadosCuentaModelo extends mainModel{

		//Funcipon para registrar los estados del administrador
		protected function agregar_estadosCuenta_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO estado_cuenta(estadocuentacodigo,estadocuentanombre) VALUES(:CODIGO,:OPCION)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":OPCION",$datos['OPCION']);
			$query->execute();
			return $query;
		}

		protected function datos_estadosCuenta_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM estado_cuenta WHERE estadocuentacodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT estadocuentacodigo FROM estado_cuenta");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT estadocuentacodigo,estadocuentanombre FROM estado_cuenta ORDER BY estadocuentanombre ASC");
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


		protected function actualizar_estadosCuenta_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE estado_cuenta SET estadocuentanombre=:OPCION WHERE estadocuentacodigo=:CODIGO");
			$query->bindParam("OPCION",$datos['OPCION']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}