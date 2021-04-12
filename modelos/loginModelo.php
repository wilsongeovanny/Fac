<?php
//require_once "../Administrador/core/mainModel.php";

	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class loginModelo extends mainModel{
		/*protected function iniciar_sesion_modelo($datos){
			$sql=mainModel::conectar()->prepare("SELECT * FROM cuenta WHERE CuentaEmail=:Email AND CuentaClave=:Clave AND CuentaEstado='Activo'");
			$sql->bindParam(':Email',$datos['Email']);
			$sql->bindParam(':Clave',$datos['Clave']);
			$sql->execute();
			return $sql;	
		}*/

		protected function iniciar_sesion_modelo($datos){
			$sql=mainModel::conectar()->prepare("SELECT * FROM cuenta WHERE cuentausuario=:USUARIO AND cuentaclave=:CLAVE");
			$sql->bindParam(':USUARIO',$datos['USUARIO']);
			$sql->bindParam(':CLAVE',$datos['CLAVE']);
			$sql->execute();
			return $sql;	
		}

		protected function verificar_email_modelo($datos){
			$sql=mainModel::conectar()->prepare("SELECT cuentausuario FROM cuenta WHERE cuentausuario=:USUARIO");
			$sql->bindParam(':USUARIO',$datos['USUARIO']);
			$sql->execute();
			return $sql;	
		}

		/*protected function verificar_clave_modelo($datos){
			$sql=mainModel::conectar()->prepare("SELECT CUENTACLAVE FROM cuenta WHERE CUENTACLAVE=:CLAVE");
			$sql->bindParam(':CLAVE',$datos['CLAVE']);
			$sql->execute();
			return $sql;	
		}*/


		protected function cerrar_sesion_modelo($datos){
			
			if ($datos['Usuario']!="" && $datos['Token_S']==$datos['Token']) {
				$Abitacora=mainModel::actualizar_bitacora($datos['Codigo'],$datos['Hora']);
				if ($Abitacora->rowCount()==1) {
					session_unset();
					session_destroy(); 
					$respuesta="true";
				}else{
					$respuesta="false";
				}
			}else{
				$respuesta="false";
			}
			return $respuesta;
		}
		/*protected function cerrar_sesion_modelo($datos){
			
				//$Abitacora=mainModel::actualizar_bitacora($datos['Codigo'],$datos['Hora']);
		
					session_unset();
					session_destroy(); 
					$respuesta="true";
			
			
			return $respuesta;
		}*/
	}