<?php 

	class cargosControladores{

		public function datos_cargos_ajax_controlador($DEPARTAMENTOCODIGO){

			$link = mysqli_connect("localhost", "root", "");
			mysqli_select_db($link, "50");
			$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
			$consulta=sprintf("select * from departemento where EMPRESACODIGO	='%s'",$DEPARTAMENTOCODIGO);
			$result = mysqli_query($link, $consulta);

		return $result;
		}

		public function datos_empleados_ajax_controlador($CARGOCODIGO){

			$link = mysqli_connect("localhost", "root", "");
			mysqli_select_db($link, "50");
			$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
			$consulta=sprintf("select * from cargo where DEPARTAMENTOCODIGO	='%s'",$CARGOCODIGO);
			$result = mysqli_query($link, $consulta);

		return $result;
		}

		public function datos_usuarios_ajax_controlador($EMPLEADOCODIGO){

			$link = mysqli_connect("localhost", "root", "");
			mysqli_select_db($link, "50");
			$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
			$consulta=sprintf("select * from empleados where CARGOCODIGO	='%s'",$EMPLEADOCODIGO);
			$result = mysqli_query($link, $consulta);

		return $result;
		}

		public function datos_marcas_ajax_controlador($MARCAHARDWARECODIGO){

			$link = mysqli_connect("localhost", "root", "");
			mysqli_select_db($link, "50");
			$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
			$consulta=sprintf("select * from marca_hardware where TIPOHARDWARECODIGO='%s'",$MARCAHARDWARECODIGO);
			$result = mysqli_query($link, $consulta);

		return $result;
		}

		public function datos_modelos_ajax_controlador($MODELOHARDWARECODIGO){

			$link = mysqli_connect("localhost", "root", "");
			mysqli_select_db($link, "50");
			$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
			$consulta=sprintf("select * from modelo_hardware where MARCAHARDWARECODIGO	='%s'",$MODELOHARDWARECODIGO);
			$result = mysqli_query($link, $consulta);

		return $result;
		}


		public function datos_buscar_controlador($EMPLEADOCODIGO){

			$link = mysqli_connect("localhost", "root", "");
			mysqli_select_db($link, "50");
			$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
			$consulta=sprintf("select * from empleados where EMPLEADOCODIGO	='%s'",$EMPLEADOCODIGO);
			$result = mysqli_query($link, $consulta);

		return $result;
		}


		public function insertar($materia_id, $pregunta, $res_1, $res_2, $res_3, $res_4, $res_verdad){

			$link = mysqli_connect("localhost", "root", "");
			mysqli_select_db($link, "sevilla");
			$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
			$consulta=sprintf("INSERT INTO preguntas (materia_id, pregunta, res_1, res_2, res_3, res_4, res_verdad) values ('%s','%s','%s','%s','%s','%s','%s')",$materia_id, $pregunta, $res_1, $res_2, $res_3, $res_4, $res_verdad);
			$result = mysqli_query($link, $consulta);
			echo($consulta);

		//return $result;
		}

	}