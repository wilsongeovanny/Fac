<?php

//require_once "../Administrador/core/configAPP.php";
	if ($peticionAjax) {
		require_once "../core/configAPP.php";
	}else{
		require_once "./core/configAPP.php";
	}
	class mainModel{
		protected function conectar(){
			$enlace = new PDO(SGBD,USER,PASS);
			return $enlace;
		}

		protected function ejecutar_consulta_simple($consulta){
			$respuesta = self::conectar()->prepare($consulta);
			$respuesta->execute();
			return $respuesta;
		}

		protected function agregar_cuenta($datos){
			$sql=self::conectar()->prepare("INSERT INTO cuenta(CuentaCodigo, CuentaPrivilegio, CuentaUsuario, CuentaClave, CuentaEmail, CuentaEstado, CuentaTipo, CuentaGenero, CuentaFoto) VALUES(:Codigo,:Privilegio,:Usuario,:Clave,:Email,:Estado,:Tipo,:Genero,:Foto)");
			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":Privilegio",$datos['Privilegio']);
			$sql->bindParam(":Usuario",$datos['Usuario']);
			$sql->bindParam(":Clave",$datos['Clave']);
			$sql->bindParam(":Email",$datos['Email']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Tipo",$datos['Tipo']);
			$sql->bindParam(":Genero",$datos['Genero']);
			$sql->bindParam(":Foto",$datos['Foto']);
			$sql->execute();
			return $sql;
		}

		protected function eliminar_cuenta($codigo){
			$sql=self::conectar()->prepare("DELETE FROM cuenta WHERE CuentaCodigo=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function datos_cuenta($codigo,$tipo){
			$query=self::conectar()->prepare("SELECT * FROM cuenta WHERE CuentaCodigo=:Codigo AND CuentaTipo=:Tipo");
			$query->bindParam(":Codigo",$codigo);
			$query->bindParam(":Tipo",$tipo);
			$query->execute();
			return $query;
		}

		protected function actualizar_cuenta($datos){
			$query=self::conectar()->prepare("UPDATE cuenta SET CuentaPrivilegio=:Privilegio,CuentaUsuario=:Usuario,CuentaClave=:Clave,CuentaEmail=:Email,CuentaEstado=:Estado,CuentaGenero=:Genero,CuentaFoto=:Foto WHERE CuentaCodigo=:Codigo");
			$query->bindParam(":Privilegio",$datos['CuentaPrivilegio']);
			$query->bindParam(":Usuario",$datos['CuentaUsuario']);
			$query->bindParam(":Clave",$datos['CuentaClave']);
			$query->bindParam(":Email",$datos['CuentaEmail']);
			$query->bindParam(":Estado",$datos['CuentaEstado']);
			$query->bindParam(":Genero",$datos['CuentaGenero']);
			$query->bindParam(":Foto",$datos['CuentaFoto']);
			$query->bindParam(":Codigo",$datos['CuentaCodigo']);
			$query->execute();
			return $query;
		}

		protected function guardar_bitacora($datos){
			$sql=self::conectar()->prepare("INSERT INTO bitacora(bitacoracodigo,cuentacodigo,bitacorafecha,bitacorahorainicio,bitacorahorafinal,bitacoratipo,bitacorayear) VALUES(:CODIGO,:CUENTA,:FECHA,:INICIO,:FINAL,:TIPO,:YEAR)");
			$sql->bindParam(":CODIGO",$datos['CODIGO']);
			$sql->bindParam(":CUENTA",$datos['CUENTA']);
			$sql->bindParam(":FECHA",$datos['FECHA']);
			$sql->bindParam(":INICIO",$datos['INICIO']);
			$sql->bindParam(":FINAL",$datos['FINAL']);
			$sql->bindParam(":TIPO",$datos['TIPO']);
			$sql->bindParam(":YEAR",$datos['YEAR']);
			$sql->execute();
			return $sql;
		}

		protected function actualizar_bitacora($codigo,$hora){
			$sql=self::conectar()->prepare("UPDATE bitacora SET bitacorahorafinal=:Hora WHERE bitacoracodigo=:Codigo");
			$sql->bindParam(":Hora",$hora);
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		protected function eliminar_bitacora($codigo){
			$sql=self::conectar()->prepare("DELETE FROM bitacora WHERE CuentaCodigo=:Codigo");
			$sql->bindParam(":Codigo",$codigo);
			$sql->execute();
			return $sql;
		}

		public function encryption($string){
			$output="FALSE";
			$key=hash('sha256', SECRET_KEY);
			$iv= substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}

		protected function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}

		protected function generar_codigo_aleatorio($letra, $longitud, $num){
			for ($i=1; $i<=$longitud; $i++) { 
				$numero = rand(0,9); //obtener un # aleatorio rand
				$letra.= $numero; 
			}
			return $letra.$num;      //$letra."-".$num;
		}

		//MIO GERATE TOKEN
		//function generateToken($string)
		protected function generateToken($gt)
		{
			$gen = md5(uniqid(mt_rand(), false));	
			return $gen;
		}
		//-----------------------------------------
		protected function validaPassword($var1, $var2)
		{
			if (strcmp($var1, $var2) !== 0){
				return false;
				} else {
				return true;
			}
		}
		// ----------------------------------------

		protected function limpiar_cadena($cadena){ //Evitar inyeccion sql
			$cadena=trim($cadena); //trim elimina espacios en blanco _carlos _=espacio
			$cadena=stripcslashes($cadena); //quitar barras invertidas del string
			$cadena=str_ireplace("<script>", "", $cadena); //no le entendi
			$cadena=str_ireplace("</script>", "", $cadena); //elimina etiquetas de llava script
			$cadena=str_ireplace("<script src>", "", $cadena);
			$cadena=str_ireplace("<script type=>", "", $cadena);
			$cadena=str_ireplace("SELECT * FROM", "", $cadena); //Si alguien quiere hacer inyección sql
			$cadena=str_ireplace("DELETE * FROM", "", $cadena);
			$cadena=str_ireplace("INSERT INTO", "", $cadena);
			$cadena=str_ireplace("--", "", $cadena);
			$cadena=str_ireplace("[", "", $cadena);
			$cadena=str_ireplace("]", "", $cadena);
			$cadena=str_ireplace("==", "", $cadena);
			$cadena=str_ireplace(";", "", $cadena);
			return $cadena;
		}

		protected function sweet_alert($datos){
			if ($datos['Alerta']=="simple") {
				$alerta="
					<script>
						swal(
							'".$datos['Titulo']."',
							'".$datos['Texto']."',
							'".$datos['Tipo']."'
						)
					</script>
				";
			}elseif ($datos['Alerta']=="recargar") {
				$alerta="
					<script>
						swal({
							title: '".$datos['Titulo']."',
							text: '".$datos['Texto']."',
							type: '".$datos['Tipo']."',
							confirmButtonText: 'Aceptar'
							}).then(function () {
								location.reload();
							});
					</script>
				";
			}elseif ($datos['Alerta']=="recargarasig") {
				$alerta="
					<script>
						swal({
							title: '".$datos['Titulo']."',
							text: '".$datos['Texto']."',
							type: '".$datos['Tipo']."',
							confirmButtonText: 'Aceptar'
							}).then(function () {
								window.location.assign('".SERVERURL."asignacion/');
							});
					</script>
				";
			}elseif ($datos['Alerta']=="registrar") {
				$alerta="
					<script>
						swal({
							title: '".$datos['Titulo']."',
							text: '".$datos['Texto']."',
							type: '".$datos['Tipo']."',
							confirmButtonText: 'Aceptar e ir a Gmail'
							}).then(function () {
								window.location.assign('https://accounts.google.com/')
							});
					</script>
				";
			}elseif ($datos['Alerta']=="cambiar") {
				$alerta="
					<script>
						swal({
							title: '".$datos['Titulo']."',
							text: '".$datos['Texto']."',
							type: '".$datos['Tipo']."',
							confirmButtonText: 'Iniciar sesión'
							}).then(function () {
								window.location.assign('../login')
							});
					</script>
				";
			}elseif ($datos['Alerta']=="limpiar") {
				$alerta="
					<script>
						swal({
							title: '".$datos['Titulo']."',
							text: '".$datos['Texto']."',
							type: '".$datos['Tipo']."',
							confirmButtonText: 'Aceptar'
							}).then(function () {
								$('.FormularioAjax')[0].reset();
							});
					</script>
				";
			}
			return $alerta;
		}
	}