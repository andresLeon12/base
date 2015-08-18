<?php 

if (session_id()==null)
 		session_start();
	
include_once("../Conexion.class.php");

$conex = new Conexion;//instanciando la clase conexion

if(isset($_POST['Agregar'])){

	$nombre = $_POST["nombre"];
	$descripcion = $_POST["descripcion"];
	
	$duplicarRegistro =  json_decode($conex->get("SELECT * FROM rol where nombre='$nombre'"));
	if (count($duplicarRegistro) > 0) {
		$_SESSION["msj"] = "Error!. Ya existe este Rol.";
		header("location: inicio_admin.php");
		return;
	}

	$query  = "insert into rol(nombre,descripcion) values ('$nombre','$descripcion')";

	if ($conex->insert($query)) {
		$_SESSION["msj"] = "Rol Agregado Satisfactoriamente";
	}else{
		$_SESSION["msj"] = "Rol No Agregado";
	}

	header("location: inicio_admin.php");

}elseif (isset($_POST['Editar'])) {
		
		$id = $_POST["idRol"];
		$nombre = $_POST["nombre2"];
		$descripcion = $_POST["descripcion2"];
	
		$verificarRegistro =  json_decode($conex->get("SELECT * FROM rol where nombre='$nombre' and idRol=$id"));

		if (count($verificarRegistro) == 0)
		{
			$duplicarRegistro =  json_decode($conex->get("SELECT * FROM rol where nombre='$nombre'"));
			if (count($duplicarRegistro) > 0) {
				$_SESSION["msj"] = "Error!. Ya existe este Rol.";
				header("location: inicio_admin.php");
				return;
			}
		}
		
		$query = "update rol set nombre='$nombre',descripcion='$descripcion' where idRol=$id";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Rol editado satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Rol no editado";
		}	

		header("location: inicio_admin.php");//////////////////////////////////////////////////////////////////////

	}elseif (isset($_POST['Eliminar'])) {

		$idRol = $_POST['idRolForm'];
		$nomRol = $_POST['nombreRolForm'];
		
		$query  = "DELETE FROM rol WHERE idRol = $idRol";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Se ha borrado ".$nomRol;
		}else{
			$_SESSION["msj"] = "Hubo un error al borrar ".$nomRol;
		}
		header("location: inicio_admin.php");
	}

?>