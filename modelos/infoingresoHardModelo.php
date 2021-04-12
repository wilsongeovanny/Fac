<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class infoingresoHardModelo extends mainModel{

		//Función para registrar un informe de ingreso de hardware
		protected function agregar_infoingresoHard_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO informe_ingreso_hardware(icodigo,itema,itiposervicio,ilugartrabajo,iantecedentes,
				iobjetivos,ianalisis,iconclusiones,irecomendaciones,irespoelaborado,irespovisto)
				VALUES(:ICOD,:ITEM,:ISERVICIO,:ITRABAJO,:IANTE,:IOBJ,:IANALIS,:ICONCL,:IRECOM,:IELAB,:IVISTO)");
			$query->bindParam(":ICOD",$datos['ICOD']);
			$query->bindParam(":ITEM",$datos['ITEM']);
			$query->bindParam(":ISERVICIO",$datos['ISERVICIO']);
			$query->bindParam(":ITRABAJO",$datos['ITRABAJO']);
			$query->bindParam(":IANTE",$datos['IANTE']);
			$query->bindParam(":IOBJ",$datos['IOBJ']);
			$query->bindParam(":IANALIS",$datos['IANALIS']);
			$query->bindParam(":ICONCL",$datos['ICONCL']);
			$query->bindParam(":IRECOM",$datos['IRECOM']);
			$query->bindParam(":IELAB",$datos['IELAB']);
			$query->bindParam(":IVISTO",$datos['IVISTO']);
			$query->execute();
			return $query;
		}

		protected function agregar_empinfohar_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO empinfo_hardware_ingreso(empinfohardcodigo,icodigo,empleadocodigo) VALUES(:EIHCODIGO,:INFORME,:EMPLEADO)");
			$query->bindParam(":EIHCODIGO",$datos['EIHCODIGO']);
			$query->bindParam(":INFORME",$datos['INFORME']);
			$query->bindParam(":EMPLEADO",$datos['EMPLEADO']);
			$query->execute();
			return $query;
		}


		protected function agregar_informaHardware_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO hardware_ingreso(hiserie,serireexterno,modelohardwarecodigo,tipohardwarecodigo,marcahardwarecodigo,estadoinfoharcodigo,colorhardwarecodigo,icodigo,estadoasigharcodigo,hifecha,hititulo,hicaracteristicas,hicables,hiobservaciones) VALUES(:HCODIGO,:EXTERNO,:HMODELO,:HTIPO,:HMARCA,:HESTADO,:HCOLOR,:HINFOCOD,:ESTADOASIG,:HFECHA,:HTITULO,:HCARAC,:HCABLE,:HOBS)");
			$query->bindParam(":HCODIGO",$datos['HCODIGO']);
			$query->bindParam(":EXTERNO",$datos['EXTERNO']);
			$query->bindParam(":HMODELO",$datos['HMODELO']);
			$query->bindParam(":HTIPO",$datos['HTIPO']);
			$query->bindParam(":HMARCA",$datos['HMARCA']);
			$query->bindParam(":HESTADO",$datos['HESTADO']);
			$query->bindParam(":HCOLOR",$datos['HCOLOR']);
			$query->bindParam(":HINFOCOD",$datos['HINFOCOD']);
			$query->bindParam(":ESTADOASIG",$datos['ESTADOASIG']);
			$query->bindParam(":HFECHA",$datos['HFECHA']);
			$query->bindParam(":HTITULO",$datos['HTITULO']);
			$query->bindParam(":HCARAC",$datos['HCARAC']);
			$query->bindParam(":HCABLE",$datos['HCABLE']);
			$query->bindParam(":HOBS",$datos['HOBS']);
			$query->execute();
			return $query;
		}

			
		/*protected function eliminar_infoingresoHard_modelo($codinfo){
			$sql=self::conectar()->prepare("DELETE FROM empinfo_hardware_ingreso WHERE empinfohardcodigo=:ICOD");
			$sql->bindParam(":ICOD",$codinfo);
			$sql->execute();
			return $sql;
		}*/

		protected function datos_infoingresoHard_modelo($tipo,$codigo){
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
				$query=mainModel::conectar()->prepare("SELECT SQL_CALC_FOUND_ROWS *,T1.empinfohardcodigo FROM empinfo_hardware_ingreso as T1, informe_ingreso_hardware as T2, hardware_ingreso as T3, empleados as T4 WHERE T3.hiserie=:codigo AND T1.empleadocodigo=T2.irespoelaborado AND T2.irespoelaborado=T4.empleadocodigo");
				$query->bindParam(":codigo",$codigo);
			}/*elseif($tipo=="SelectMaterias"){
				$query=mainModel::conectar()->prepare("SELECT * FROM tipo_hardware WHERE marcahardwarecodigo=:codigo ORDER BY marcahardwarenombre ASC");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="Pregunta") {
				$query=mainModel::conectar()->prepare("SELECT * FROM modelo_hardware WHERE modelohardwarecodigo=:codigo");
				$query->bindParam(":codigo",$codigo);
			}*/elseif ($tipo=="Tipo") {
				$query=mainModel::conectar()->prepare("SELECT *,T1.icodigo FROM informe_ingreso_hardware as T1, hardware_ingreso as T3, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, estado_info_hardware as T9 WHERE T3.hiserie=:codigo AND T3.icodigo=T1.icodigo AND T3.tipohardwarecodigo=T5.tipohardwarecodigo AND T3.marcahardwarecodigo=T6.marcahardwarecodigo AND T3.modelohardwarecodigo=T7.modelohardwarecodigo AND T3.colorhardwarecodigo=T8.colorhardwarecodigo AND T3.estadoinfoharcodigo=T9.estadoinfoharcodigo");
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

		//Función para actualizar el informe de ingreso de hardware rechazado
		protected function actualizar_informe_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE informe_ingreso_hardware SET itema=:TEMA, itiposervicio=:SERVICIO, ilugartrabajo=:LUGAR, iantecedentes=:ANTECEDENTE, iobjetivos=:OBJETIVO, ianalisis=:ANALISIS, iconclusiones=:CONCLUSION, irecomendaciones=:RECOMEND, irespoelaborado=:RESPONSABLE, irespovisto=:VISTO WHERE icodigo=:CODIGO");
			$query->bindParam("TEMA",$datos['TEMA']);
			$query->bindParam("SERVICIO",$datos['SERVICIO']);
			$query->bindParam("LUGAR",$datos['LUGAR']);
			$query->bindParam("ANTECEDENTE",$datos['ANTECEDENTE']);
			$query->bindParam("OBJETIVO",$datos['OBJETIVO']);
			$query->bindParam("ANALISIS",$datos['ANALISIS']);
			$query->bindParam("CONCLUSION",$datos['CONCLUSION']);
			$query->bindParam("RECOMEND",$datos['RECOMEND']);
			$query->bindParam("RESPONSABLE",$datos['RESPONSABLE']);
			$query->bindParam("VISTO",$datos['VISTO']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}


		protected function actualizar_responsables_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE empinfo_hardware_ingreso SET icodigo=:INFORME,empleadocodigo=:EMPLEADO WHERE empinfohardcodigo=:CODIGO");
			$query->bindParam("INFORME",$datos['INFORME']);
			$query->bindParam("EMPLEADO",$datos['EMPLEADO']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}


		//Función para editar el hardware de ingreso rechazado
		protected function actualizar_hardware_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE hardware_ingreso SET serireexterno=:EXTERNO, modelohardwarecodigo=:MODELO, tipohardwarecodigo=:TIPO, marcahardwarecodigo=:MARCA, estadoinfoharcodigo=:ESTADO, colorhardwarecodigo=:COLOR, icodigo=:INFORME, hifecha=:FECHA, hititulo=:TITULO, hicaracteristicas=:CARACT, hicables=:CABLES, hiobservaciones=:OBSERV WHERE hiserie=:CODIGO");
			$query->bindParam("EXTERNO",$datos['EXTERNO']);
			$query->bindParam("MODELO",$datos['MODELO']);
			$query->bindParam("TIPO",$datos['TIPO']);
			$query->bindParam("MARCA",$datos['MARCA']);
			$query->bindParam("ESTADO",$datos['ESTADO']);
			$query->bindParam("COLOR",$datos['COLOR']);
			$query->bindParam("INFORME",$datos['INFORME']);
			$query->bindParam("FECHA",$datos['FECHA']);
			$query->bindParam("TITULO",$datos['TITULO']);
			$query->bindParam("CARACT",$datos['CARACT']);
			$query->bindParam("CABLES",$datos['CABLES']);
			$query->bindParam("OBSERV",$datos['OBSERV']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}

	}