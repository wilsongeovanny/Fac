<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class empleadosModelo extends mainModel{
		//Función para registrar un nuevo empleado
		protected function agregar_empleados_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO empleados(empleadocodigo,empleadocedula,cargocodigo,estadoempleadocodigo,empleadonombres,empleadoapellidos,empleadotelefono,empleadocelular,empleadocorreo,empleadofecha) VALUES(:CODIGO,:CEDULA,:CARGO,:ESTADO,:NOMBRES,:APELLIDOS,:TELEFONO,:CELULAR,:CORREO,:FECHA)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":CEDULA",$datos['CEDULA']);
			$query->bindParam(":CARGO",$datos['CARGO']);
			$query->bindParam(":ESTADO",$datos['ESTADO']);
			$query->bindParam(":NOMBRES",$datos['NOMBRES']);
			$query->bindParam(":APELLIDOS",$datos['APELLIDOS']);
			$query->bindParam(":TELEFONO",$datos['TELEFONO']);
			$query->bindParam(":CELULAR",$datos['CELULAR']);
			$query->bindParam(":CORREO",$datos['CORREO']);
			$query->bindParam(":FECHA",$datos['FECHA']);
			$query->execute();
			return $query;
		}

		protected function datos_empleados_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM empleados WHERE empleadocodigo=:codigo");
				$query->bindParam(":codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT departamentocodigo FROM departemento");
			}elseif($tipo=="SelectEmpresa"){
				$query=mainModel::conectar()->prepare("SELECT * FROM empresa ORDER BY EMPRESANOMBRE ASC");
			}elseif($tipo=="SelectDep"){
				$query=mainModel::conectar()->prepare("SELECT * FROM departemento ORDER BY departamentonombre ASC");
			}elseif($tipo=="SelectMaterias"){
				$query=mainModel::conectar()->prepare("SELECT * FROM empresacodigo WHERE departamentocodigo=:codigo ORDER BY departamentonombre ASC");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="Pregunta") {
				$query=mainModel::conectar()->prepare("SELECT * FROM cargo WHERE cargocodigo=:codigo");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="Estados") {
				$query=mainModel::conectar()->prepare("SELECT * FROM estado_empleado ORDER BY estadoempleadonombre");
			}elseif ($tipo=="SelectEstados1") {
				$query=mainModel::conectar()->prepare("SELECT *,T1.empleadocodigo FROM empleados as T1, estado_empleado as T2 WHERE T1.empleadocodigo=:codigo AND T2.estadoempleadocodigo=T1.estadoempleadocodigo");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="SelectCargos") {
				$query=mainModel::conectar()->prepare("SELECT * FROM cargo ORDER BY cargonombre ASC");
			}elseif ($tipo=="Empleado") {
				$query=mainModel::conectar()->prepare("SELECT *,T1.empleadocodigo FROM empleados as T1, cargo as T2, departemento as T3, empresa as T4, estado_empleado as T5 WHERE T1.empleadocodigo=:codigo AND T1.cargocodigo=T2.cargocodigo AND T2.departamentocodigo=T3.departamentocodigo AND T3.empresacodigo=T4.empresacodigo AND T1.estadoempleadocodigo=T5.estadoempleadocodigo ORDER BY empleadonombres");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="Hardware") {
				$query=mainModel::conectar()->prepare("SELECT *,T1.HISERIE FROM hardware as T1, empleados as T2, hardware_ingreso as T3, tipo_hardware as T4, marca_hardware as T5, modelo_hardware as T6, color_hardware as T7, estado_hardware as T8, estado_asignacion_hardware as T9 WHERE (T2.empleadocodigo='EMPADO89121941' AND T1.empleadocodigo=T2.empleadocodigo AND T1.HISERIE=T3.HISERIE AND T3.TIPOHARDWARECODIGO=T4.TIPOHARDWARECODIGO AND T3.MARCAHARDWARECODIGO=T5.MARCAHARDWARECODIGO AND T3.MODELOHARDWARECODIGO=T6.MODELOHARDWARECODIGO AND T3.COLORHARDWARECODIGO=T7.COLORHARDWARECODIGO AND T1.ESTADOHARDWARECODIGO=T8.ESTADOHARDWARECODIGO AND T8.ESTADOHARDWARENOMBRE='ACTIVO' AND T3.ESTADOASIGHARCODIGO=T9.ESTADOASIGHARCODIGO AND T9.ESTADOASIGHARNOMBRE='ASIGNADO') OR (T2.empleadocodigo='EMPADO89121941' AND T1.empleadocodigo=T2.empleadocodigo AND T1.HISERIE=T3.HISERIE AND T3.TIPOHARDWARECODIGO=T4.TIPOHARDWARECODIGO AND T3.MARCAHARDWARECODIGO=T5.MARCAHARDWARECODIGO AND T3.MODELOHARDWARECODIGO=T6.MODELOHARDWARECODIGO AND T3.COLORHARDWARECODIGO=T7.COLORHARDWARECODIGO AND T1.ESTADOHARDWARECODIGO=T8.ESTADOHARDWARECODIGO AND T8.ESTADOHARDWARENOMBRE='ACTIVO' AND T3.ESTADOASIGHARCODIGO=T9.ESTADOASIGHARCODIGO AND T9.ESTADOASIGHARNOMBRE='REASIGNADO')");
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


			//Función para editar el empleado
			protected function actualizar_empleados_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE empleados SET empleadocedula=:CEDULA,cargocodigo=:CARGO,estadoempleadocodigo=:ESTADO,empleadonombres=:NOMBRES,empleadoapellidos=:APELLIDOS,empleadotelefono=:TELEFONO,empleadocelular=:CELULAR,empleadocorreo=:CORREO,empleadofecha=:FECHA WHERE empleadocodigo=:CODIGO");
			$query->bindParam("CEDULA",$datos['CEDULA']);	
			$query->bindParam("CARGO",$datos['CARGO']);
			$query->bindParam("ESTADO",$datos['ESTADO']);
			$query->bindParam("NOMBRES",$datos['NOMBRES']);
			$query->bindParam("APELLIDOS",$datos['APELLIDOS']);
			$query->bindParam("TELEFONO",$datos['TELEFONO']);
			$query->bindParam("CELULAR",$datos['CELULAR']);
			$query->bindParam("CORREO",$datos['CORREO']);
			$query->bindParam("FECHA",$datos['FECHA']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
		
	}