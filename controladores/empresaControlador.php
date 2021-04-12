<?php 
	if ($peticionAjax) {
		require_once "../modelos/empresaModelo.php";
	}else{
		require_once "./modelos/empresaModelo.php";
	}  

	class empresaControlador extends empresaModelo{

		public function agregar_empresa_controlador($Imagen){


			if (!empty($_POST['ruc-reg']) && !empty($_POST['nombre-reg']) && !empty($_POST['telefono-reg']) && !empty($_POST['correo-reg']) && !empty($_POST['direccion-reg'])) {

				$DireccionImg='../imagenes/';
				$ArchivoImg=$Imagen['foto-reg']['name'];
				$EstencionImg = strtolower(pathinfo($ArchivoImg,PATHINFO_EXTENSION));
				$final = rand(1000,1000000).".".$EstencionImg;

				$ruc=mainModel::limpiar_cadena($_POST['ruc-reg']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
				$telefono=mainModel::limpiar_cadena($_POST['telefono-reg']);
				$correo=mainModel::limpiar_cadena($_POST['correo-reg']);
				$direccion=mainModel::limpiar_cadena($_POST['direccion-reg']);
				$imagen=mainModel::limpiar_cadena($final);

				$consultacod=mainModel::ejecutar_consulta_simple("SELECT empresacodigo FROM empresa");
				$numero=($consultacod->rowCount())+1;
				$codigo=mainModel::generar_codigo_aleatorio("EMPRESA",7,$numero);
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT empresacodigo FROM empresa WHERE empresacodigo='$codigo'");
				if ($consulta1->rowCount()<=0) {

					$consultaruc=mainModel::ejecutar_consulta_simple("SELECT empresaruc FROM empresa WHERE empresaruc='$ruc'");
					if ($consultaruc->rowCount()<=0) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT empresanombre FROM empresa WHERE empresanombre='$nombre'");
						if ($consulta2->rowCount()<=0) {
							$datosEmpresa=[
								"CODIGO"=>$codigo,
								"RUC"=>$ruc,
								"NOMBRE"=>$nombre,
								"TELEFONO"=>$telefono,
								"CORREO"=>$correo,
								"DIRECCION"=>$direccion,
								"LOGO"=>$imagen
							];
							$guardarEmpresa=empresaModelo::agregar_empresa_modelo($datosEmpresa);
							if ($guardarEmpresa->rowCount()>=1) {
								move_uploaded_file($Imagen['foto-reg']['tmp_name'],$DireccionImg.$final);
								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Empresa registrada",
									"Texto"=>"La empresa se ha registrado con éxito",
									"Tipo"=>"success"
								];
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"No se guardaron los datos de la empresa, porfavor intente nuevamente",
									"Tipo"=>"error"
								];	
							}
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"El nombre de la empresa que acaba de ingresar ya se encuentra en el sistema, por favor intente nuevamente",
								"Tipo"=>"error"
							];	
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El ruc de la empresa que acaba de ingresar ya se encuentra registrado en el sistema, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}
				}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El código que se generó para la empresa ya se encuentra en el sistema, por favor intente nuevamente recargando la página",
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

		public function datos_empresa_controlador($tipo,$codigo){
			$codigo=mainModel::limpiar_cadena($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return empresaModelo::datos_empresa_modelo($tipo,$codigo);
		}

		//Controlador para gaginar administradores
		public function listar_empresa_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			//Búsqueda de la empresa requerida a través de una tabla dinamica
			//Para ello se necesita realizar una consulta de todas las empresaa



			$datos=mainModel::ejecutar_consulta_simple("SELECT * FROM empresa");
			$datos=$datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>#</th>
							<th>RUC</th>
							<th>NOMBRE</th>
							<th>TELEFONO</th>
							<th>CORREO</th>
							<th>DIRECCION</th>
							
			';
						//if ($privilegio<=2) {
							$tabla.='
							<th>ACCION</th>
							
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
							<td>'.$rows['empresaruc'].'</td>
							<td>'.$rows['empresanombre'].'</td>
							<td>'.$rows['empresatelefono'].'</td>
							<td>'.$rows['empresacorreo'].'</td>
							<td>'.$rows['empresadireccion'].'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
								
								<form method="POST" action="'.SERVERURL.'municipioinfo/">
								<input type="hidden" value="'.$rows['empresacodigo'].'" name="codigo">
								<button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-primary"><i class="fa fa-edit" onclick="editbtnmenu"></i> Editar</button>
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

		/*public function eliminar_empresa_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-del']);
			$adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

			if ($adminPrivilegio==1) {
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT EmpresaCodigo FROM libro WHERE EmpresaCodigo='$codigo'");

				if ($consulta1->rowCount()<=0) {
					$DelEmpresa=empresaModelo::eliminar_empresa_modelo($codigo);

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

		//Controlador actualizar la entidad
		public function actualizar_empresa_controlador($Imagen){
			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['ruc-up']) && !empty($_POST['nombre-up']) && !empty($_POST['telefono-up']) && !empty($_POST['correo-up']) && !empty($_POST['direccion-up'])) {

				$cuenta=mainModel::limpiar_cadena($_POST['codigo']);

				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
				$ruc=mainModel::limpiar_cadena($_POST['ruc-up']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);
				$telefono=mainModel::limpiar_cadena($_POST['telefono-up']);
				$correo=mainModel::limpiar_cadena($_POST['correo-up']);
				$direccion=mainModel::limpiar_cadena($_POST['direccion-up']);

				$buscar=mainModel::ejecutar_consulta_simple("SELECT empresalogo FROM empresa WHERE empresacodigo='$cuenta'");
				$DatosLogo=$buscar->fetch();
				
				$ArchivoImg = $_FILES['foto-up']['name'];

				if ($ArchivoImg) {
					$DireccionImg='../imagenes/';
					unlink($DireccionImg.$DatosLogo['empresalogo']);
					$EstencionImg = strtolower(pathinfo($ArchivoImg,PATHINFO_EXTENSION));
					$final = rand(1000,1000000).".".$EstencionImg;
					move_uploaded_file($Imagen['foto-up']['tmp_name'],$DireccionImg.$final);
				}else{
					$final=$DatosLogo['empresalogo'];
				}

				$imagen=mainModel::limpiar_cadena($final);


				$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM empresa WHERE empresacodigo='$cuenta'");
				$DatosEmpresa=$query1->fetch();

				if ($dni!=$DatosEmpresa['empresacodigo']) {
					$consulta1=mainModel::ejecutar_consulta_simple("SELECT empresacodigo FROM empresa WHERE empresacodigo='$dni'");
					if ($consulta1->rowCount()>=2) {
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El código que se genero para la empresa ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
					}
				}

				if ($ruc!=$DatosEmpresa['empresaruc']) {
					$consulta1=mainModel::ejecutar_consulta_simple("SELECT empresaruc FROM empresa WHERE empresaruc='$ruc'");
					if ($consulta1->rowCount()>=2) {
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El ruc que acaba de ingresar ya se encuentra en el sistema, porfavor intente nuevamente",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
					}
				}

				if ($nombre!=$DatosEmpresa['empresanombre']) {
					$consulta3=mainModel::ejecutar_consulta_simple("SELECT empresanombre FROM empresa WHERE empresanombre='$nombre'");
					if ($consulta3->rowCount()>=2) {
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El nombre de la empresa que acaba de ingresar ya se encuentra en el sistema, porfavor intente nuevamente",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
					}
				}





				$dataEmpresa=[
					"RUC"=>$ruc,
					"NOMBRE"=>$nombre,
					"TELEFONO"=>$telefono,
					"CORREO"=>$correo,
					"DIRECCION"=>$direccion,
					"LOGO"=>$imagen,
					"CODIGO"=>$cuenta
				];

				$editarEmpresa=empresaModelo::actualizar_empresa_modelo($dataEmpresa);
				if ($editarEmpresa->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Felicitaciones!",
						"Texto"=>"Los datos de la empresa se han actualizado con éxito",
						"Tipo"=>"success"
						];
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Para actualizar los datos de la empresa es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
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