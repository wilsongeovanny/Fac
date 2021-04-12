<?php 
	if ($peticionAjax) {
		require_once "../modelos/privilegiosModelo.php";
	}else{
		require_once "./modelos/privilegiosModelo.php";
	}  

	class privilegiosControlador extends privilegiosModelo{

		public function agregar_privilegios_controlador(){

			$modulo=mainModel::limpiar_cadena($_POST['modulo-reg']);
			$menu=mainModel::limpiar_cadena($_POST['menu-reg']);

			$consultacod=mainModel::ejecutar_consulta_simple("SELECT MODMENUCODIGO FROM modulo_menu");
			$numero=($consultacod->rowCount())+1;
			$codigo=mainModel::generar_codigo_aleatorio("MODMEN",7,$numero);

			$consulta1=mainModel::ejecutar_consulta_simple("SELECT MODMENUCODIGO FROM modulo_menu WHERE MODMENUCODIGO='$codigo'");
			if ($consulta1->rowCount()<=0) {
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT MENUCODIGO FROM modulo_menu WHERE MENUCODIGO='$menu'");
				if ($consulta2->rowCount()<=0) {
					$datosEmpresa=[
						"CODIGO"=>$codigo,
						"MENU"=>$menu,
						"MODULO"=>$modulo,
					];
					$guardarEmpresa=privilegiosModelo::agregar_privilegios_modelo($datosEmpresa);
					if ($guardarEmpresa->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Empresa registrada",
							"Texto"=>"El menú fue asignado a un modulo con exito",
							"Tipo"=>"success"
						];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No se asigno el menú al modulo, porfavor intente nuevamnete",
							"Tipo"=>"error"
						];	
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El menú que acaba de seleccionar ya se encuentra asignado a un modulo, porfavor intente nuevamnete",
						"Tipo"=>"error"
					];	
				}
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El código que acaba de ingresar ya se encuentra en el sistema, porfavor intente nuevamnete",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}

		public function datos_privilegios_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return privilegiosModelo::datos_privilegios_modelo($tipo,$codigo);
		}

		//Controlador para gaginar administradores
		public function listar_privilegios_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			$consulta="SELECT SQL_CALC_FOUND_ROWS *,T1.MODMENUCODIGO FROM modulo_menu as T1, menu as T2, modulo as T3 WHERE T1.MENUCODIGO=T2.MENUCODIGO AND T1.MODULOCODIGO=T3.MODULOCODIGO" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>#</th>
							<th>MENU</th>
							<th>MODULO</th>
							
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
							<td>'.$rows['MENUNOMBRE'].'</td>
							<td>'.$rows['MODULONOMBRE'].'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							
								<a href="'.SERVERURL.'privilegiosinfo/'.mainModel::encryption($rows['MODMENUCODIGO']).'/" class="btn btn-primary">
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

		/*public function eliminar_privilegios_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-del']);
			$adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

			if ($adminPrivilegio==1) {
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT EmpresaCodigo FROM libro WHERE EmpresaCodigo='$codigo'");

				if ($consulta1->rowCount()<=0) {
					$DelEmpresa=privilegiosModelo::eliminar_privilegios_modelo($codigo);

					if ($DelEmpresa->rowCount()==1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Empresa eliminada",
							"Texto"=>"La empresa fue eliminada con exito",
							"Tipo"=>"success"
						];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"Lo sentimos no hemos podido eliminar la empresa",
							"Tipo"=>"error"
						];
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"Lo sentimos no podemos eliminar la empresa poeque tiene libros asociados",
						"Tipo"=>"error"
					];
				}
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Tu no tienes los permisos necesarios para eliminar registros del sistema",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}*/

		//Controlador actualizar datos copiada de clientes
		public function actualizar_privilegios_controlador(){
			$cuenta=mainModel::decryption($_POST['codigo']);

			$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
			$modulo=mainModel::limpiar_cadena($_POST['modulo-up']);
			$menu=mainModel::limpiar_cadena($_POST['menu-up']);

			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM modulo_menu WHERE MODMENUCODIGO='$cuenta'");
			$DatosEmpresa=$query1->fetch();

			if ($dni!=$DatosEmpresa['MODMENUCODIGO']) {
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT MODMENUCODIGO FROM modulo_menu WHERE MODMENUCODIGO='$dni'");
				if ($consulta1->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El código que acaba de ingresar ya se encuentra en el sistema, porfavor intente nuevamnete",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}

			if ($menu!=$DatosEmpresa['MENUCODIGO']) {
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT MENUCODIGO FROM modulo_menu WHERE MENUCODIGO='$menu'");
				if ($consulta2->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El menú que acaba de seleccionar ya se encuentra asignado a un modulo, porfavor intente nuevamnete",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}


			$dataEmpresa=[
				"MENU"=>$menu,
				"MODULO"=>$modulo,
				"CODIGO"=>$cuenta
			];

			$editarEmpresa=privilegiosModelo::actualizar_privilegios_modelo($dataEmpresa);
			if ($editarEmpresa->rowCount()>=1) {
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Datos actualizados",
					"Texto"=>"La asignación del menú al modulo fue actualizado con exito",
					"Tipo"=>"success"
					];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No se pudo actualizar asignación del menú al modulo, porfavor intente nuevamnete",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}

	}