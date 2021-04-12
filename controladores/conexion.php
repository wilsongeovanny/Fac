<?php 
	include('datosConexion.php');
	class Conexion {
		function Conectar(){
			try{
				$conexion = new PDO("pgsql:host=".SERVER1.";port=5432;dbname=".DBNAME1, USER1, PASSWORD1);
				return $conexion;
				
				//	alert ("yghjk");
				
				
			}catch (Exception $error){
				die("El error de conexión es: ".$error->getMessage());
			}
		}
	}
 ?>