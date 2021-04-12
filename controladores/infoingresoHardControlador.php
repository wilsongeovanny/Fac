<?php 
if ($peticionAjax) {
	require_once "../modelos/infoingresoHardModelo.php";
}else{
	require_once "./modelos/infoingresoHardModelo.php";
}  

class infoingresoHardControlador extends infoingresoHardModelo{

		//Controlador para agregar administrador
	public function agregar_infoingresoHard_controlador(){
		if (!empty($_POST['respo-reg']) && !empty($_POST['tema-reg']) && !empty($_POST['fecha-reg']) && !empty($_POST['servicio-reg']) && !empty($_POST['trabajo-reg']) && !empty($_POST['antecedente-reg']) && !empty($_POST['objetivo-reg']) && !empty($_POST['analisis-reg']) && !empty($_POST['conclusion-reg']) && !empty($_POST['recomendacion-reg']) && !empty($_POST['item'])) {

			$tema=mainModel::limpiar_cadena($_POST['tema-reg']);
			/*OTRO*///$fecha=mainModel::limpiar_cadena($_POST['fecha-reg']);
			$fecha=$_POST['fecha-reg'];
			$servicio=mainModel::limpiar_cadena($_POST['servicio-reg']);
			$trabajo=mainModel::limpiar_cadena($_POST['trabajo-reg']);
			$antecedente=mainModel::limpiar_cadena($_POST['antecedente-reg']);
			$objtetivo=mainModel::limpiar_cadena($_POST['objetivo-reg']);
			$analisis=mainModel::limpiar_cadena($_POST['analisis-reg']);

			$detail = $_POST["item"];

			/*     aqui va hardware      */

			$conclusion=mainModel::limpiar_cadena($_POST['conclusion-reg']);
			$recomendacion=mainModel::limpiar_cadena($_POST['recomendacion-reg']);
			$elnombre=mainModel::limpiar_cadena($_POST['respo-reg']);

			$es='null';
			
			/*OTRO*///$estado=mainModel::limpiar_cadena($_POST['estado-reg']);


			if(!empty($_POST['vnombre-up'])){
				$estado=mainModel::limpiar_cadena($_POST['vnombre-up']);
			}else{
				$estado='null';
			}

			if ($estado!='null') {

			$vnombre=mainModel::limpiar_cadena($_POST['vnombre-up']);

				$max1=strlen($antecedente);
				$max2=strlen($objtetivo);
				$max3=strlen($analisis);
				$max4=strlen($conclusion);
				$max5=strlen($recomendacion);
				$carmax=255;

				if ($max1<=$carmax && $max2<=$carmax && $max3<=$carmax && $max4<=$carmax && $max5<=$carmax) {

				


					$informe=mainModel::ejecutar_consulta_simple("SELECT icodigo FROM informe_ingreso_hardware");
					$numero1=($informe->rowCount())+1;
					$codinfo=mainModel::generar_codigo_aleatorio("INFINGHAD",7,$numero1);

					$consulta1=mainModel::ejecutar_consulta_simple("SELECT icodigo FROM informe_ingreso_hardware WHERE icodigo='$codinfo'");
					$c1=$codinfo;
					if ($consulta1->rowCount()<=0) {
						

						$datosinfoingresoHard=[
							"ICOD"=>$c1,
							"ITEM"=>$tema,
							"ISERVICIO"=>$servicio,
							"ITRABAJO"=>$trabajo,
							"IANTE"=>$antecedente,
							"IOBJ"=>$objtetivo,
							"IANALIS"=>$analisis,
							"ICONCL"=>$conclusion,
							"IRECOM"=>$recomendacion,
							"IELAB"=>$elnombre,
							"IVISTO"=>$vnombre
						];
						$guardarinfoingresoHard=infoingresoHardModelo::agregar_infoingresoHard_modelo($datosinfoingresoHard);
						if ($guardarinfoingresoHard->rowCount()>=1) {



											$varestado='NO ASIGNADO';
											$consultasig=mainModel::ejecutar_consulta_simple("SELECT estadoasigharcodigo FROM estado_asignacion_hardware WHERE estadoasigharnombre='$varestado'");
											$DatosASIG=$consultasig->fetch();

											if (isset($DatosASIG['estadoasigharcodigo'])) {
												$estadosasig=$DatosASIG['estadoasigharcodigo'];
												




											//SI SE NECESITARA GENERAR UN CODIGO PARA ESTE REGISTRO
											/*$empleado3=mainModel::ejecutar_consulta_simple("SELECT empinfohardcodigo FROM hardware_ingreso");
											$numero4=($empleado3->rowCount())+1;
											$codihad=mainModel::generar_codigo_aleatorio("INVENT",7,$numero4);

											$empleado3=mainModel::ejecutar_consulta_simple("SELECT empinfohardcodigo FROM hardware_ingreso");
												$numero4=($empleado3->rowCount())+1;
												$inventario=mainModel::generar_codigo_aleatorio("INVENT",7,$numero4);*/
											
											for ($i = 0; $i < sizeof($detail['serie']); $i++) {	

												$empleado3=mainModel::ejecutar_consulta_simple("SELECT hiserie FROM hardware_ingreso");
												$numero10=($empleado3->rowCount())+1;
												$inventario=mainModel::generar_codigo_aleatorio("INVENT",7,$numero10);
												$consultainv=mainModel::ejecutar_consulta_simple("SELECT hiserie FROM hardware_ingreso WHERE hiserie='$inventario'");

												if ($consultainv->rowCount()>=1) {
													$alerta=[
														"Alerta"=>"simple",
														"Titulo"=>"Ocurrió un error inesperado",
														"Texto"=>"El código de inventario que se asigno esta ingresanso duplicado, por favor intente nuevamente recargando la página",
														"Tipo"=>"error"
													];
													return mainModel::sweet_alert($alerta);
													exit();
												}

												//$aaa=$detail['serie'][$i];
												/*$consultaserie=mainModel::ejecutar_consulta_simple("SELECT serireexterno FROM hardware_ingreso WHERE serireexterno='$aaa");

												if ($consultaserie->rowCount()>=1) {
													$alerta=[
														"Alerta"=>"simple",
														"Titulo"=>"Ocurrió un error inesperado",
														"Texto"=>"El código de inventario que se asigno esta ingresanso duplicado, por favor intente nuevamente con otro código",
														"Tipo"=>"error"
													];
													return mainModel::sweet_alert($alerta);
													exit();
												}*/


												$datosinfohar=[
													"HCODIGO"=>$inventario,
													"EXTERNO"=>$detail['serie'][$i],
													"HMODELO"=>$detail['modelo'][$i],
													"HTIPO"=>$detail['tipo'][$i],
													"HMARCA"=>$detail['marca'][$i],
													"HESTADO"=>$detail['estado'][$i],
													"HCOLOR"=>$detail['color'][$i],
													"HINFOCOD"=>$c1,
													"ESTADOASIG"=>$estadosasig,
													"HFECHA"=>$fecha,
													"HTITULO"=>$detail['titulo'][$i],
													"HCARAC"=>$detail['carac'][$i],
													"HCABLE"=>$detail['cable'][$i],
													"HOBS"=>$detail['obs'][$i]

												];
												$guardarinfohar=infoingresoHardModelo::agregar_informaHardware_modelo($datosinfohar);


											}
											if ($guardarinfohar->rowCount()>=1) {



												$alerta=[
													"Alerta"=>"recargar",
													"Titulo"=>"Felicitaciones!",
													"Texto"=>"El informe de ingreso de hardware se ha registrado con éxito",
													"Tipo"=>"success"
												];




											}else{
												$eliminaras=mainModel::ejecutar_consulta_simple("DELETE FROM informe_ingreso_hardware WHERE icodigo='$c1'");
												//$eliminaras1=mainModel::ejecutar_consulta_simple("DELETE FROM empinfo_hardware_ingreso WHERE empinfohardcodigo='$c2'");
												//$eliminaras2=mainModel::ejecutar_consulta_simple("DELETE FROM empinfo_hardware_ingreso WHERE empinfohardcodigo='$c3'");
												$alerta=[
													"Alerta"=>"simple",
													"Titulo"=>"Ocurrio un error inesperado",
													"Texto"=>"No se ha podido ingresar el informe, porfavor intente nuevamnete",
													"Tipo"=>"error"
												];	
											}	






										}else{
											//$eliminaras=mainModel::ejecutar_consulta_simple("DELETE FROM informe_ingreso_hardware WHERE icodigo='$c1'");
											//$eliminaras1=mainModel::ejecutar_consulta_simple("DELETE FROM empinfo_hardware_ingreso WHERE empinfohardcodigo='$c2'");
											//$eliminaras2=mainModel::ejecutar_consulta_simple("DELETE FROM empinfo_hardware_ingreso WHERE empinfohardcodigo='$c3'");
											$alerta=[
												"Alerta"=>"simple",
												"Titulo"=>"Ocurrio un error inesperado",
												"Texto"=>"Para realizar este proceso debe tener ingresado los dos estados de asignación de hardware, porfavor intente nuevamnete",
												"Tipo"=>"error"
											];	
										}	


						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"No se ha podido guardar el informe del hardware de ingreso, porfavor intente nuevamente",
								"Tipo"=>"error"
							];	
						}

					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El código que se genero para el informe de ingreso del hardware ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
							"Tipo"=>"error"
						];
					}

				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El número de caracteres ingresados en un uno de los campos es mayor al número permitido, por favor verifique e intente nuevamente ",
						"Tipo"=>"error"
					];
				}

			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Es necesario que ingreso todos los campos, por favor llénelos e intente nuevamente",
					"Tipo"=>"error"
				];
			}

		}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Es necesario que ingreso todos los campos, por favor llénelos e intente nuevamente",
					"Tipo"=>"error"
				];
		}
		return mainModel::sweet_alert($alerta);
	}


		//CONTROLADOR PARA LISTAR HARDWARE RECHAZADO
public function listar_infoingresoHard_controlador(/*$privilegio,$codigo*/){


			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);


	$tabla="";

	//Consulta para la búsqueda del informe aprobado de ingreso de hardware requerido
	//Para la búsqueda se utilizo una tabla dinamica de la plantilla F¿Gentellas Master
	$consulta="SELECT *,T1.icodigo FROM informe_ingreso_hardware as T1, hardware_ingreso as T3, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, estado_info_hardware as T9 WHERE T3.icodigo=T1.icodigo AND T3.tipohardwarecodigo=T5.tipohardwarecodigo AND T3.marcahardwarecodigo=T6.marcahardwarecodigo AND T3.modelohardwarecodigo=T7.modelohardwarecodigo AND T3.colorhardwarecodigo=T8.colorhardwarecodigo AND T3.estadoinfoharcodigo=T9.estadoinfoharcodigo AND T9.estadoinfoharnombre='APROBADO'";

	$conexion = mainModel::conectar();

	$datos = $conexion->query($consulta);
	$datos= $datos->fetchAll();




			//InicioTabla_______________________________________________________________
	$tabla.='

	<thead>
	<tr>
	<th>#</th>
	<th>TITULO DEL INFORME</th>
	<th>COD INVENTARIO</th>
	<th>SERIE DEL HARDWARE</th>
	'./*<th>HARDWARE DE INGRESO</th>*/'
	<th>TIPO DE HARDWARE</th>
	<th>MARCA DE HARDWARE</th>
	<th>MODELO DE HARDWARE</th>
	<th>COLOR DE HARDWARE</th>
	<th>ESTADO DE VERIFICACIÓN</th>
	<th>FECHA DE VERIFICACIÓN</th>

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
		$tabla.='
		<tr>
		<td>'.$contador.'</td>
		<td>'.$rows['itema'].'</td>
		<td>'.$rows['hiserie'].'</td>
		<td>'.$rows['serireexterno'].'</td>
		'./*<td>'.$rows['hititulo'].'</td>*/'
		<td>'.$rows['tipohardwarenombre'].'</td>
		<td>'.$rows['marcahardwarenombre'].'</td>
		<td>'.$rows['modelohardwarenombre'].'</td>
		<td>'.$rows['colorhardwarenombre'].'</td>
		<td>'.$rows['estadoinfoharnombre'].'</td>
		<td>'.$rows['hifecha'].'</td>
		';
						//if ($privilegio<=2) {
		$tabla.='
		<td>
		<form method="POST" action="'.SERVERURL.'inforingresohardinfo/">
		<input type="hidden" value="'.$rows['hiserie'].'" name="codigo">
		<button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-primary"> Informe</button>
		</form>
		<form method="POST" action="'.SERVERURL.'informacionharingreso/">
		<input type="hidden" value="'.$rows['hiserie'].'" name="codigo">
		<button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-primary"> Hardware</button>
		</form>




		<a style="font-size:15px; borderbox:0px; width:100px;" method="post" height:36px;" href="'.SERVERURL.'Reportes/Informe.php?Cod='.$rows['hiserie'].'" title="Visualizar Informe" target="_blank" class="btn btn-secondary">
		<i class="fa fa-print"></i>
		</a>



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
						$contador++;
				//}


						$tabla.='
						</tbody>
						';
			//Fin Tabla__________________________________________________________________



						return $tabla;
					}

				//CONTROLADOR PARA LISTAR HARDWARE RECHAZADO
				public function listar_infoingresorechazo_controlador(/*$privilegio,$codigo*/){


			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);


					$tabla="";



		//Consulta para la búsqueda del informe rechazado de ingreso de hardware requerido
		//Para la búsqueda se utilizo una tabla dinamica de la plantilla F¿Gentellas Master
		$consulta="SELECT *,T1.icodigo FROM informe_ingreso_hardware as T1, hardware_ingreso as T3, tipo_hardware as T5, marca_hardware as T6, modelo_hardware as T7, color_hardware as T8, estado_info_hardware as T9 WHERE T3.icodigo=T1.icodigo AND T3.tipohardwarecodigo=T5.tipohardwarecodigo AND T3.marcahardwarecodigo=T6.marcahardwarecodigo AND T3.modelohardwarecodigo=T7.modelohardwarecodigo AND T3.colorhardwarecodigo=T8.colorhardwarecodigo AND T3.estadoinfoharcodigo=T9.estadoinfoharcodigo AND T9.estadoinfoharnombre='RECHAZADO'";


					$conexion = mainModel::conectar();

					$datos = $conexion->query($consulta);
					$datos= $datos->fetchAll();




			//InicioTabla_______________________________________________________________
	$tabla.='

	<thead>
	<tr>
	<th>#</th>
	<th>TITULO DEL INFORME</th>
	<th>COD INVENTARIO</th>
	<th>SERIE DEL HARDWARE</th>
	'./*<th>HARDWARE DE INGRESO</th>*/'
	<th>TIPO DE HARDWARE</th>
	<th>MARCA DE HARDWARE</th>
	<th>MODELO DE HARDWARE</th>
	<th>COLOR DE HARDWARE</th>
	<th>ESTADO DE VERIFICACIÓN</th>
	<th>FECHA DE VERIFICACIÓN</th>

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
		$tabla.='
		<tr>
		<td>'.$contador.'</td>
		<td>'.$rows['itema'].'</td>
		<td>'.$rows['hiserie'].'</td>
		<td>'.$rows['serireexterno'].'</td>
		'./*<td>'.$rows['hititulo'].'</td>*/'
		<td>'.$rows['tipohardwarenombre'].'</td>
		<td>'.$rows['marcahardwarenombre'].'</td>
		<td>'.$rows['modelohardwarenombre'].'</td>
		<td>'.$rows['colorhardwarenombre'].'</td>
		<td>'.$rows['estadoinfoharnombre'].'</td>
		<td>'.$rows['hifecha'].'</td>
		';
						//if ($privilegio<=2) {
		$tabla.='
		<td>
		<form method="POST" action="'.SERVERURL.'inforingresohardinfo/">
		<input type="hidden" value="'.$rows['hiserie'].'" name="codigo">
		<button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-primary"> Informe</button>
		</form>
		<form method="POST" action="'.SERVERURL.'informacionharingreso/">
		<input type="hidden" value="'.$rows['hiserie'].'" name="codigo">
		<button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-primary"> Hardware</button>
		</form>




		<a style="font-size:15px; borderbox:0px; width:100px;" method="post" height:36px;" href="'.SERVERURL.'Reportes/Informe.php?Cod='.$rows['hiserie'].'/" title="Visualizar Informe" target="_blank" class="btn btn-secondary">
		<i class="fa fa-print"></i>
		</a>



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
						$contador++;
				//}


						$tabla.='
						</tbody>
						';
			//Fin Tabla__________________________________________________________________



						return $tabla;
					}

					public function datos_infoingresoHard_controlador($tipo,$codigo){
						$codigo=mainModel::limpiar_cadena($codigo);
						$tipo=mainModel::limpiar_cadena($tipo);

						return infoingresoHardModelo::datos_infoingresoHard_modelo($tipo,$codigo);
					}

		//Controlador actualizar el nombre del menú
					public function actualizar_informe_controlador(){

						if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['respo-reg']) && !empty($_POST['tema-up']) && !empty($_POST['servicio-up']) && !empty($_POST['trabajo-up']) && !empty($_POST['antecedente-up']) && !empty($_POST['objetivo-up']) && !empty($_POST['analisis-up']) && !empty($_POST['conclusion-up']) && !empty($_POST['recomendacion-up']) && !empty($_POST['vnombre-up']) && !empty($_POST['informe-up'])) {


							$cuenta=mainModel::limpiar_cadena($_POST['codigo']);
							$dni=mainModel::limpiar_cadena($_POST['codigo-up']);

							$tema=mainModel::limpiar_cadena($_POST['tema-up']);
							//$fecha=$_POST['fecha-up'];
							$servicio=mainModel::limpiar_cadena($_POST['servicio-up']);
							$trabajo=mainModel::limpiar_cadena($_POST['trabajo-up']);
							$antecedente=mainModel::limpiar_cadena($_POST['antecedente-up']);
							$objtetivo=mainModel::limpiar_cadena($_POST['objetivo-up']);
							$analisis=mainModel::limpiar_cadena($_POST['analisis-up']);

							$conclusion=mainModel::limpiar_cadena($_POST['conclusion-up']);
							$recomendacion=mainModel::limpiar_cadena($_POST['recomendacion-up']);
							$elnombre=mainModel::limpiar_cadena($_POST['respo-reg']);
							$vnombre=mainModel::limpiar_cadena($_POST['vnombre-up']);

							$informe=mainModel::limpiar_cadena($_POST['informe-up']);


				//$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM hardware_ingreso WHERE hiserie='$cuenta'");
				//$DatosInforme=$query1->fetch();

				//$icod=$DatosInforme['icodigo'];
							$max1=strlen($antecedente);
							$max2=strlen($objtetivo);
							$max3=strlen($analisis);
							$max4=strlen($conclusion);
							$max5=strlen($recomendacion);
							$carmax=255;

							if ($max1<=$carmax && $max2<=$carmax && $max3<=$carmax && $max4<=$carmax && $max5<=$carmax) {
								$datainforme=[

									"TEMA"=>$tema,
									"SERVICIO"=>$servicio,
									"LUGAR"=>$trabajo,
									"ANTECEDENTE"=>$antecedente,
									"OBJETIVO"=>$objtetivo,
									"ANALISIS"=>$analisis,
									"CONCLUSION"=>$conclusion,
									"RECOMEND"=>$recomendacion,
									"RESPONSABLE"=>$elnombre,
									"VISTO"=>$vnombre,
									"CODIGO"=>$informe

								];
								$editarinforme=infoingresoHardModelo::actualizar_informe_modelo($datainforme);
								if ($editarinforme->rowCount()>=1) {


											$alerta=[
												"Alerta"=>"recargar",
												"Titulo"=>"Felicitaciones",
												"Texto"=>"El informe de ingreso de hardware se ha actualizado con éxito",
												"Tipo"=>"success"
											];


								}else{
									$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Ocurrió un error inesperado",
										"Texto"=>"Para actualizar los datos del informe de ingreso de hardware es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
										"Tipo"=>"error"
									];
								}
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrió un error inesperado",
									"Texto"=>"El número de caracteres ingresados en un uno de los campos es mayor al número permitido, por favor verifique e intente nuevamente ",
									"Tipo"=>"error"
								];
							}
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"Es necesario que ingreso todos los campos, por favor llénelos e intente nuevamente",
								"Tipo"=>"error"
							];
						}
						return mainModel::sweet_alert($alerta);
					}







					public function actualizar_hardware_controlador(){
						if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['titulo-up']) && !empty($_POST['tipo-up']) && !empty($_POST['marca-up']) && !empty($_POST['modelo-up']) && !empty($_POST['color-up']) && !empty($_POST['carac-up']) && !empty($_POST['cable-up']) && !empty($_POST['obs-up']) && !empty($_POST['estado-up']) && !empty($_POST['externo-up']) && !empty($_POST['informe-up'])) {

							$cuenta=mainModel::limpiar_cadena($_POST['codigo']);
							$dni=mainModel::limpiar_cadena($_POST['codigo-up']);

							//$fecha=$_POST['fecha-up'];

							$titulo=mainModel::limpiar_cadena($_POST['titulo-up']);
							$tipo=mainModel::limpiar_cadena($_POST['tipo-up']);
							$marca=mainModel::limpiar_cadena($_POST['marca-up']);
							$modelo=mainModel::limpiar_cadena($_POST['modelo-up']);
							//$serie=mainModel::limpiar_cadena($_POST['serie-up']);
							$color=mainModel::limpiar_cadena($_POST['color-up']);
							$carac=mainModel::limpiar_cadena($_POST['carac-up']);
							$cable=mainModel::limpiar_cadena($_POST['cable-up']);
							$obs=mainModel::limpiar_cadena($_POST['obs-up']);
							$estado=mainModel::limpiar_cadena($_POST['estado-up']);


							$externo=mainModel::limpiar_cadena($_POST['externo-up']);


							$informe=mainModel::limpiar_cadena($_POST['informe-up']);

				//PARA QUE SI EL HARDWARE YA ESTA ASIGNADO A UNA PERONA NO SE PUEDA MODIFICAR EL ESTADO DE HARDWARE APROBADO A RECHAZADO
							$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM hardware_ingreso WHERE hiserie='$cuenta'");
							$DatosEstado1=$query1->fetch();
							$a=$DatosEstado1['estadoasigharcodigo'];
							$fecha=$DatosEstado1['hifecha'];

							$b='ASIGNADO';

							$query2=mainModel::ejecutar_consulta_simple("SELECT estadoasigharcodigo FROM estado_asignacion_hardware WHERE estadoasigharnombre='$b'");
							$DatosEstado2=$query2->fetch();
							$c=$DatosEstado2['estadoasigharcodigo'];

							if ($a==$c) {
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrió un error inesperado",
									"Texto"=>"El hardware ya se encuentra asignado a una persona por lo tanto ya no puede actualizar sus datos",
									"Tipo"=>"error"
								];
								return mainModel::sweet_alert($alerta);
								exit();
							}

							$datainf=[
								"EXTERNO"=>$externo,
								"MODELO"=>$modelo,
								"TIPO"=>$tipo,
								"MARCA"=>$marca,
								"ESTADO"=>$estado,
								"COLOR"=>$color,
								"INFORME"=>$informe,
								"FECHA"=>$fecha,
								"TITULO"=>$titulo,
								"CARACT"=>$carac,
								"CABLES"=>$cable,
								"OBSERV"=>$obs,
								"CODIGO"=>$cuenta
							];
							$editarinf=infoingresoHardModelo::actualizar_hardware_modelo($datainf);
							if ($editarinf->rowCount()>=1) {



								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"La información del hardware de ingreso se ha actualizado con éxito",
									"Tipo"=>"success"
								];

							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrió un error inesperado",
									"Texto"=>"Para actualizar los datos del hardware de ingreso es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
									"Tipo"=>"error"
								];
							}
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"Es necesario que ingreso todos los campos, por favor llénelos e intente nuevamente",
								"Tipo"=>"error"
							];
						}
							return mainModel::sweet_alert($alerta);
					}
				}