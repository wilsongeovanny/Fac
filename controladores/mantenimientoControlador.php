<?php 
if ($peticionAjax) {
	require_once "../modelos/mantenimientoModelo.php";
}else{
	require_once "./modelos/mantenimientoModelo.php";
}  

class mantenimientoControlador extends mantenimientoModelo{

	
//LISTADO DE HARDWARE ASIGNADO
public function listar_mantenimiento_controlador(/*$privilegio,$codigo*/){

	$tabla="";

	//Consulta para la busqueda del hardware asignado, liberado, reasignado para su respectivo mantenimiento.

	
	//Consulta para imprimir el informe tecnico de entrega posterior a haber realizado su respectivo mantenimiento.
	//Para la búsqueda se utilizo una tabla dinamica de la pnatilla de Gentellas Master.
	$consulta="SELECT *,T1.hiserie FROM hardware as T1, hardware_ingreso as T2, estado_info_hardware as T3, estado_asignacion_hardware as T4, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, informe_ingreso_hardware as T9, empleados as T10 WHERE (T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='ASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T2.icodigo=T9.icodigo AND T1.empleadocodigo=T10.empleadocodigo) OR (T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='REASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T2.icodigo=T9.icodigo AND T1.empleadocodigo=T10.empleadocodigo) OR (T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='NO REASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T2.icodigo=T9.icodigo AND T1.empleadocodigo=T10.empleadocodigo)
	";

	$conexion = mainModel::conectar();
	$datos = $conexion->query($consulta);
	$datos= $datos->fetchAll();


			//InicioTabla_______________________________________________________________
	$tabla.='

	<thead>
	<tr>
	<th>#</th>
	<th>CÓDIGO QR</th>
	<th>COD. DE INVENTARIO</th>
	<th># DE SERIE</th>
	<th>TIPO</th>
	<th>MARCA</th>
	<th>MODELO</th>
	<th>COLOR</th>
	<th>ESTADO</th>
	<th>FECHA DE INGRESO</th>

	';
						//if ($privilegio<=2) {
	$tabla.='
	<th>ACCIÓN</th>

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
		//$b='holas';
		$tabla.='
		<tr>
		<td>'.$contador.'</td>
		<td>'.$a.'</td>
		<td>'.$rows['hiserie'].'</td>
		<td>'.$rows['serireexterno'].'</td>
		<td>'.$rows['tipohardwarenombre'].'</td>
		<td>'.$rows['marcahardwarenombre'].'</td>
		<td>'.$rows['modelohardwarenombre'].'</td>
		<td>'.$rows['colorhardwarenombre'].'</td>
		<td>'.$rows['estadoasigharnombre'].'</td>
		<td>'.$rows['hifecha'].'</td>
		';
						//if ($privilegio<=2) {
		$tabla.='
		<td>
		<form method="POST" action="'.SERVERURL.'mantenimientoinfo/">
		<input type="hidden" value="'.trim($rows['hiserie']).'" name="codigo">
		<button type="submit" class="btn btn-primary"><i class="fa fa-folder-open-o"></i> Historial</button>
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





		//LISTADO DE HARDWARE QUE ESPERA EL MANTENIMIENTO
		public function listar_enreparacion_controlador(/*$privilegio,$codigo*/){

		$tabla="";

			//Consulta para la busqueda del hardware para imprimir la hoja del diagnostico generado.

			//Consulta para la búsqueda del hardware para generar el informe técnico de entrega posterior a su respectivo mantenimiento
			//Para la búsqueda se utilizo una tabla dinamica de la pnatilla de Gentellas Master
			$consulta="SELECT *,T1.hiserie FROM hardware as T1, hardware_ingreso as T2, estado_info_hardware as T3, estado_asignacion_hardware as T4, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, informe_ingreso_hardware as T9, empleados as T10, mantenimiento as T11, estado_mantenimiento as T12 WHERE (T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='ASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T2.icodigo=T9.icodigo AND T1.empleadocodigo=T10.empleadocodigo AND T1.hardwareqr=T11.hardwareqr AND T11.estadomantenimientocodigo=T12.estadomantenimientocodigo AND T12.estadomantenimientonombre='EN REPARACION') OR (T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='REASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T2.icodigo=T9.icodigo AND T1.empleadocodigo=T10.empleadocodigo AND T1.hardwareqr=T11.hardwareqr AND T11.estadomantenimientocodigo=T12.estadomantenimientocodigo AND T12.estadomantenimientonombre='EN REPARACION') OR (T1.hiserie=T2.hiserie AND T2.estadoinfoharcodigo=T3.estadoinfoharcodigo AND T3.estadoinfoharnombre='APROBADO' AND T2.estadoasigharcodigo=T4.estadoasigharcodigo AND T4.estadoasigharnombre='NO REASIGNADO' AND T2.tipohardwarecodigo=T5.tipohardwarecodigo AND T2.marcahardwarecodigo=T6.marcahardwarecodigo AND T2.modelohardwarecodigo=T7.modelohardwarecodigo AND T2.colorhardwarecodigo=T8.colorhardwarecodigo AND T2.icodigo=T9.icodigo AND T1.empleadocodigo=T10.empleadocodigo AND T1.hardwareqr=T11.hardwareqr AND T11.estadomantenimientocodigo=T12.estadomantenimientocodigo AND T12.estadomantenimientonombre='EN REPARACION')
			";

		$conexion = mainModel::conectar();
		$datos = $conexion->query($consulta);
		$datos= $datos->fetchAll();


		//InicioTabla_______________________________________________________________
		$tabla.='

			<thead>
			<tr>
			<th>#</th>
			<th>CÓDIGO QR</th>
			<th>COD. DE INVENTARIO</th>
			<th># DE SERIE</th>
			<th>TIPO</th>
			<th>MARCA</th>
			<th>MODELO</th>
			<th>COLOR</th>
			<th>ESTADO</th>
			<th>FECHA DE INGRESO</th>

		';
						//if ($privilegio<=2) {
		$tabla.='
			<th>ACCIÓN</th>

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
		//$b='holas';
			$tabla.='
			<tr>
			<td>'.$contador.'</td>
			<td>'.$a.'</td>
			<td>'.$rows['hiserie'].'</td>
			<td>'.$rows['serireexterno'].'</td>
			<td>'.$rows['tipohardwarenombre'].'</td>
			<td>'.$rows['marcahardwarenombre'].'</td>
			<td>'.$rows['modelohardwarenombre'].'</td>
			<td>'.$rows['colorhardwarenombre'].'</td>
			<td>'.$rows['estadoasigharnombre'].'</td>
			<td>'.$rows['hifecha'].'</td>
			';
							//if ($privilegio<=2) {
			$tabla.='
			<td>
			<form method="POST" action="'.SERVERURL.'mantenimientoinfo/">
			<input type="hidden" value="'.trim($rows['hiserie']).'" name="codigo">
			<button type="submit" class="btn btn-primary"><i class="fa fa-folder-open-o"></i> Historial</button>
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



					//LISTADO DE HARDWARE QUE ESPERA EL MANTENIMIENTO
		public function listar_dadodebaja_controlador(/*$privilegio,$codigo*/){

		$tabla="";

			$consulta="SELECT *,T1.hiserie FROM hardware as T1, estado_hardware as T2, hardware_ingreso as T3, tipo_hardware as T4, marca_hardware as T5, modelo_hardware as T6, color_hardware as T7, estado_info_hardware as T8, estado_asignacion_hardware as T9 WHERE (T1.hiserie=T3.hiserie AND T1.estadohardwarecodigo=T2.estadohardwarecodigo AND T2.estadohardwarenombre='DADO DE BAJA' AND T3.tipohardwarecodigo=T4.tipohardwarecodigo AND T3.marcahardwarecodigo=T5.marcahardwarecodigo AND T3.modelohardwarecodigo=T6.modelohardwarecodigo AND T3.colorhardwarecodigo=T7.colorhardwarecodigo AND T3.estadoinfoharcodigo=T8.estadoinfoharcodigo AND T8.estadoinfoharnombre='APROBADO' AND T3.estadoasigharcodigo=T9.estadoasigharcodigo AND T9.estadoasigharnombre='ASIGNADO') OR (T1.hiserie=T3.hiserie AND T1.estadohardwarecodigo=T2.estadohardwarecodigo AND T2.estadohardwarenombre='DADO DE BAJA' AND T3.tipohardwarecodigo=T4.tipohardwarecodigo AND T3.marcahardwarecodigo=T5.marcahardwarecodigo AND T3.modelohardwarecodigo=T6.modelohardwarecodigo AND T3.colorhardwarecodigo=T7.colorhardwarecodigo AND T3.estadoinfoharcodigo=T8.estadoinfoharcodigo AND T8.estadoinfoharnombre='APROBADO' AND T3.estadoasigharcodigo=T9.estadoasigharcodigo AND T9.estadoasigharnombre='REASIGNADO') OR (T1.hiserie=T3.hiserie AND T1.estadohardwarecodigo=T2.estadohardwarecodigo AND T2.estadohardwarenombre='DADO DE BAJA' AND T3.tipohardwarecodigo=T4.tipohardwarecodigo AND T3.marcahardwarecodigo=T5.marcahardwarecodigo AND T3.modelohardwarecodigo=T6.modelohardwarecodigo AND T3.colorhardwarecodigo=T7.colorhardwarecodigo AND T3.estadoinfoharcodigo=T8.estadoinfoharcodigo AND T8.estadoinfoharnombre='APROBADO' AND T3.estadoasigharcodigo=T9.estadoasigharcodigo AND T9.estadoasigharnombre='NO REASIGNADO')

		";

		$conexion = mainModel::conectar();
		$datos = $conexion->query($consulta);
		$datos= $datos->fetchAll();


		//InicioTabla_______________________________________________________________
		$tabla.='

			<thead>
			<tr>
			<th>#</th>
			<th>CÓDIGO QR</th>
			<th>COD. DE INVENTARIO</th>
			<th># DE SERIE</th>
			<th>TIPO</th>
			<th>MARCA</th>
			<th>MODELO</th>
			<th>COLOR</th>
			<th>ESTADO</th>
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
		//$b='holas';
			$tabla.='
			<tr>
			<td>'.$contador.'</td>
			<td>'.$a.'</td>
			<td>'.$rows['hiserie'].'</td>
			<td>'.$rows['serireexterno'].'</td>
			<td>'.$rows['tipohardwarenombre'].'</td>
			<td>'.$rows['marcahardwarenombre'].'</td>
			<td>'.$rows['modelohardwarenombre'].'</td>
			<td>'.$rows['colorhardwarenombre'].'</td>
			<td>'.$rows['estadoasigharnombre'].'</td>
			<td>'.$rows['hifecha'].'</td>
			';
							//if ($privilegio<=2) {
			$tabla.='
			<td>
			<form method="POST" action="'.SERVERURL.'mantenimientoinfo/">
			<input type="hidden" value="'.trim($rows['hiserie']).'" name="codigo">
			<button type="submit" class="btn btn-primary"><i class="fa fa-folder-open-o"></i> Historial</button>
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



					public function datos_mantenimiento_controlador($tipo,$codigo){
						$codigo=mainModel::limpiar_cadena($codigo);
						$tipo=mainModel::limpiar_cadena($tipo);

						return mantenimientoModelo::datos_mantenimiento_modelo($tipo,$codigo);
					}

}

