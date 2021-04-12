<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class estadosReasigModelo extends mainModel{
		protected function agregar_estadosReasig_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO estado_reasignacion_hardware(ESTADOREASIGHARCODIGO,ESTADOREASIGHARNOMBRE) VALUES(:CODIGO,:OPCION)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":OPCION",$datos['OPCION']);
			$query->execute();
			return $query;
		}

		protected function datos_estadosReasig_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM estado_reasignacion_hardware WHERE ESTADOREASIGHARCODIGO=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT ESTADOREASIGHARCODIGO FROM estado_reasignacion_hardware");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT ESTADOREASIGHARCODIGO,ESTADOREASIGHARNOMBRE FROM estado_reasignacion_hardware ORDER BY ESTADOREASIGHARNOMBRE ASC");
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


		protected function actualizar_estadosReasig_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE estado_reasignacion_hardware SET ESTADOREASIGHARNOMBRE=:OPCION WHERE ESTADOREASIGHARCODIGO=:CODIGO");
			$query->bindParam("OPCION",$datos['OPCION']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}