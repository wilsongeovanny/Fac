<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class manteEntregarModelo extends mainModel{
		
		protected function agregar_reporespo_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO responsable_reporte(resprepocodigo,empleadocodigo) VALUES(:CODIGO,:RESPO)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":RESPO",$datos['RESPO']);
			$query->execute();
			return $query;
		}

		protected function agregar_vistorespo_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO vistobueno_reporte(vistorepocodigo,empleadocodigo) VALUES(:CODIGO,:VISTO)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":VISTO",$datos['VISTO']);
			$query->execute();
			return $query;
		}

		protected function agregar_infoentrega_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO informacion_entrega(entregacodigo,entregahora,entregafecha) VALUES(:CODIGO,:HORA,:FECHA)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":HORA",$datos['HORA']);
			$query->bindParam(":FECHA",$datos['FECHA']);
			$query->execute();
			return $query;
		}

		//Función para generar el informe técnico de entrega
		protected function agregar_reporte_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO reporte(reportecodigo,entregacodigo	,vistorepocodigo,resprepocodigo,reportehm,reporteusuario,reporteservicior) VALUES(:CODIGO,:ENTREGA,:VISTO,:RESPONSABLE,:ENTREGADO,:REPORTE,:INFORME)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":ENTREGA",$datos['ENTREGA']);
			$query->bindParam(":VISTO",$datos['VISTO']);
			$query->bindParam(":RESPONSABLE",$datos['RESPONSABLE']);
			$query->bindParam(":ENTREGADO",$datos['ENTREGADO']);
			$query->bindParam(":REPORTE",$datos['REPORTE']);
			$query->bindParam(":INFORME",$datos['INFORME']);
			$query->execute();
			return $query;
		}

		protected function datos_manteEntregar_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT *,T1.mantenimientocodigo FROM mantenimiento as T1, hardware as T2, hardware_ingreso as T3, estado_info_hardware as T4, estado_asignacion_hardware as T5, tipo_hardware as T6, marca_hardware as T7, modelo_hardware as T8, color_hardware as T9, informe_ingreso_hardware as T10, empleados as T11, cargo as T12, departemento as T13, empresa as T14, diagnostico as T15, informacion_ingreso as T16 WHERE T1.mantenimientocodigo=:codigo AND T1.hardwareqr=T2.hardwareqr AND T2.hiserie=T3.hiserie AND T3.estadoinfoharcodigo=T4.estadoinfoharcodigo AND T3.estadoasigharcodigo=T5.estadoasigharcodigo AND T3.tipohardwarecodigo=T6.tipohardwarecodigo AND T3.marcahardwarecodigo=T7.marcahardwarecodigo AND T3.modelohardwarecodigo=T8.modelohardwarecodigo AND T3.colorhardwarecodigo=T9.colorhardwarecodigo AND T3.icodigo=T10.icodigo AND T2.empleadocodigo=T11.empleadocodigo AND T11.cargocodigo=T12.cargocodigo AND T12.departamentocodigo=T13.departamentocodigo AND T13.empresacodigo=T14.empresacodigo AND T1.diagnosticocodigo=T15.diagnosticocodigo AND T15.ingresocodigo=T16.ingresocodigo");
				$query->bindParam(":codigo",$codigo);
			}if ($tipo=="Diagnostico") {
				$query=mainModel::conectar()->prepare("SELECT *,T1.mantenimientocodigo FROM mantenimiento as T1, diagnostico as T2, responsable_diagnostico as T3, informacion_ingreso as T5, estado_mantenimiento as T6, hardware as T7, estado_hardware as T8, hardware_ingreso as T9, tipo_hardware as T10, marca_hardware as T11, modelo_hardware as T12, color_hardware as T13, informe_ingreso_hardware as T14, estado_info_hardware as T15, estado_asignacion_hardware as T16, empleados as T17, cargo as T18, departemento as T19, empresa as T20  WHERE T1.mantenimientocodigo=:codigo AND T1.diagnosticocodigo=T2.diagnosticocodigo AND T2.respdiagcodigo=T3.respdiagcodigo AND T5.ingresocodigo=T2.ingresocodigo AND T1.estadomantenimientocodigo=T6.estadomantenimientocodigo AND T1.hardwareqr=T7.hardwareqr AND T7.estadohardwarecodigo=T8.estadohardwarecodigo AND T7.hiserie=T9.hiserie AND T9.tipohardwarecodigo=T10.tipohardwarecodigo AND T9.marcahardwarecodigo=T11.marcahardwarecodigo AND T9.modelohardwarecodigo=T12.modelohardwarecodigo AND T9.colorhardwarecodigo=T13.colorhardwarecodigo AND T9.icodigo=T14.icodigo AND T9.estadoinfoharcodigo=T15.estadoinfoharcodigo AND T9.estadoasigharcodigo=T16.estadoasigharcodigo AND T7.empleadocodigo=T17.empleadocodigo AND T17.cargocodigo=T18.cargocodigo AND T18.departamentocodigo=T19.departamentocodigo AND T19.empresacodigo=T20.empresacodigo");

				

				$query->bindParam(":codigo",$codigo);
			}
			//Consulta para la impresión de la hoja de diagnóstico generado para el mantenimiento de hardware
			if ($tipo=="Informe") {
				$query=mainModel::conectar()->prepare("SELECT *,T1.mantenimientocodigo FROM mantenimiento as T1, diagnostico as T2, responsable_diagnostico as T3, informacion_ingreso as T5, estado_mantenimiento as T6, hardware as T7, estado_hardware as T8, hardware_ingreso as T9, tipo_hardware as T10, marca_hardware as T11, modelo_hardware as T12, color_hardware as T13, informe_ingreso_hardware as T14, estado_info_hardware as T15, estado_asignacion_hardware as T16, empleados as T17, cargo as T18, departemento as T19, empresa as T20, estado_mantenimiento as T21, tipo_mantenimiento as T22, informacion_entrega as T23, reporte as T24 WHERE T1.mantenimientocodigo=:codigo AND T1.diagnosticocodigo=T2.diagnosticocodigo AND T2.respdiagcodigo=T3.respdiagcodigo AND T5.ingresocodigo=T2.ingresocodigo AND T1.estadomantenimientocodigo=T6.estadomantenimientocodigo AND T1.hardwareqr=T7.hardwareqr AND T7.estadohardwarecodigo=T8.estadohardwarecodigo AND T7.hiserie=T9.hiserie AND T9.tipohardwarecodigo=T10.tipohardwarecodigo AND T9.marcahardwarecodigo=T11.marcahardwarecodigo AND T9.modelohardwarecodigo=T12.modelohardwarecodigo AND T9.colorhardwarecodigo=T13.colorhardwarecodigo AND T9.icodigo=T14.icodigo AND T9.estadoinfoharcodigo=T15.estadoinfoharcodigo AND T9.estadoasigharcodigo=T16.estadoasigharcodigo AND T7.empleadocodigo=T17.empleadocodigo AND T17.cargocodigo=T18.cargocodigo AND T18.departamentocodigo=T19.departamentocodigo AND T19.empresacodigo=T20.empresacodigo AND T1.estadomantenimientocodigo=T21.estadomantenimientocodigo AND T1.tipomantecodigo=T22.tipomantecodigo AND T1.reportecodigo=T24.reportecodigo AND T23.entregacodigo=T24.entregacodigo");
				$query->bindParam(":codigo",$codigo);
			}

			elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT departamentocodigo FROM informacion_ingreso");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT empresacodigo,empresanombre FROM empresa ORDER BY empresanombre ASC");
			}elseif($tipo=="SelecTipo"){
				$query=mainModel::conectar()->prepare("SELECT tipomantecodigo,tipomantenombre FROM tipo_mantenimiento ORDER BY tipomantenombre ASC");
			}
			$query->execute();
			return $query;
		}

	}