<?php 
	class vistasModelo{
		protected function obtener_vistas_modelo($vistas){
			$listaBlanca=["home","menu","menuinfo","modulos","modulosinfo","privilegios","privilegiosinfo","municipio","municipioinfo","departamentos","departamentosinfo","empleados","empleadosinfo","estadosEmpleado","perfil","personal","perfilinfo","estadosEmpleadoinfo","estadosAdministrador","estadosAdministradorinfo","estadosHardwareasignacion","estadosHardwareasignacioninfo","estadosHardwareingreso","estadosHardwareingresoinfo","estadosHardware","estadosHardwareinfo","asignacion","asignacioninfo","asignadosinfo","asignados","asignadosinfo","estadosreasignacion","estadosreasignacioninfo","liberados","reasignacioninfo","reasignados","reasignadosinfo","tipohardware","tipohardwareinfo","marcashardware","marcashardwareinfo","modeloshardware","modeloshardwareinfo","coloreshardware","coloreshardwareinfo","informeingresohardware","informeingresoechazado","inforingresohardinfo","informacionharingreso","informeingresohareareinfo","estadosMantenimiento","estadosMantenimientoinfo","tiposMantenimiento","tiposMantenimientoinfo","cargos","cargosinfo","downloads","activos","administrador","administradorinfo","invoice","mantenimiento","mantenimientoinfo","manteentrega","mantenimientoreport","reparacion","dadodebaja","diagnosticoReporte","hardwareinfo","reasignadosempinfo","roles","rolesinfo"];
			if(in_array($vistas, $listaBlanca)){
				if(is_file("./vistas/contenidos/".$vistas."-view.php")){
					$contenido="./vistas/contenidos/".$vistas."-view.php";
				}else{
					$contenido="login";
				}
			}elseif($vistas=="login"){
				$contenido="login";
			}elseif($vistas=="recuperar"){
				$contenido="recuperar";
			}elseif($vistas=="cambiar"){
				$contenido="cambiar";
			}elseif($vistas=="registrar"){
				$contenido="registrar";
			}elseif($vistas=="activar"){
				$contenido="activar";
			}elseif($vistas=="index"){
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}
	}