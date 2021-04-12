<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class menuModelo extends mainModel{
		protected function agregar_menu_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO menu(MENUCODIGO,MENUOPCION,MENUNOMBRE) VALUES(:CODIGO,:OPCION,:NOMBRE)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":OPCION",$datos['OPCION']);
			$query->bindParam(":NOMBRE",$datos['NOMBRE']);
			$query->execute();
			return $query;
		}

		protected function datos_menu_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM menu WHERE MENUCODIGO=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT MENUCODIGO FROM empresa");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT MENUCODIGO,MENUNOMBRE FROM menu ORDER BY MENUNOMBRE ASC");
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


		protected function actualizar_menu_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE menu SET MENUNOMBRE=:NOMBRE WHERE MENUCODIGO=:CODIGO");
			$query->bindParam("NOMBRE",$datos['NOMBRE']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}