<?php 
	if ($peticionAjax) {
		require_once "../modelos/coloresHardwareModelo.php";
	}else{
		require_once "./modelos/coloresHardwareModelo.php";
	}  

	class coloresHardwareControlador extends coloresHardwareModelo{

		//Controlador para agregar colores al hadware
		public function agregar_coloresHardware_controlador(){
			if (!empty($_POST['nombre-reg'])) {
				$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
				
				$consultacod=mainModel::ejecutar_consulta_simple("SELECT colorhardwarecodigo FROM color_hardware");
				$numero=($consultacod->rowCount())+1;
				$codigo=mainModel::generar_codigo_aleatorio("COLHARD",7,$numero);

				$consulta1=mainModel::ejecutar_consulta_simple("SELECT colorhardwarecodigo FROM color_hardware WHERE colorhardwarecodigo='$codigo'");
				if ($consulta1->rowCount()<=0) {
					$consulta2=mainModel::ejecutar_consulta_simple("SELECT colorhardwarenombre FROM color_hardware WHERE colorhardwarenombre='$nombre'");
					if ($consulta2->rowCount()<=0) {


						

						$datoscoloresHardware=[
							"CODIGO"=>$codigo,
							"NOMBRE"=>$nombre
						];
						$guardarcoloresHardware=coloresHardwareModelo::agregar_coloresHardware_modelo($datoscoloresHardware);
						if ($guardarcoloresHardware->rowCount()>=1) {
							$alerta=[
								"Alerta"=>"recargar",
								"Titulo"=>"Felicitaciones!",
								"Texto"=>"El color del hardware se ha registrado con éxito",
								"Tipo"=>"success"
							];
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"No se ha podido guardar el color del hardware, porfavor intente nuevamente",
								"Tipo"=>"error"
							];	
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El color del hardware ya se encuentra registrado en el sistema, por favor intente nuevamente",
							"Tipo"=>"error"
						];	
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El código que se genero para el color del hardware ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
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
		public function listar_coloresHardware_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			$consulta="SELECT * FROM color_hardware" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th><center>#</center></th>
							<th><center>NOMBRE DEL COLOR DE HARDWARE</center></th>
							
			';
						//if ($privilegio<=2) {

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
							<td><center>'.$rows['colorhardwarenombre'].'</center></td>
							';
						//if ($privilegio<=2) {


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
							"Texto"=>"El administrador fue eliminado con exito del sistema",
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

		public function datos_coloresHardware_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return coloresHardwareModelo::datos_coloresHardware_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_coloresHardware_controlador(){

			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['nombre-up'])) {

				$cuenta=mainModel::decryption($_POST['codigo']);

				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);

				$vermh=mainModel::ejecutar_consulta_simple("SELECT * FROM hardware_ingreso WHERE colorhardwarecodigo='$$dni'");
				if ($vermh->rowCount()<=0) {

					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM color_hardware WHERE colorhardwarecodigo='$cuenta'");
					$DatosEmpresa=$query1->fetch();

					if ($dni!=$DatosEmpresa['colorhardwarecodigo']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT colorhardwarecodigo FROM color_hardware WHERE colorhardwarecodigo='$dni'");
						if ($consulta1->rowCount()>=1) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El código que se genero para el color del hardware ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					if ($nombre!=$DatosEmpresa['colorhardwarenombre']) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT colorhardwarecodigo FROM color_hardware WHERE colorhardwarenombre='$nombre'");
						if ($consulta2->rowCount()>=1) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El color del hardware ya se encuentra registrado en el sistema, por favor intente nuevamente",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					$dataEmpresa=[
						"NOMBRE"=>$nombre,
						"CODIGO"=>$cuenta,
					];
					$editarcoloresHardware=coloresHardwareModelo::actualizar_coloresHardware_modelo($dataEmpresa);
					if ($editarcoloresHardware->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"El color del hardware se ha actualizado con éxito",
							"Tipo"=>"success"
						];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Para actualizar el color del hardware es necesario que se realize por lo menos un cambio, porfavor intente nuevamente",
							"Tipo"=>"error"
						];
					}

				}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El color de hardware ya se encuentra en uso, por lo tanto no puede editarla",
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