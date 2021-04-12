<?php 
	if ($peticionAjax) {
		require_once "../modelos/estadosHardwareingresoModelo.php";
	}else{
		require_once "./modelos/estadosHardwareingresoModelo.php";
	}  

	class estadosHardwareingresoControlador extends estadosHardwareingresoModelo{

		//Controlador para agregar administrador
		public function agregar_estadosHardwareingreso_controlador(){
			if (!empty($_POST['opcion-reg'])) {
				$opcion=mainModel::limpiar_cadena($_POST['opcion-reg']);

				if ($opcion=='APROBADO' || $opcion=='RECHAZADO' ) {
				
					$consultacod=mainModel::ejecutar_consulta_simple("SELECT estadoinfoharcodigo FROM estado_info_hardware");
					$numero=($consultacod->rowCount())+1;
					$codigo=mainModel::generar_codigo_aleatorio("ESINHAR",7,$numero);


					$consulta1=mainModel::ejecutar_consulta_simple("SELECT estadoinfoharcodigo FROM estado_info_hardware WHERE estadoinfoharcodigo='$codigo'");
					if ($consulta1->rowCount()<=0) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT estadoinfoharnombre FROM estado_info_hardware WHERE estadoinfoharnombre='$opcion'");
						if ($consulta2->rowCount()<=0) {


							

							$datosestadosHardwareingreso=[
								"CODIGO"=>$codigo,
								"OPCION"=>$opcion,
							];
							$guardarestadosHardwareingreso=estadosHardwareingresoModelo::agregar_estadosHardwareingreso_modelo($datosestadosHardwareingreso);
							if ($guardarestadosHardwareingreso->rowCount()>=1) {
								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"El estado de ingreso del hardware se ha registrado con éxito",
									"Tipo"=>"success"
								];
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No se ha podido guardar el estado del hardware de ingreso, porfavor intente nuevamnete",
									"Tipo"=>"error"
								];	
							}
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"El estado del hardware de ingreso ya se encuentra registrado en el sistema",
								"Tipo"=>"error"
							];	
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El código que se genero para el estado del hardware de ingreso ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
							"Tipo"=>"error"
						];
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"Solo puede ingresar los estados del hardware de ingreso que vienen por defecto en el sistema",
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
		public function listar_estadosHardwareingreso_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			$consulta="SELECT * FROM estado_info_hardware" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th><center>#</center></th>
							<th><center>ESTADOS DEL HARDWARE DE INGRESO</center></th>
							
			';
						//if ($privilegio<=2) {
							$tabla.='
							'./*<th>ACCION</th>*/'
							
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
					$a=$rows['estadoinfoharcodigo'];
					$tabla.='
						<tr>
							<td><center>'.$contador.'</center></td>
							<td><center>'.$rows['estadoinfoharnombre'].'</center></td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							'./*<td>


								<form method="POST" action="'.SERVERURL.'estadosHardwareingresoinfo/">
									<input type="hidden" value="'.mainModel::encryption($a).'" name="codigo">
									<button type="submit" class="btn btn-primary"> Asignar</button>
								</form>        
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

		public function datos_estadosHardwareingreso_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return estadosHardwareingresoModelo::datos_estadosHardwareingreso_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_estadosHardwareingreso_controlador(){

			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['opcion-up'])) {
				$cuenta=mainModel::decryption($_POST['codigo']);

				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
				$opcion=mainModel::limpiar_cadena($_POST['opcion-up']);

				if ($opcion=='APROBADO' || $opcion=='RECHAZADO' ) {

					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM estado_info_hardware WHERE estadoinfoharcodigo='$cuenta'");
					$Datos=$query1->fetch();

					if ($dni!=$Datos['estadoinfoharcodigo']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT estadoinfoharcodigo FROM estado_info_hardware WHERE estadoinfoharcodigo='$dni'");
						if ($consulta1->rowCount()>=1) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El código que se genero para el estado del hardware de ingreso ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					if ($opcion!=$Datos['estadoinfoharnombre']) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT estadoinfoharnombre FROM estado_info_hardware WHERE estadoinfoharnombre='$opcion'");
						if ($consulta2->rowCount()>=1) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El estado del hardware de ingreso ya se encuentra registrado en el sistema",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					$dataestadosHardwareingreso=[
						"OPCION"=>$opcion,
						"CODIGO"=>$cuenta,
					];
					$editarestadosHardwareingreso=estadosHardwareingresoModelo::actualizar_estadosHardwareingreso_modelo($dataestadosHardwareingreso);
					if ($editarestadosHardwareingreso->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"El estado del hardware de ingreso se ha actualizado con exito",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Para actualizar el estado del hardware de ingreso es necesario que se realize por lo menos un cambio, porfavor intente nuevamente",
							"Tipo"=>"error"
						];
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"Solo puede ingresar los estados del hardware de ingreso que vienen por defecto en el sistema",
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