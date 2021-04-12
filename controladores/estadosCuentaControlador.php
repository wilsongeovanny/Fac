<?php 
	if ($peticionAjax) {
		require_once "../modelos/estadosCuentaModelo.php";
	}else{
		require_once "./modelos/estadosCuentaModelo.php";
	}  

	class estadosCuentaControlador extends estadosCuentaModelo{

		//Controlador para agregar administrador
		public function agregar_estadosCuenta_controlador(){
			//$codigo=mainModel::limpiar_cadena($_POST['codigo-reg']);

			if (!empty($_POST['opcion-reg'])) {
				$opcion=mainModel::limpiar_cadena($_POST['opcion-reg']);

				if (trim($opcion)=='ACTIVO' || trim($opcion)=='DESACTIVO') {
				
					$consultacod=mainModel::ejecutar_consulta_simple("SELECT estadocuentacodigo FROM estado_cuenta");
					$numero=($consultacod->rowCount())+1;
					$codigo=mainModel::generar_codigo_aleatorio("ESTCT",7,$numero);

					$consulta1=mainModel::ejecutar_consulta_simple("SELECT estadocuentacodigo FROM estado_cuenta WHERE estadocuentacodigo='$codigo'");
					if ($consulta1->rowCount()<=0) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT estadocuentanombre FROM estado_cuenta WHERE estadocuentanombre='$opcion'");
						if ($consulta2->rowCount()<=0) {


							

							$datosMenu=[
								"CODIGO"=>$codigo,
								"OPCION"=>$opcion,
							];
							$guardarMenu=estadosCuentaModelo::agregar_estadosCuenta_modelo($datosMenu);
							if ($guardarMenu->rowCount()>=1) {
								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"El estado del administrador se ha registrado con éxito",
									"Tipo"=>"success"
								];
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No hemos podido guardar el estado, porfavor intente nuevamnete",
									"Tipo"=>"error"
								];	
							}
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"El estado del administrador ya se encuentra registrado en el sistema, por favor intente nuevamente",
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
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Solo puede ingresar los estados del administrador que vienen por defecto en el sistema",
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
		public function listar_estadosCuenta_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			$consulta="SELECT * FROM estado_cuenta" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th><center>#</center></th>
							<th><center>NOMBRES</center></th>
							
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
							<td><center>'.$rows['estadocuentanombre'].'</center></td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							'./*<td>
							
								<a href="'.SERVERURL.'estadosCuentainfo/'.mainModel::encryption($rows['estadocuentacodigo']).'/" class="btn btn-primary">
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

		public function datos_estadosCuenta_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return estadosCuentaModelo::datos_estadosCuenta_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_estadosCuenta_controlador(){
			$cuenta=mainModel::decryption($_POST['codigo']);

			$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
			$opcion=mainModel::limpiar_cadena($_POST['opcion-up']);


			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM estado_cuenta WHERE estadocuentacodigo='$cuenta'");
			$DatosEmpresa=$query1->fetch();

			if ($dni!=$DatosEmpresa['estadocuentacodigo']) {
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT estadocuentacodigo FROM estado_cuenta WHERE estadocuentacodigo='$dni'");
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

			if ($opcion!=$DatosEmpresa['estadocuentanombre']) {
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT estadocuentanombre FROM estado_cuenta WHERE estadocuentanombre='$opcion'");
				if ($consulta2->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El estado del administrador ya se encuentra registrado en el sistema, porfavor intente nuevamnete",
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
			$editarMenu=estadosCuentaModelo::actualizar_estadosCuenta_modelo($dataEmpresa);
			if ($editarMenu->rowCount()>=1) {
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Datos actualizados",
					"Texto"=>"El estado del administrador se ha actualizado con éxito",
					"Tipo"=>"success"
					];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No se ha podido actualizar el estado, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}
	}