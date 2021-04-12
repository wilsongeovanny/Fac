<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class perfilModelo extends mainModel{
		protected function agregar_perfil_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO perfil_cuenta(PERFILCODIGO,PERFILNOMBRE) VALUES(:CODIGO,:NOMBRE)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":NOMBRE",$datos['NOMBRE']);
			$query->execute();
			return $query;
		}

		protected function datos_perfil_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM perfil_cuenta WHERE PERFILCODIGO=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT PERFILCODIGO FROM perfil_cuenta");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT PERFILCODIGO,PERFILNOMBRE FROM perfil_cuenta ORDER BY PERFILNOMBRE ASC");
			}
			$query->execute();
			return $query;
		}

		protected function eliminar_perfil_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM perfil_cuenta WHERE PERFILCODIGO=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function actualizar_perfil_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE perfil_cuenta SET PERFILNOMBRE=:NOMBRE WHERE PERFILCODIGO=:CODIGO");
			$query->bindParam("NOMBRE",$datos['NOMBRE']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}