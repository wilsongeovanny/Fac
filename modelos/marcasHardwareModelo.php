<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class marcasHardwareModelo extends mainModel{

		//Función para registrar una nueva marca de hardware
		protected function agregar_marcasHardware_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO marca_hardware(marcahardwarecodigo,tipohardwarecodigo,marcahardwarenombre) VALUES(:CODIGO,:TIPO,:NOMBRE)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":TIPO",$datos['TIPO']);
			$query->bindParam(":NOMBRE",$datos['NOMBRE']);
			$query->execute();
			return $query;
		}

		protected function datos_marcasHardware_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM marca_hardware WHERE marcahardwarecodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT marcahardwarecodigo FROM marca_hardware");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT tipohardwarecodigo,tipohardwarenombre FROM tipo_hardware ORDER BY tipohardwarecodigo ASC");
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

		//Función para editar una marca
		protected function actualizar_marcasHardware_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE marca_hardware SET tipohardwarecodigo=:TIPO,marcahardwarenombre=:NOMBRE WHERE marcahardwarecodigo=:CODIGO");
			$query->bindParam("TIPO",$datos['TIPO']);
			$query->bindParam("NOMBRE",$datos['NOMBRE']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}