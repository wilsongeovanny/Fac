<?php 
	if ($peticionAjax) {
		require_once "../modelos/manteEntregarModelo.php";
	}else{
		require_once "./modelos/manteEntregarModelo.php";
	}  

	class manteEntregarControlador extends manteEntregarModelo{

		//CONTROLADOR PARA AGREGAR MANTENBIMIENTO, DIAGNOSTICO Y IFORMACIÓN DE INGRESO
		public function agregar_manteEntregar_controlador(){

			if (!empty($_POST['codqr-reg']) && !empty($_POST['pers-reg']) && !empty($_POST['pers-reg']) && !empty($_POST['hentrega-reg']) && !empty($_POST['fentrega-reg']) && !empty($_POST['opcion-reg']) && !empty($_POST['reporte-reg']) && !empty($_POST['informe-reg']) && !empty($_POST['mant-reg']) && !empty($_POST['tipom-reg']) && !empty($_POST['esman-reg'])) {
				//DATOS DEL RESPONSABLE DEL REPORTE
				$respo=mainModel::limpiar_cadena($_POST['respo-reg']);
				//DATOS DEL RESPONSABLE DEL VISTO BUENO
				$visto=mainModel::limpiar_cadena($_POST['pers-reg']);
				//DATOS PARA LA INFORMACION DE ENTREGA
				$hora=$_POST['hentrega-reg'];
				$fecha=$_POST['fentrega-reg'];
				$opcion=mainModel::limpiar_cadena($_POST['opcion-reg']);
				$reporte=mainModel::limpiar_cadena($_POST['reporte-reg']);
				$informe=mainModel::limpiar_cadena($_POST['informe-reg']);
				$mantecod=mainModel::limpiar_cadena($_POST['mant-reg']);
				$tipo=mainModel::limpiar_cadena($_POST['tipom-reg']);
				$esman=mainModel::limpiar_cadena($_POST['esman-reg']);
				//DATOS PARA EL MANTENIMIENTO
				$qr=$_POST['codqr-reg'];
				//$responsable='0503986838';
				//$tipo='null';
				// DATOS PARA EL DIAGNOSTICO
				


				$max1=strlen($reporte);
				$max2=strlen($informe);
				$carmax=255;

				if ($max1<=$carmax && $max2<=$carmax) {





					$consultacodresp=mainModel::ejecutar_consulta_simple("SELECT resprepocodigo FROM responsable_reporte");
					$numeroresp=($consultacodresp->rowCount())+1;
					$codigoresp=mainModel::generar_codigo_aleatorio("RESREP",7,$numeroresp);
					//$respo=$codigoresp;

					$consultares=mainModel::ejecutar_consulta_simple("SELECT resprepocodigo FROM responsable_reporte WHERE resprepocodigo='$codigoresp'");
					if ($consultares->rowCount()<=0) {

						$datosResponsable=[
							"CODIGO"=>$codigoresp,
							"RESPO"=>$respo
						];
						$guardarResponsable=manteEntregarModelo::agregar_reporespo_modelo($datosResponsable);
						if ($guardarResponsable->rowCount()>=1) {

									
							/*      FIN DE REGISTRO DE RESPONSABLE  */




							$consultacodvis=mainModel::ejecutar_consulta_simple("SELECT vistorepocodigo FROM vistobueno_reporte");
							$numerovis=($consultacodvis->rowCount())+1;
							$codigovis=mainModel::generar_codigo_aleatorio("VISREP",7,$numerovis);
							//$vis=$codigovis;

							$consultavis=mainModel::ejecutar_consulta_simple("SELECT vistorepocodigo FROM vistobueno_reporte WHERE vistorepocodigo='$codigovis'");
							if ($consultavis->rowCount()<=0) {

								$datosVisto=[
									"CODIGO"=>$codigovis,
									"VISTO"=>$visto
								];
								$guardarVisto=manteEntregarModelo::agregar_vistorespo_modelo($datosVisto);
								if ($guardarVisto->rowCount()>=1) {

											


									/*      FIN DE REGISTRO DE VISTO BUENO  */



									$consultacodent=mainModel::ejecutar_consulta_simple("SELECT entregacodigo FROM informacion_entrega");
									$numeroent=($consultacodent->rowCount())+1;
									$codigoent=mainModel::generar_codigo_aleatorio("INFENT",7,$numeroent);
									//$vis=$codigoent;

									$consultaent=mainModel::ejecutar_consulta_simple("SELECT entregacodigo FROM informacion_entrega WHERE entregacodigo='$codigoent'");
									if ($consultaent->rowCount()<=0) {

										$datosEnt=[
											"CODIGO"=>$codigoent,
											"HORA"=>$hora,
											"FECHA"=>$fecha
										];
										$guardarEnt=manteEntregarModelo::agregar_infoentrega_modelo($datosEnt);
										if ($guardarEnt->rowCount()>=1) {

													


											/*      FIN DE REGISTRO DE INFORME TECNICO  */



											$consultacodrepor=mainModel::ejecutar_consulta_simple("SELECT reportecodigo FROM reporte");
											$numerorepor=($consultacodrepor->rowCount())+1;
											$codigorepor=mainModel::generar_codigo_aleatorio("REPORT",7,$numerorepor);
											//$vis=$codigorepor;

											$consultarepor=mainModel::ejecutar_consulta_simple("SELECT reportecodigo FROM reporte WHERE reportecodigo='$codigorepor'");
											if ($consultarepor->rowCount()<=0) {

												$datosRepor=[
													"CODIGO"=>$codigorepor,
													"ENTREGA"=>$codigoent,
													"VISTO"=>$codigovis,
													"RESPONSABLE"=>$codigoresp,
													"ENTREGADO"=>$opcion,
													"REPORTE"=>$reporte,
													"INFORME"=>$informe


												];
												$guardarRepor=manteEntregarModelo::agregar_reporte_modelo($datosRepor);
												if ($guardarRepor->rowCount()>=1) {

															


													/*    FIN DE REPORTE TECNICO DE INFORME TECNICO  */




													$consultaesthar=mainModel::ejecutar_consulta_simple("SELECT estadohardwarecodigo FROM estado_hardware WHERE estadohardwarenombre='DADO DE BAJA'");
													$Esthar=$consultaesthar->fetch();
													$estadohar=$Esthar['estadohardwarecodigo'];


													if ($consultaesthar->rowCount()>=1) {


														/*      FIN DE VALIDAR QUE ESTEN INGRESADOS LOS ESTADOS DEL HARDWARE  */
														




														$consultaestados=mainModel::ejecutar_consulta_simple("SELECT estadomantenimientocodigo FROM estado_mantenimiento WHERE estadomantenimientonombre='REPARADO'");
														$EstadosMant=$consultaestados->fetch();
														$estadomante=$EstadosMant['estadomantenimientocodigo'];


														if ($consultaestados->rowCount()>=1) {


															/*      FIN DE VALIDAR QUE ESTEN INGRESADOS LOS ESTADOS DEL MANTENIMIENTO  */
															



															$consultatipos=mainModel::ejecutar_consulta_simple("SELECT tipomantenombre FROM tipo_mantenimiento WHERE tipomantecodigo='$tipo'");
															$EstadosTipos=$consultatipos->fetch();
															$estadoTipos=$EstadosTipos['tipomantenombre'];


															if ($consultatipos->rowCount()>=1) {


															/*      FIN DE VALIDAR QUE ESTEN INGRESADOS LOS TIPOS DEL MANTENIMIENTO  */



															

																$actualizarMant=mainModel::ejecutar_consulta_simple("UPDATE mantenimiento SET estadomantenimientocodigo='$estadomante', reportecodigo='$codigorepor', tipomantecodigo='$tipo' WHERE mantenimientocodigo='$mantecod'");
																if ($actualizarMant->rowCount()>=1) {

																			


																	/*      FIN DE ACTUALIZAR EL MANTENIMIENTO   */



																	if ($estadoTipos=='DE BAJA') {


																		$actualizarHard=mainModel::ejecutar_consulta_simple("UPDATE hardware SET estadohardwarecodigo='$estadohar' WHERE hardwareqr='$qr'");


																		if ($actualizarMant->rowCount()>=1) {
																			$alerta=[
																				"Alerta"=>"recargar",
																				"Titulo"=>"Dado de baja correcatamente",
																				"Texto"=>"Se ha dado de baja al hardware con éxito despúes de su respectiva revisión técnica",
																				"Tipo"=>"success"
																			];
																		}else{
																			//ELIMINAR EL RESPONSABLE DEL MANTENIMIENTO, DEL VISTO BUENO, LA INFORMACION DE ENTREGA, EL REPORTE DE ENTREGA Y ACTUALIZAR EL MANTENIMIENTO A SUS VALORES QUE VIENEN POR DEFECTO SIN EL REPORTE SI NO SE HA LOGRADO DAR DE BAJA AL HARDWARE
																			$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_reporte WHERE resprepocodigo='$respo'");
																			$eliminarvis=mainModel::ejecutar_consulta_simple("DELETE FROM vistobueno_reporte WHERE vistorepocodigo='$codigovis'");
																			$eliminarinf=mainModel::ejecutar_consulta_simple("DELETE FROM informacion_entrega WHERE entregacodigo='$codigoent'");
																			$eliminarrepor=mainModel::ejecutar_consulta_simple("DELETE FROM reporte WHERE reportecodigo='$codigorepor'");

																			$consulta==mainModel::ejecutar_consulta_simple("DELETE FROM responsable_reporte WHERE resprepocodigo='$respo'");

																			$actualizaEmer=mainModel::ejecutar_consulta_simple("UPDATE mantenimiento SET estadomantenimientocodigo='$esman', reportecodigo='', tipomantecodigo='' WHERE mantenimientocodigo='$mantecod'");


																			$alerta=[
																				"Alerta"=>"simple",
																				"Titulo"=>"Ocurrio un error inesperado",
																				"Texto"=>"No hemos podido dar de baja al hardaware, porfavor intente nuevamnete",
																				"Tipo"=>"error"
																			];
																		}

																		
																	}else{


																		$alerta=[
																			"Alerta"=>"recargar",
																			"Titulo"=>"Felicitaciones!",
																			"Texto"=>"Usted ha finalizado el mantenimiento $estadoTipos del hardware",
																			"Tipo"=>"success"
																		];
				
																	}



																	/*      FIN DE ACTUALIZAR EL MANTENIMIENTO   */
																	



																}else{
																	//ELIMINAR EL RESPONSABLE DEL MANTENIMIENTO, DEL VISTO BUENO, LA INFORMACION DE ENTREGA Y EL REPORTE DE ENTREGA SI NO SE LOGRO INGRESAR LA INFORMACION DE ENTREGA
																	$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_reporte WHERE resprepocodigo='$respo'");
																	$eliminarvis=mainModel::ejecutar_consulta_simple("DELETE FROM vistobueno_reporte WHERE vistorepocodigo='$codigovis'");
																	$eliminarinf=mainModel::ejecutar_consulta_simple("DELETE FROM informacion_entrega WHERE entregacodigo='$codigoent'");
																	$eliminarrepor=mainModel::ejecutar_consulta_simple("DELETE FROM reporte WHERE reportecodigo='$codigorepor'");
																	$alerta=[
																		"Alerta"=>"simple",
																		"Titulo"=>"Ocurrio un error inesperado",
																		"Texto"=>"No hemos podido guardar el reporte técnico del mantenimiento, porfavor intente nuevamnete",
																		"Tipo"=>"error"
																	];	
																}





															/*      FIN DE VALIDAR QUE ESTEN INGRESADOS LOS TIPOS DEL MANTENIMIENTO  */

															}else{

																//ELIMINAR EL RESPONSABLE DEL MANTENIMIENTO, DEL VISTO BUENO, LA INFORMACION DE ENTREGA Y EL REPORTE DE ENTREGA SI NO SE HAN INGRESADO LOS TIPOS DEL MANTENIMIENTO
																$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_reporte WHERE resprepocodigo='$respo'");
																$eliminarvis=mainModel::ejecutar_consulta_simple("DELETE FROM vistobueno_reporte WHERE vistorepocodigo='$codigovis'");
																$eliminarinf=mainModel::ejecutar_consulta_simple("DELETE FROM informacion_entrega WHERE entregacodigo='$codigoent'");
																$eliminarrepor=mainModel::ejecutar_consulta_simple("DELETE FROM reporte WHERE reportecodigo='$codigorepor'");

																$alerta=[
																	"Alerta"=>"simple",
																	"Titulo"=>"Ocurrio un error inesperado",
																	"Texto"=>"Primero debe ingresar los tipos de mantenimiento que vienen por defecto en el sistema, si los problemas persisten contactese con el desarrollador del sistema",
																	"Tipo"=>"error"
																];

															}



															/*      FIN DE VALIDAR QUE ESTEN INGRESADOS LOS ESTADOS DEL MANTENIMIENTO  */

														}else{

															//ELIMINAR EL RESPONSABLE DEL MANTENIMIENTO, DEL VISTO BUENO, LA INFORMACION DE ENTREGA Y EL REPORTE DE ENTREGA SI NO SE HAN INGRESADO LOS TIPOS DEL MANTENIMIENTO
															$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_reporte WHERE resprepocodigo='$respo'");
															$eliminarvis=mainModel::ejecutar_consulta_simple("DELETE FROM vistobueno_reporte WHERE vistorepocodigo='$codigovis'");
															$eliminarinf=mainModel::ejecutar_consulta_simple("DELETE FROM informacion_entrega WHERE entregacodigo='$codigoent'");
															$eliminarrepor=mainModel::ejecutar_consulta_simple("DELETE FROM reporte WHERE reportecodigo='$codigorepor'");

															$alerta=[
																"Alerta"=>"simple",
																"Titulo"=>"Ocurrio un error inesperado",
																"Texto"=>"Primero debe ingresar los estados de mantenimiento que vienen por defecto en el sistema, si los problemas persisten contactese con el desarrollador del sistema",
																"Tipo"=>"error"
															];

														}




														/*      FIN DE VALIDAR QUE ESTEN INGRESADOS LOS ESTADOS DEL HARDWARE  */

													}else{

														//ELIMINAR EL RESPONSABLE DEL MANTENIMIENTO, DEL VISTO BUENO, LA INFORMACION DE ENTREGA Y EL REPORTE DE ENTREGA SI NO SE HAN INGRESADO LOS TIPOS DEL MANTENIMIENTO
														$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_reporte WHERE resprepocodigo='$respo'");
														$eliminarvis=mainModel::ejecutar_consulta_simple("DELETE FROM vistobueno_reporte WHERE vistorepocodigo='$codigovis'");
														$eliminarinf=mainModel::ejecutar_consulta_simple("DELETE FROM informacion_entrega WHERE entregacodigo='$codigoent'");
														$eliminarrepor=mainModel::ejecutar_consulta_simple("DELETE FROM reporte WHERE reportecodigo='$codigorepor'");

														$alerta=[
															"Alerta"=>"simple",
															"Titulo"=>"Ocurrio un error inesperado",
															"Texto"=>"Primero debe ingresar los estados de hardware que vienen por defecto en el sistema, si los problemas persisten contactese con el desarrollador del sistema",
															"Tipo"=>"error"
														];

													}

													/*      FIN DE REPORTE TECNICO DE INFORME TECNICO  */
													



												}else{
													//ELIMINAR EL RESPONSABLE DEL MANTENIMIENTO, DEL VISTO BUENO Y LA INFORMACION DE ENTREGA SI NO SE LOGRO INGRESAR LA INFORMACION DE ENTREGA
													$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_reporte WHERE resprepocodigo='$respo'");
													$eliminarvis=mainModel::ejecutar_consulta_simple("DELETE FROM vistobueno_reporte WHERE vistorepocodigo='$codigovis'");
													$eliminarinf=mainModel::ejecutar_consulta_simple("DELETE FROM informacion_entrega WHERE entregacodigo='$codigoent'");
													$alerta=[
														"Alerta"=>"simple",
														"Titulo"=>"Ocurrio un error inesperado",
														"Texto"=>"No hemos hola 100 podido guardar el reporte técnico del mantenimiento, porfavor intente nuevamnete",
														"Tipo"=>"error"
													];	
												}

											}else{
												//ELIMINAR EL RESPONSABLE DEL MANTENIMIENTO, DEL VISTO BUENO Y LA INFORMACION DE ENTREGA SI EL CODIGO DE LA INFORMACION ENTRA REPETIDO
												$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_reporte WHERE resprepocodigo='$respo'");
												$eliminarvis=mainModel::ejecutar_consulta_simple("DELETE FROM vistobueno_reporte WHERE vistorepocodigo='$codigovis'");
												$eliminarinf=mainModel::ejecutar_consulta_simple("DELETE FROM informacion_entrega WHERE entregacodigo='$codigoent'");
												$alerta=[
													"Alerta"=>"simple",
												 	"Titulo"=>"Ocurrio un error inesperado",
													"Texto"=>"El código del reporte técnico del mantenimiento que se asigno ya se encuentra registrado en el sistema, por favor intente nuevamente regargando la página",
													"Tipo"=>"error"
												];
											}




											/*      FIN DE REGISTRO DE INFORME TECNICO  */
											



										}else{
											//ELIMINAR EL RESPONSABLE DEL MANTENIMIENTO Y DEL VISTO BUENO SI NO SE LOGRO INGRESAR LA INFORMACION DE ENTREGA
											$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_reporte WHERE resprepocodigo='$respo'");
											$eliminarvis=mainModel::ejecutar_consulta_simple("DELETE FROM vistobueno_reporte WHERE vistorepocodigo='$codigovis'");
											$alerta=[
												"Alerta"=>"simple",
												"Titulo"=>"Ocurrio un error inesperado",
												"Texto"=>"No hemos hola 3 podido guardar el reporte técnico del mantenimiento, porfavor intente nuevamnete",
												"Tipo"=>"error"
											];	
										}

									}else{
										//ELIMINAR EL RESPONSABLE DEL MANTENIMIENTO Y DEL VISTO BUENO SI EL CODIGO DE VISTO BUENO ENTRA REPETIDO
										$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_reporte WHERE resprepocodigo='$respo'");
										$eliminarvis=mainModel::ejecutar_consulta_simple("DELETE FROM vistobueno_reporte WHERE vistorepocodigo='$codigovis'");
										$alerta=[
											"Alerta"=>"simple",
										 	"Titulo"=>"Ocurrio un error inesperado",
											"Texto"=>"El código de la información de entrega del mantenimiento que se asigno ya se encuentra registrado en el sistema, por favor intente nuevamente regargando la página",
											"Tipo"=>"error"
										];
									}




									/*      FIN DE REGISTRO DE VISTO BUENO  */
									



								}else{
									//ELIMINAR EL RESPONSABLE DEL MANTENIMIENTO SI NO SE HA LOGRADO INGRESAR AL RESP. DEL VISTO BUENO
									$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_reporte WHERE resprepocodigo='$respo'");
									$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Ocurrio un error inesperado",
										"Texto"=>"No hemos hola 3 podido guardar el reporte técnico del mantenimiento, porfavor intente nuevamnete",
										"Tipo"=>"error"
									];	
								}

							}else{
								//ELIMINAR EL RESPONSABLE DEL MANTENIMIENTO SI EL CODIGO DEL RESP. DEL VISTO BUENO ESTA INGRESANDO DUPLICADO AL SISTEMA
								$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_reporte WHERE resprepocodigo='$respo'");
								$alerta=[
									"Alerta"=>"simple",
								 	"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"El código del responsable del visto bueno del mantenimiento que se asigno ya se encuentra registrado en el sistema, por favor intente nuevamente regargando la página",
									"Tipo"=>"error"
								];
							}





							/*      FIN DE REGISTRO DE RESPONSABLE  */


						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"No hemos hola 3 podido guardar el reporte técnico del mantenimiento, porfavor intente nuevamnete",
								"Tipo"=>"error"
							];	
						}

					}else{
						$alerta=[
							"Alerta"=>"simple",
						 	"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El código del responsable del mantenimiento que se asigno ya se encuentra registrado en el sistema, por favor intente nuevamente regargando la página",
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


		//Controlador para gaginar administradores
		public function listar_manteEntregar_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM departemento" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			$consulta="SELECT *,T2.mantenimientocodigo as id_pl FROM empresa as T1 INNER JOIN mantenimiento as T2 on T1.empresacodigo=T2.empresacodigo ORDER BY empresanombre";

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>#</th>
							<th>EMPRESA</th>
							<th>NOMBRE</th>
							
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
							<td>'.$rows['empresanombre'].'</td>
							<td>'.$rows['departamentonombre'].'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							
								<a href="'.SERVERURL.'manteEntregarinfo/'.mainModel::encryption($rows['mantenimientocodigo']).'/" class="btn btn-primary">
									<i class="fa fa-edit" onclick="editbtnmenu"></i> Editar
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
					//$contador++;
				//}
			

			$tabla.='
					</tbody>
				';
			//Fin Tabla__________________________________________________________________

			

			return $tabla;
		}



		public function datos_manteEntregar_controlador($tipo,$codigo){
			$codigo=mainModel::limpiar_cadena($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return manteEntregarModelo::datos_manteEntregar_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_manteEntregar_controlador(){
			$cuenta=mainModel::decryption($_POST['codigo']);

			$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);


			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM mantenimiento WHERE mantenimientocodigo='$cuenta'");
			$DatosmanteEntregar=$query1->fetch();

			if ($dni!=$DatosmanteEntregar['mantenimientocodigo']) {
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT mantenimientocodigo FROM mantenimiento WHERE mantenimientocodigo='$dni'");
				if ($consulta1->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El código que acaba de ingresar ya se encuentra registrado en el sistema",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}

			if ($nombre!=$DatosmanteEntregar['departamentonombre']) {
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT departamentocodigo FROM mantenimiento WHERE departamentonombre='$nombre'");
				if ($consulta2->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El nombre del departamento ya se encuentra registrado en el sistema, porfavor intente nuevamnete",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}

			$datamanteEntregar=[
				"NOMBRE"=>$nombre,
				"CODIGO"=>$cuenta,
			];
			$editarmanteEntregar=manteEntregarModelo::actualizar_manteEntregar_modelo($datamanteEntregar);
			if ($editarmanteEntregar->rowCount()>=1) {
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Datos actualizados",
					"Texto"=>"El nombre del departamento se ha actualizado con exito",
					"Tipo"=>"success"
					];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos pordido actualizar el nombre del departamento, porfavor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}
	}