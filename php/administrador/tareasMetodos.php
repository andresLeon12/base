 <?php
	if (session_id()==null)
 		session_start();
	include_once("../Conexion.class.php");

	if(isset($_POST['Agregar'])){
		$nombre = $_POST["nombre"];
		$descripcion = $_POST["descripcion"];
		$idActividad = $_POST["actividadN"];

		if($idActividad == 0){
			$_SESSION["msj"] = "Es necesario seleccionar un Actividad. Asegurate de que existan Actividades.";
			header("location: inicio_admin.php");
			return;
		}

		$conex = new Conexion;
		$query = "SELECT * FROM tarea WHERE nombre='$nombre' and Actividad_idActividad=$idActividad";
		$consulta = json_decode($conex->get($query));
		if(count($consulta) > 0){
			$_SESSION['msj'] = "Esta tarea ya existe";
			header("location: inicio_admin.php");
			return;
		}

		$query  = "insert into tarea(nombre,descripcion,Actividad_idActividad) values ('$nombre','$descripcion',$idActividad)";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Tarea Agregada Satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Tarea No Agregada";
		}

		header("location: inicio_admin.php");
	}elseif (isset($_POST['Editar'])) {
		$nombre = $_POST["nombre2"];
		$descripcion = $_POST["descripcion2"];
		$idActividad = $_POST["actividadN2"];
		$idTarea = $_POST["idTarea"];//para editar esa fase en especifico

		if($idActividad == 0){
			$_SESSION["msj"] = "Es necesario seleccionar una Actividad. Asegurate de que existan Actividades.";
			header("location: inicio_admin.php");
			return;
		}

		$conex = new Conexion;
		$query = "SELECT * FROM tarea WHERE nombre='$nombre' and Actividad_idActividad=$idActividad";
		$consulta = json_decode($conex->get($query));
		if(count($consulta) > 0){
			$_SESSION['msj'] = "Esta tarea ya existe";
			header("location: inicio_admin.php");
			return;
		}
		$query  = "update tarea set nombre='$nombre',descripcion='$descripcion',Actividad_idActividad=$idActividad where idTarea=$idTarea";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Tarea Editada Satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Tarea No Editada";
		}

		header("location: inicio_admin.php");
	}elseif (isset($_POST['eliminar'])) {
		$idTarea = $_POST['idTareaForm'];
		$nombreTarea = $_POST['nombreTareaForm'];

		$conex = new Conexion;

		$query  = "DELETE FROM tarea WHERE idTarea = $idTarea";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Se ha borrado ".$nombreTarea;
		}else{
			$_SESSION["msj"] = "Hubo un error al borrar ".$nombreTarea;
		}
		header("location: inicio_admin.php");
	}

?>