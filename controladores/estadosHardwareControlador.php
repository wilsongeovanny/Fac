<?php 
	if ($peticionAjax) {
		require_once "../modelos/estadosHardwareModelo.php";
	}else{
		require_once "./modelos/estadosHardwareModelo.php";
	}  

	class estadosHardwareControlador extends estadosHardwareModelo{

		//Controlador para agregar administrador
		public function agregar_estadosHardware_controlador(){
			if (!empty($_POST['opcion-reg'])) {

				$opcion=mainModel::limpiar_cadena($_POST['opcion-reg']);
				if ($opcion=='ASIGNADO' || $opcion=='NO ASIGNADO' || $opcion=='REASIGNADO' || $opcion=='NO REASIGNADO') {
				
					$consultacod=mainModel::ejecutar_consulta_simple("SELECT estadoasigharcodigo FROM estado_asignacion_hardware");
					$numero=($consultacod->rowCount())+1;
					$codigo=mainModel::generar_codigo_aleatorio("ESTHARD",7,$numero);

					$consulta1=mainModel::ejecutar_consulta_simple("SELECT estadoasigharcodigo FROM estado_asignacion_hardware WHERE estadoasigharcodigo='$codigo'");
					if ($consulta1->rowCount()<=0) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT estadoasigharnombre FROM estado_asignacion_hardware WHERE estadoasigharnombre='$opcion'");
						if ($consulta2->rowCount()<=0) {
							

							$datosestadosHardware=[
								"CODIGO"=>$codigo,
								"OPCION"=>$opcion,
							];
							$guardarestadosHardware=estadosHardwareModelo::agregar_estadosHardware_modelo($datosestadosHardware);
							if ($guardarestadosHardware->rowCount()>=1) {
								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"El estado de asignación o reasignación se ha registrado con éxito",
									"Tipo"=>"success"
								];
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No se ha podido gurdar el estado de asignación o reasignación, porfavor intente nuevamente",
									"Tipo"=>"error"
								];	
							}
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"El estado de asignación o reasignación ya se encuentra registrado en el sistema, por
								favor intente nuevamente",
								"Tipo"=>"error"
							];	
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El código que se genero para el estado del asignación o reasignación ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
							"Tipo"=>"error"
						];
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"Solo puede ingresar los estados de asignación y reasignación que vienen por defecto en el sistema",
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


		//Controlador para gaginar administradores
		public function listar_estadosHardware_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			$consulta="SELECT * FROM estado_asignacion_hardware" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th><center>#</center></th>
							<th style="width:900px"><center>ESTADOS DE ASINACIÓN Y REASIGNACIÓN DE HARDWARE</center></th>
							
			';
						//if ($privilegio<=2) {
							/*$tabla.='
							<th>ACCION</th>
							
							';*/
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
							<td><center>'.$rows['estadoasigharnombre'].'</center></td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							'./*<td>
							
								<a href="'.SERVERURL.'estadosHardwareasignacioninfo/'.mainModel::encryption($rows['estadoasigharcodigo']).'/" class="btn btn-primary">
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

		public function datos_estadosHardware_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return estadosHardwareModelo::datos_estadosHardware_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_estadosHardware_controlador(){
			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['opcion-up'])) {

				//$Consultaestados=mainModel::ejecutar_consulta_simple("SELECT estadoasigharnombre FROM estado_asignacion_hardware WHERE estadoasigharnombre='$opcion'");
				//$resultados=$Consultaestados->fetch();
				//$veri=$resultados['estadoasigharnombre'];

				$cuenta=mainModel::decryption($_POST['codigo']);

				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
				$opcion=mainModel::limpiar_cadena($_POST['opcion-up']);

				if ($opcion=='ASIGNADO' || $opcion=='NO ASIGNADO' || $opcion=='REASIGNADO' || $opcion=='NO REASIGNADO') {

					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM estado_asignacion_hardware WHERE estadoasigharcodigo='$cuenta'");
					$DatosestadosHardware=$query1->fetch();

					if ($dni!=$DatosestadosHardware['estadoasigharcodigo']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT estadoasigharcodigo FROM estado_asignacion_hardware WHERE estadoasigharcodigo='$dni'");
						if ($consulta1->rowCount()>=1) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El código que se genero para el estado del asignación o reasignación ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					if ($opcion!=$DatosestadosHardware['estadoasigharnombre']) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT estadoasigharnombre FROM estado_asignacion_hardware WHERE estadoasigharnombre='$opcion'");
						if ($consulta2->rowCount()>=1) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El estado de asignación o reasignación ya se encuentra registrado en el sistema, porfavor intente nuevamente",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					$dataestadosHardware=[
						"OPCION"=>$opcion,
						"CODIGO"=>$cuenta,
					];
					$editarestadosHardware=estadosHardwareModelo::actualizar_estadosHardware_modelo($dataestadosHardware);
					if ($editarestadosHardware->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Datos actualizados",
							"Texto"=>"El estado de asignación o reasignación se ha actualizado con exito",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Para actualizar el estado del asignación o reasignación es necesario que se realize por lo menos un cambio, porfavor intente nuevamente",
							"Tipo"=>"error"
						];
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"Solo puede ingresar los estados de asignación y reasignación que vienen por defecto en el sistema",
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