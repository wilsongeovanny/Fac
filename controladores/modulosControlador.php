<?php 
	if ($peticionAjax) {
		require_once "../modelos/modulosModelo.php";
	}else{
		require_once "./modelos/modulosModelo.php";
	}  

	class modulosControlador extends modulosModelo{

		//Controlador para agregar administrador
		public function agregar_modulos_controlador(){
			//$codigo=mainModel::limpiar_cadena($_POST['codigo-reg']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
			
			$consultacod=mainModel::ejecutar_consulta_simple("SELECT modulocodigo FROM modulo");
			$numero=($consultacod->rowCount())+1;
			$codigo=mainModel::generar_codigo_aleatorio("MOD",7,$numero);

			$consulta1=mainModel::ejecutar_consulta_simple("SELECT modulocodigo FROM modulo WHERE modulocodigo='$codigo'");
			if ($consulta1->rowCount()<=0) {
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT modulonombre FROM modulo WHERE modulonombre='$nombre'");
				if ($consulta2->rowCount()<=0) {


					

					$datosModulo=[
						"CODIGO"=>$codigo,
						"NOMBRE"=>$nombre
					];
					$guardarModulo=modulosModelo::agregar_modulos_modelo($datosModulo);
					if ($guardarModulo->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"El módulo del sistema se registrado con éxito",
							"Tipo"=>"success"
						];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No se ha podido registrar del módulo del sistema, porfavor intente nuevamente",
							"Tipo"=>"error"
						];	
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El módulo ya se encuentra registrado en el sistema, por favor intente nuevamente",
						"Tipo"=>"error"
					];	
				}
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El código que se asigno al módulo ya se encuentra registrado en el sistema, por favor intente nuevamente recargando la página",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}


		public function datos_modulos_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return modulosModelo::datos_modulos_modelo($tipo,$codigo);
		}

		//Controlador para gaginar administradores
		public function listar_modulos_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			$consulta="SELECT * FROM modulo" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
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
							/*$tabla.='
							<th>ACCIONES</th>
							
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
							<td><center>'.$rows['modulonombre'].'</center></td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							'./*<td>
							
								<a href="'.SERVERURL.'modulosinfo/'.mainModel::encryption($rows['modulocodigo']).'/" class="btn btn-primary">
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

		//Controlador actualizar el nombre del menú
		public function actualizar_modulos_controlador(){
			$cuenta=mainModel::decryption($_POST['codigo']);

			$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
			$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);


			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM modulo WHERE modulocodigo='$cuenta'");
			$DatosModulo=$query1->fetch();

			if ($dni!=$DatosModulo['modulocodigo']) {
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT modulocodigo FROM modulo WHERE modulocodigo='$dni'");
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

			if ($nombre!=$DatosModulo['modulonombre']) {
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT modulonombre FROM modulo WHERE modulonombre='$nombre'");
				if ($consulta2->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El nombre del modulo ya se encuentra registrado en el sistema, porfavor intente nuevamnete",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}

			$dataModulo=[
				"NOMBRE"=>$nombre,
				"CODIGO"=>$cuenta,
			];
			$editarModulo=modulosModelo::actualizar_modulos_modelo($dataModulo);
			if ($editarModulo->rowCount()>=1) {
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Datos actualizados",
					"Texto"=>"El nombre del modulo se ha actualizado con exito",
					"Tipo"=>"success"
					];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos pordido actualizar el nombre del modulo, porfavor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}
	}