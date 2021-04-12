<?php 
	if ($peticionAjax) {
		require_once "../modelos/rolesModelo.php";
	}else{
		require_once "./modelos/rolesModelo.php";
	}  

	class rolesControlador extends rolesModelo{

		//Controlador para agregar administrador
		public function agregar_roles_controlador(){
			//$codigo=mainModel::limpiar_cadena($_POST['codigo-reg']);

			if (!empty($_POST['nombre-reg']) && !empty($_POST['descripcion-reg']) && !empty($_POST['opcion-reg']) && !empty($_POST['privilegios'])) {

				$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
				$descripcion=mainModel::limpiar_cadena($_POST['descripcion-reg']);
				$estado=mainModel::limpiar_cadena($_POST['opcion-reg']);
				$privilegios=mainModel::limpiar_cadena($_POST['privilegios']);
				
				$consultacod=mainModel::ejecutar_consulta_simple("SELECT codigoroles FROM roles");
				$numero=($consultacod->rowCount())+1;
				$codigo=mainModel::generar_codigo_aleatorio("ROLES",7,$numero);

				$consulta1=mainModel::ejecutar_consulta_simple("SELECT codigoroles FROM roles WHERE codigoroles='$codigo'");
				if ($consulta1->rowCount()<=0) {

					$consulta1=mainModel::ejecutar_consulta_simple("SELECT rolesnombre FROM roles WHERE rolesnombre='$nombre'");
					if ($consulta1->rowCount()<=0) {

						$datosRol=[
							"CODIGO"=>trim($codigo),
							"NOMBRE"=>trim($nombre),
							"DESCRIPCION"=>trim($descripcion),
							"ESTADO"=>trim($estado)
						];
						$guardarRol=rolesModelo::agregar_roles_modelo($datosRol);
						if ($guardarRol->rowCount()>=1) {
							




							$arreglo_cadena_detalles = explode("&&", $privilegios);
							for ($i=0; $i <count($arreglo_cadena_detalles) ; $i++) { 

								$detales_rol=[
									"ROLES"=>trim($codigo),
									"MODULOS"=>trim($arreglo_cadena_detalles[$i])
								];

								$guardarDetRol=rolesModelo::agregar_detalles_modelo($detales_rol);
								
							}

							$numero_detalles=count($arreglo_cadena_detalles);

							$consultar_detalles=mainModel::ejecutar_consulta_simple("SELECT codigoroles FROM privilegios WHERE codigoroles='$codigo'");
							if ($consultar_detalles->rowCount()==$numero_detalles) {
								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"El rol de administrador se ha registrado con éxito",
									"Tipo"=>"success"
								];


							}else{
								$eliminaras=mainModel::ejecutar_consulta_simple("DELETE FROM roles WHERE codigoroles='$codigo'");
								$eliminarasdetalles=mainModel::ejecutar_consulta_simple("DELETE FROM privilegios WHERE codigoroles='$codigo'");
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No se ha podido guardar el rol, porfavor intente nuevamente",
									"Tipo"=>"error"
								];	
							}

							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No se ha podido guardar el rol, porfavor intente nuevamente",
									"Tipo"=>"error"
								];	
							}	
								
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"El nombre del rol ya se encuentra registrado en el sistema, por favor intente nuevamente con otro nombre",
								"Tipo"=>"error"
							];	
						}

				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El código que se asigno al rol ya se encuentra registrado en el sistema por favor intente nuevamente recargando la página",
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


		public function datos_roles_controlador($tipo,$codigo){
			$codigo=mainModel::limpiar_cadena($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return rolesModelo::datos_roles_modelo($tipo,$codigo);
		}

		//Controlador para gaginar administradores
		public function listar_roles_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			//Consulta para buscar los roles del administrador.
			//Para la búsqueda se utilizo una tabla dinamica de la pantilla Gentellas Master.
			$consulta="SELECT * FROM roles";



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
							<th><center>DESCRIPCION</center></th>
							<th><center>ESTADO</center></th>
							
			';
						//if ($privilegio<=2) {
							$tabla.='
							<th><center>ACCIONES</center></th>
							
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
							<td><center>'.$rows['rolesnombre'].'</center></td>
							<td><center>'.$rows['rolesdescripcion'].'</center></td>
							<td><center>'.$rows['rolesestado'].'</center></td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							
								'./*<center><a href="'.SERVERURL.'rolesinfo/'.mainModel::encryption($rows['codigoroles']).'/" class="btn btn-primary">
									<i class="fa fa-edit" onclick="editbtnmenu"></i> Editar
								</a></center>*/'


								<center><form method="POST" action="'.SERVERURL.'rolesinfo/">
								<input type="hidden" value="'.trim($rows['codigoroles']).'" name="codigo">
								<button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-primary"> Editar</button>
								</form></center>
                                              
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

		//Controlador actualizar el nombre del menú
		public function actualizar_roles_controlador(){
			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) &&  !empty($_POST['nombre-up']) && !empty($_POST['descripcion-up']) && !empty($_POST['opcion-up']) && !empty($_POST['detemrg'])) {

				$cuenta=mainModel::limpiar_cadena($_POST['codigo']);

				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);
				$descripcion=mainModel::limpiar_cadena($_POST['descripcion-up']);
				$estado=mainModel::limpiar_cadena($_POST['opcion-up']);

				


				$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM roles WHERE codigoroles='$cuenta'");
				$DatosRol=$query1->fetch();

				$aa=$DatosRol['rolesnombre'];

				if ($dni!=$DatosRol['codigoroles']) {
					$consulta1=mainModel::ejecutar_consulta_simple("SELECT codigoroles FROM roles WHERE codigoroles='$dni'");
					if ($consulta1->rowCount()>=2) {
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

				if ($nombre!=$DatosRol['rolesnombre']) {
					$consulta2=mainModel::ejecutar_consulta_simple("SELECT rolesnombre FROM roles WHERE rolesnombre='$nombre'");
					if ($consulta2->rowCount()>=2) {
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El nombre del rol ya se encuentra registrado en el sistema, por favor intente nuevamente",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
					}
				}

				$dataRol=[
					"NOMBRE"=>$nombre,
					"DESCRIPCION"=>$descripcion,
					"ESTADO"=>$estado,
					"CODIGO"=>$cuenta
				];
				$editarRol=rolesModelo::actualizar_roles_modelo($dataRol);
				if ($editarRol->rowCount()>=0) {
						




					if (!empty($_POST['detalles'])) {
					$detalled_roles=mainModel::limpiar_cadena($_POST['detalles']);
					$ami=$detalled_roles;
					$consultar_detalles=mainModel::ejecutar_consulta_simple("SELECT * FROM privilegios WHERE codigoroles='$cuenta'");
					//$contador_detalles=$consultar_detalles->rowCount();
					$eliminara_detalles=mainModel::ejecutar_consulta_simple("DELETE FROM privilegios WHERE codigoroles='$cuenta'");





					$arreglo_cadena_detalles = explode("&&", $detalled_roles);
					for ($i=0; $i <count($arreglo_cadena_detalles) ; $i++) { 

						$detales_rol=[
							"ROLES"=>$cuenta,
							"MODULOS"=>$arreglo_cadena_detalles[$i]
						];

						$guardarDetRol=rolesModelo::agregar_detalles_modelo($detales_rol);

					}

					$numero_detalles=count($arreglo_cadena_detalles);

					$consultar_detalles=mainModel::ejecutar_consulta_simple("SELECT codigoroles FROM privilegios WHERE codigoroles='$cuenta'");
					if ($consultar_detalles->rowCount()==$numero_detalles) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"El rol de administrador se ha actualizado con éxito",
							"Tipo"=>"success"
						];


					}else{
						//$eliminaras=mainModel::ejecutar_consulta_simple("DELETE FROM roles WHERE codigoroles='$codigo'");
						//$eliminarasdetalles=mainModel::ejecutar_consulta_simple("DELETE FROM privilegios WHERE codigoroles='$codigo'");
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No se ha podido guardar el rol, porfavor intente nuevamente",
							"Tipo"=>"error"
						];	
					}






					}else{
						//$detalled_roles=mainModel::limpiar_cadena($_POST['detemrg']);
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"El rol de administrador se ha actualizado con éxito",
							"Tipo"=>"success"
						];
					}



				
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No se ha podido actualizar el rol, porfavor intente nuevamente",
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