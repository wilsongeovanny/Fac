<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class reasignacionModelo extends mainModel{



		//Función para reasignar hardware a los empleados
		protected function actualizar_reasignacion_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE hardware SET empleadocodigo=EMPLEADO,hifecha=:FECHA,hiimagenqr=:IMAGEN WHERE hardwareqr=:CODIGO");
			
			$query->bindParam("EMPLEADO",$datos['EMPLEADO']);
			$query->bindParam("FECHA",$datos['FECHA']);
			$query->bindParam("IMAGEN",$datos['IMAGEN']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}

		protected function datos_reasignacion_modelo($tipo,$codigo){
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
				$query=mainModel::conectar()->prepare("SELECT *,T1.icodigo FROM informe_ingreso_hardware as T1, hardware_ingreso as T3, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, estado_info_hardware as T9, hardware as T10 WHERE T3.hiserie=:codigo AND T3.icodigo=T1.icodigo AND T3.tipohardwarecodigo=T5.tipohardwarecodigo AND T3.marcahardwarecodigo=T6.marcahardwarecodigo AND T3.modelohardwarecodigo=T7.modelohardwarecodigo AND T3.colorhardwarecodigo=T8.colorhardwarecodigo AND T3.estadoinfoharcodigo=T9.estadoinfoharcodigo AND T3.hiserie=T10.hiserie");
				$query->bindParam(":codigo",$codigo);
			}
			$query->execute();
			return $query;
		
	}


	}