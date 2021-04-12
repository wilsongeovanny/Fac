<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class coloresHardwareModelo extends mainModel{

		//Función para registrar un nuevo color de hardware en el sistema
		protected function agregar_coloresHardware_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO color_hardware(colorhardwarecodigo,colorhardwarenombre) VALUES(:CODIGO,:NOMBRE)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":NOMBRE",$datos['NOMBRE']);
			$query->execute();
			return $query;
		}

		protected function datos_coloresHardware_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM color_hardware WHERE colorhardwarecodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT colorhardwarecodigo FROM color_hardware");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT colorhardwarecodigo,colorhardwarenombre FROM color_hardware ORDER BY colorhardwarenombre ASC");
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


		protected function actualizar_coloresHardware_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE color_hardware SET colorhardwarenombre=:NOMBRE WHERE colorhardwarecodigo=:CODIGO");
			$query->bindParam("NOMBRE",$datos['NOMBRE']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}