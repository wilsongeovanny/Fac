<?php 
	if ($peticionAjax) {
		require_once "../modelos/tipoHardwareModelo.php";
	}else{
		require_once "./modelos/tipoHardwareModelo.php";
	}  

	class tipoHardwareControlador extends tipoHardwareModelo{

		//Controlador para agregar los tipos de hardware
		public function agregar_tipoHardware_controlador(){
			if (!empty($_POST['nombre-reg'])) {

				$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
				
				$consultacod=mainModel::ejecutar_consulta_simple("SELECT tipohardwarecodigo FROM tipo_hardware");
				$numero=($consultacod->rowCount())+1;
				$codigo=mainModel::generar_codigo_aleatorio("TIPHARD",7,$numero);

				$consulta1=mainModel::ejecutar_consulta_simple("SELECT tipohardwarecodigo FROM tipo_hardware WHERE tipohardwarecodigo='$codigo'");
				if ($consulta1->rowCount()<=0) {
					$consulta2=mainModel::ejecutar_consulta_simple("SELECT tipohardwarenombre FROM tipo_hardware WHERE tipohardwarenombre='$nombre'");
					if ($consulta2->rowCount()<=0) {


						

						$datostipoHardware=[
							"CODIGO"=>$codigo,
							"NOMBRE"=>$nombre
						];
						$guardartipoHardware=tipoHardwareModelo::agregar_tipoHardware_modelo($datostipoHardware);
						if ($guardartipoHardware->rowCount()>=1) {
							$alerta=[
								"Alerta"=>"recargar",
								"Titulo"=>"Felicitaciones!",
								"Texto"=>"El tipo de hardware se ha registrado con éxito",
								"Tipo"=>"success"
							];
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"No se ha podido guardar el tipo de haedware, porfavor intente nuevamente",
								"Tipo"=>"error"
							];	
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El tipo de hardware ya se encuentra registrado en el sistema, por favor intente nuevamente",
							"Tipo"=>"error"
						];	
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El código que se genero para el tipo de haedware ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
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
		public function listar_tipoHardware_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			
			//Búsqueda de un tipo de hardware a través de una tabla dinamica
			//Que se encuentra en la plantilla Gentellas Master
			$consulta="SELECT * FROM tipo_hardware";

			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM tipo_hardware" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th><center>#</center></th>
							<th><center>TIPOS DE HARDWARE</center></th>
							
			';
						//if ($privilegio<=2) {
							$tabla.='
							<th><center>ACCION</center></th>
							
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
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							
								<form method="POST" action="'.SERVERURL.'tipohardwareinfo/">
								<input type="hidden" value="'.$rows['tipohardwarecodigo'].'" name="codigo">
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


		//Eliminar administrador
		public function eliminar_administrador_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-del']);
			$adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

			if ($adminPrivilegio==1) {
				$query1=mainModel::ejecutar_consulta_simple("SELECT id FROM admin WHERE CuentaCodigo='$codigo'");
				$datosAdmin=$query1->fetch();
				if ($datosAdmin['id']!=1) {
					$DelAdmin=administradorModelo::eliminar_administrador_modelo($codigo);
					mainModel::eliminar_bitacora($codigo);
					if ($DelAdmin->rowCount()>=1) {
						$DelCuenta=mainModel::eliminar_cuenta($codigo);
						if ($DelCuenta->rowCount()>=1) {
							$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Administrador eliminado",
							"Texto"=>"El administrador fue eliminado con éxito del sistema",
							"Tipo"=>"success"
							];
						}else{
							$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No podemos eliminar esta cuenta en este momento",
							"Tipo"=>"error"
							];
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No podemos eliminar este administrador en este momento",
							"Tipo"=>"error"
						];
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"No podemos eliminar el administrador principal del sistema",
						"Tipo"=>"error"
					];
				}

			}else{
				$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"Tú no tienes los permisos necesarios para realizar esta operación",
						"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}

		public function datos_tipoHardware_controlador($tipo,$codigo){
			$codigo=mainModel::limpiar_cadena($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return tipoHardwareModelo::datos_tipoHardware_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_tipoHardware_controlador(){

			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['nombre-up'])) {
				$cuenta=mainModel::limpiar_cadena($_POST['codigo']);

				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);

				$vermh=mainModel::ejecutar_consulta_simple("SELECT * FROM hardware_ingreso WHERE tipohardwarecodigo='$dni'");
				if ($vermh->rowCount()<=0) {

					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM tipo_hardware WHERE tipohardwarecodigo='$cuenta'");
					$DatostipoHardware=$query1->fetch();

					if ($dni!=$DatostipoHardware['tipohardwarecodigo']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT tipohardwarecodigo FROM tipo_hardware WHERE tipohardwarecodigo='$dni'");
						if ($consulta1->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El código que se genero para el tipo de herdware ya se encuentra en el sistema, por favor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					if ($nombre!=$DatostipoHardware['tipohardwarenombre']) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT tipohardwarecodigo FROM tipo_hardware WHERE tipohardwarenombre='$nombre'");
						if ($consulta2->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El tipo de hardware ya se encuentra registrado en el sistema, por favor intente nuevamente",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					$datatipoHardware=[
						"NOMBRE"=>$nombre,
						"CODIGO"=>$cuenta,
					];
					$editartipoHardware=tipoHardwareModelo::actualizar_tipoHardware_modelo($datatipoHardware);
					if ($editartipoHardware->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"El tipo de hardware se ha actualizado con éxito",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Para actualizar el tipo de hardware es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}

				}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El tipo de hardware ya se encuentra en uso, por lo tanto, no puede editarlo",
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