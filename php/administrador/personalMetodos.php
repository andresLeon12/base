<?php  

if (session_id()==null) {
	session_start();
}

include_once("../Conexion.class.php");

$conex = new Conexion;//instanciando la clase conexion

if(isset($_POST['Agregar'])){

	$nombre = $_POST["nombre"];
	$apeP = $_POST['aP'];
	$apeM = $_POST['aM'];
	$email = $_POST['email'];
	$rol = $_POST['rol'];
	$habilidades = $_POST['habilidades'];

	if ($rol == 0) {
		$_SESSION["msj"] = "Para ingresar un personal es necesario que seleccione un Rol.";
		header("location: inicio_admin.php");
		return;
	}

	$query = "SELECT * FROM personal where nombre='$nombre' and apellidoP='$apeP' and apellidoM='$apeM' and correo_electronico='$email'";
	/*echo $query;
	return;*/
	$duplicarRegistro =  json_decode($conex->get($query));
	if (count($duplicarRegistro) > 0) {
		$_SESSION["msj"] = "Error!. Ya existe este personal.";
		header("location: inicio_admin.php");
		return;
	}

	$query  = "insert into personal(nombre,apellidoP,apellidoM,habilidades,correo_electronico) values ('$nombre','$apeP','$apeM','$habilidades','$email')";

	$tabla = "personal_rol";
	$campo_tabla1 = "Rol_idRol";
	$campo_tabla2 = "Personal_idPersonal";

	$booleano = $conex->insertTabRel($query,$tabla,$campo_tabla1,$campo_tabla2,$rol);
	//$booleano = $conex->insertAct($query,$idDependencia);

	if($booleano){
		$_SESSION["msj"] = "Personal agregado Satisfactoriamente";
	}else{
		$_SESSION["msj"] = "Personal no agregado";
	}

	header("location: inicio_admin.php");

}elseif (isset($_POST['Editar'])) {
		
	$id = $_POST["idPersonal"];
	$nombre = $_POST["nombre2"];
	$aP = $_POST["aP2"];
	$aM = $_POST["aM2"];
	$email = $_POST["email2"];
	$habilidades = $_POST["habilidades2"];
	$idRol = $_POST['rol2'];
	
	if ($idRol == 0) {
		$_SESSION["msj"] = "Para Editar un personal es necesario que seleccione un Rol.";
		header("location: inicio_admin.php");
		return;
	}

	$verificarRegistro =  json_decode($conex->get("SELECT * FROM personal where correo_electronico='$email' and idPersonal=$id"));

	if (count($verificarRegistro) == 0)
	{
		$query = "SELECT * FROM personal where correo_electronico='$email'";

		$duplicarRegistro =  json_decode($conex->get($query));
		if (count($duplicarRegistro) > 0) {
			$_SESSION["msj"] = "Error!. Ya existe este personal.";
			header("location: inicio_admin.php");
			return;
		}
	}
	
	//Antes que nada se verificará si en la relacion rol-personal se tiene algun dato
	$isExistDatos =  json_decode($conex->get("SELECT * FROM personal_rol where Personal_idPersonal=$id"));
	//$isExistDatos =  json_decode($conex->get("SELECT * FROM personal_rol"));
	if (count($isExistDatos) == 0) {
		$query  = "insert into personal_rol(Rol_idRol,Personal_idPersonal) values ($idRol,$id)";
		if (!$conex->insert($query)) {
			$_SESSION["msj"] = "Ocurrio un error al actualizar el personal";
			header("Location: inicio_admin.php");
			return;
		}		
	}else{
		//primero se hara el update a la relacion
		$query = "update personal_rol set Rol_idRol=$idRol,Personal_idPersonal=$id where Personal_idPersonal=$id";
		if (!$conex->insert($query)) {
			$_SESSION["msj"] = "Ocurrio un error al actualizar el personal";
			header("Location: inicio_admin.php");
			return;
		}
	}
	
	//echo $query;	
	//return;

	$query = "update personal set nombre='$nombre',apellidoP='$aP',apellidoM='$aM',correo_electronico='$email',habilidades='$habilidades' where idPersonal=$id";	
	
	if ($conex->insert($query)) {
		$_SESSION["msj"] = "Personal editado satisfactoriamente";
	}else{
		$_SESSION["msj"] = "Personal no editado";
	}	
	
	header("location: inicio_admin.php");//////////////////////////////////////////////////////////////////////

}elseif (isset($_POST['Eliminar'])) {

	$idPersonal = $_POST['idPersonalForm'];
	$nomPersonal = $_POST['nombrePersonalForm'];
		
	$query  = "DELETE FROM personal WHERE idPersonal = $idPersonal";

	if ($conex->insert($query)) {
		$_SESSION["msj"] = "Se ha borrado ".$nomPersonal;
	}else{
		$_SESSION["msj"] = "Hubo un error al borrar ".$nomPersonal;
	}
	header("location: inicio_admin.php");
}
?>