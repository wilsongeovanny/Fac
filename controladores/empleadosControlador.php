<?php 
	if ($peticionAjax) {
		require_once "../modelos/empleadosModelo.php";
	}else{
		require_once "./modelos/empleadosModelo.php";
	}  

	class empleadosControlador extends empleadosModelo{

		//Controlador para agregar administrador
		public function agregar_empleados_controlador(){
			if (!empty($_POST['cedula-reg']) && !empty($_POST['nombres-reg']) && !empty($_POST['apellidos-reg']) && !empty($_POST['telefono-reg']) && !empty($_POST['celular-reg']) && !empty($_POST['correo-reg']) && !empty($_POST['fecha-reg']) && !empty($_POST['emp-reg']) && !empty($_POST['dep-reg']) && !empty($_POST['car-reg']) && !empty($_POST['estado-reg'])) {

				$cedula=mainModel::limpiar_cadena($_POST['cedula-reg']);
				$nombres=mainModel::limpiar_cadena($_POST['nombres-reg']);
				$apellidos=mainModel::limpiar_cadena($_POST['apellidos-reg']);
				$telefono=mainModel::limpiar_cadena($_POST['telefono-reg']);
				$celular=mainModel::limpiar_cadena($_POST['celular-reg']);
				$correo=mainModel::limpiar_cadena($_POST['correo-reg']);
				$fecha=mainModel::limpiar_cadena($_POST['fecha-reg']);
				$entidad=mainModel::limpiar_cadena($_POST['emp-reg']);
				$departamento=mainModel::limpiar_cadena($_POST['dep-reg']);
				$cargo=mainModel::limpiar_cadena($_POST['car-reg']);
				$estado=mainModel::limpiar_cadena($_POST['estado-reg']);
				
				$verdep=mainModel::ejecutar_consulta_simple("SELECT * FROM cargo WHERE cargocodigo='$cargo'");
				if ($verdep->rowCount()>=1) {

					$verdep1=mainModel::ejecutar_consulta_simple("SELECT * FROM estado_empleado WHERE estadoempleadocodigo='$estado'");
					if ($verdep1->rowCount()>=1) {

						$consultacod=mainModel::ejecutar_consulta_simple("SELECT empleadocodigo FROM empleados");
						$numero=($consultacod->rowCount())+1;
						$codigo=mainModel::generar_codigo_aleatorio("EMPADO",7,$numero);
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT empleadocodigo FROM empleados WHERE empleadocodigo='$codigo'");
						
						if ($consulta1->rowCount()<=0) {

							$consulta=mainModel::ejecutar_consulta_simple("SELECT empleadocedula FROM empleados WHERE empleadocedula='$cedula'");
							if ($consulta->rowCount()<=0) {

								$consulta1=mainModel::ejecutar_consulta_simple("SELECT empleadocorreo FROM empleados WHERE empleadocorreo='$correo'");
								if ($consulta1->rowCount()<=0) {
								


									

									$datosDepartamento=[
										"CODIGO"=>$codigo,
										"CEDULA"=>$cedula,
										"CARGO"=>$cargo,
										"ESTADO"=>$estado,
										"NOMBRES"=>$nombres,
										"APELLIDOS"=>$apellidos,
										"TELEFONO"=>$telefono,
										"CELULAR"=>$celular,
										"CORREO"=>$correo,
										"FECHA"=>$fecha
									];
									$guardarDepartamento=empleadosModelo::agregar_empleados_modelo($datosDepartamento);
									if ($guardarDepartamento->rowCount()>=1) {
										$alerta=[
											"Alerta"=>"recargar",
											"Titulo"=>"Felicitaciones!",
											"Texto"=>"El empleado se ha registrado con éxito",
											"Tipo"=>"success"
										];
									}else{
										$alerta=[
											"Alerta"=>"simple",
											"Titulo"=>"Ocurrio un error inesperado",
											"Texto"=>"No se ha podido registar el empleado, porfavor intente nuevamnete",
											"Tipo"=>"error"
										];	
									}
									}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"El correo del empleado que acaba de ingresar ya se encuentra en el sistema",
									"Tipo"=>"error"
								];
							}
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"El cédula del empleado que acaba de ingresar ya se encuentra en el sistema",
									"Tipo"=>"error"
								];
							}

						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"El código que se genero para el empleado ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
						}

					}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"Primero debe ingresar los estados del empleado que vienen por defecto en el sistema, si los problemas persisten contactese con el desarrollador del sistema",
						"Tipo"=>"error"
					];
					}

				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El cargo que usted ha elejido para el empleado no se encuentra registrado en el sistema, porfavor intente nuevamente recargando la página",
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
		public function listar_adminpag_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";



			$consulta="SELECT *,T3.empleadocodigo FROM cargo as T1, estado_empleado as T2, empleados as T3, departemento as T4 WHERE T1.cargocodigo=T3.cargocodigo AND T2.estadoempleadocodigo=T3.estadoempleadocodigo AND T4.departamentocodigo=T1.departamentocodigo";

			
			$conexion = mainModel::conectar();
			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>CÉDULA</th>
							<th>APELLIDOS</th>
							<th>NOMBRES</th>
							<th>CARGO</th>
							
			';
						//if ($privilegio<=2) {
							$tabla.='
							<th>ACCIÓN</th>
							
							';
						//}
						//if ($privilegio==1) {
							
						//}
			$tabla.='</tr>
					</thead>
					<tbody>';

				
				$contador=1;
				foreach ($datos as $rows) {

					$cedula=$rows['empleadocedula'];
					$nombre=$rows['empleadonombres'];
					$apellido=$rows['empleadoapellidos'];
					$cargo=$rows['cargonombre'];

					$tabla.='
						<tr>
							<td id="cedula='.($rows['empleadocedula']).'">'.$cedula.'</td>
							
							<td id="nombre='.($rows['empleadocedula']).'">'.$apellido.'</td>
							<td id="apellido='.($rows['empleadocedula']).'">'.$nombre.'</td>
							<td id="departemento='.($rows['empleadocedula']).'">'.$cargo.'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							<a style="display: block; margin-left: auto; margin-right: auto; color: #ffffff;" class="btn btn-primary" class="btn btn-primary" value="'.$rows['empleadocedula'].'" onclick="aminpag('.$rows['empleadocedula'].')"> Agregar
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
					$contador++;
				//}
			

			$tabla.='
					</tbody>
				';
			//Fin Tabla__________________________________________________________________

			

			return $tabla;
		}


		//Controlador para gaginar administradores
		public function listar_empleados_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM departemento" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cargo ORDER BY cargonombre";
			

			$consulta="SELECT *,T3.empleadocodigo FROM cargo as T1, estado_empleado as T2, empleados as T3, departemento as T4 WHERE T1.cargocodigo=T3.cargocodigo AND T2.estadoempleadocodigo=T3.estadoempleadocodigo AND T4.departamentocodigo=T1.departamentocodigo ORDER BY empleadonombres";

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>#</th>
							<th>CÉDULA</th>
							<th>NOMBRES</th>
							<th>APELLIDOS</th>
							<th>TÉLEFONO</th>
							<th>CELULAR</th>
							<th>CORREO</th>
							<th>DEPARTAMENTO</th>
							<th>CARGO</th>
							<th>ESTADO</th>
							<th>FECHA</th>
							
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
					$a=$rows['empleadocodigo'];
					$tabla.='
						<tr>
							<td>'.$contador.'</td>
							<td>'.$rows['empleadocedula'].'</td>
							
							<td>'.$rows['empleadonombres'].'</td>
							<td>'.$rows['empleadoapellidos'].'</td>
							<td>'.$rows['empleadotelefono'].'</td>
							<td>'.$rows['empleadocelular'].'</td>
							<td>'.$rows['empleadocorreo'].'</td>
							
							<td>'.$rows['departamentonombre'].'</td>
							<td>'.$rows['cargonombre'].'</td>
							<td>'.$rows['estadoempleadonombre'].'</td>
							<td>'.$rows['empleadofecha'].'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							

								<form method="POST" action="'.SERVERURL.'empleadosinfo/">
								<input type="hidden" value="'.($a).'" name="codigo">
								<button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-primary"> Editar</button>
								</form> 

								<form method="POST" action="'.SERVERURL.'hardwareinfo/">
								<input type="hidden" value="'.($a).'" name="codigo">
								<button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-secondary"> Hardware</button>
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



				//Controlador para gaginar administradores
		public function listar_asigempleados_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM departemento" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cargo ORDER BY cargonombre";
			
			//Búsqueda del empleado requerido a través de una tabla dinamica.
			//Para ello se necesita realizar una búsqueda de todos los empleados
			//Incluido la empresa, el departamento y el cargo que ocupa.
			$consulta="SELECT *,T3.empleadocodigo FROM cargo as T1, estado_empleado as T2, empleados as T3, departemento as T4 WHERE T1.cargocodigo=T3.cargocodigo AND T2.estadoempleadocodigo=T3.estadoempleadocodigo AND T4.departamentocodigo=T1.departamentocodigo ORDER BY empleadonombres";

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>#</th>
							<th>CÉDULA</th>
							<th>APELLIDOS</th>
							<th>NOMBRES</th>
							<th>DEPARTAMENTO</th>
							<th>CARGO</th>
							
			';
						//if ($privilegio<=2) {
							$tabla.='
							<th>ACCIÓN</th>
							
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

					$cedula=$rows['empleadocedula'];
					$nombre=$rows['empleadonombres'];
					$apellido=$rows['empleadoapellidos'];
					$departemento=$rows['departamentonombre'];
					$cargo=$rows['cargonombre'];

					$tabla.='
						<tr>
							<td>'.$contador.'</td>
							<td>'.$cedula.'</td>
							
							<td>'.$apellido.'</td>
							<td>'.$nombre.'</td>
							<td>'.$departemento.'</td>
							<td>'.$cargo.'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							<a style="color: #ffffff;" class="btn btn-primary" class="btn btn-primary" value="'.$rows['empleadocodigo'].'" onclick="cargar('.$rows['empleadocodigo'].')"> Agregar
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


						//Controlador para gaginar administradores
		public function listar_vistoempleados_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM departemento" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cargo ORDER BY cargonombre";
			

			//$consulta="SELECT *,T1.empleadocodigo FROM empleados as T1, estado_empleado as T2, cargo as T3, departemento as T4, empresa as T5 WHERE T2.estadoempleadonombre='ACTIVO' AND T1.cargocodigo=T3.cargocodigo AND T4.departamentonombre='SISTEMAS' AND T4.empresacodigo=T5.empresacodigo";

			//$consulta="SELECT *,T1.empleadocodigo FROM empleados as T1, estado_empleado as T2, cargo as T3, departemento as T4, empresa as T5 WHERE T2.estadoempleadonombre='ACTIVO' AND T1.cargocodigo=T3.cargocodigo AND T3.departamentocodigo=t4.departamentocodigo AND T4.departamentonombre='SISTEMAS' AND T4.empresacodigo=T5.empresacodigo";

			$consulta="SELECT *,T1.empleadocodigo FROM empleados as T1, estado_empleado as T2, cargo as T3, departemento as T4, empresa as T5 WHERE T1.estadoempleadocodigo=T2.estadoempleadocodigo AND T2.estadoempleadonombre='ACTIVO' AND T1.cargocodigo=T3.cargocodigo AND T3.departamentocodigo=t4.departamentocodigo AND T4.departamentonombre='SISTEMAS' AND T4.empresacodigo=T5.empresacodigo";

			
			$conexion = mainModel::conectar();
			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>CÉDULA</th>
							<th>APELLIDOS</th>
							<th>NOMBRES</th>
							<th>CARGO</th>
							
			';
						//if ($privilegio<=2) {
							$tabla.='
							<th>ACCIÓN</th>
							
							';
						//}
						//if ($privilegio==1) {
							
						//}
			$tabla.='</tr>
					</thead>
					<tbody>';

				
				$contador=1;
				foreach ($datos as $rows) {

					$cedula=$rows['empleadocedula'];
					$nombre=$rows['empleadonombres'];
					$apellido=$rows['empleadoapellidos'];
					$cargo=$rows['cargonombre'];

					$tabla.='
						<tr>
							<td id="cedula='.($rows['empleadocedula']).'">'.$cedula.'</td>
							
							<td id="nombre='.($rows['empleadocedula']).'">'.$apellido.'</td>
							<td id="apellido='.($rows['empleadocedula']).'">'.$nombre.'</td>
							<td id="departemento='.($rows['empleadocedula']).'">'.$cargo.'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							<a style="display: block; margin-left: auto; margin-right: auto; color: #ffffff;" class="btn btn-primary" class="btn btn-primary" value="'.$rows['empleadocedula'].'" onclick="cargarv('.$rows['empleadocedula'].')"> Agregar
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
					$contador++;
				//}
			

			$tabla.='
					</tbody>
				';
			//Fin Tabla__________________________________________________________________

			

			return $tabla;
		}


						//Controlador para gaginar administradores
		public function listar_vistoempleadosinfo_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM departemento" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cargo ORDER BY cargonombre";
			

			$consulta="SELECT *,T1.empleadocodigo FROM empleados as T1, estado_empleado as T2, cargo as T3, departemento as T4, empresa as T5 WHERE T2.estadoempleadonombre='ACTIVO' AND T1.cargocodigo=T3.cargocodigo AND T4.departamentonombre='SISTEMAS' AND T4.empresacodigo=T5.empresacodigo";

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>CÉDULA</th>
							<th>APELLIDOS</th>
							<th>NOMBRES</th>
							<th>CARGO</th>
							
			';
						//if ($privilegio<=2) {
							$tabla.='
							<th>ACCIÓN</th>
							
							';
						//}
						//if ($privilegio==1) {
							
						//}
			$tabla.='</tr>
					</thead>
					<tbody>';

				
				$contador=1;
				foreach ($datos as $rows) {

					$cedula=$rows['empleadocedula'];
					$nombre=$rows['empleadonombres'];
					$apellido=$rows['empleadoapellidos'];
					$cargo=$rows['cargonombre'];

					$tabla.='
						<tr>
							<td id="cedula='.($rows['empleadocedula']).'">'.$cedula.'</td>
							
							<td id="nombre='.($rows['empleadocedula']).'">'.$apellido.'</td>
							<td id="apellido='.($rows['empleadocedula']).'">'.$nombre.'</td>
							<td id="departemento='.($rows['empleadocedula']).'">'.$cargo.'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							<a style="display: block; margin-left: auto; margin-right: auto; color: #ffffff;" class="btn btn-primary" class="btn btn-primary" value="'.$rows['empleadocedula'].'" onclick="cargar('.$rows['empleadocedula'].')"> Agregar
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
					$contador++;
				//}
			

			$tabla.='
					</tbody>
				';
			//Fin Tabla__________________________________________________________________

			

			return $tabla;
		}




						//Controlador para gaginar administradores
		public function listar_vistoinforme_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM departemento" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			//$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cargo ORDER BY cargonombre";
			

			$consulta="SELECT *,T1.empleadocodigo FROM empleados as T1, estado_empleado as T2, cargo as T3, departemento as T4, empresa as T5 WHERE T2.estadoempleadonombre='ACTIVO' AND T1.cargocodigo=T3.cargocodigo AND T3.departamentocodigo=T4.departamentocodigo AND T4.departamentonombre='SISTEMAS' AND T4.empresacodigo=T5.empresacodigo";

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>CÉDULA</th>
							<th>APELLIDOS</th>
							<th>NOMBRES</th>
							<th>CARGO</th>
							
			';
						//if ($privilegio<=2) {
							$tabla.='
							<th>ACCIÓN</th>
							
							';
						//}
						//if ($privilegio==1) {
							
						//}
			$tabla.='</tr>
					</thead>
					<tbody>';

				
				$contador=1;
				foreach ($datos as $rows) {

					$cedula=$rows['empleadocedula'];
					$nombre=$rows['empleadonombres'];
					$apellido=$rows['empleadoapellidos'];
					$cargo=$rows['cargonombre'];

					$tabla.='
						<tr>
							<td id="cedula='.($rows['empleadocedula']).'">'.$cedula.'</td>
							
							<td id="nombre='.($rows['empleadocedula']).'">'.$apellido.'</td>
							<td id="apellido='.($rows['empleadocedula']).'">'.$nombre.'</td>
							<td id="departemento='.($rows['empleadocedula']).'">'.$cargo.'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							<a style="display: block; margin-left: auto; margin-right: auto; color: #ffffff;" class="btn btn-primary" class="btn btn-primary" value="'.$rows['empleadocedula'].'" onclick="cargari('.$rows['empleadocedula'].')"> Agregar
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
					$contador++;
				//}
			

			$tabla.='
					</tbody>
				';
			//Fin Tabla__________________________________________________________________

			

			return $tabla;
		}



		public function datos_empleados_controlador($tipo,$codigo){
			$codigo=mainModel::limpiar_cadena($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return empleadosModelo::datos_empleados_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_empleados_controlador(){
			

			if (!empty($_POST['codigo']) && !empty($_POST['respo-reg']) && !empty($_POST['cedula-up']) && !empty($_POST['nombres-up']) && !empty($_POST['apellidos-up']) && !empty($_POST['telefono-up']) && !empty($_POST['celular-up']) && !empty($_POST['correo-up']) && !empty($_POST['fecha-up']) && !empty($_POST['emp-up']) && !empty($_POST['dep-reg']) && !empty($_POST['car-reg']) && !empty($_POST['estemrg-up'])) {
			

			$cuenta=mainModel::limpiar_cadena($_POST['codigo']);
			$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
			$respo=mainModel::limpiar_cadena($_POST['respo-reg']);

			$cedula=mainModel::limpiar_cadena($_POST['cedula-up']);

			//$codigo=mainModel::limpiar_cadena($_POST['cedula-reg']);
			$nombres=mainModel::limpiar_cadena($_POST['nombres-up']);
			$apellidos=mainModel::limpiar_cadena($_POST['apellidos-up']);
			$telefono=mainModel::limpiar_cadena($_POST['telefono-up']);
			$celular=mainModel::limpiar_cadena($_POST['celular-up']);
			$correo=mainModel::limpiar_cadena($_POST['correo-up']);
			$fecha=mainModel::limpiar_cadena($_POST['fecha-up']);
			$entidad=mainModel::limpiar_cadena($_POST['emp-up']);
			$departamento=mainModel::limpiar_cadena($_POST['dep-reg']);
			$cargo=mainModel::limpiar_cadena($_POST['car-reg']);


			if(!empty($_POST['estado-up'])){
				$estado=mainModel::limpiar_cadena($_POST['estado-up']);

				/*if (empty($_POST['estado-up'])) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Es necesario que ingreso todos los campos, por favor llénelos e intente nuevamente",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}*/

			}else{
				$estado=mainModel::limpiar_cadena($_POST['estemrg-up']);
			}

			

			$Consultaestados=mainModel::ejecutar_consulta_simple("SELECT * FROM estado_empleado WHERE estadoempleadocodigo='$estado'");
			$resultados=$Consultaestados->fetch();
			$veri=$resultados['estadoempleadonombre'];


			if (trim($veri)=='DESACTIVO') {
				$estasig=mainModel::ejecutar_consulta_simple("SELECT estadoasigharcodigo FROM estado_asignacion_hardware WHERE estadoasigharnombre='NO REASIGNADO'");
			    $busquedaasig=$estasig->fetch();
			    $codasig=$busquedaasig['estadoasigharcodigo'];


				$esthard=mainModel::ejecutar_consulta_simple("SELECT * FROM estado_hardware WHERE estadohardwarenombre='ACTIVO'");
			    $busqueda1=$esthard->fetch();
			    $cod1=$busqueda1['estadohardwarecodigo'];
			    $verihar=mainModel::ejecutar_consulta_simple("SELECT * FROM hardware WHERE empleadocodigo='$dni' AND estadohardwarecodigo='$cod1'");
			    if ($verihar->rowCount()>=1) {

			    	if(isset($_POST['tema-reg'])){
						$tema=mainModel::limpiar_cadena($_POST['tema-reg']);
						$aufe=mainModel::limpiar_cadena($_POST['aufe-reg']);
						$descri=mainModel::limpiar_cadena($_POST['descri-up']);

						if (empty($_POST['tema-reg']) && empty($_POST['aufe-reg']) && empty($_POST['descri-up'])) {

							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"Es necesario que ingreso todos los campos, por favor llénelos e intente nuevamente",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
					
						}
					}else{
						$tema='null';
						$aufe='null';
						$descri='null';
















						/* SI DESA DESATIVARLE Y NO TIENE HARDWARE ASIGNADO */
				
					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocodigo='$cuenta'");
					$DatosEmpresa=$query1->fetch();

					if ($dni!=$DatosEmpresa['empleadocodigo']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT empleadocodigo FROM empleados WHERE empleadocodigo='$dni'");
						if ($consulta1->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El codigo que se ha asignado al empleado ya se encuentra registrado en el sistemas, porfavor intente nuevamente recargando la pagina",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocedula='$cedula'");
					$DatosEmpresa=$query1->fetch();

					if ($cedula!=$DatosEmpresa['empleadocedula']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT empleadocedula FROM empleados WHERE empleadocedula='$cedula'");
						if ($consulta1->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El cédula del empleado que acaba de ingresar ya se encuentra registrado en el sistema",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					if ($correo!=$DatosEmpresa['empleadocorreo']) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT empleadocorreo FROM empleados WHERE empleadocorreo='$correo'");
						if ($consulta2->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El correo del empleado que acaba de ingresar ya se encuentra registrado en el sistema, porfavor intente nuevamente",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}


					$dataDepartamento=[
								"CEDULA"=>$cedula,
								"CARGO"=>$cargo,
								"ESTADO"=>$estado,
								"NOMBRES"=>$nombres,
								"APELLIDOS"=>$apellidos,
								"TELEFONO"=>$telefono,
								"CELULAR"=>$celular,
								"CORREO"=>$correo,
								"FECHA"=>$fecha,
								"CODIGO"=>$cuenta
					];
					$editarDepartamento=empleadosModelo::actualizar_empleados_modelo($dataDepartamento);
					if ($editarDepartamento->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"Los datos del empleado se han editado con éxito",
							"Tipo"=>"success"
							];
						return mainModel::sweet_alert($alerta);
						exit();
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Para editar los datos del empleado es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
					}
				


					/* SI DESA DESATIVARLE Y NO TIENE HARDWARE ASIGNADO */




















					}
			    	


				    $datos= $verihar->fetchAll();

				    $contador=0;
				    foreach ($datos as $rows) {
				     $contador=$contador+1;
				     $qserie=$rows['hiserie'];
				     $auditoria=mainModel::ejecutar_consulta_simple("UPDATE hardware_ingreso SET estadoasigharcodigo='$codasig' WHERE hiserie='$qserie'");


				     /* RESPONSABLE DE LA AUDITORIA */
					 $respoaud=mainModel::ejecutar_consulta_simple("SELECT codigoauditoria FROM responsable_auditoria");
					 $numero5=($respoaud->rowCount())+1;
					 $codigo5=mainModel::generar_codigo_aleatorio("RESPAUD",7,$numero5);

					 $insertrespaud=mainModel::ejecutar_consulta_simple("INSERT INTO responsable_auditoria(codigoauditoria, empleadocodigo) VALUES ('$codigo5','$respo')");
					 /* RESPONSABLE DE LA AUDITORIA */


				     /* AUDITORIA */
					 $regaud=mainModel::ejecutar_consulta_simple("SELECT auditoriacodigo FROM auditoria_hardware");
					 $numero6=($regaud->rowCount())+1;
					 $dataud=mainModel::generar_codigo_aleatorio("AUDHAR",7,$numero6);
		
					 $insertaud=mainModel::ejecutar_consulta_simple("INSERT INTO auditoria_hardware(auditoriacodigo,auditoriatema,auditoriafecha,auditoriadescripcion,empleadocodigo,hiserie,codigoauditoria) VALUES ('$dataud', '$tema','$aufe','$descri','$cuenta','$qserie','$codigo5')");

					 /* AUDITORIA */


			
				   	}
				   	if (($insertrespaud->rowCount()>=1)&&($insertaud->rowCount()>=1)) {








					/* SI SE REALIZO LA UDITORIA DESACTIVAR EL CLIENTE */

						$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocodigo='$cuenta'");
						$DatosEmpresa=$query1->fetch();

						if ($dni!=$DatosEmpresa['empleadocodigo']) {
							$consulta1=mainModel::ejecutar_consulta_simple("SELECT empleadocodigo FROM empleados WHERE empleadocodigo='$dni'");
							if ($consulta1->rowCount()>=2) {
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrió un error inesperado",
									"Texto"=>"El codigo que se ha asignado al empleado ya se encuentra registrado en el sistemas, porfavor intente nuevamente recargando la pagina",
									"Tipo"=>"error"
								];
								return mainModel::sweet_alert($alerta);
								exit();
							}
						}

						$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocedula='$cedula'");
						$DatosEmpresa=$query1->fetch();

						if ($cedula!=$DatosEmpresa['empleadocedula']) {
							$consulta1=mainModel::ejecutar_consulta_simple("SELECT empleadocedula FROM empleados WHERE empleadocedula='$cedula'");
							if ($consulta1->rowCount()>=2) {
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrió un error inesperado",
									"Texto"=>"El cédula del empleado que acaba de ingresar ya se encuentra registrado en el sistema",
									"Tipo"=>"error"
								];
								return mainModel::sweet_alert($alerta);
								exit();
							}
						}

						if ($correo!=$DatosEmpresa['empleadocorreo']) {
							$consulta2=mainModel::ejecutar_consulta_simple("SELECT empleadocorreo FROM empleados WHERE empleadocorreo='$correo'");
							if ($consulta2->rowCount()>=2) {
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrió un error inesperado",
									"Texto"=>"El correo del empleado que acaba de ingresar ya se encuentra registrado en el sistema, porfavor intente nuevamente",
									"Tipo"=>"error"
								];
								return mainModel::sweet_alert($alerta);
								exit();
							}
						}


						$dataDepartamento=[
									"CEDULA"=>$cedula,
									"CARGO"=>$cargo,
									"ESTADO"=>$estado,
									"NOMBRES"=>$nombres,
									"APELLIDOS"=>$apellidos,
									"TELEFONO"=>$telefono,
									"CELULAR"=>$celular,
									"CORREO"=>$correo,
									"FECHA"=>$fecha,
									"CODIGO"=>$cuenta
						];
						$editarDepartamento=empleadosModelo::actualizar_empleados_modelo($dataDepartamento);
						if ($editarDepartamento->rowCount()>=1) {
							


							$alerta=[
								"Alerta"=>"recargar",
								"Titulo"=>"Felicitaciones!",
								"Texto"=>"El empleado ha sido desactivado, por lo tanto se ha liberado $contador equipos de hardware a través de la auditoria correspondiente",
								"Tipo"=>"success"
							];
		


						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"Para editar los datos del empleado es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
								"Tipo"=>"error"
							];
						}
						return mainModel::sweet_alert($alerta);

						/* SI SE REALIZO LA UDITORIA DESACTIVAR EL CLIENTE */















						

						}

					if (($auditoria->rowCount()<=0)) {

						/* SI YA SE LE LIBERO EL HARDWARE A ESTA PERSONA Y FUE ACTIVADA Y DESEA DESACTIVARLA OTRA VEZ ENTONCES HACER ESTO */
					

					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocodigo='$cuenta'");
					$DatosEmpresa=$query1->fetch();

					if ($dni!=$DatosEmpresa['empleadocodigo']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT empleadocodigo FROM empleados WHERE empleadocodigo='$dni'");
						if ($consulta1->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El codigo que se ha asignado al empleado ya se encuentra registrado en el sistemas, porfavor intente nuevamente recargando la pagina",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocedula='$cedula'");
					$DatosEmpresa=$query1->fetch();

					if ($cedula!=$DatosEmpresa['empleadocedula']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT empleadocedula FROM empleados WHERE empleadocedula='$cedula'");
						if ($consulta1->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El cédula del empleado que acaba de ingresar ya se encuentra registrado en el sistema",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					if ($correo!=$DatosEmpresa['empleadocorreo']) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT empleadocorreo FROM empleados WHERE empleadocorreo='$correo'");
						if ($consulta2->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El correo del empleado que acaba de ingresar ya se encuentra registrado en el sistema, porfavor intente nuevamente",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}


					$dataDepartamento=[
								"CEDULA"=>$cedula,
								"CARGO"=>$cargo,
								"ESTADO"=>$estado,
								"NOMBRES"=>$nombres,
								"APELLIDOS"=>$apellidos,
								"TELEFONO"=>$telefono,
								"CELULAR"=>$celular,
								"CORREO"=>$correo,
								"FECHA"=>$fecha,
								"CODIGO"=>$cuenta
					];
					$editarDepartamento=empleadosModelo::actualizar_empleados_modelo($dataDepartamento);
					if ($editarDepartamento->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"Los datos del empleado se han editado con éxito",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Para editar los datos del empleado es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}
					return mainModel::sweet_alert($alerta);

					/* SI YA SE LE LIBERO EL HARDWARE A ESTA PERSONA Y FUE ACTIVADA Y DESEA DESACTIVARLA OTRA VEZ ENTONCES HACER ESTO */

					
					}	
				}elseif ($verihar->rowCount()<=0) {

					/* SI DESA DESATIVARLE Y NO TIENE HARDWARE ASIGNADO */
				
					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocodigo='$cuenta'");
					$DatosEmpresa=$query1->fetch();

					if ($dni!=$DatosEmpresa['empleadocodigo']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT empleadocodigo FROM empleados WHERE empleadocodigo='$dni'");
						if ($consulta1->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El codigo que se ha asignado al empleado ya se encuentra registrado en el sistemas, porfavor intente nuevamente recargando la pagina",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocedula='$cedula'");
					$DatosEmpresa=$query1->fetch();

					if ($cedula!=$DatosEmpresa['empleadocedula']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT empleadocedula FROM empleados WHERE empleadocedula='$cedula'");
						if ($consulta1->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El cédula del empleado que acaba de ingresar ya se encuentra registrado en el sistema",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					if ($correo!=$DatosEmpresa['empleadocorreo']) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT empleadocorreo FROM empleados WHERE empleadocorreo='$correo'");
						if ($consulta2->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El correo del empleado que acaba de ingresar ya se encuentra registrado en el sistema, porfavor intente nuevamente",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}


					$dataDepartamento=[
								"CEDULA"=>$cedula,
								"CARGO"=>$cargo,
								"ESTADO"=>$estado,
								"NOMBRES"=>$nombres,
								"APELLIDOS"=>$apellidos,
								"TELEFONO"=>$telefono,
								"CELULAR"=>$celular,
								"CORREO"=>$correo,
								"FECHA"=>$fecha,
								"CODIGO"=>$cuenta
					];
					$editarDepartamento=empleadosModelo::actualizar_empleados_modelo($dataDepartamento);
					if ($editarDepartamento->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"Los datos del empleado se han editado con éxito",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Para editar los datos del empleado es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}
					return mainModel::sweet_alert($alerta);



					/* SI DESA DESATIVARLE Y NO TIENE HARDWARE ASIGNADO */
				}




			}elseif (trim($veri)=='ACTIVO') {

				/* SI DESEA ACTIVARLE ACTIVARLE */

				$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM empleados WHERE empleadocodigo='$cuenta'");
				$DatosEmpresa=$query1->fetch();

				if ($dni!=$DatosEmpresa['empleadocodigo']) {
					$consulta1=mainModel::ejecutar_consulta_simple("SELECT empleadocodigo FROM empleados WHERE empleadocodigo='$dni'");
					if ($consulta1->rowCount()>=2) {
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El cédula del empleado que acaba de ingresar ya se encuentra registrado en el sistema",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
					}
				}

				if ($correo!=$DatosEmpresa['empleadocorreo']) {
					$consulta2=mainModel::ejecutar_consulta_simple("SELECT empleadocorreo FROM empleados WHERE empleadocorreo='$correo'");
					if ($consulta2->rowCount()>=2) {
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El correo del empleado que acaba de ingresar ya se encuentra registrado en el sistema, porfavor intente nuevamente",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
					}
				}


				$dataDepartamento=[
							"CEDULA"=>$cedula,
							"CARGO"=>$cargo,
							"ESTADO"=>$estado,
							"NOMBRES"=>$nombres,
							"APELLIDOS"=>$apellidos,
							"TELEFONO"=>$telefono,
							"CELULAR"=>$celular,
							"CORREO"=>$correo,
							"FECHA"=>$fecha,
							"CODIGO"=>$cuenta
				];
				$editarDepartamento=empleadosModelo::actualizar_empleados_modelo($dataDepartamento);
				if ($editarDepartamento->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Felicitaciones!",
						"Texto"=>"Los datos del empleado se han editado con éxito",
						"Tipo"=>"success"
						];
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Para editar los datos del empleado es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
						"Tipo"=>"error"
					];
				}
				return mainModel::sweet_alert($alerta);


				/* SI DESEA ACTIVARLE ACTIVARLE */










			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Primero $estado ssssssssss debe ingresar los estados del empleado que vienen por defecto en el sistema, si los problemas persisten contactese con el desarrollador del sistema",
					"Tipo"=>"error"
				];
				return mainModel::sweet_alert($alerta);
			}
		}else{
			$alerta=[
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"Es necesario que ingreso todos los campos, por favor llénelos e intente nuevamente",
				"Tipo"=>"error"
			];
			return mainModel::sweet_alert($alerta);
		}
	}
}