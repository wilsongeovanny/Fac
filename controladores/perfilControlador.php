<?php 
	if ($peticionAjax) {
		require_once "../modelos/perfilModelo.php";
	}else{
		require_once "./modelos/perfilModelo.php";
	}  

	class perfilControlador extends perfilModelo{

		public function agregar_perfil_controlador(){

			$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);

			$consultacod=mainModel::ejecutar_consulta_simple("SELECT PERFILCODIGO FROM perfil_cuenta");
			$numero=($consultacod->rowCount())+1;
			$codigo=mainModel::generar_codigo_aleatorio("PERFIL",7,$numero);

			$consulta1=mainModel::ejecutar_consulta_simple("SELECT PERFILCODIGO FROM perfil_cuenta WHERE PERFILCODIGO='$codigo'");
			if ($consulta1->rowCount()<=0) {
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT PERFILNOMBRE FROM perfil_cuenta WHERE PERFILNOMBRE='$nombre'");
				if ($consulta2->rowCount()<=0) {
					$datosPerfil=[
						"CODIGO"=>$codigo,
						"NOMBRE"=>$nombre,
					];
					$guardarPerfil=perfilModelo::agregar_perfil_modelo($datosPerfil);
					if ($guardarPerfil->rowCount()>=1) {
						
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Perfil registrado",
							"Texto"=>"Los datos del municipio se registraron con exito",
							"Tipo"=>"success"
						];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No se guardaron los datos del municipio, porfavor intente nuevamnete",
							"Tipo"=>"error"
						];	
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El nombre de la entidad que acaba de ingresar ya se encuentra en el sistema, porfavor intente nuevamnete",
						"Tipo"=>"error"
					];	
				}
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El ruc que acaba de ingresar ya se encuentra en el sistema, porfavor intente nuevamnete",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}

		public function datos_perfil_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return perfilModelo::datos_perfil_modelo($tipo,$codigo);
		}

		//Controlador para gaginar administradores
		public function listar_perfil_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM perfil_cuenta" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>#</th>
							<th>NOMBRE</th>
							
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
							<td>'.$rows['PERFILNOMBRE'].'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							
								<a href="'.SERVERURL.'perfilinfo/'.mainModel::encryption($rows['PERFILCODIGO']).'/" class="btn btn-primary">
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

		/*public function eliminar_perfil_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-del']);
			$adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

			if ($adminPrivilegio==1) {
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT EmpresaCodigo FROM libro WHERE EmpresaCodigo='$codigo'");

				if ($consulta1->rowCount()<=0) {
					$DelPerfil=perfilModelo::eliminar_perfil_modelo($codigo);

					if ($DelPerfil->rowCount()==1) {
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
		public function actualizar_perfil_controlador(){
			$cuenta=mainModel::decryption($_POST['codigo']);

			$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);

			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM perfil_cuenta WHERE PERFILCODIGO='$cuenta'");
			$DatosPerfil=$query1->fetch();

			if ($dni!=$DatosPerfil['PERFILCODIGO']) {
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT PERFILCODIGO FROM perfil_cuenta WHERE PERFILCODIGO='$dni'");
				if ($consulta1->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El ruc que acaba de ingresar ya se encuentra en el sistema, porfavor intente nuevamnete",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}

			if ($nombre!=$DatosPerfil['PERFILNOMBRE']) {
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT PERFILNOMBRE FROM perfil_cuenta WHERE PERFILNOMBRE='$nombre'");
				if ($consulta2->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El nombre de la entidad que acaba de ingresar ya se encuentra en el sistema, porfavor intente nuevamnete",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}





			$dataPerfil=[
				"NOMBRE"=>$nombre,
				"CODIGO"=>$cuenta
			];

			$editarPerfil=perfilModelo::actualizar_perfil_modelo($dataPerfil);
			if ($editarPerfil->rowCount()>=1) {
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Datos actualizados",
					"Texto"=>"Los datos del municipio se actualizaron con exito",
					"Tipo"=>"success"
					];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No se actualizaron los datos del municipio, porfavor intente nuevamnete",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}

	}