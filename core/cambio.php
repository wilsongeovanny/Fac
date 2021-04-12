<?php
require_once "./core/configAPP.php";
//require_once ''.SERVERURL.'core/configAPP.php';

class cambio{

		public function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}
}
?>