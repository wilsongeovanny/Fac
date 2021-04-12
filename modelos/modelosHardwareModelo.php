<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class modelosHardwareModelo extends mainModel{

		//Función para registrar un nuevo modelo a la marca
		protected function agregar_modelosHardware_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO modelo_hardware(modelohardwarecodigo,marcahardwarecodigo,modelohardwarenombre) VALUES(:CODIGO,:MARCA,:NOMBRE)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":MARCA",$datos['MARCA']);
			$query->bindParam(":NOMBRE",$datos['NOMBRE']);
			$query->execute();
			return $query;
		}


		protected function datos_modelosHardware_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM modelo_hardware WHERE modelohardwarecodigo=:codigo");
				$query->bindParam(":codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT marcahardwarecodigo FROM marca_hardware");
			}elseif($tipo=="TipoHardware"){
				$query=mainModel::conectar()->prepare("SELECT * FROM tipo_hardware ORDER BY tipohardwarenombre ASC");
			}elseif($tipo=="MarcaHardware"){
				$query=mainModel::conectar()->prepare("SELECT * FROM marca_hardware ORDER BY marcahardwarenombre ASC");
			}/*elseif($tipo=="SelectMaterias"){
				$query=mainModel::conectar()->prepare("SELECT * FROM tipo_hardware WHERE marcahardwarecodigo=:codigo ORDER BY marcahardwarenombre ASC");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="Pregunta") {
				$query=mainModel::conectar()->prepare("SELECT * FROM modelo_hardware WHERE modelohardwarecodigo=:codigo");
				$query->bindParam(":codigo",$codigo);
			}*/elseif ($tipo=="Tipo") {
				$query=mainModel::conectar()->prepare("SELECT a.*,b.marcahardwarecodigo,c.tipohardwarecodigo FROM modelo_hardware a,modelo_hardware b,marca_hardware c WHERE a.modelohardwarecodigo=:codigo AND a.modelohardwarecodigo= b.modelohardwarecodigo AND b.marcahardwarecodigo= c.marcahardwarecodigo");
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


		//Función para editar un modelo
		protected function actualizar_modelosHardware_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE modelo_hardware SET marcahardwarecodigo=:MARCA,modelohardwarenombre=:NOMBRE WHERE modelohardwarecodigo=:CODIGO");
			$query->bindParam("MARCA",$datos['MARCA']);
			$query->bindParam("NOMBRE",$datos['NOMBRE']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}