<?php 
	if ($peticionAjax) {
		require_once "../modelos/menuModelo.php";
	}else{
		require_once "./modelos/menuModelo.php";
	}  

	class menuControlador extends menuModelo{

		//Controlador para agregar administrador
		public function agregar_menu_controlador(){
			//$codigo=mainModel::limpiar_cadena($_POST['codigo-reg']);
			$opcion=mainModel::limpiar_cadena($_POST['opcion-reg']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
			
			$consultacod=mainModel::ejecutar_consulta_simple("SELECT MENUCODIGO FROM menu");
			$numero=($consultacod->rowCount())+1;
			$codigo=mainModel::generar_codigo_aleatorio("MENU",7,$numero);

			$consulta1=mainModel::ejecutar_consulta_simple("SELECT MENUCODIGO FROM menu WHERE MENUCODIGO='$codigo'");
			if ($consulta1->rowCount()<=0) {
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT MENUOPCION FROM menu WHERE MENUOPCION='$opcion'");
				if ($consulta2->rowCount()<=0) {


					

					$datosMenu=[
						"CODIGO"=>$codigo,
						"OPCION"=>$opcion,
						"NOMBRE"=>$nombre
					];
					$guardarMenu=menuModelo::agregar_menu_modelo($datosMenu);
					if ($guardarMenu->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Empresa registrada",
							"Texto"=>"El nombre del menú se ha registrado con éxito",
							"Tipo"=>"success"
						];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No hemos podido guardar el nombre del menú, porfavor intente nuevamnete",
							"Tipo"=>"error"
						];	
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El nombre del menú ya se encuentra registrado en el sistema, porfavor intente nuevamnete",
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
			return mainModel::sweet_alert($alerta);
		}


		//Controlador para gaginar administradores
		public function listar_menu_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM menu" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>#</th>
							<th>OPCIÓNES</th>
							<th>NOMBRES</th>
							
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
							<td>'.$rows['MENUOPCION'].'</td>
							<td>'.$rows['MENUNOMBRE'].'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							
								<a href="'.SERVERURL.'menuinfo/'.mainModel::encryption($rows['MENUCODIGO']).'/" class="btn btn-primary">
									<i class="fa fa-edit" onclick="editbtnmenu"></i> Editar
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

		public function datos_menu_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return menuModelo::datos_menu_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_menu_controlador(){
			$cuenta=mainModel::decryption($_POST['codigo']);

			$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);


			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM menu WHERE MENUCODIGO='$cuenta'");
			$DatosEmpresa=$query1->fetch();

			if ($dni!=$DatosEmpresa['MENUCODIGO']) {
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT MENUCODIGO FROM menu WHERE MENUCODIGO='$dni'");
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

			if ($nombre!=$DatosEmpresa['MENUNOMBRE']) {
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT MENUCODIGO FROM menu WHERE MENUNOMBRE='$nombre'");
				if ($consulta2->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El nombre del menú ya se encuentra registrado en el sistema, porfavor intente nuevamnete",
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
			$editarMenu=menuModelo::actualizar_menu_modelo($dataEmpresa);
			if ($editarMenu->rowCount()>=1) {
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Datos actualizados",
					"Texto"=>"El nombre del menú se ha actualizado con exito",
					"Tipo"=>"success"
					];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos pordido actualizar el nombre del mennú, porfavor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}
	}