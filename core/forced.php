<?php
require_once "./core/configAPP.php";
//require_once ''.SERVERURL.'core/configAPP.php';

class forced{

		public function conectar(){
			$enlace = new PDO(SGBD,USER,PASS);
			return $enlace;
		}

		public function ejecutar_consulta_simple($consulta){
			$respuesta = self::conectar()->prepare($consulta);
			$respuesta->execute();
			return $respuesta;
		}

		public function generar_codigo_aleatorio($letra, $longitud, $num){
			for ($i=1; $i<=$longitud; $i++) { 
				$numero = rand(0,9); //obtener un # aleatorio rand
				$letra.= $numero; 
			}
			return $letra.$num;      //$letra."-".$num;
		}

		public function encryption($string){
			$output="FALSE";
			$key=hash('sha256', SECRET_KEY);
			$iv= substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}
}
?>