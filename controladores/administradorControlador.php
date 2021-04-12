<?php 
	if ($peticionAjax) {
		require_once "../modelos/administradorModelo.php";
		require_once "../funcs/funcs.php";
		require_once '../PHPMailer/PHPMailerAutoload.php';
	}else{
		require_once "./modelos/administradorModelo.php";
		require_once "./funcs/funcs.php";
		require_once './PHPMailer/PHPMailerAutoload.php';
	}  

	class administradorControlador extends administradorModelo{

		//Controlador para agregar administrador
		public function agregar_administrador_controlador($Imagen){

			if (!empty($_POST['estado-reg']) && !empty($_POST['roles-reg']) && !empty($_POST['pers-reg']) && !empty($_POST['usuario-reg']) && !empty($_POST['clave-reg']) && !empty($_POST['clave1-reg'])) {

				$DireccionImg='../cuenta/';
				$ArchivoImg=$Imagen['foto-reg']['name'];
				$EstencionImg = strtolower(pathinfo($ArchivoImg,PATHINFO_EXTENSION));
				$final = rand(1000,1000000).".".$EstencionImg;

				$estado=mainModel::limpiar_cadena($_POST['estado-reg']);
				$roles=mainModel::limpiar_cadena($_POST['roles-reg']);
				$empleado=mainModel::limpiar_cadena($_POST['pers-reg']);
				$email=mainModel::limpiar_cadena($_POST['correo-reg']);
				$usuario=mainModel::limpiar_cadena($_POST['usuario-reg']);
				$clave=trim($_POST['clave-reg']);
				$clave1=trim($_POST['clave1-reg']);
				$v=2;
				$activacion='0';
				
				if ($clave==$clave1) {

					$verificar_usuario=mainModel::ejecutar_consulta_simple("SELECT cuentausuario FROM cuenta WHERE cuentausuario='$usuario'");
					if ($verificar_usuario->rowCount()<=0) {

						$verificar_empleado=mainModel::ejecutar_consulta_simple("SELECT empleadocodigo FROM cuenta WHERE empleadocodigo='$empleado'");
						if ($verificar_empleado->rowCount()<=0) {

							$consultacod=mainModel::ejecutar_consulta_simple("SELECT cuentacodigo FROM cuenta");
							$numero=($consultacod->rowCount())+1;
							$codigo=mainModel::generar_codigo_aleatorio("ADMIN",7,$numero);

							$consulta1=mainModel::ejecutar_consulta_simple("SELECT cuentacodigo FROM cuenta WHERE cuentacodigo='$codigo'");
							if ($consulta1->rowCount()<=0) {

								$datosDepartamento=[
									"CODIGO"=>trim($codigo),
									"ESTADO"=>trim($estado),
									"ROLES"=>trim($roles),								
									"EMPLEADO"=>trim($empleado),
									"USURAIO"=>trim($usuario),
									"FOTO"=>trim($final),								
									"CLAVE"=>mainModel::encryption($clave),								
									"ACTIVACION"=>trim($activacion),
									"REQUEST"=>0,
									"TOKEN"=>0
								];
								$guardarDepartamento=administradorModelo::agregar_administrador_modelo($datosDepartamento);
								if ($guardarDepartamento->rowCount()>=1) {

									$vg=trim($usuario);
									$ll=trim($codigo);

									$url=$url=SERVERURL.'activar/?id='.mainModel::encryption($vg).'&val='.mainModel::encryption($ll);

									$asunto = 'Activar Cuenta - Administrador';
									$cuerpo = "Estimad@ $usuario: <br /><br />Para continuar con el proceso de registro, es indispensable de click en el siguiente link <a href='$url'>Activar Cuenta</a>";


									if(enviarEmail($email, $usuario, $asunto, $cuerpo)){
										move_uploaded_file($Imagen['foto-reg']['tmp_name'],$DireccionImg.$final);
										$alerta=[
											"Alerta"=>"recargar",
											"Titulo"=>"Felicitaciones!",
											"Texto"=>"El administrador se ha registrado con éxito",
											"Tipo"=>"success"
										];

									}else{
										clienteModelo::eliminar_cliente($codigo);
										mainModel::eliminar_cuenta($codigo);
										$alerta=[
											"Alerta"=>"limpiar",
											"Titulo"=>"Ocurrio un error inesperado",
											"Texto"=>"No hemos podido enviar su link de activación, porfavor intente registrarse más tarde o pongase en contacto con el administrador",
											"Tipo"=>"error"
										];
									}

								}else{
									$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Ocurrio un error inesperado",
										"Texto"=>"No hemos podido registrar el usuario, porfavor intente nuevamente",
										"Tipo"=>"error"
									];	
								}

							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"El código que se generó para el administrador ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
									"Tipo"=>"error"
								];
							}
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"El empleado ya tiene una cuenta registrada en el sistema",
								"Tipo"=>"error"
							];	
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"El nombre del usuario que acaba de ingresar ya se encuentra en el sistema, por favor intente nuevamente",
							"Tipo"=>"error"
						];	
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Las contraseñas no coinnciden, por favor verifiquelas e intente nuevamente",
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
		public function listar_administrador_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";
			
			//Consulta para mostrar en lista todos los administradore registrados en el sistema.
			//Para la busqueda se utilizo una tabla dinamica de la plantilla Gentellas Master.
			$consulta="SELECT *,T1.cuentacodigo FROM cuenta as T1, estado_cuenta as T2, empleados as T3, roles as T4 WHERE T1.estadocuentacodigo=T2.estadocuentacodigo AND T1.empleadocodigo=T3.empleadocodigo AND T1.codigoroles=T4.codigoroles ORDER BY empleadonombres";

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th><center>#</center></th>
							<th><center>CEDULA</center></th>
							<th><center>NOMBRES</center></th>
							<th><center>USUARIO</center></th>
							<th><center>ROL</center></th>
							<th><center>ESTADO</center></th>
							
							
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
							<td><center>'.$rows['empleadocedula'].'</center></td>
							<td><center>'.$rows['empleadoapellidos']." ".$rows['empleadonombres'].'</center></td>
							<td><center>'.$rows['cuentausuario'].'</center></td>
							<td><center>'.$rows['rolesnombre'].'</center></td>
							<td><center>'.$rows['estadocuentanombre'].'</center></td>
							
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td><center>
							
								

								<form method="POST" action="'.SERVERURL.'administradorinfo/">
								<input type="hidden" value="'.trim($rows['cuentacodigo']).'" name="codigo">
								<button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-primary"> Editar</button>
								</form>
                                              
							</center></td>

						
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



		public function datos_administrador_controlador($tipo,$codigo){
			$codigo=mainModel::limpiar_cadena($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return administradorModelo::datos_administrador_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_administrador_controlador($Imagen){
			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['estado-up']) && !empty($_POST['roles-up']) && !empty($_POST['usuario-up']) && !empty($_POST['clave-up']) && !empty($_POST['clave1-up'])) {
				$cuenta=mainModel::limpiar_cadena($_POST['codigo']);

				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);

				$estado=mainModel::limpiar_cadena($_POST['estado-up']);
				$roles=mainModel::limpiar_cadena($_POST['roles-up']);
				$usuario=mainModel::limpiar_cadena($_POST['usuario-up']);
				$clave=trim($_POST['clave-up']);
				$clave1=trim($_POST['clave1-up']);


				$buscar=mainModel::ejecutar_consulta_simple("SELECT cuentafoto FROM cuenta WHERE cuentacodigo='$cuenta'");
				$DatosLogo=$buscar->fetch();

				$ArchivoImg = $_FILES['foto-up']['name'];

				if ($ArchivoImg) {
					$DireccionImg='../cuenta/';
					unlink($DireccionImg.$DatosLogo['cuentafoto']);
					$EstencionImg = strtolower(pathinfo($ArchivoImg,PATHINFO_EXTENSION));
					$final = rand(1000,1000000).".".$EstencionImg;
					move_uploaded_file($Imagen['foto-up']['tmp_name'],$DireccionImg.$final);
				}else{
					$final=$DatosLogo['cuentafoto'];
				}

				$imagen=mainModel::limpiar_cadena($final);


				if ($clave==$clave1) {

					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE cuentacodigo='$cuenta'");
					$DatosAdmin=$query1->fetch();

					if ($dni!=$DatosAdmin['cuentacodigo']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT cuentacodigo FROM cuenta WHERE cuentacodigo='$dni'");
						if ($consulta1->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El código que acaba de ingresar ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					if ($usuario!=$DatosAdmin['cuentausuario']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT cuentausuario FROM cuenta WHERE cuentausuario='$usuario'");
						if ($consulta1->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El nombre del usuario que acaba de ingresar ya se encuentra en el sistema, por favor intente nuevamente",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}


					$dataAdmin=[
						"ESTADO"=>$estado,
						"ROLES"=>$roles,
						"USUARIO"=>$usuario,
						"FOTO"=>$imagen,
						"CLAVE"=>mainModel::encryption($clave),
						"CODIGO"=>$cuenta
					];
					$editarAdmin=administradorModelo::actualizar_administrador_modelo($dataAdmin);
					if ($editarAdmin->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"El administrador se ha actualizado con éxito",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Para actualizar el administrador es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Las contraseñas no coinnciden, por favor verifiquelas e intente nuevamente",
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




















































		//Enviar Email contraseña cliente
		public function enviar_email_controlador(){

			$email=mainModel::limpiar_cadena($_POST['usuario-rec']);

			$VerificarE=[
				"EMAIL"=>$email,
			];
			$EVerificar=administradorModelo::verificar_email_modelo($VerificarE);
			if ($EVerificar->rowCount()==0) {
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El Correo $email que acaba de ingresar no se encuentra registrado en el sistema, porfavor intente nuevamente.",
					"Tipo"=>"error"
				];	
				return mainModel::sweet_alert($alerta);
			}else{
				/*#Rrecuperar*/
				$Rrecuperar=mainModel::ejecutar_consulta_simple("SELECT *,T1.empleadocorreo FROM empleados as T1, estado_empleado as T2, cuenta as T3, estado_cuenta as T4 WHERE T1.estadoempleadocodigo=T2.estadoempleadocodigo AND T2.estadoempleadonombre='ACTIVO' AND T1.empleadocodigo=T3.empleadocodigo AND T3.estadocuentacodigo=T4.estadocuentacodigo AND T4.estadocuentanombre='ACTIVO' AND T1.empleadocorreo='$email'");
				if ($Rrecuperar->rowCount()==0) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No hemos 1 podido enviar el Correo de recuperación de contraseña por problemas técnicos, porfavor intente nuevamente.",
						"Tipo"=>"error"
					];	
					return mainModel::sweet_alert($alerta);
				}else{
					$DatosRecuperar=$Rrecuperar->fetch();
					$user_id=$DatosRecuperar['cuentacodigo'];
					$nombre=$DatosRecuperar['cuentausuario'];
					$nombre1=mainModel::encryption($DatosRecuperar['cuentausuario']);
					$request=1;
					$token=mainModel::generateToken($user_id);


					/*$CambiarR=[
						"Token"=>$token,
						"Request"=>$request,

						"Email"=>$email,
					];
					$Rcambiar=clienteModelo::recuperar_recuperar_modelo($CambiarR);*/
					/*$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Se econtro el email $nombre",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);*/


					$Rcambiar=mainModel::ejecutar_consulta_simple("UPDATE cuenta SET cuentatoken='$token', cuentarequest=1 WHERE cuentacodigo='$user_id'");
					if ($Rcambiar->rowCount()==0) {
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No hemos 2 podido enviar el Correo de recuperación de contraseña por problemas técnicos, porfavor intente nuevamente.",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
					}else{
						
						$url=SERVERURL.'cambiar/?val='.$token.'&val1='.$nombre1;
						

						//$url = 'http://'.$_SERVER["SERVER_NAME"].'/GADMH/cambiar/?val='.$token.'&val1='.$nombre1;
          
          				$asunto = 'Recuperar Password - Administrador';
    					$cuerpo = "Hola $nombre: <br /><br />Se ha solicitado un reinicio de contrase&ntilde;a. <br /><br /> Para restaurar la contrase&ntilde;a, visita la siguiente direcci&oacute;n: <a href='$url'>Cambiar</a>";
          
						if(enviarEmail($email, $nombre, $asunto, $cuerpo)){

						    $alerta=[
								"Alerta"=>"limpiar",
								"Titulo"=>"Correo de recuperación enviado",
								//"Texto"=>"El CLIENTE se registro con exito en el sistema",
								//"Texto"=>"Para terminar el proceso de registro siga las instrucciones que le hemos enviado la direccion de correo electronico: $email.",
								"Texto"=>"Siga las instrucciones que le hemos enviado a la dirección de su correo electrónico.",
								"Tipo"=>"success"
							];
							return mainModel::sweet_alert($alerta);

				           //echo"<script>alert('Para terminar el proceso de registro siga las instrucciones que le hemos enviado a la dirección de su correo electrónico: $email'); window.location='https://accounts.google.com/signin/v2/identifier?service=mail&passive=true&rm=false&continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&ss=1&scc=1&ltmpl=default&ltmplcache=2&emr=1&osid=1&flowName=GlifWebSignIn&flowEntry=ServiceLogin';</script>";

				            /*echo "Para terminar el proceso de registro siga las instrucciones que le hemos enviado la direccion de correo electronico: $email";
				          echo "<br><a href='index.php' >Iniciar Sesion</a>";*/

						          
						}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No hemos podido enviar el Correo de recuperación de contraseña por problemas técnicos, porfavor intente nuevamente.",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
					}



					}

				}
			}

		}

		//Cambiar Contraseña cliente
		public function recuperar_contrasenia_controlador(){
			$cc1=mainModel::limpiar_cadena($_POST['contraseña-rec']);
			$conpas=mainModel::encryption($cc1);

			$cc2=mainModel::limpiar_cadena($_POST['ccontraseña-rec']);

			$vc1=mainModel::limpiar_cadena($_POST['val-rec']);

			$va2=mainModel::limpiar_cadena($_POST['val1-rec']);
			$vc2=mainModel::decryption($va2);

			/*$BuscarCambiar=[
				"Token"=>$vc1,
				"Usuario"=>$vc2,
			];

			$a="HOLA";*/

			$CambiarBuscar=mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE cuentausuario='$vc2' AND cuentatoken='$vc1'");
			if ($CambiarBuscar->rowCount()==0) {
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					/*"Texto"=>"No se pudo verificar sus datos intente nuevamente.",*/ //WIN 7
					"Texto"=>"Su contraseña ya fue modificada, de no ser asi intente nuevamente ingresando al link con el cual llego aqui.",
					"Tipo"=>"error"
				];	
				return mainModel::sweet_alert($alerta);
			}else{

			if (!mainModel::validaPassword($cc1, $cc2)) {
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Las contraseñas no coinciden",
					"Texto"=>"Por favor intente nuevamente.",
					"Tipo"=>"error"
				];	
				return mainModel::sweet_alert($alerta);
			}else{
				$BC=mainModel::ejecutar_consulta_simple("SELECT cuentacodigo FROM cuenta WHERE cuentausuario='$vc2' AND cuentatoken='$vc1'");
				$asignar=$BC->fetch();
				$compas=$asignar['cuentacodigo'];
				$CambiarCambiar=mainModel::ejecutar_consulta_simple("UPDATE cuenta SET cuentatoken='', cuentarequest=0, cuentaclave='$conpas' WHERE cuentacodigo='$compas'");
				if ($CambiarCambiar->rowCount()==1) {
					$alerta=[
						"Alerta"=>"cambiar",
						"Titulo"=>"¡Felicitaciones!",
						"Texto"=>"Su contraseña fue restablecida.",							
						"Tipo"=>"success"
					];
					return mainModel::sweet_alert($alerta);
				}else{
					$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Lo sentimos no se ha podido restablecer su contraseña, por favor intente nuevamente o pongase en contacto con el administrador.",
					"Tipo"=>"error"
				];	
				return mainModel::sweet_alert($alerta);
				}
				/*$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Igual.",
					"Tipo"=>"error"
				];	
				return mainModel::sweet_alert($alerta);*/
			}

			}
		}
	}