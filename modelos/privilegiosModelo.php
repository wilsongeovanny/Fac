<?php
	if ($peticionAjax) {
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}  

	class privilegiosModelo extends mainModel{
		protected function agregar_privilegios_modelo($datos){
			$query=mainModel::conectar()->prepare("INSERT INTO modulo_menu(MODMENUCODIGO,MENUCODIGO,MODULOCODIGO) VALUES(:CODIGO,:MENU,:MODULO)");
			$query->bindParam(":CODIGO",$datos['CODIGO']);
			$query->bindParam(":MENU",$datos['MENU']);
			$query->bindParam(":MODULO",$datos['MODULO']);
			$query->execute();
			return $query;
		}

		protected function datos_privilegios_modelo($tipo,$codigo){
			if ($tipo=="Unico") {
				$query=mainModel::conectar()->prepare("SELECT * FROM modulo_menu WHERE MODMENUCODIGO=:CODIGO");
				$query->bindParam(":CODIGO",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT MODMENUCODIGO FROM modulo_menu");
			}elseif($tipo=="Select"){
				$query=mainModel::conectar()->prepare("SELECT EMPRESACODIGO,EMPRESANOMBRE FROM empresa ORDER BY EMPRESANOMBRE ASC");
			}elseif($tipo=="Modulos"){
				$query=mainModel::conectar()->prepare("SELECT * FROM modulo ORDER BY MODULONOMBRE ASC");
			}elseif($tipo=="Menus"){
				$query=mainModel::conectar()->prepare("SELECT * FROM menu ORDER BY MENUNOMBRE ASC");
			}
			$query->execute();
			return $query;
		}

		protected function eliminar_privilegios_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM empresa WHERE EmpresaCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		/*protected function actualizar_empresa_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE empresa SET EmpresaCodigo=:Codigo,EmpresaNombre=:Nombre,EmpresaTelefono=:Telefono,EmpresaEmail=:Email,EmpresaDireccion=:Direccion,EmpresaDirector=:Director,EmpresaMoneda=:Moneda,EmpresaYear=:Year WHERE id=:ID");
			$query->bindParam("Codigo",$datos['Codigo']);
			$query->bindParam("Nombre",$datos['Nombre']);
			$query->bindParam("Telefono",$datos['Telefono']);
			$query->bindParam("Email",$datos['Email']);
			$query->bindParam("Direccion",$datos['Direccion']);
			$query->bindParam("Director",$datos['Director']);
			$query->bindParam("Moneda",$datos['Moneda']);
			$query->bindParam("Year",$datos['Year']);
			$query->bindParam("ID",$datos['ID']);
			$query->execute();
			return $query;
		}*/

		protected function actualizar_privilegios_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE modulo_menu SET MENUCODIGO=:MENU,MODULOCODIGO=:MODULO WHERE MODMENUCODIGO=:CODIGO");
			$query->bindParam("MENU",$datos['MENU']);
			$query->bindParam("MODULO",$datos['MODULO']);
			$query->bindParam("CODIGO",$datos['CODIGO']);
			$query->execute();
			return $query;
		}
	}