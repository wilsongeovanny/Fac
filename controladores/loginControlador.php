<?php
//require_once "../Administrador/modelos/loginModelo.php";
if ($peticionAjax) {
	require_once "../modelos/loginModelo.php";
}else{
	require_once "./modelos/loginModelo.php";
}  

class loginControlador extends loginModelo{
	public function iniciar_sesion_controlador(){
		$usuario=mainModel::limpiar_cadena($_POST['usuario']);
		$clave=trim($_POST['clave']);

		//$clave=mainModel::encryption($clave0);


		$VerificarE=[
			"USUARIO"=>$usuario,
		];

		$EVerificar=loginModelo::verificar_email_modelo($VerificarE);

		if ($EVerificar->rowCount()==0) {
			$alerta=[
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El Usuario que acaba de ingresar no se encuentra registrado en el sistema, por favor intente nuevamente.",
				"Tipo"=>"error"
			];	

			return mainModel::sweet_alert($alerta);
			exit();
		}else{

			/*$VerificarC=[
				"CLAVE"=>$clave,
			];

			$CVerificar=loginModelo::verificar_clave_modelo($VerificarC);

			if ($CVerificar->rowCount()==0) {
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La CONTRASEÑAS que acaba de ingresar no es correcta, porfavor intente nuevamente.",
					"Tipo"=>"error"
				];	

				return mainModel::sweet_alert($alerta);
				exit();
			} else{*/







				$datosLogin=[
					"USUARIO"=>$usuario,
					"CLAVE"=>mainModel::encryption($clave)
				];


				$datosCuenta=loginModelo::iniciar_sesion_modelo($datosLogin);

				if ($datosCuenta->rowCount()==1) {
					$row=$datosCuenta->fetch();
					$cuenta_codigo=$row['cuentacodigo'];

					$verificar_cuenta=mainModel::ejecutar_consulta_simple("SELECT *,T1.cuentacodigo FROM cuenta as T1, estado_cuenta as T2 WHERE T1.cuentacodigo='$cuenta_codigo' AND T1.estadocuentacodigo=T2.estadocuentacodigo AND T2.estadocuentanombre='ACTIVO'");
					
					if ($verificar_cuenta->rowCount()==1) {
						$cu_usu=$verificar_cuenta->fetch();
						$codigo_final=$cu_usu['cuentacodigo'];
						$activacion=$cu_usu['cuentaactivacion'];

						if ($activacion==1) {
						
						
							$row=$datosCuenta->fetch();
							$fechaActual=date("Y-m-d");
							$yearActual=date("Y");
							$horaActual=date("h:i:s");

							$consulta1=mainModel::ejecutar_consulta_simple("SELECT bitacoracodigo FROM bitacora");
							$numero=($consulta1->rowCount())+1;

							$codigoB=mainModel::generar_codigo_aleatorio("CB",7,$numero);

							$datosBitacora=[
								"CODIGO"=>$codigoB,
								"CUENTA"=>$codigo_final,
								"FECHA"=>$fechaActual,
								"INICIO"=>$horaActual,
								"FINAL"=>"Sin registro",
								"TIPO"=>"ADMINISTRADOR",
								"YEAR"=>$yearActual
							];

							$insertarBitacora=mainModel::guardar_bitacora($datosBitacora);

							if ($insertarBitacora->rowCount()>=1) {

								$query1=mainModel::ejecutar_consulta_simple("SELECT *,T1.cuentacodigo FROM cuenta as T1, estado_cuenta as T2, roles as T3, empleados as T4 WHERE T1.cuentacodigo='$codigo_final' AND T1.estadocuentacodigo=T2.estadocuentacodigo AND T1.codigoroles=T3.codigoroles AND T1.empleadocodigo=T4.empleadocodigo");


								if ($query1->rowCount()==1) {

									$UserData=$query1->fetch();



									//session_start(['name'=>'SBP']);

									$_SESSION['codigo_gad']=$UserData['cuentacodigo'];
									$_SESSION['estado_gad']=$UserData['estadocuentanombre'];
									$_SESSION['rol_gad']=$UserData['codigoroles'];
									$_SESSION['empleado_gad']=$UserData['empleadocodigo'];
									$_SESSION['usuario_gad']=$UserData['cuentausuario'];
									$_SESSION['foto']=$UserData['cuentafoto'];
									$_SESSION['token_gad']=md5(uniqid(mt_rand(),true));
									$_SESSION['codigo_bitacora_gad']=$codigoB;

									$url=SERVERURL."home/";


									return $urlLocation='<script> window.location="'.$url.'" </script>';






								}else{
									$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Ocurrio un error inesperado",
										"Texto"=>"No hemos podido iniciar la sesión por problemas técnicos, por favor intente nuevamente",
										"Tipo"=>"error"
									];
									return mainModel::sweet_alert($alerta);	
									exit();	
								}


							}else{
									$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Ocurrio un error inesperado",
										"Texto"=>"No hemos podido iniciar la sesión por problemas técnicos, por favor intente nuevamente",
										"Tipo"=>"error"
									];
									return mainModel::sweet_alert($alerta);	
									exit();	
								}






						}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"Su cuenta aún no ha sido activada, por favor actívela ingresando al link que se le ha enviado a su correo",
									"Tipo"=>"error"
								];
								return mainModel::sweet_alert($alerta);	
								exit();	
							}


						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"Su cuenta se encuentra desactivada, de creer que hay algún error por favor contáctese con uno de los administradores.",
								"Tipo"=>"error"
							];	

							return mainModel::sweet_alert($alerta);
							exit();
						} 






				}else{
						/*$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"Su CUENTA en PurChase fue deshabilitada, para abilitarla de nuevo pongase en contacto con el administrador",
							"Tipo"=>"error"
						];*/ //WIN 7
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Su contraseña es incorrecta, para recuperarla de clic en Recupérala aquí que se encuentra bajo el botón de Ingresar al Sistema.",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
					}


				//} VERIFICAR CONTRASEÑA


				}


			}

		/*public function cerrar_sesion_controlador(){
			session_start(['name'=>'SBP']);
			
			return loginModelo::cerrar_sesion_modelo($datos);
		}*/

		public function cerrar_sesion_controlador(){
			session_start(['name'=>'SBP']);
			$token=trim($_GET['Token']);
			$hora=date("h:i:s");
			$datos=[
				"Usuario"=>$_SESSION['usuario_gad'],
				"Token_S"=>$_SESSION['token_gad'],
				"Token"=>$token,
				"Codigo"=>$_SESSION['codigo_bitacora_gad'],
				"Hora"=>$hora
			];
			return loginModelo::cerrar_sesion_modelo($datos);
		}
		
		public function forzar__cierre_sesion_controlador(){
			//session_start(['name'=>'SBP']); //NO IBA  /* DESDE EL 73
			session_unset();
			session_destroy();
			$redirect='<script> window.location.href="'.SERVERURL.'login/" </script>';
			return $redirect;
		}

		/*public function redireccionar_usuario_controlador($tipo){
			if ($tipo=="Cliente") {
				$redirect='<script> window.location.href="'.SERVERURL.'catalogo/" </script>';
			}else if($tipo=="Usuario"){
				$redirect='<script> window.location.href="'.SERVERURL.'preguntas/" </script>';
			}
			return $redirect;
		}*/
	}	