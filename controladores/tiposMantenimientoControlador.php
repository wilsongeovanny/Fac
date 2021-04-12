<?php 
	if ($peticionAjax) {
		require_once "../modelos/tiposMantenimientoModelo.php";
	}else{
		require_once "./modelos/tiposMantenimientoModelo.php";
	}  

	class tiposMantenimientoControlador extends tiposMantenimientoModelo{

		//Controlador para agregar administrador
		public function agregar_tiposMantenimiento_controlador(){
			if (!empty($_POST['opcion-reg'])) {
				$opcion=mainModel::limpiar_cadena($_POST['opcion-reg']);
						
				if ($opcion=='CORRECTIVO' || $opcion=='DE BAJA' || $opcion=='PREVENTIVO') {
				
					$consultacod=mainModel::ejecutar_consulta_simple("SELECT tipomantecodigo FROM tipo_mantenimiento");
					$numero=($consultacod->rowCount())+1;
					$codigo=mainModel::generar_codigo_aleatorio("TIPMANT",7,$numero);

					$consulta1=mainModel::ejecutar_consulta_simple("SELECT tipomantecodigo FROM tipo_mantenimiento WHERE tipomantecodigo='$codigo'");
					if ($consulta1->rowCount()<=0) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT tipomantenombre FROM tipo_mantenimiento WHERE tipomantenombre='$opcion'");
						if ($consulta2->rowCount()<=0) {
							

							$datostiposMantenimiento=[
								"CODIGO"=>$codigo,
								"OPCION"=>$opcion,
							];
							$guardartiposMantenimiento=tiposMantenimientoModelo::agregar_tiposMantenimiento_modelo($datostiposMantenimiento);
							if ($guardartiposMantenimiento->rowCount()>=1) {
								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"El tipo del mantenimiento se ha registrado con éxito",
									"Tipo"=>"success"
								];
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No se ha podido guardar el tipo del mantenimiento, porfavor intente nuevamente",
									"Tipo"=>"error"
								];	
							}
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"El tipo del mantenimiento ya se encuentra registrado en el sistema, por favor intente nuevamente",
								"Tipo"=>"error"
							];	
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El código que se genero para el tipo de mantenimiento del hardware ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
							"Tipo"=>"error"
						];
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"Solo puede ingresar los tipos del mantenimiento de hardware que vienen por defecto en el sistema",
						"Tipo"=>"error"
					];
				}
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Faltan campos por llenar",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}


		//Controlador para gaginar administradores
		public function listar_tiposMantenimiento_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			$consulta="SELECT * FROM tipo_mantenimiento" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th><center>#</center></th>
							<th><center>TIPOS DEL MANTENIMIENTO</center></th>
							
			';
						//if ($privilegio<=2) {
							$tabla.='
							'./*<th>ACCIONES</th>*/'
							
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
							<td><center>'.$rows['tipomantenombre'].'</center></td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							'./*<td>
							
								<a href="'.SERVERURL.'tiposMantenimientoinfo/'.mainModel::encryption($rows['tipomantecodigo']).'/" class="btn btn-primary">
									<i class="fa fa-edit" onclick="editbtnmenu"></i> Editar
								</a>
                                              
							</td>*/'

						
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

		public function datos_tiposMantenimiento_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return tiposMantenimientoModelo::datos_tiposMantenimiento_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_tiposMantenimiento_controlador(){
			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) &&!empty($_POST['opcion-up'])) {

				$cuenta=mainModel::decryption($_POST['codigo']);
				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
				$opcion=mainModel::limpiar_cadena($_POST['opcion-up']);

				if ($opcion=='CORRECTIVO' || $opcion=='DE BAJA' || $opcion=='PREVENTIVO') {

					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM tipo_mantenimiento WHERE tipomantecodigo='$cuenta'");
					$DatostiposMantenimiento=$query1->fetch();

					if ($dni!=$DatostiposMantenimiento['tipomantecodigo']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT tipomantecodigo FROM tipo_mantenimiento WHERE tipomantecodigo='$dni'");
						if ($consulta1->rowCount()>=1) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El código que se genero para el tipo de mantenimiento del hardware ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					if ($opcion!=$DatostiposMantenimiento['tipomantenombre']) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT tipomantenombre FROM tipo_mantenimiento WHERE tipomantenombre='$opcion'");
						if ($consulta2->rowCount()>=1) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El tipo del mantenimiento ya se encuentra registrado en el sistema, por favor intente nuevamente",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					$datatiposMantenimiento=[
						"OPCION"=>$opcion,
						"CODIGO"=>$cuenta,
					];
					$editartiposMantenimiento=tiposMantenimientoModelo::actualizar_tiposMantenimiento_modelo($datatiposMantenimiento);
					if ($editartiposMantenimiento->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"El tipo de mantenimiento se ha actualizado con éxito",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Para actualizar el tipo del mantenimiento es necesario que se realize por lo menos un cambio, porfavor intente nuevamente",
							"Tipo"=>"error"
						];
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"Solo puede ingresar los tipos del mantenimiento de hardware que vienen por defecto en el sistema",
						"Tipo"=>"error"
					];
				}
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Faltan campos por llenar",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}
	}