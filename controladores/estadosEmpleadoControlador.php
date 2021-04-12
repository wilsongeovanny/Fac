<?php 
	if ($peticionAjax) {
		require_once "../modelos/estadosEmpleadoModelo.php";
	}else{
		require_once "./modelos/estadosEmpleadoModelo.php";
	}  

	class estadosEmpleadoControlador extends estadosEmpleadoModelo{

		//Controlador para agregar administrador
		public function agregar_estadosEmpleado_controlador(){
			
			if (!empty($_POST['opcion-reg'])) {

				$opcion=mainModel::limpiar_cadena($_POST['opcion-reg']);

				if ($opcion=='ACTIVO' || $opcion=='DESACTIVO') {

					$consultacod=mainModel::ejecutar_consulta_simple("SELECT estadoempleadocodigo FROM estado_empleado");
					$numero=($consultacod->rowCount())+1;
					$codigo=mainModel::generar_codigo_aleatorio("ESTEM",7,$numero);



					$consulta1=mainModel::ejecutar_consulta_simple("SELECT estadoempleadocodigo FROM estado_empleado WHERE estadoempleadocodigo='$codigo'");

					if ($consulta1->rowCount()<=0) {

						$consulta2=mainModel::ejecutar_consulta_simple("SELECT estadoempleadonombre FROM estado_empleado WHERE estadoempleadonombre='$opcion'");
						if ($consulta2->rowCount()<=0) {

							$datosMenu=[
								"CODIGO"=>$codigo,
								"OPCION"=>$opcion,
							];
							$guardarMenu=estadosEmpleadoModelo::agregar_estadosEmpleado_modelo($datosMenu);
							if ($guardarMenu->rowCount()>=1) {
								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"El estado del empleado se ha registrado con éxito",
									"Tipo"=>"success"
								];
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrió un error inesperado",
									"Texto"=>"No se ha podido guardar el estado del empleado, por favor intente nuevamente",
									"Tipo"=>"error"
								];	
							}
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El estado del empleado ya se encuentra registrado en el sistema, por favor intente nuevamente",
								"Tipo"=>"error"
							];	
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El código que se genero para el estado del empleado ya se encuentra en el sistema, por favor intente nuevamente recargando la página",
							"Tipo"=>"error"
						];
					}

				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Solo puede ingresar los estados del empleado que vienen por defecto en el sistema",
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
		public function listar_estadosEmpleado_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			$consulta="SELECT * FROM estado_empleado" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th><center>#</center></th>
							<th><center>ESTADOS DEL EMPLEADO</center></th>
							
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
					$tabla.='
						<tr>
							<td><center>'.$contador.'</center></td>
							<td><center>'.$rows['estadoempleadonombre'].'</center></td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							
							
								'./*<td> <a href="'.SERVERURL.'estadosEmpleadoinfo/'.mainModel::encryption($rows['estadoempleadocodigo']).'/" class="btn btn-primary">
									<i class="fa fa-edit" onclick="editbtnmenu"></i> Editar
								</td> </a>*/'
                                              
							

						
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

		public function datos_estadosEmpleado_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return estadosEmpleadoModelo::datos_estadosEmpleado_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_estadosEmpleado_controlador(){

			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['opcion-up'])) {

				$cuenta=mainModel::decryption($_POST['codigo']);

				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
				$opcion=mainModel::limpiar_cadena($_POST['opcion-up']);

				if ($opcion=='ACTIVO' || $opcion=='DESACTIVO' ) {

					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM estado_empleado WHERE estadoempleadocodigo='$cuenta'");
					$DatosEmpresa=$query1->fetch();

					if ($dni!=$DatosEmpresa['estadoempleadocodigo']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT estadoempleadocodigo FROM estado_empleado WHERE estadoempleadocodigo='$dni'");
						if ($consulta1->rowCount()>=1) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El código que se genero para el estado del empleado ya se encuentra en el sistema, por favor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					if ($opcion!=$DatosEmpresa['estadoempleadonombre']) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT estadoempleadonombre FROM estado_empleado WHERE estadoempleadonombre='$opcion'");
						if ($consulta2->rowCount()>=1) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El estado del empleado ya se encuentra registrado en el sistema, por favor intente nuevamente",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					$dataEmpresa=[
						"OPCION"=>$opcion,
						"CODIGO"=>$cuenta,
					];
					$editarMenu=estadosEmpleadoModelo::actualizar_estadosEmpleado_modelo($dataEmpresa);
					if ($editarMenu->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"El estado del empleado se ha actualizado con exito",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Para actualizar el estado del empleado es necesario que se realize por lo menos un cambio, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}

				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Solo puede ingresar los estados del empleado que vienen por defecto en el sistema",
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