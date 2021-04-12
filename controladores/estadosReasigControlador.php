<?php 
	if ($peticionAjax) {
		require_once "../modelos/estadosReasigModelo.php";
	}else{
		require_once "./modelos/estadosReasigModelo.php";
	}  

	class estadosReasigControlador extends estadosReasigModelo{

		//Controlador para agregar administrador
		public function agregar_estadosReasig_controlador(){
			//$codigo=mainModel::limpiar_cadena($_POST['codigo-reg']);
			$opcion=mainModel::limpiar_cadena($_POST['opcion-reg']);
			
			$consultacod=mainModel::ejecutar_consulta_simple("SELECT ESTADOREASIGHARCODIGO FROM estado_reasignacion_hardware");
			$numero=($consultacod->rowCount())+1;
			$codigo=mainModel::generar_codigo_aleatorio("ESTHARD",7,$numero);

			$consulta1=mainModel::ejecutar_consulta_simple("SELECT ESTADOREASIGHARCODIGO FROM estado_reasignacion_hardware WHERE ESTADOREASIGHARCODIGO='$codigo'");
			if ($consulta1->rowCount()<=0) {
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT ESTADOREASIGHARNOMBRE FROM estado_reasignacion_hardware WHERE ESTADOREASIGHARNOMBRE='$opcion'");
				if ($consulta2->rowCount()<=0) {
					

					$datosestadosReasig=[
						"CODIGO"=>$codigo,
						"OPCION"=>$opcion,
					];
					$guardarestadosReasig=estadosReasigModelo::agregar_estadosReasig_modelo($datosestadosReasig);
					if ($guardarestadosReasig->rowCount()>=1) {
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Empresa registrada",
							"Texto"=>"El estado se ha registrado con éxito",
							"Tipo"=>"success"
						];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No hemos podido guardar el estado, porfavor intente nuevamnete",
							"Tipo"=>"error"
						];	
					}
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El estado ya se encuentra registrado en el sistema, porfavor intente nuevamnete",
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
		public function listar_estadosReasig_controlador(/*$privilegio,$codigo*/){
			
		
			//$privilegio=mainModel::limpiar_cadena($privilegio);
			//$codigo=mainModel::limpiar_cadena($codigo);
			

			$tabla="";

			

			
			$consulta="SELECT * FROM estado_reasignacion_hardware" /*WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre*/;
			//$paginaurl="adminlist";
			

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			

		
			//InicioTabla_______________________________________________________________
			$tabla.='
			
					<thead>
						<tr>
							<th>#</th>
							<th>ESTADOS DE REASIGNACIÓN</th>
							
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
							<td>'.$rows['ESTADOREASIGHARNOMBRE'].'</td>
							';
						//if ($privilegio<=2) {
							$tabla.='
							<td>
							
								<a href="'.SERVERURL.'estadosreasignacioninfo/'.mainModel::encryption($rows['ESTADOREASIGHARCODIGO']).'/" class="btn btn-primary">
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

		public function datos_estadosReasig_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return estadosReasigModelo::datos_estadosReasig_modelo($tipo,$codigo);
		}

		//Controlador actualizar el nombre del menú
		public function actualizar_estadosReasig_controlador(){
			$cuenta=mainModel::decryption($_POST['codigo']);

			$dni=mainModel::limpiar_cadena($_POST['codigo-up']);
			$opcion=mainModel::limpiar_cadena($_POST['opcion-up']);


			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM estado_reasignacion_hardware WHERE ESTADOREASIGHARCODIGO='$cuenta'");
			$DatosestadosReasig=$query1->fetch();

			if ($dni!=$DatosestadosReasig['ESTADOREASIGHARCODIGO']) {
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT ESTADOREASIGHARCODIGO FROM estado_reasignacion_hardware WHERE ESTADOREASIGHARCODIGO='$dni'");
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

			if ($opcion!=$DatosestadosReasig['ESTADOREASIGHARNOMBRE']) {
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT ESTADOREASIGHARNOMBRE FROM estado_reasignacion_hardware WHERE ESTADOREASIGHARNOMBRE='$opcion'");
				if ($consulta2->rowCount()>=1) {
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El estado ya se encuentra registrado en el sistema, porfavor intente nuevamnete",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}

			$dataestadosReasig=[
				"OPCION"=>$opcion,
				"CODIGO"=>$cuenta,
			];
			$editarestadosReasig=estadosReasigModelo::actualizar_estadosReasig_modelo($dataestadosReasig);
			if ($editarestadosReasig->rowCount()>=1) {
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Datos actualizados",
					"Texto"=>"El estado se ha actualizado con exito",
					"Tipo"=>"success"
					];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos pordido actualizar el estado, porfavor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}
	}