<?php 
	if ($peticionAjax) {
		require_once "../modelos/modelosHardwareModelo.php";
	}else{
		require_once "./modelos/modelosHardwareModelo.php";
	}  

	class modelosHardwareControlador extends modelosHardwareModelo{

		//Controlador para agregar administrador
		public function agregar_modelosHardware_controlador(){
			if (!empty($_POST['tipo-reg']) && !empty($_POST['marca-reg']) && !empty($_POST['nombre-reg'])) {
				$tipo=mainModel::limpiar_cadena($_POST['tipo-reg']);
				$marca=mainModel::limpiar_cadena($_POST['marca-reg']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);

				$vertipo=mainModel::ejecutar_consulta_simple("SELECT * FROM marca_hardware  WHERE marcahardwarecodigo='$marca'");

				if ($vertipo->rowCount()>=1) {	


					$verModelo=mainModel::ejecutar_consulta_simple("SELECT * FROM modelo_hardware as T1 WHERE T1.modelohardwarenombre='$nombre' AND T1.marcahardwarecodigo='$marca'");
						if ($verModelo->rowCount()<=0) {

					/*$verasig=mainModel::ejecutar_consulta_simple("SELECT * FROM marca_hardware as T1, tipo_hardware as T2 WHERE T1.marcahardwarecodigo='$marca' AND T2.tipohardwarecodigo='$tipo'");
					if ($verasig->rowCount()<=0) {*/
				
					
						$consultacod=mainModel::ejecutar_consulta_simple("SELECT modelohardwarecodigo FROM modelo_hardware");
						$numero=($consultacod->rowCount())+1;
						$codigo=mainModel::generar_codigo_aleatorio("MODHARD",7,$numero);

						$consulta1=mainModel::ejecutar_consulta_simple("SELECT modelohardwarecodigo FROM modelo_hardware WHERE modelohardwarecodigo='$codigo'");
						if ($consulta1->rowCount()<=0) {
							


								

								$datosmodelosHardware=[
									"CODIGO"=>$codigo,
									"MARCA"=>$marca,
									"NOMBRE"=>$nombre
								];
								$guardarmodelosHardware=modelosHardwareModelo::agregar_modelosHardware_modelo($datosmodelosHardware);
								if ($guardarmodelosHardware->rowCount()>=1) {
									$alerta=[
										"Alerta"=>"recargar",
										"Titulo"=>"Felicitaciones!",
										"Texto"=>"El modelo se ha registrado con éxito",
										"Tipo"=>"success"
									];
								}else{
									$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Ocurrio un error inesperado",
										"Texto"=>"No hemos podido guardar el nombre del cargo, porfavor intente nuevamnete",
										"Tipo"=>"error"
									];	
								}

						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"El código que acaba de ingresar ya se encuentra en el sistema",
								"Tipo"=>"error"
							];
						}

					}else{
						//	$eliminarresp=mainModel::ejecutar_consulta_simple("DELETE FROM cargo WHERE CARGOCODIGO='$codigo'");
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"La marca ya tiene un modelo con este nombre, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"La marca de hardware que usted ha elejido según el tipo de hardware para el modelo no se encuentra registrado en el sistema, porfavor intente nuevamente recargando la página",
						"Tipo"=>"error"
					];
				}
				/*}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"La marca de hardware que usted ha elejido para el modelo de hardware no se encuentra registrado en el sistema, porfavor intente nuevamente recargando la página",
						"Tipo"=>"error"
					];
				}*/
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Es necesario que ingrese todos los campos, por favor llénelos e intente nuevamente",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}


		//Controlador para gaginar administradores
		public function listar_modelosHardware_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM departemento" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cargo ORDER BY CARGONOMBRE";
			

			//$consulta="SELECT SQL_CALC_FOUND_ROWS *,T2.modelohardwarecodigo as id_pl FROM marca_hardware as T1 INNER JOIN modelo_hardware as T2 on T1.marcahardwarecodigo=T2.marcahardwarecodigo ORDER BY modelohardwarenombre";

			//Consulta del modelo de hardware referente a la marca y al tipo
			//Para la búsqueda se utilizo una tabla dinamica de la plnatilla Gentella Master
			$consulta="SELECT *,T1.modelohardwarecodigo FROM modelo_hardware as T1, marca_hardware as T2, tipo_hardware as T3 WHERE T1.modelohardwarecodigo=T1.modelohardwarecodigo AND T1.marcahardwarecodigo=T2.marcahardwarecodigo AND T2.tipohardwarecodigo=T3.tipohardwarecodigo";

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th><center>#</center></th>
							<th><center>TIPO DE HARDWARE</center></th>
							<th><center>MARCA DE HARDWARE</center></th>
							<th><center>MODELO DE HARDWARE</center></th>
							
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
							<td><center>'.$rows['tipohardwarenombre'].'</center></td>
							<td><center>'.$rows['marcahardwarenombre'].'</center></td>
							<td><center>'.$rows['modelohardwarenombre'].'</center></td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							
								'./*<a href="'.SERVERURL.'modeloshardwareinfo/'.mainModel::encryption($rows['modelohardwarecodigo']).'/" class="btn btn-primary">
									<i class="fa fa-edit" onclick="editbtnmenu"></i> Editar
								</a>*/'
								<form method="POST" action="'.SERVERURL.'modeloshardwareinfo/">
								<input type="hidden" value="'.mainModel::encryption($rows['modelohardwarecodigo']).'" name="codigo">
								<center><button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-primary"> Editar</button></center>
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



		//Controlador para gaginar administradores
		public function listar_selectmaodelo_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM departemento" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cargo ORDER BY CARGONOMBRE";
			

			//$consulta="SELECT SQL_CALC_FOUND_ROWS *,T2.modelohardwarecodigo as id_pl FROM marca_hardware as T1 INNER JOIN modelo_hardware as T2 on T1.marcahardwarecodigo=T2.marcahardwarecodigo ORDER BY modelohardwarenombre";

			$consulta="SELECT *,T1.modelohardwarecodigo FROM modelo_hardware as T1, marca_hardware as T2, tipo_hardware as T3 WHERE T1.modelohardwarecodigo=T1.modelohardwarecodigo AND T1.marcahardwarecodigo=T2.marcahardwarecodigo AND T2.tipohardwarecodigo=T3.tipohardwarecodigo";

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>#</th>
							<th>TIPO DE HARDWARE</th>
							<th>MARCA DE HARDWARE</th>
							<th>MODELO DE HARDWARE</th>
							
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
							<td>'.$rows['tipohardwarenombre'].'</td>
							<td>'.$rows['marcahardwarenombre'].'</td>
							<td>'.$rows['modelohardwarenombre'].'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							
								<a style="display: block; margin-left: auto; margin-right: auto; color: #ffffff;" class="btn btn-primary" class="btn btn-primary" value="'.$rows['modelohardwarecodigo'].'" onclick="cargar('.$rows['modelohardwarecodigo'].')"> Seleccionar
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



		public function datos_modelosHardware_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return modelosHardwareModelo::datos_modelosHardware_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_modelosHardware_controlador(){

			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['tipo-up']) && !empty($_POST['marca-reg']) && !empty($_POST['nombre-up'])) {

				$cuenta=mainModel::decryption($_POST['codigo']);

				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);

				$tipo=mainModel::limpiar_cadena($_POST['tipo-up']);
				$marca=mainModel::limpiar_cadena($_POST['marca-reg']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);

				$vermh=mainModel::ejecutar_consulta_simple("SELECT * FROM hardware_ingreso WHERE modelohardwarecodigo='$dni'");
				if ($vermh->rowCount()<=0) {

					/*$vertipo=mainModel::ejecutar_consulta_simple("SELECT * FROM marca_hardware  WHERE marcahardwarecodigo='$marca'");

					if ($vertipo->rowCount()>=1) {*/


						//$verasig=mainModel::ejecutar_consulta_simple("SELECT * FROM modelo_hardware as T1, marca_hardware as T2, tipo_hardware as T3 WHERE T3.tipohardwarecodigo='$tipo' AND T2.marcahardwarecodigo='$marca' AND T3.tipohardwarecodigo=T2.tipohardwarecodigo AND T1. T1.modelohardwarenombre='$nombre'");
						$verModelo=mainModel::ejecutar_consulta_simple("SELECT * FROM modelo_hardware as T1 WHERE T1.modelohardwarenombre='$nombre' AND T1.marcahardwarecodigo='$marca'");
						if ($verModelo->rowCount()<=0) {


							$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM modelo_hardware WHERE modelohardwarecodigo='$cuenta'");
							$DatosmodelosHardware=$query1->fetch();

							if ($dni!=$DatosmodelosHardware['modelohardwarecodigo']) {
								$consulta1=mainModel::ejecutar_consulta_simple("SELECT modelohardwarecodigo FROM modelo_hardware WHERE modelohardwarecodigo='$dni'");
								if ($consulta1->rowCount()>=2) {
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


							$datamodelosHardware=[
								"MARCA"=>$marca,
								"NOMBRE"=>$nombre,
								"CODIGO"=>$cuenta
							];
							$editarmodelosHardware=modelosHardwareModelo::actualizar_modelosHardware_modelo($datamodelosHardware);
							if ($editarmodelosHardware->rowCount()>=1) {
								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"El modelo se ha actualizado con éxito",
									"Tipo"=>"success"
									];
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrió un error inesperado",
									"Texto"=>"Para actualizar los datos del modelo es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
									"Tipo"=>"error"
								];
							}



						/*}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"La marca de hardware que usted ha elejido según el tipo de hardware para el modelo no se encuentra registrado en el sistema, porfavor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
						}*/




					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"La marca de hardware ya tiene un modelo con este nombre registrado en el sistema, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}




				}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El modelo de hardware ya se encuentra en uso, por lo tanto, no puede editarlo",
							"Tipo"=>"error"
						];
				}
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Es necesario que ingrese todos los campos, por favor llénelos e intente nuevamente",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}
	}