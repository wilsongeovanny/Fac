<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class mantenimientoModelo extends mainModel{

		protected function agregar_mantenimiento_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO hardware(hardwareqr,hiserie,empleadocodigo,estadohardwarecodigo,hifecha,hiimagenqr) VALUES(:CODIGO,:SERIE,:EMPLEADO,:ESTADO,:FECHA,:IMAGEN)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":SERIE",$datos['SERIE']);
			$query->bindParam(":EMPLEADO",$datos['EMPLEADO']);
			$query->bindParam(":ESTADO",$datos['ESTADO']);
			$query->bindParam(":FECHA",$datos['FECHA']);
			$query->bindParam(":IMAGEN",$datos['IMAGEN']);
			$query->execute();
			return $query;
		}

		protected function datos_mantenimiento_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM modelo_hardware WHERE itiposervicio=:codigo");
				$query->bindParam(":codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT marcahardwarecodigo FROM marca_hardware");
			}elseif($tipo=="TipoHardware"){
				$query=mainModel::conectar()->prepare("SELECT * FROM tipo_hardware ORDER BY tipohardwarenombre ASC");
			}elseif($tipo=="MarcaHardware"){
				$query=mainModel::conectar()->prepare("SELECT * FROM marca_hardware ORDER BY marcahardwarenombre ASC");
			}elseif($tipo=="ModeloHardware"){
				$query=mainModel::conectar()->prepare("SELECT * FROM modelo_hardware ORDER BY modelohardwarenombre ASC");
			}elseif($tipo=="ColoresHardware"){
				$query=mainModel::conectar()->prepare("SELECT * FROM color_hardware ORDER BY colorhardwarenombre ASC");
			}elseif($tipo=="Estados"){
				$query=mainModel::conectar()->prepare("SELECT * FROM estado_info_hardware ORDER BY estadoinfoharnombre ASC");
			}elseif($tipo=="Empleados"){
				$query=mainModel::conectar()->prepare("SELECT * FROM empleados ORDER BY empleadonombres ASC");
			}elseif($tipo=="Responsables"){
				$query=mainModel::conectar()->prepare("SELECT *,T1.empinfohardcodigo FROM empinfo_hardware_ingreso as T1, informe_ingreso_hardware as T2, hardware_ingreso as T3, empleados as T4 WHERE T3.hiserie=:codigo AND T1.empleadocodigo=T2.irespoelaborado AND T2.irespoelaborado=T4.empleadocodigo");
				$query->bindParam(":codigo",$codigo);
			}elseif($tipo=="SelectEmpresa"){
				$query=mainModel::conectar()->prepare("SELECT * FROM empresa ORDER BY empresanombre ASC");
			}elseif($tipo=="SelectDep"){
				$query=mainModel::conectar()->prepare("SELECT * FROM departemento ORDER BY departamentonombre ASC");
			}elseif ($tipo=="SelectCargos") {
				$query=mainModel::conectar()->prepare("SELECT * FROM cargo ORDER BY cargonombre ASC");
			}elseif ($tipo=="Empleados") {
				$query=mainModel::conectar()->prepare("SELECT * FROM empleados ORDER BY empleadonombres ASC");
			}elseif ($tipo=="Tipo") {
				$query=mainModel::conectar()->prepare("SELECT *,T1.hiserie FROM hardware as T1, hardware_ingreso as T2, estado_info_hardware as T3, estado_asignacion_hardware as T4, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, estado_hardware as T9, informe_ingreso_hardware as T10, empleados as T11, cargo as T12, departemento as T13, empresa as T14 WHERE (T1.hiserie=:codigo AND T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='ASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T1.estadohardwarecodigo=T9.estadohardwarecodigo AND T2.icodigo=T10.icodigo AND T1.empleadocodigo=T11.empleadocodigo AND T11.cargocodigo=T12.cargocodigo AND T12.departamentocodigo=T13.departamentocodigo AND T13.empresacodigo=T14.empresacodigo) OR (T1.hiserie=:codigo AND T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='REASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T1.estadohardwarecodigo=T9.estadohardwarecodigo AND T2.icodigo=T10.icodigo AND T1.empleadocodigo=T11.empleadocodigo AND T11.cargocodigo=T12.cargocodigo AND T12.departamentocodigo=T13.departamentocodigo AND T13.empresacodigo=T14.empresacodigo) OR (T1.hiserie=:codigo AND T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='NO REASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T1.estadohardwarecodigo=T9.estadohardwarecodigo AND T2.icodigo=T10.icodigo AND T1.empleadocodigo=T11.empleadocodigo AND T11.cargocodigo=T12.cargocodigo AND T12.departamentocodigo=T13.departamentocodigo AND T13.empresacodigo=T14.empresacodigo)");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="Reasignados") {
				$query=mainModel::conectar()->prepare("SELECT *,T1.hardwareqr FROM hardware as T1, hardware_ingreso as T2, estado_info_hardware as T3, estado_asignacion_hardware as T4, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, estado_hardware as T9, informe_ingreso_hardware as T10, empleados as T11, cargo as T12, departemento as T13, empresa as T14 WHERE (T1.hardwareqr=:codigo AND T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='ASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T1.estadohardwarecodigo=T9.estadohardwarecodigo AND T2.icodigo=T10.icodigo AND T1.empleadocodigo=T11.empleadocodigo AND T11.cargocodigo=T12.cargocodigo AND T12.departamentocodigo=T13.departamentocodigo AND T13.empresacodigo=T14.empresacodigo) OR (T1.hardwareqr=:codigo AND T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='REASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T1.estadohardwarecodigo=T9.estadohardwarecodigo AND T2.icodigo=T10.icodigo AND T1.empleadocodigo=T11.empleadocodigo AND T11.cargocodigo=T12.cargocodigo AND T12.departamentocodigo=T13.departamentocodigo AND T13.empresacodigo=T14.empresacodigo) OR (T1.hardwareqr=:codigo AND T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='NO REASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T1.estadohardwarecodigo=T9.estadohardwarecodigo AND T2.icodigo=T10.icodigo AND T1.empleadocodigo=T11.empleadocodigo AND T11.cargocodigo=T12.cargocodigo AND T12.departamentocodigo=T13.departamentocodigo AND T13.empresacodigo=T14.empresacodigo)");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="Empreag") {
				$query=mainModel::conectar()->prepare("SELECT *,T1.hiserie FROM hardware as T1, hardware_ingreso as T2, estado_info_hardware as T3, estado_asignacion_hardware as T4, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, estado_hardware as T9, informe_ingreso_hardware as T10, empleados as T11, cargo as T12, departemento as T13, empresa as T14 WHERE T1.hiserie=:codigo AND T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='REASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T1.estadohardwarecodigo=T9.estadohardwarecodigo AND T2.icodigo=T10.icodigo AND T1.empleadocodigo=T11.empleadocodigo AND T11.cargocodigo=T12.cargocodigo AND T12.departamentocodigo=T13.departamentocodigo AND T13.empresacodigo=T14.empresacodigo");
				$query->bindParam(":codigo",$codigo);
			}
			$query->execute();
			return $query;
		
	}



		protected function actualizar_mantenimiento_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE hardware SET hardwareqr=:QR,empleadocodigo=:EMPLEADO,estadohardwarecodigo=:ESTADO,fechaasignacion=:FECHA WHERE hiserie=:CODIGO");
			$query->bindParam("QR",$datos['QR']);
			$query->bindParam("EMPLEADO",$datos['EMPLEADO']);
			$query->bindParam("ESTADO",$datos['ESTADO']);
			$query->bindParam("FECHA",$datos['FECHA']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}