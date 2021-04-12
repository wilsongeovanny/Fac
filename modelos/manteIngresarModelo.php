<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class manteIngresarModelo extends mainModel{

		//Función para generar mantenimientos
		protected function agregar_mantenimiento_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO mantenimiento(mantenimientocodigo,estadomantenimientocodigo,hardwareqr,diagnosticocodigo) VALUES(:CODIGO,:ESTADO,:QR,:DIAGNOSTICO)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":ESTADO",$datos['ESTADO']);
			$query->bindParam(":QR",$datos['QR']);
			$query->bindParam(":DIAGNOSTICO",$datos['DIAGNOSTICO']);
			$query->execute();
			return $query;
		}

		protected function agregar_responsable_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO responsable_diagnostico(respdiagcodigo,empleadocodigo) VALUES(:CODIGO,:RESPO)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":RESPO",$datos['RESPO']);
			$query->execute();
			return $query;
		}

		//Función para generar la hoja de diagnóstico de hardware para su respectivo mantenimiento
		protected function agregar_diagnostico_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO diagnostico(diagnosticocodigo,ingresocodigo,respdiagcodigo,diagnosticoreporteusuario,diagnosticoinformetecnico) VALUES(:CODIGO,:INGRESO,:RESPONSABLE,:REPORTE,:INFORME)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":INGRESO",$datos['INGRESO']);
			$query->bindParam(":RESPONSABLE",$datos['RESPONSABLE']);
			$query->bindParam(":REPORTE",$datos['REPORTE']);
			$query->bindParam(":INFORME",$datos['INFORME']);
			$query->execute();
			return $query;
		}


		protected function agregar_infoingreso_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO informacion_ingreso(INGRESOCODIGO,INGRESOHORA,INGRESOFECHA) VALUES(:CODIGO,:HORA,:FECHA)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":HORA",$datos['HORA']);
			$query->bindParam(":FECHA",$datos['FECHA']);
			$query->execute();
			return $query;
		}

		protected function datos_manteIngresar_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM informacion_ingreso WHERE departamentocodigo=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT departamentocodigo FROM informacion_ingreso");
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


		/*protected function actualizar_mantenimiento_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE mantenimiento SET ESTADOMANTENIMIENTOCODIGO=:ESTADO,HARDWAREQR=:QR,RESPMANTECODIGO=:RESPONSABLE,TIPOMANTECODIGO=:TIPO WHERE MANTENIMIENTOCODIGO=:CODIGO");
			$query->bindParam("ESTADO",$datos['ESTADO']);
			$query->bindParam("QR",$datos['QR']);
			$query->bindParam("RESPONSABLE",$datos['RESPONSABLE']);
			$query->bindParam("TIPO",$datos['TIPO']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}

		protected function actualizar_diagnostico_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE diagnostico SET MANTENIMIENTOCODIGO=:MANTENIMIENTO,DIAGNOSTICOREPORTEUSUARIO=:REPORTE,DIAGNOSTICOINFORMETECNICO=:INFORME WHERE DIAGNOSTICOCODIGO=:CODIGO");
			$query->bindParam("MANTENIMIENTO",$datos['MANTENIMIENTO']);
			$query->bindParam("REPORTE",$datos['REPORTE']);
			$query->bindParam("INFORME",$datos['INFORME']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}


		protected function actualizar_infoingreso_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE informacion_ingreso SET DIAGNOSTICOCODIGO=:DIAGNOSTICO,INGRESOHORA=:HORA,INGRESOFECHA=:FECHA WHERE INGRESOCODIGO=:CODIGO");
			$query->bindParam("DIAGNOSTICO",$datos['DIAGNOSTICO']);
			$query->bindParam("HORA",$datos['HORA']);
			$query->bindParam("FECHA",$datos['FECHA']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}*/

	}