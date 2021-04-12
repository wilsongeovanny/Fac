<?php 
	if ($peticionAjax) {
		require_once "../modelos/marcasHardwareModelo.php";
	}else{
		require_once "./modelos/marcasHardwareModelo.php";
	}  

	class marcasHardwareControlador extends marcasHardwareModelo{

		//Controlador para agregar tipos de marcas
		public function agregar_marcasHardware_controlador(){
			if (!empty($_POST['opcion-reg']) && !empty($_POST['nombre-reg'])) {

				$opcion=mainModel::limpiar_cadena($_POST['opcion-reg']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);

				$vertipo=mainModel::ejecutar_consulta_simple("SELECT * FROM tipo_hardware WHERE tipohardwarecodigo='$opcion'");

				if ($vertipo->rowCount()>=1) {

					$verasig=mainModel::ejecutar_consulta_simple("SELECT * FROM marca_hardware as T1, tipo_hardware as T2 WHERE T1.tipohardwarecodigo='$opcion' AND T1.marcahardwarenombre='$nombre' AND T2.tipohardwarecodigo='$opcion'");
					if ($verasig->rowCount()<=0) {
				
						$consultacod=mainModel::ejecutar_consulta_simple("SELECT marcahardwarecodigo FROM marca_hardware");
						$numero=($consultacod->rowCount())+1;
						$codigo=mainModel::generar_codigo_aleatorio("MARHARD",7,$numero);

						$consulta1=mainModel::ejecutar_consulta_simple("SELECT marcahardwarecodigo FROM marca_hardware WHERE marcahardwarecodigo='$codigo'");
						if ($consulta1->rowCount()<=0) {
						
							$datosmarcasHardware=[
								"CODIGO"=>$codigo,
								"TIPO"=>$opcion,
								"NOMBRE"=>$nombre
							];
								$guardarmarcasHardware=marcasHardwareModelo::agregar_marcasHardware_modelo($datosmarcasHardware);
								if ($guardarmarcasHardware->rowCount()>=1) {
								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"La marca del hardware se ha registrado con éxito",
									"Tipo"=>"success"
								];
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No se ha podido guardar la marca del hardware, por favor intente nuevamente",
									"Tipo"=>"error"
								];	
							}

						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"El código que se genero para la marca del hardware ya se encuentra en el sistema, por favor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
						}



					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El tipo de hardware que usted ha elegido ya tiene una marca con el nombre ingresado, por favor intente nuevamente con otro nombre",
							"Tipo"=>"error"
						];
					}

				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El tipo de hardware que usted ha elejido para la marca de hardware no se encuentra registrado en el sistema, por favor intente nuevamente recargando la página",
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
		public function listar_marcasHardware_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM departemento" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			$consulta="SELECT *,T2.marcahardwarecodigo as id_pl FROM tipo_hardware as T1 INNER JOIN marca_hardware as T2 on T1.tipohardwarecodigo=T2.tipohardwarecodigo ORDER BY tipohardwarenombre";

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th><center>#</center></th>
							<th><center>TIPOS DE HARDWARE</center></th>
							<th><center>MARCAS DE HARDWARE</center></th>
							
			';
						//if ($privilegio<=2) {
							$tabla.='
							<th>ACCION</th>
							
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
							<td><center>'.$rows['tipohardwarenombre'].'</center></td>
							<td><center>'.$rows['marcahardwarenombre'].'</center></td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>

								<form method="POST" action="'.SERVERURL.'marcashardwareinfo/">
								<input type="hidden" value="'.$rows['marcahardwarecodigo'].'" name="codigo">
								<center><button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-primary"><i class="fa fa-edit" onclick="editbtnmenu"></i> Editar</button></center>
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



		public function datos_marcasHardware_controlador($tipo,$codigo){
			$codigo=mainModel::limpiar_cadena($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return marcasHardwareModelo::datos_marcasHardware_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_marcasHardware_controlador(){
			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['opcion-up']) && !empty($_POST['nombre-up'])) {
				$cuenta=mainModel::limpiar_cadena($_POST['codigo']);

				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
				$opcion=mainModel::limpiar_cadena($_POST['opcion-up']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);


				$vermh=mainModel::ejecutar_consulta_simple("SELECT * FROM hardware_ingreso WHERE marcahardwarecodigo='$dni'");
				if ($vermh->rowCount()<=0) {
					# code...

					$vertipo=mainModel::ejecutar_consulta_simple("SELECT * FROM tipo_hardware WHERE tipohardwarecodigo='$opcion'");
					if ($vertipo->rowCount()>=1) {

						$verasig=mainModel::ejecutar_consulta_simple("SELECT * FROM marca_hardware as T1, tipo_hardware as T2 WHERE T1.tipohardwarecodigo='$opcion' AND T1.marcahardwarenombre='$nombre' AND T2.tipohardwarecodigo='$opcion'");
						if ($verasig->rowCount()<=1) {

							$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM marca_hardware WHERE marcahardwarecodigo='$cuenta'");
							$DatosEmpresa=$query1->fetch();

							if ($dni!=$DatosEmpresa['marcahardwarecodigo']) {
								$consulta1=mainModel::ejecutar_consulta_simple("SELECT marcahardwarecodigo FROM marca_hardware WHERE marcahardwarecodigo='$dni'");
								if ($consulta1->rowCount()>=2) {
									$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Ocurrió un error inesperado",
										"Texto"=>"El código que se genero para la marca del hardware ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
										"Tipo"=>"error"
									];
									return mainModel::sweet_alert($alerta);
									exit();
								}
							}

							$datamarcasHardware=[
								"TIPO"=>$opcion,
								"NOMBRE"=>$nombre,
								"CODIGO"=>$cuenta
							];
							$editarmarcasHardware=marcasHardwareModelo::actualizar_marcasHardware_modelo($datamarcasHardware);
							if ($editarmarcasHardware->rowCount()>=1) {
								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"La marca del hardware se ha actualizado con éxito",
									"Tipo"=>"success"
									];
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrió un error inesperado",
									"Texto"=>"Para actualizar la marca del hardware es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
									"Tipo"=>"error"
								];
							}
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"El tipo de hardware que usted ha elegido ya tiene una marca con el nombre ingresado, por favor intente nuevamente con otro nombre",
								"Tipo"=>"error"
							];
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El tipo de hardware que usted ha elejido para la marca de hardware no se encuentra registrado en el sistema, porfavor intente nuevamente recargando la página",
							"Tipo"=>"error"
						];
					}

				}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"La marca de hardware ya se encuentra en uso, por lo tanto, no la puede editar",
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