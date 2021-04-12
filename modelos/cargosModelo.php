<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class cargosModelo extends mainModel{
		//Funcupion para registrar un nuevo cargo en el sistema
		protected function agregar_cargos_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO cargo(cargocodigo,departamentocodigo,cargonombre) VALUES(:CODIGO,:DEPA,:NOMBRE)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":DEPA",$datos['DEPA']);
			$query->bindParam(":NOMBRE",$datos['NOMBRE']);
			$query->execute();
			return $query;
		}


		protected function datos_cargos_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM cargo WHERE cargocodigo=:codigo");
				$query->bindParam(":codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT departamentocodigo FROM departemento");
			}elseif($tipo=="SelectEmpresa"){
				$query=mainModel::conectar()->prepare("SELECT * FROM empresa ORDER BY empresanombre ASC");
			}elseif($tipo=="SelectDep"){
				$query=mainModel::conectar()->prepare("SELECT * FROM departemento ORDER BY departamentonombre ASC");
			}elseif($tipo=="SelectMaterias"){
				$query=mainModel::conectar()->prepare("SELECT * FROM empresacodigo WHERE departamentocodigo=:codigo ORDER BY departamentonombre ASC");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="Pregunta") {
				$query=mainModel::conectar()->prepare("SELECT * FROM cargo WHERE cargocodigo=:codigo");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="Empresa") {
				$query=mainModel::conectar()->prepare("SELECT a.*,b.departamentocodigo,c.empresacodigo FROM cargo a,cargo b,departemento c WHERE a.cargocodigo=:codigo AND a.cargocodigo= b.cargocodigo AND b.departamentocodigo= c.departamentocodigo");
				$query->bindParam(":codigo",$codigo);
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

		//Dunción para editar un cargo
		protected function actualizar_cargos_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE cargo SET departamentocodigo=:DEPA,cargonombre=:NOMBRE WHERE cargocodigo=:CODIGO");
			$query->bindParam("NOMBRE",$datos['NOMBRE']);
			$query->bindParam("DEPA",$datos['DEPA']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}