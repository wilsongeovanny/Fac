<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class administradorModelo extends mainModel{

		//Funcion para registrar administradores
		protected function agregar_administrador_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO cuenta(cuentacodigo,estadocuentacodigo,codigoroles,empleadocodigo,cuentausuario,cuentafoto,cuentaclave,cuentaactivacion,cuentarequest,cuentatoken) VALUES(:CODIGO,:ESTADO,:ROLES,:EMPLEADO,:USURAIO,:FOTO,:CLAVE,:ACTIVACION,:REQUEST,:TOKEN)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":ESTADO",$datos['ESTADO']);
			$query->bindParam(":ROLES",$datos['ROLES']);
			$query->bindParam(":EMPLEADO",$datos['EMPLEADO']);
			$query->bindParam(":USURAIO",$datos['USURAIO']);
			$query->bindParam(":FOTO",$datos['FOTO']);
			$query->bindParam(":CLAVE",$datos['CLAVE']);
			$query->bindParam(":ACTIVACION",$datos['ACTIVACION']);
			$query->bindParam(":REQUEST",$datos['REQUEST']);
			$query->bindParam(":TOKEN",$datos['TOKEN']);
			$query->execute();
			return $query;
		}


		protected function datos_administrador_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT *,T1.cuentacodigo FROM cuenta as T1, estado_cuenta as T2, empleados as T3, roles as T4, cargo as T5, departemento as T6, empresa as T7  WHERE T1.cuentacodigo=:codigo AND T1.estadocuentacodigo=T2.estadocuentacodigo AND T1.empleadocodigo=T3.empleadocodigo AND T1.codigoroles=T4.codigoroles AND T3.cargocodigo=T5.cargocodigo AND T5.departamentocodigo=T6.departamentocodigo AND T6.empresacodigo=T7.empresacodigo");
				$query->bindParam(":codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT departamentocodigo FROM departemento");
			}elseif($tipo=="SelectEmpresa"){
				$query=mainModel::conectar()->prepare("SELECT * FROM empresa ORDER BY empresanombre ASC");
			}elseif($tipo=="SelectDep"){
				$query=mainModel::conectar()->prepare("SELECT * FROM departemento ORDER BY departamentonombre ASC");
			}elseif($tipo=="SelectMaterias"){
				$query=mainModel::conectar()->prepare("SELECT * FROM empresacodigo WHERE departamentocodigo=:codigo ORDER BY departamentonombre ASC");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="Pregunta") {
				$query=mainModel::conectar()->prepare("SELECT * FROM cargo WHERE cargocodigo=:codigo");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="Empresa") {
				$query=mainModel::conectar()->prepare("SELECT a.*,b.departamentocodigo,c.empresacodigo FROM cargo a,cargo b,departemento c WHERE a.cargocodigo=:codigo AND a.cargocodigo= b.cargocodigo AND b.departamentocodigo= c.departamentocodigo");
				$query->bindParam(":codigo",$codigo);
			}elseif ($tipo=="SelectCargos") {
				$query=mainModel::conectar()->prepare("SELECT * FROM cargo ORDER BY cargonombre ASC");
			}elseif ($tipo=="Empleados") {
				$query=mainModel::conectar()->prepare("SELECT * FROM empleados ORDER BY empleadonombres ASC");
			}elseif ($tipo=="Perfil") {
				$query=mainModel::conectar()->prepare("SELECT * FROM perfil_cuenta ORDER BY perfilnombre ASC");
			}elseif ($tipo=="Estados") {
				$query=mainModel::conectar()->prepare("SELECT * FROM estado_cuenta ORDER BY estadocuentanombre ASC");
			}elseif ($tipo=="MODMEN") {
				$query=mainModel::conectar()->prepare("SELECT *,T3.modmenucodigo FROM menu as T1, modulo as T2, modulo_menu as T3 WHERE T1.menucodigo=T3.menucodigo AND T2.modulocodigo=T3.modulocodigo ORDER BY modulonombre");
			}elseif ($tipo=="Modulos") {
				$query=mainModel::conectar()->prepare("SELECT * FROM modulo ORDER BY modulonombre");
			}elseif ($tipo=="Rol") {
				$query=mainModel::conectar()->prepare("SELECT * FROM roles WHERE rolesestado='ACTIVO' ORDER BY rolesnombre ASC");
			}
			$query->execute();
			return $query;
		
	}

		//Función para editar el administrador
		protected function actualizar_administrador_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE cuenta SET estadocuentacodigo=:ESTADO,codigoroles=:ROLES,cuentausuario=:USUARIO,cuentafoto=:FOTO,cuentaclave=:CLAVE WHERE cuentacodigo=:CODIGO");
			$query->bindParam("ESTADO",$datos['ESTADO']);
			$query->bindParam("ROLES",$datos['ROLES']);
			$query->bindParam("USUARIO",$datos['USUARIO']);
			$query->bindParam("FOTO",$datos['FOTO']);
			$query->bindParam("CLAVE",$datos['CLAVE']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}

		protected function verificar_email_modelo($datos){
			$sql=mainModel::conectar()->prepare("SELECT * FROM empleados WHERE empleadocorreo=:EMAIL");
			$sql->bindParam(':EMAIL',$datos['EMAIL']);
			$sql->execute();
			return $sql;	
		}
	}