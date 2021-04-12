<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class departamentosModelo extends mainModel{

		//Función para agregar un nuevo departamento
		protected function agregar_departamentos_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO departemento(departamentocodigo,empresacodigo,departamentonombre) VALUES(:CODIGO,:EMPRESA,:NOMBRE)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":EMPRESA",$datos['EMPRESA']);
			$query->bindParam(":NOMBRE",$datos['NOMBRE']);
			$query->execute();
			return $query;
		}

		protected function datos_departamentos_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM departemento WHERE departamentocodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT departamentocodigo FROM departemento");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT empresacodigo,empresanombre FROM empresa ORDER BY empresanombre ASC");
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

		//Función para actualizar el departamento
		protected function actualizar_departamentos_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE departemento SET departamentonombre=:NOMBRE WHERE departamentocodigo=:CODIGO");
			$query->bindParam("NOMBRE",$datos['NOMBRE']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}


