<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class rolesModelo extends mainModel{

		//Función para registrar nuevos roles de administrador
		protected function agregar_roles_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO roles(codigoroles,rolesnombre,rolesdescripcion,rolesestado) VALUES(:CODIGO,:NOMBRE,:DESCRIPCION,:ESTADO)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":NOMBRE",$datos['NOMBRE']);
			$query->bindParam(":DESCRIPCION",$datos['DESCRIPCION']);
			$query->bindParam(":ESTADO",$datos['ESTADO']);
			$query->execute();
			return $query;
		}

		protected function agregar_detalles_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO privilegios(codigoroles,modulocodigo) VALUES(:ROLES,:MODULOS)");
			$query->bindParam(":ROLES",$datos['ROLES']);
			$query->bindParam(":MODULOS",$datos['MODULOS']);
			$query->execute();
			return $query;
		}

		protected function datos_roles_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM roles WHERE codigoroles=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT modulocodigo FROM modulo");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT modulocodigo,modulonombre FROM modulo ORDER BY modulonombre ASC");
			}elseif($tipo=="Estados"){
				$query=mainModel::conectar()->prepare("SELECT codigoroles,rolesestado FROM roles ORDER BY rolesestado ASC");
			}elseif($tipo=="Roles"){
				$query=mainModel::conectar()->prepare("SELECT modulocodigo,modulonombre FROM modulo ORDER BY modulocodigo ASC");
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

		//Función para editar el rol de administrador
		protected function actualizar_roles_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE roles SET rolesnombre=:NOMBRE,rolesdescripcion=:DESCRIPCION,rolesestado=:ESTADO WHERE codigoroles=:CODIGO");
			$query->bindParam("NOMBRE",$datos['NOMBRE']);
			$query->bindParam("DESCRIPCION",$datos['DESCRIPCION']);
			$query->bindParam("ESTADO",$datos['ESTADO']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}


		protected function actualizar_detalles_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE privilegios SET modulocodigo=:MODULOS WHERE codigoroles=:ROLES");
			$query->bindParam("MODULOS",$datos['MODULOS']);
			$query->bindParam("ROLES",$datos['ROLES']);
			$query->execute();
			return $query;
		}
	}