<?php 
if ($peticionAjax) {
	require_once "../modelos/reasignacionModelo.php";
}else{
	require_once "./modelos/reasignacionModelo.php";
}  

class reasignacionControlador extends reasignacionModelo{

	public function agregar_asignacion_controlador(){

		$cuenta=mainModel::limpiar_cadena($_POST['codigo']);
		$codimg=mainModel::limpiar_cadena($_POST['codimg-up']);
		$codqr=mainModel::limpiar_cadena($_POST['codqr-up']);
			//
		$empleado=mainModel::limpiar_cadena($_POST['pers-reg']);
		
		$imagen=$codimg.'.png';
		$final=$codimg;

		$veriestado='ACTIVO';
		$fecha=date("Y-m-d");

		$queryverf=mainModel::ejecutar_consulta_simple("SELECT estadohardwarecodigo FROM estado_hardware WHERE estadohardwarenombre='$veriestado'");
		$DatosVest=$queryverf->fetch();
		$estado=$DatosVest['estadohardwarecodigo'];


		if ($queryverf->rowCount()>=1) {

			$asignado='ASIGNADO';

			$query1=mainModel::ejecutar_consulta_simple("SELECT estadoasigharcodigo FROM estado_asignacion_hardware WHERE estadoasigharnombre='$asignado'");
			$DatosEstado=$query1->fetch();
			$data=$DatosEstado['estadoasigharcodigo'];


			if ($query1->rowCount()>=1) {




				$informacion=mainModel::ejecutar_consulta_simple("SELECT empleadonombres,empleadoapellidos FROM empleados WHERE empleadocodigo='$empleado'");
				$DatosEmpleado=$informacion->fetch();
				$infoempnom=$DatosEmpleado['empleadonombres'];
				$infoempape=$DatosEmpleado['empleadoapellidos'];

				$consulta1=mainModel::ejecutar_consulta_simple("SELECT hardwareqr FROM hardware WHERE hardwareqr='$codqr'");
				if ($consulta1->rowCount()<=0) {
					$consulta2=mainModel::ejecutar_consulta_simple("SELECT hiserie FROM hardware WHERE hiserie='$cuenta'");
					if ($consulta2->rowCount()<=0) {
						$datosAsignar=[
							"CODIGO"=>$codqr,
							"SERIE"=>$cuenta,
							"EMPLEADO"=>$empleado,
							"ESTADO"=>$estado,
							"FECHA"=>$fecha,
							"IMAGEN"=>$imagen
						];
						$guardarAsignacion=asignacionModelo::agregar_asignacion_modelo($datosAsignar);
						if ($guardarAsignacion->rowCount()>=1) {
								//move_uploaded_file($Imagen['foto-reg']['tmp_name'],$DireccionImg.$final);



							$query2=mainModel::ejecutar_consulta_simple("UPDATE hardware_ingreso SET estadoasigharcodigo='$data' WHERE hiserie='$cuenta'");


							if ($guardarAsignacion->rowCount()>=1) {

								$direccion='../imagenes_qr/';
								$extension='png';
								$imgmover='../temp/test.png';
								rename($imgmover, $direccion.$final.'.'.$extension);

								$alerta=[
									"Alerta"=>"recargarasig",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"La asignación del hardware al empleado $infoempape $infoempnom ha sido un éxito",
									"Tipo"=>"success"
								];
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No se guardaron los datos del municipio, porfavor intente nuevamnete",
									"Tipo"=>"error"
								];	
							}


							
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"No se ha logrado completar la asignación el hardware, porfavor intente nuevamnete",
								"Tipo"=>"error"
							];	
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El # de serie que acaba de ingresar ya se encuentra registrado en el sistema, por favor intente nuevamente recargando la pagina",
							"Tipo"=>"error"
						];
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El código QR que acaba de ingresar ya se encuentra registrado en el sistema, por favor intente nuevamente recargando la pagina",
						"Tipo"=>"error"
					];
				}
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Primero debe ingresar los estados de la asignación del hardware que vienen por defecto en el sistema, si los problemas persisten contactese con el desarrollador del sistema",
					"Tipo"=>"error"
				];	
			}
		}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Primero debe ingresar los estados del hardware que vienen por defecto en el sistema, si los problemas persisten contactese con el desarrollador del sistema",
					"Tipo"=>"error"
				];	
			}
		return mainModel::sweet_alert($alerta);
	}

		//LISTADO DE HARDWARE A ASIGNAR
public function listar_asignacion_controlador(/*$privilegio,$codigo*/){
	
	$tabla="";
	$consulta="SELECT *,T1.hiserie FROM hardware_ingreso as T1, estado_info_hardware as T2, estado_asignacion_hardware as T3, tipo_hardware as T4, marca_hardware as T5, modelo_hardware as T6, color_hardware as T7, informe_ingreso_hardware as T8 WHERE T1.estadoinfoharcodigo=T2.estadoinfoharcodigo AND T2.estadoinfoharnombre='APROBADO' AND T1.estadoasigharcodigo=T3.estadoasigharcodigo AND T3.estadoasigharnombre='NO ASIGNADO' AND T1.tipohardwarecodigo=T4.tipohardwarecodigo AND T1.marcahardwarecodigo=T5.marcahardwarecodigo AND T1.modelohardwarecodigo=T6.modelohardwarecodigo AND T1.colorhardwarecodigo=T7.colorhardwarecodigo AND T1.icodigo=T8.icodigo
	";

	$conexion = mainModel::conectar();
	$datos = $conexion->query($consulta);
	$datos= $datos->fetchAll();

	
			//InicioTabla_______________________________________________________________
	$tabla.='
	
	<thead>
	<tr>
	<th>#</th>
	<th>SERIE DEL HARDWARE</th>
	<th>HARDWARE DE INGRESO</th>
	<th>MARCA DE HARDWARE</th>
	<th>MODELO DE HARDWARE</th>
	<th>COLOR DE HARDWARE</th>
	<th>FECHA DE INGRESO</th>
	
	';
						//if ($privilegio<=2) {
	$tabla.='
	<th>ACCIONES</th>
	
	';
						//}
						//if ($privilegio==1) {
	
						//}
	$tabla.='</tr>
	</thead>
	<tbody>';
	
	$contador=0;
	foreach ($datos as $rows) {
		$contador=$contador+1;
		$a=$rows['hiserie'];
		$tabla.='
		<tr>
		<td>'.$contador.'</td>
		<td>'.$a.'</td>
		<td>'.$rows['tipohardwarenombre'].'</td>
		<td>'.$rows['marcahardwarenombre'].'</td>
		<td>'.$rows['modelohardwarenombre'].'</td>
		<td>'.$rows['colorhardwarenombre'].'</td>
		<td>'.$rows['hifecha'].'</td>
		';
						//if ($privilegio<=2) {
		$tabla.='
		<td>
		<form method="POST" action="'.SERVERURL.'asignacioninfo/">
		<input type="hidden" value="'.mainModel::encryption($a).'" name="codigo">
		<button type="submit" class="btn btn-primary"> Asignar</button>
		</form>    
		</td>

		
		';

						//}
						//if ($privilegio==1) {
							/*$tabla.='
							<td>
								<form action="'.SERVERURL.'ajax/administradorAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
									<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['CuentaCodigo']).'"></input>
									<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'"></input>
									<button type="submit" class="btn btn-danger btn-raised btn-xs">
										<i class="zmdi zmdi-delete"></i>
									</button>
									<div class="RespuestaAjax"></div>
								</form>
							</td>
							';*/
						}	
						$tabla.='
						</tr>
						';
						//$contador++;
				//}
						

						$tabla.='
						</tbody>
						';
			//Fin Tabla__________________________________________________________________
						return $tabla;
					}


		//LISTADO DE HARDWARE ASIGNADO
				public function listar_asignados_controlador(/*$privilegio,$codigo*/){
					
					$tabla="";
					$consulta="SELECT SQL_CALC_FOUND_ROWS *,T1.hardwareqr FROM hardware as T1, hardware_ingreso as T2, estado_info_hardware as T3, estado_asignacion_hardware as T4, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, informe_ingreso_hardware as T9, empleados as T10, cargo as T11, departemento as T12, empresa as T13 WHERE T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='ASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T2.icodigo=T9.icodigo AND T1.empleadocodigo=T10.empleadocodigo AND T10.cargocodigo=T11.cargocodigo AND T11.departamentocodigo=T12.departamentocodigo AND T12.empresacodigo=T13.empresacodigo
					";

					$conexion = mainModel::conectar();
					$datos = $conexion->query($consulta);
					$datos= $datos->fetchAll();

					
			//InicioTabla_______________________________________________________________
					$tabla.='
					
					<thead>
					<tr>
					<th>#</th>
					<th>SERIE DEL HARDWARE</th>
					<th>CÓDIGO QR</th>
					<th>HARDWARE DE INGRESO</th>
					<th>MARCA DE HARDWARE</th>
					<th>MODELO DE HARDWARE</th>
					<th>COLOR DE HARDWARE</th>
					<th>FECHA DE INGRESO</th>
					
					';
						//if ($privilegio<=2) {
					$tabla.='
					<th>ACCIONES</th>
					
					';
						//}
						//if ($privilegio==1) {
					
						//}
					$tabla.='</tr>
					</thead>
					<tbody>';
					
					$contador=0;
					foreach ($datos as $rows) {
						$contador=$contador+1;
						$a=$rows['hardwareqr'];
						$tabla.='
						<tr>
						<td>'.$contador.'</td>
						<td>'.$rows['hiserie'].'</td>
						<td>'.$a.'</td>
						<td>'.$rows['tipohardwarenombre'].'</td>
						<td>'.$rows['marcahardwarenombre'].'</td>
						<td>'.$rows['modelohardwarenombre'].'</td>
						<td>'.$rows['colorhardwarenombre'].'</td>
						<td>'.$rows['hifecha'].'</td>
						';
						//if ($privilegio<=2) {
						$tabla.='
						<td>
						<form method="POST" action="'.SERVERURL.'asignadosinfo/">
						<input type="hidden" value="'.mainModel::encryption($a).'" name="codigo">
						<button type="submit" class="btn btn-primary"> Información</button>
						</form>        
						</td>

						
						';

						//}
						//if ($privilegio==1) {
							/*$tabla.='
							<td>
								<form action="'.SERVERURL.'ajax/administradorAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
									<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['CuentaCodigo']).'"></input>
									<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'"></input>
									<button type="submit" class="btn btn-danger btn-raised btn-xs">
										<i class="zmdi zmdi-delete"></i>
									</button>
									<div class="RespuestaAjax"></div>
								</form>
							</td>
							';*/
						}	
						$tabla.='
						</tr>
						';
						//$contador++;
				//}
						

						$tabla.='
						</tbody>
						';
			//Fin Tabla__________________________________________________________________
						return $tabla;
					}




				//LISTADO DE HARDWARE PARA REASIGNAR A UN NUEVI EMPLEADO POST REALIZADA LA AUDITORIA A LA PERSONA QUE LO DEJO
				public function listar_liberados_controlador(/*$privilegio,$codigo*/){
					
					$tabla="";
					$consulta="SELECT SQL_CALC_FOUND_ROWS *,T1.hardwareqr FROM hardware as T1, hardware_ingreso as T2, estado_info_hardware as T3, estado_asignacion_hardware as T4, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, informe_ingreso_hardware as T9, empleados as T10, cargo as T11, departemento as T12, empresa as T13 WHERE T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='NO REASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T2.icodigo=T9.icodigo AND T1.empleadocodigo=T10.empleadocodigo AND T10.cargocodigo=T11.cargocodigo AND T11.departamentocodigo=T12.departamentocodigo AND T12.empresacodigo=T13.empresacodigo
					";

					$conexion = mainModel::conectar();
					$datos = $conexion->query($consulta);
					$datos= $datos->fetchAll();

					
			//InicioTabla_______________________________________________________________
					$tabla.='
					
					<thead>
					<tr>
					<th>#</th>
					<th>SERIE DEL HARDWARE</th>66
					<th>HARDWARE DE INGRESO</th>
					<th>MARCA DE HARDWARE</th>
					<th>MODELO DE HARDWARE</th>
					<th>COLOR DE HARDWARE</th>
					<th>FECHA DE INGRESO</th>
					
					';
						//if ($privilegio<=2) {
					$tabla.='
					<th>ACCIONES</th>
					
					';
						//}
						//if ($privilegio==1) {
					
						//}
					$tabla.='</tr>
					</thead>
					<tbody>';
					
					$contador=0;
					foreach ($datos as $rows) {
						$contador=$contador+1;
						$a=$rows['hiserie'];
						$tabla.='
						<tr>
						<td>'.$contador.'</td>
						<td>'.$rows['hiserie'].'</td>
						<td>'.$rows['tipohardwarenombre'].'</td>
						<td>'.$rows['marcahardwarenombre'].'</td>
						<td>'.$rows['modelohardwarenombre'].'</td>
						<td>'.$rows['colorhardwarenombre'].'</td>
						<td>'.$rows['hifecha'].'</td>
						';
						//if ($privilegio<=2) {
						$tabla.='
						<td>
						<form method="POST" action="'.SERVERURL.'reasignacioninfo/">
						<input type="hidden" value="'.mainModel::encryption($a).'" name="codigo">
						<button type="submit" class="btn btn-primary"> Reasignar</button>
						</form>        
						</td>

						
						';

						//}
						//if ($privilegio==1) {
							/*$tabla.='
							<td>
								<form action="'.SERVERURL.'ajax/administradorAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
									<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['CuentaCodigo']).'"></input>
									<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'"></input>
									<button type="submit" class="btn btn-danger btn-raised btn-xs">
										<i class="zmdi zmdi-delete"></i>
									</button>
									<div class="RespuestaAjax"></div>
								</form>
							</td>
							';*/
						}	
						$tabla.='
						</tr>
						';
						//$contador++;
				//}
						

						$tabla.='
						</tbody>
						';
			//Fin Tabla__________________________________________________________________
						return $tabla;
					}




				//LISTADO DE HARDWARE REASIGNADO A UN NUEVO EMPLEADO POST REALIZADA LA AUDITORIA A LA PERSONA QUE LO DEJO
				public function listar_reacontrasignados_controlador(/*$privilegio,$codigo*/){
					
					$tabla="";
					$consulta="SELECT SQL_CALC_FOUND_ROWS *,T1.hardwareqr FROM hardware as T1, hardware_ingreso as T2, estado_info_hardware as T3, estado_asignacion_hardware as T4, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, informe_ingreso_hardware as T9, empleados as T10, cargo as T11, departemento as T12, empresa as T13 WHERE T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='REASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T2.icodigo=T9.icodigo AND T1.empleadocodigo=T10.empleadocodigo AND T10.cargocodigo=T11.cargocodigo AND T11.departamentocodigo=T12.departamentocodigo AND T12.empresacodigo=T13.empresacodigo
					";

					$conexion = mainModel::conectar();
					$datos = $conexion->query($consulta);
					$datos= $datos->fetchAll();

					
			//InicioTabla_______________________________________________________________
					$tabla.='
					
					<thead>
					<tr>
					<th>#</th>
					<th>SERIE DEL HARDWARE</th>
					<th>CÓDIGO QR</th>
					<th>HARDWARE DE INGRESO</th>
					<th>MARCA DE HARDWARE</th>
					<th>MODELO DE HARDWARE</th>
					<th>COLOR DE HARDWARE</th>
					<th>FECHA DE INGRESO</th>
					
					';
						//if ($privilegio<=2) {
					$tabla.='
					<th>ACCIONES</th>
					
					';
						//}
						//if ($privilegio==1) {
					
						//}
					$tabla.='</tr>
					</thead>
					<tbody>';
					
					$contador=0;
					foreach ($datos as $rows) {
						$contador=$contador+1;
						$a=$rows['hardwareqr'];
						$tabla.='
						<tr>
						<td>'.$contador.'</td>
						<td>'.$rows['hiserie'].'</td>
						<td>'.$a.'</td>
						<td>'.$rows['tipohardwarenombre'].'</td>
						<td>'.$rows['marcahardwarenombre'].'</td>
						<td>'.$rows['modelohardwarenombre'].'</td>
						<td>'.$rows['colorhardwarenombre'].'</td>
						<td>'.$rows['hifecha'].'</td>
						';
						//if ($privilegio<=2) {
						$tabla.='
						<td>
						<form method="POST" action="'.SERVERURL.'reasignacioninfo/">
						<input type="hidden" value="'.mainModel::encryption($a).'" name="codigo">
						<button type="submit" class="btn btn-primary"> Reasignar</button>
						</form>        
						</td>

						
						';

						//}
						//if ($privilegio==1) {
							/*$tabla.='
							<td>
								<form action="'.SERVERURL.'ajax/administradorAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
									<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['CuentaCodigo']).'"></input>
									<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'"></input>
									<button type="submit" class="btn btn-danger btn-raised btn-xs">
										<i class="zmdi zmdi-delete"></i>
									</button>
									<div class="RespuestaAjax"></div>
								</form>
							</td>
							';*/
						}	
						$tabla.='
						</tr>
						';
						//$contador++;
				//}
						

						$tabla.='
						</tbody>
						';
			//Fin Tabla__________________________________________________________________
						return $tabla;
					}



					public function datos_reasignacion_controlador($tipo,$codigo){
						$codigo=mainModel::limpiar_cadena($codigo);
						$tipo=mainModel::limpiar_cadena($tipo);

						return reasignacionModelo::datos_reasignacion_modelo($tipo,$codigo);
					}

		//Controlador asignar hardware
					public function actualizar_hardware_controlador(){
						if (!empty($_POST['siesta-up']) && !empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['codqr-up']) && !empty($_POST['pers-reg']) && !empty($_POST['codimg-up'])) {

							$codqr=mainModel::limpiar_cadena($_POST['siesta-up']);
							$cuenta=mainModel::decryption($_POST['codigo']);
							$dni=mainModel::limpiar_cadena($_POST['codigo-up']);

							$qr=mainModel::limpiar_cadena($_POST['codqr-up']);
				//
							$empleado=mainModel::limpiar_cadena($_POST['pers-reg']);
				//			
							$codimg=mainModel::limpiar_cadena($_POST['codimg-up']);
							$imagen=$codimg.'.png';
							$final=$codimg;

							$estado1='ACTIVO';
							$fecha=date("Y-m-d");
							
							$queryverf=mainModel::ejecutar_consulta_simple("SELECT estadohardwarecodigo FROM estado_hardware WHERE estadohardwarenombre='$estado1'");
							$DatosVest=$queryverf->fetch();
							$estado=$DatosVest['estadohardwarecodigo'];


							if ($queryverf->rowCount()>=1) {


								$reasignado='REASIGNADO';

								$query1=mainModel::ejecutar_consulta_simple("SELECT estadoasigharcodigo FROM estado_asignacion_hardware WHERE estadoasigharnombre='$reasignado'");
								$DatosEstado=$query1->fetch();
								$data=$DatosEstado['estadoasigharcodigo'];


								if ($query1->rowCount()>=1) {



									$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM hardware WHERE hardwareqr='$qr'");
									$DatosQR=$query1->fetch();

									if ($dni!=$DatosQR['hardwareqr']) {
										$consulta1=mainModel::ejecutar_consulta_simple("SELECT hardwareqr FROM hardware WHERE hardwareqr='$qr'");
										if ($consulta1->rowCount()>=1) {
											$alerta=[
												"Alerta"=>"simple",
												"Titulo"=>"Ocurrió un error inesperado",
												"Texto"=>"El código QR que acaba de ingresar ya se encuentra registrado en el sistema, por favor intente nuevamente recargando la pagina",
												"Tipo"=>"error"
											];
											return mainModel::sweet_alert($alerta);
											exit();
										}
									}

									




									$informacion=mainModel::ejecutar_consulta_simple("SELECT empleadonombres,empleadoapellidos FROM empleados WHERE empleadocodigo='$empleado'");
									$DatosEmpleado=$informacion->fetch();
									$infoempnom=$DatosEmpleado['empleadonombres'];
									$infoempape=$DatosEmpleado['empleadoapellidos'];






									$editharing=mainModel::ejecutar_consulta_simple("UPDATE hardware_ingreso SET estadoasigharcodigo='$data' WHERE hiserie='$dni'");




									if ($editharing->rowCount()>=1) {

										$edithar=mainModel::ejecutar_consulta_simple("UPDATE hardware SET hardwareqr='$qr', empleadocodigo='$empleado',hifecha='$fecha',hiimagenqr='$imagen' WHERE hardwareqr='$codqr'");

										$direccion='../imagenes_qr/';
										$extension='png';
										$imgmover='../temp/test.png';
										rename($imgmover, $direccion.$final.'.'.$extension);

										$alerta=[
											"Alerta"=>"recargar",
											"Titulo"=>"Felicitaciones!",
											"Texto"=>"La reasignación del hardware al empleado $infoempape $infoempnom ha sido un éxito",
											"Tipo"=>"success"
										];

									}else{
										$alerta=[
											"Alerta"=>"simple",
											"Titulo"=>"Ocurrió un error inesperado",
											"Texto"=>"Usted no ha realizado ningun cambio o su número de serie ya se encuentra registrado en el sistema, porfavor intente nuevamente, si los problemas persisten contactese con el desarrollador del sistema",
											"Tipo"=>"error"
										];
									}



								}else{
									$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Ocurrio un error inesperado",
										"Texto"=>"Primero debe ingresar los estados de la asignación del hardware que vienen por defecto en el sistema, si los problemas persisten contactese con el desarrollador del sistema",
										"Tipo"=>"error"
									];	
								}
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"Primero debe ingresar los estados del hardware que vienen por defecto en el sistema, si los problemas persisten contactese con el desarrollador del sistema",
									"Tipo"=>"error"
								];	
							}

						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"Es necesario que haya seleccionado a una persona para la reasignación, por favor selecciónela e intente nuevamente",
								"Tipo"=>"error"
							];
						}
						return mainModel::sweet_alert($alerta);
					}
				}