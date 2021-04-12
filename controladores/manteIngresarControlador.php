<?php 
	if ($peticionAjax) {
		require_once "../modelos/manteIngresarModelo.php";
	}else{
		require_once "./modelos/manteIngresarModelo.php";
	}  

	class manteIngresarControlador extends manteIngresarModelo{

		//CONTROLADOR PARA AGREGAR MANTENBIMIENTO, DIAGNOSTICO Y IFORMACIÓN DE INGRESO
		public function agregar_manteIngresar_controlador(){
			//DATOS DEL RESPONSABLE DEL MANTENIMIENTO

			if (!empty($_POST['codqr-reg']) && !empty($_POST['respo-reg']) && !empty($_POST['reporte-reg']) && !empty($_POST['informe-reg']) && !empty($_POST['hora-reg']) && !empty($_POST['fecha-reg'])) {

				$respo=mainModel::limpiar_cadena($_POST['respo-reg']);
				//DATOS PARA EL MANTENIMIENTO
				$qr=$_POST['codqr-reg'];
				//$responsable='0503986838';
				//$tipo='null';
				// DATOS PARA EL DIAGNOSTICO
				$reporte=mainModel::limpiar_cadena($_POST['reporte-reg']);
				$informe=mainModel::limpiar_cadena($_POST['informe-reg']);
				//DATOS PARA LA INFORMACION DE ENTREGA
				$hora=$_POST['hora-reg'];
				$fecha=$_POST['fecha-reg'];


				$max1=strlen($reporte);
				$max2=strlen($informe);
				$carmax=255;

				if ($max1<=$carmax && $max2<=$carmax) {



					$consultacode=mainModel::ejecutar_consulta_simple("SELECT respdiagcodigo FROM responsable_diagnostico");
					$numeroe=($consultacode->rowCount())+1;
					$codigoe=mainModel::generar_codigo_aleatorio("RESPDIAG",7,$numeroe);
					//$respo=$codigoe;

					$consultae=mainModel::ejecutar_consulta_simple("SELECT respdiagcodigo FROM responsable_diagnostico WHERE respdiagcodigo='$codigoe'");
					if ($consultae->rowCount()<=0) {

						$datosResponsable=[
							"CODIGO"=>$codigoe,
							"RESPO"=>$respo
						];
						$guardarResponsable=manteIngresarModelo::agregar_responsable_modelo($datosResponsable);
						if ($guardarResponsable->rowCount()>=1) {

									





												
							/* -------------------- INICIO DE INGRESO -------------------- */


							
												

							$consultacodi=mainModel::ejecutar_consulta_simple("SELECT ingresocodigo FROM informacion_ingreso");
							$numeroi=($consultacodi->rowCount())+1;
							$codigoi=mainModel::generar_codigo_aleatorio("DIAGINF",7,$numeroi);

							$consultai=mainModel::ejecutar_consulta_simple("SELECT ingresocodigo FROM informacion_ingreso WHERE ingresocodigo='$codigoi'");
							if ($consultai->rowCount()<=0) {

													

								$datosDiagIng=[
									"CODIGO"=>$codigoi,
									"HORA"=>$hora,
									"FECHA"=>$fecha
								];

								$guardarDiagIng=manteIngresarModelo::agregar_infoingreso_modelo($datosDiagIng);

								if ($guardarDiagIng->rowCount()>=1) {


								/* -------------------- FIN DE INGRESO -------------------- */



										/* -------------------- INICIO IAGNOSTICO -------------------- */
										

										$consultacodd=mainModel::ejecutar_consulta_simple("SELECT diagnosticocodigo FROM diagnostico");
										$numerod=($consultacodd->rowCount())+1;
										$codigod=mainModel::generar_codigo_aleatorio("MANTDIAG",7,$numerod);

										$consultad=mainModel::ejecutar_consulta_simple("SELECT diagnosticocodigo FROM diagnostico WHERE diagnosticocodigo='$codigod'");
										if ($consultad->rowCount()<=0) {

											

											$datosDiagnostico=[
												"CODIGO"=>$codigod,
												"INGRESO"=>$codigoi,
												"RESPONSABLE"=>$codigoe,
												"REPORTE"=>$reporte,
												"INFORME"=>$informe
											];

											$guardarDiagnostico=manteIngresarModelo::agregar_diagnostico_modelo($datosDiagnostico);

											if ($guardarDiagnostico->rowCount()>=1) {

												/* -------------------- FIN IAGNOSTICO -------------------- */



												$consultacodm=mainModel::ejecutar_consulta_simple("SELECT mantenimientocodigo FROM mantenimiento");
												$numerom=($consultacodm->rowCount())+1;
												$codigom=mainModel::generar_codigo_aleatorio("MANTEN",7,$numerom);

												$consulta1=mainModel::ejecutar_consulta_simple("SELECT mantenimientocodigo FROM mantenimiento WHERE mantenimientocodigo='$codigom'");
												if ($consulta1->rowCount()<=0) {

													$consulta2=mainModel::ejecutar_consulta_simple("SELECT estadomantenimientocodigo FROM estado_mantenimiento WHERE estadomantenimientonombre='EN REPARACION'");
													$EstadosMant=$consulta2->fetch();
													$estadomante=$EstadosMant['estadomantenimientocodigo'];

													if ($consulta2->rowCount()>=1) {


														$datosMantenimiento=[
															"CODIGO"=>$codigom,
															"ESTADO"=>$estadomante,
															"QR"=>$qr,
															"DIAGNOSTICO"=>$codigod
															//"RESPONSABLE"=>$codigoe
																	//"TIPO"=>$tipo
														];
														$guardarMantenimiento=manteIngresarModelo::agregar_mantenimiento_modelo($datosMantenimiento);

														if ($guardarMantenimiento->rowCount()>=1) {



															$alerta=[
																"Alerta"=>"recargar",
																"Titulo"=>"Felicitaciones!",
																"Texto"=>"La hoja de diagnóstico del hardware se ha registrado con éxito",
																"Tipo"=>"success"
															];


														}else{
															//ELIMINAR EL RESPONSABLE, LA INFORMACION DEL DIAGNOSTICO Y EL DIAGNOSTICO SI NO SE PUDO REGISTRAR EL MANTENIMIENTO
															$eliminare=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_diagnostico WHERE respdiagcodigo='$respo'");
															$eliminari=mainModel::ejecutar_consulta_simple("DELETE FROM informacion_ingreso WHERE ingresocodigo='$codigoi'");
															$eliminard=mainModel::ejecutar_consulta_simple("DELETE FROM diagnostico WHERE diagnosticocodigo='$codigod'");
															$alerta=[
																"Alerta"=>"simple",
																"Titulo"=>"Ocurrio un error inesperado",
																"Texto"=>"No hemos hola 4 podido guardar el diagnostico del mantenimiento, porfavor intente nuevamnete",
																"Tipo"=>"error"
															];	
														}

													}else{
														//ELIMINAR EL RESPONSABLE, LA INFORMACION DEL DIAGNOSTICO Y EL DIAGNOSTICO SI AUN NO SE HA REGISTRADO NINGUN ESTADO DE MANTENIMIENTO
														$eliminare=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_diagnostico WHERE respdiagcodigo='$respo'");
														$eliminari=mainModel::ejecutar_consulta_simple("DELETE FROM informacion_ingreso WHERE ingresocodigo='$codigoi'");
														$eliminard=mainModel::ejecutar_consulta_simple("DELETE FROM diagnostico WHERE diagnosticocodigo='$codigod'");
														$alerta=[
															"Alerta"=>"simple",
															"Titulo"=>"Ocurrio un error inesperado",
															"Texto"=>"Primero debe ingresar los estados de mantenimiento en el sistema",
															"Tipo"=>"error"
														];
													}
												}else{

													//ELIMINAR EL RESPONSABLE, LA INFORMACION DEL DIAGNOSTICO Y EL DIAGNOSTICO SI EL CODIGO DEL MANTENIMIENTO QUE INGRESA ES REPETIDO
													$eliminare=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_diagnostico WHERE respdiagcodigo='$respo'");
													$eliminari=mainModel::ejecutar_consulta_simple("DELETE FROM informacion_ingreso WHERE ingresocodigo='$codigoi'");
													$eliminard=mainModel::ejecutar_consulta_simple("DELETE FROM diagnostico WHERE diagnosticocodigo='$codigod'");

													$alerta=[
														"Alerta"=>"simple",
														"Titulo"=>"Ocurrio un error inesperado",
														"Texto"=>"El código del mantenimiento que se asigno ya se encuentra registrado en el sistema, por favor intente nuevamente regargando la página",
														"Tipo"=>"error"
													];
												}


												/* -------------------- FIN IAGNOSTICO -------------------- */



											}else{


												//ELIMINAR EL RESPONSABLE Y LA INFORMACION DEL DIAGNOSTICO SI NO SE PUDO REGISTRAR EL DIAGNOSTICO
												$eliminare=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_diagnostico WHERE respdiagcodigo='$respo'");
												$eliminari=mainModel::ejecutar_consulta_simple("DELETE FROM informacion_ingreso WHERE ingresocodigo='$codigoi'");

												$alerta=[
													"Alerta"=>"simple",
													"Titulo"=>"Ocurrio un error inesperado",
													"Texto"=>"No hemos hola 2 podido guardar el diagnostico del mantenimiento, porfavor intente nuevamnete",
													"Tipo"=>"error"
												];	
											}


										}else{


											//ELIMINAR EL RESPONSABLE Y LA INFORMACION DEL DIAGNOSTICO SI EL CODIGO DEL DIAGNOSTICO QUE INGRESA ES REPETIDO
											$eliminare=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_diagnostico WHERE respdiagcodigo='$respo'");
											$eliminari=mainModel::ejecutar_consulta_simple("DELETE FROM informacion_ingreso WHERE ingresocodigo='$codigoi'");

											$alerta=[
												"Alerta"=>"simple",
												"Titulo"=>"Ocurrio un error inesperado",
												"Texto"=>"El código de diagnostico del mantenimiento que se asigno ya se encuentra registrado en el sistema,por favor intente nuevamente regargando la página",
												"Tipo"=>"error"
											];
										}


										/* -------------------- FIN DIAGNOSTICO -------------------- */





								/* -------------------- INICIO DE INGRESO -------------------- */


								}else{


									//SI NO SE PUDO INGRESAR LA INFORMACION DEL DIAGNOSTICO ELIMINAR EL RESPONSABLE DEL DIAGNOSTICO
									$eliminare=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_diagnostico WHERE respdiagcodigo='$respo'");


									$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Ocurrio un error inesperado",
										"Texto"=>"No hemos  hola 1 podido guardar el diagnostico del mantenimiento, porfavor intente nuevamnete",
										"Tipo"=>"error"
									];	
								}


							}else{


								//SI EL CODIGO DE LA INFORMACION DEL DIAGNOSTICO ESTA REPETIDO ELIMINAR EL RESPONSABLE DEL DIAGNOSTICO
								$eliminare=mainModel::ejecutar_consulta_simple("DELETE FROM responsable_diagnostico WHERE respdiagcodigo='$respo'");


								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"El código de la información del diagnostico que se asigno ya se encuentra registrado en el sistema,por favor intente nuevamente regargando la página",
									"Tipo"=>"error"
								];
							}
							/* -------------------- FIN DE INGRESO -------------------- */







						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"No hemos hola 3 podido guardar el diagnostico del mantenimiento, porfavor intente nuevamnete",
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
		public function listar_manteIngresar_controlador(/*$privilegio,$codigo*/){
			
		
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
							
								<a href="'.SERVERURL.'manteIngresarinfo/'.mainModel::encryption($rows['mantenimientocodigo']).'/" class="btn btn-primary">
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



		public function datos_manteIngresar_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return manteIngresarModelo::datos_manteIngresar_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_manteIngresar_controlador(){
			$cuenta=mainModel::decryption($_POST['codigo']);

			$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);


			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM mantenimiento WHERE mantenimientocodigo='$cuenta'");
			$DatosmanteIngresar=$query1->fetch();

			if ($dni!=$DatosmanteIngresar['mantenimientocodigo']) {
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

			if ($nombre!=$DatosmanteIngresar['departamentonombre']) {
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

			$datamanteIngresar=[
				"NOMBRE"=>$nombre,
				"CODIGO"=>$cuenta,
			];
			$editarmanteIngresar=manteIngresarModelo::actualizar_manteIngresar_modelo($datamanteIngresar);
			if ($editarmanteIngresar->rowCount()>=1) {
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