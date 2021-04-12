<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class tipoHardwareModelo extends mainModel{

		//Función para registrar tipos de hardware
		protected function agregar_tipoHardware_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO tipo_hardware(tipohardwarecodigo,tipohardwarenombre) VALUES(:CODIGO,:NOMBRE)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":NOMBRE",$datos['NOMBRE']);
			$query->execute();
			return $query;
		}

		protected function datos_tipoHardware_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM tipo_hardware WHERE tipohardwarecodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT tipohardwarecodigo FROM tipo_hardware");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT tipohardwarecodigo,tipohardwarenombre FROM tipo_hardware ORDER BY tipohardwarenombre ASC");
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


		//Función para editar un tipo de hardware
		protected function actualizar_tipoHardware_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE tipo_hardware SET tipohardwarenombre=:NOMBRE WHERE tipohardwarecodigo=:CODIGO");
			$query->bindParam("NOMBRE",$datos['NOMBRE']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}