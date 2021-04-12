<?php
require_once './core/forced.php';


	function validaIdToken($usuario, $cuentacodigo){

		
		$stmt = forced::ejecutar_consulta_simple("SELECT cuentaactivacion FROM cuenta WHERE cuentausuario='$usuario' AND cuentacodigo='$cuentacodigo'");

		if($stmt->rowCount()>=1) {

			$verificar = forced::ejecutar_consulta_simple("SELECT cuentaactivacion FROM cuenta WHERE cuentausuario='$usuario' AND cuentacodigo='$cuentacodigo' AND cuentaactivacion=1");
			//$cuentaactivacion=$verificar->fetch();

			if($verificar->rowCount()>=1){
				$msg = "La cuenta ya se activo anteriormente.";
			} else {
				if(activarUsuario($cuentacodigo)){
						$msg = 'Cuenta activada.';
				} else {
						$msg = 'Error al Activar Cuenta';
				}
			}
			} else {
			$msg = 'No existe el registro para activar.';
		}
		return $msg;
	}
	
	function activarUsuario($cuentacodigo)
	{

		$stmt = forced::ejecutar_consulta_simple("UPDATE cuenta SET cuentaactivacion=1 WHERE cuentacodigo = '$cuentacodigo'");
		//$stmt->close();
		return $stmt;
	}
	function decryption($string){
		$key=hash('sha256', SECRET_KEY);
		$iv=substr(hash('sha256', SECRET_IV), 0, 16);
		$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
		return $output;
	}












?>