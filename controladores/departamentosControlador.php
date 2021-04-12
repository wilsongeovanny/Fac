<?php 
	if ($peticionAjax) {
		require_once "../modelos/departamentosModelo.php";
	}else{
		require_once "./modelos/departamentosModelo.php";
	}  

	class departamentosControlador extends departamentosModelo{

		//Controlador para agregar administrador
		public function agregar_departamentos_controlador(){
			if (!empty($_POST['opcion-reg']) && !empty($_POST['nombre-reg'])) {

				$entidad=mainModel::limpiar_cadena($_POST['opcion-reg']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);


				$verenitidad=mainModel::ejecutar_consulta_simple("SELECT * FROM empresa WHERE empresacodigo='$entidad'");
				if ($verenitidad->rowCount()>=1) {
				
					$consultacod=mainModel::ejecutar_consulta_simple("SELECT departamentocodigo FROM departemento");
					$numero=($consultacod->rowCount())+1;
					$codigo=mainModel::generar_codigo_aleatorio("DEPA",7,$numero);

					$consulta1=mainModel::ejecutar_consulta_simple("SELECT departamentocodigo FROM departemento WHERE departamentocodigo='$codigo'");
					if ($consulta1->rowCount()<=0) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT departamentonombre FROM departemento WHERE departamentonombre='$nombre'");
						if ($consulta2->rowCount()<=0) {


							

							$datosDepartamento=[
								"CODIGO"=>$codigo,
								"EMPRESA"=>$entidad,
								"NOMBRE"=>$nombre
							];
							$guardarDepartamento=departamentosModelo::agregar_departamentos_modelo($datosDepartamento);
							if ($guardarDepartamento->rowCount()>=1) {
								$alerta=[
									"Alerta"=>"recargar",
									"Titulo"=>"Felicitaciones!",
									"Texto"=>"El departamento ha sido registrado con éxito",
									"Tipo"=>"success"
								];
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrió un error inesperado",
									"Texto"=>"No se ha podido guardar departamento, porfavor intente nuevamente",
									"Tipo"=>"error"
								];	
							}
						}else{
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El nombre del departamento ya se encuentra registrado en el sistema, por favor intente nuevamente",
								"Tipo"=>"error"
							];	
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El código que se genero para el departamento ya se encuentra en el sistema, por favor intente nuevamente recargando la página",
							"Tipo"=>"error"
						];
					}

				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"La empresa que usted ha elejido para el departamento no se encuentra registrado en el sistema, por favor intente nuevamente recargando la página",
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
		public function listar_departamentos_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			//Consulta de los departamentos para la búsqueda se utilizo una plantilla Gentella Master
			$consulta="SELECT *,T2.departamentocodigo as id_pl FROM empresa as T1 INNER JOIN departemento as T2 on T1.empresacodigo=T2.empresacodigo";

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th><center>#</center></th>
							<th><center>EMPRESA</center></th>
							<th><center>NOMBRE</center></th>
							
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
							<td><center>'.$rows['empresanombre'].'</center></td>
							<td><center>'.$rows['departamentonombre'].'</center></td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td><center>
				
								<form method="POST" action="'.SERVERURL.'departamentosinfo/">
								<input type="hidden" value="'.$rows['departamentocodigo'].'" name="codigo">
								<button style="font-size:15px; borderbox:0px; width:100px;" type="submit" class="btn btn-primary"><i class="fa fa-edit" onclick="editbtnmenu"></i> Editar</button>
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



		public function datos_departamentos_controlador($tipo,$codigo){
			$codigo=mainModel::limpiar_cadena($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return departamentosModelo::datos_departamentos_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_departamentos_controlador(){
			if (!empty($_POST['codigo']) && !empty($_POST['codigo-up']) && !empty($_POST['opcion-up']) && !empty($_POST['nombre-up'])) {

				$cuenta=mainModel::limpiar_cadena($_POST['codigo']);

				$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
				$entidad=mainModel::limpiar_cadena($_POST['opcion-up']);
				$nombre=mainModel::limpiar_cadena($_POST['nombre-up']);

				$verenitidad=mainModel::ejecutar_consulta_simple("SELECT * FROM empresa WHERE empresacodigo='$entidad'");
				if ($verenitidad->rowCount()>=1) {

					$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM departemento WHERE departamentocodigo='$cuenta'");
					$DatosEmpresa=$query1->fetch();

					if ($dni!=$DatosEmpresa['departamentocodigo']) {
						$consulta1=mainModel::ejecutar_consulta_simple("SELECT departamentocodigo FROM departemento WHERE departamentocodigo='$dni'");
						if ($consulta1->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El código que se genero para el departamento ya se encuentra en el sistema, porfavor intente nuevamente recargando la página",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					if ($nombre!=$DatosEmpresa['departamentonombre']) {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT departamentocodigo FROM departemento WHERE departamentonombre='$nombre'");
						if ($consulta2->rowCount()>=2) {
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"El nombre del departamento ya se encuentra registrado en el sistema, porfavor intente nuevamente",
								"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
						}
					}

					$dataDepartamento=[
						"NOMBRE"=>$nombre,
						"CODIGO"=>$cuenta,
					];
					$editarDepartamento=departamentosModelo::actualizar_departamentos_modelo($dataDepartamento);
					if ($editarDepartamento->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Felicitaciones!",
							"Texto"=>"El departamento se ha actualizado con éxito",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"Para actualizar los datos del departamento es necesario que se realice por lo menos un cambio, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}

				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"La entidad que usted ha elejido para el departamento no se encuentra registrado en el sistema, porfavor intente nuevamente recargando la página",
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