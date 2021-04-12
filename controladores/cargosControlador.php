<?php 
	if ($peticionAjax) {
		require_once "../modelos/cargosModelo.php";
	}else{
		require_once "./modelos/cargosModelo.php";
	}  

	class cargosControlador extends cargosModelo{

		//Controlador para agregar cargos
		public function agregar_cargos_controlador(){

			if (!empty($_POST['emp-reg']) && !empty($_POST['dep-reg']) && !empty($_POST['nombre-reg'])) {
			
			

				$entidad=mainModel::limpiar_cadena($_POST['emp-reg']);
				$departamento=mainModel::limpiar_cadena($_POST['dep-reg']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);

				$verenitidad=mainModel::ejecutar_consulta_simple("SELECT * FROM empresa WHERE empresacodigo='$entidad'");
				if ($verenitidad->rowCount()>=1) {

					$verdep=mainModel::ejecutar_consulta_simple("SELECT * FROM departemento WHERE departamentocodigo='$departamento'");
					if ($verdep->rowCount()>=1) {



						$verCargo=mainModel::ejecutar_consulta_simple("SELECT * FROM cargo as T1 WHERE T1.cargonombre='$nombre' AND T1.departamentocodigo='$departamento'");
						if ($verCargo->rowCount()<=0) {


							$alerta=[
								"Alerta"=>"recargar",
								"Titulo"=>"Felicitaciones",
								"Texto"=>"El cargo se ha registrado con éxito",
								"Tipo"=>"success"
							];



					
							$consultacod=mainModel::ejecutar_consulta_simple("SELECT cargocodigo FROM cargo");
							$numero=($consultacod->rowCount())+1;
							$codigo=mainModel::generar_codigo_aleatorio("CARGO",7,$numero);

							$consulta1=mainModel::ejecutar_consulta_simple("SELECT cargocodigo FROM cargo WHERE cargocodigo='$codigo'");
							if ($consulta1->rowCount()<=0) {
								
									$datosDepartamento=[
										"CODIGO"=>$codigo,
										"DEPA"=>$departamento,
										"NOMBRE"=>$nombre
									];
									$guardarDepartamento=cargosModelo::agregar_cargos_modelo($datosDepartamento);
									if ($guardarDepartamento->rowCount()>=1) {



						

								



									}else{
										$alerta=[
											"Alerta"=>"simple",
											"Titulo"=>"Ocurrio un error inesperado",
											"Texto"=>"No se ha podido registrar el cargo, por favor intente nuevamente",
											"Tipo"=>"error"
										];	
									}

							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"El código que se genero para el cargo ya se encuentra en el sistema, por favor intente nuevamente.",
									"Tipo"=>"error"
								];
							}




						}else{
										//	$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM cargo WHERE CARGOCODIGO='$codigo'");
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"El departamento ya tiene un cargo con este nombre, por favor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
						}




					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"La departamento que usted ha elejido para el cargo no se encuentra registrado en el sistema, por favor intente nuevamente recargando la página",
							"Tipo"=>"error"
						];
					}

				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"La entidad que usted ha elejido para el departamento no se encuentra registrado en el sistema, por favor intente nuevamente recargando la página",
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
		public function listar_cargos_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM departemento" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cargo ORDER BY cargonombre";
			
			//Consulta de los cargos registrados en el sistema, para la búsqueda se utilizo la plantilla Genetella Master
			$consulta="SELECT *,T2.cargocodigo as id_pl FROM departemento as T1 INNER JOIN cargo as T2 on T1.departamentocodigo=T2.departamentocodigo ORDER BY cargonombre";

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th><center>#</center></th>
							<th><center>EMPRESA</center></th>
							<th><center>NOMBRE</center></th>
							
			';
						//if ($privilegio<=2) {
							$tabla.='
							<th><center>ACCIONES</center></th>
							
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
							<td><center>'.$contador.'</center></td>
							<td><center>'.$rows['departamentonombre'].'</center></td>
							<td><center>'.$rows['cargonombre'].'</center></td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td><center>
							
								<form method="POST" action="'.SERVERURL.'cargosinfo/">
								<input type="hidden" value="'.$rows['cargocodigo'].'" name="codigo">
								<button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-primary"><i class="fa fa-edit" onclick="editbtnmenu"></i> Editar</button>
								</form> 
                                              
							</center></td>

						
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



		public function datos_cargos_controlador($tipo,$codigo){
			$codigo=mainModel::limpiar_cadena($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return cargosModelo::datos_cargos_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_cargos_controlador(){

			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['emp-up']) && !empty($_POST['dep-reg']) && !empty($_POST['nombre-up'])) {

				$cuenta=mainModel::limpiar_cadena($_POST['codigo']);

				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);

				$entidad=mainModel::limpiar_cadena($_POST['emp-up']);
				$departamento=mainModel::limpiar_cadena($_POST['dep-reg']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);


				$verCargo=mainModel::ejecutar_consulta_simple("SELECT * FROM cargo as T1 WHERE T1.cargonombre='$nombre' AND T1.departamentocodigo='$departamento'");
				if ($verCargo->rowCount()<2) {


					$verenitidad=mainModel::ejecutar_consulta_simple("SELECT * FROM empresa WHERE empresacodigo='$entidad'");
					if ($verenitidad->rowCount()>=1) {

						$verdep=mainModel::ejecutar_consulta_simple("SELECT * FROM departemento WHERE departamentocodigo='$departamento'");
						if ($verdep->rowCount()>=1) {

							$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM cargo WHERE cargocodigo='$cuenta'");
							$DatosEmpresa=$query1->fetch();

							if ($dni!=$DatosEmpresa['cargocodigo']) {
								$consulta1=mainModel::ejecutar_consulta_simple("SELECT cargocodigo FROM cargo WHERE cargocodigo='$dni'");
								if ($consulta1->rowCount()>=2) {
									$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Ocurrió un error inesperado",
										"Texto"=>"El código que se genero para el cargo ya se encuentra en el sistema, por favor intente nuevamente recargando la página",
										"Tipo"=>"error"
									];
									return mainModel::sweet_alert($alerta);
									exit();
								}
							}


							$dataDepartamento=[
								"NOMBRE"=>$nombre,
								"DEPA"=>$departamento,
								"CODIGO"=>$cuenta,
							];
							$editarDepartamento=cargosModelo::actualizar_cargos_modelo($dataDepartamento);
							if ($editarDepartamento->rowCount()>=1) {
								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"El cargo se ha actualizado con éxito",
									"Tipo"=>"success"
									];
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrió un error inesperado",
									"Texto"=>"Para actualizar los datos del cargo es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
									"Tipo"=>"error"
								];
							}

						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"La departamento que usted ha elejido para el cargo no se encuentra registrado en el sistema, por favor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
						}

					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"La entidad que usted ha elejido para el departamento no se encuentra registrado en el sistema, por favor intente nuevamente recargando la página",
							"Tipo"=>"error"
						];
					}



				}else{
				//	$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM cargo WHERE CARGOCODIGO='$codigo'");
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El departamento ya tiene un cargo con este nombre, por favor intente nuevamente recargando la página",
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