<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class empresaModelo extends mainModel{

		//Función para registrar la empresa, la cual solo se podra registrar una.
		protected function agregar_empresa_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO empresa(empresacodigo,empresaruc,empresanombre,empresatelefono,empresacorreo,empresadireccion,empresalogo) VALUES(:CODIGO,:RUC,:NOMBRE,:TELEFONO,:CORREO,:DIRECCION,:LOGO)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":RUC",$datos['RUC']);
			$query->bindParam(":NOMBRE",$datos['NOMBRE']);
			$query->bindParam(":TELEFONO",$datos['TELEFONO']);
			$query->bindParam(":CORREO",$datos['CORREO']);
			$query->bindParam(":DIRECCION",$datos['DIRECCION']);
			$query->bindParam(":LOGO",$datos['LOGO']);
			$query->execute();
			return $query;
		}

		protected function datos_empresa_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM empresa WHERE empresacodigo=:RUC");
				$query->bindParam(":RUC",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT empresacodigo FROM empresa");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT empresacodigo,empresacodigo FROM empresa ORDER BY empresanombre ASC");
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

		//Función para editar la empresa.
		protected function actualizar_empresa_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE empresa SET empresaruc=:RUC, empresanombre=:NOMBRE,empresatelefono=:TELEFONO,empresacorreo=:CORREO,empresadireccion=:DIRECCION,empresalogo=:LOGO WHERE empresacodigo=:CODIGO");
			$query->bindParam("RUC",$datos['RUC']);
			$query->bindParam("NOMBRE",$datos['NOMBRE']);
			$query->bindParam("TELEFONO",$datos['TELEFONO']);
			$query->bindParam("CORREO",$datos['CORREO']);
			$query->bindParam("DIRECCION",$datos['DIRECCION']);
			$query->bindParam("LOGO",$datos['LOGO']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}