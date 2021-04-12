<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class modulosModelo extends mainModel{

		//Función para registrar los modulos del sistema
		protected function agregar_modulos_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO modulo(modulocodigo,modulonombre) VALUES(:CODIGO,:NOMBRE)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":NOMBRE",$datos['NOMBRE']);
			$query->execute();
			return $query;
		}

		protected function datos_modulos_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM modulo WHERE modulocodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT modulocodigo FROM modulo");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT modulocodigo,modulonombre FROM modulo ORDER BY modulonombre ASC");
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


		protected function actualizar_modulos_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE modulo SET modulonombre=:NOMBRE WHERE modulocodigo=:CODIGO");
			$query->bindParam("NOMBRE",$datos['NOMBRE']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}