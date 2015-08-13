 <?php
	session_start();
	include_once("../Conexion.class.php");
	
	$conex = new Conexion;

	if (isset($_POST['actualizar'])) {
		
		$id = $_POST["idModelo"];
		$nombre = $_POST["nombreAct"];
		$descripcion = $_POST["descripcionAct"];
		$version = $_POST["versionAct"];

		$duplicarRegistro =  json_decode($conex->get("SELECT * FROM modelo_p where nombreM='$nombre' and descripcion='$descripcion' and version='$version'"));
		if (count($duplicarRegistro) > 0) {
			$_SESSION["msj"] = "Error!. Ya existe este Modelo con esta versión.";
			header("location: inicio_admin.php");
			return;
		}

		$query = "update modelo_p set nombreM='$nombre',descripcion='$descripcion',version='$version' where idModelo_P=$id";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Modelo editado satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Modelo no editado";
		}

		$_SESSION["modelos"] = $conex->get("SELECT * FROM modelo_p");
		header("location: inicio_admin.php");//////////////////////////////////////////////////////////////////////

	}elseif(isset($_POST['Agregar'])){
		$nombre = $_POST["nombre"];
		$descripcion = $_POST["descripcion"];
		$version = $_POST["version"];

		$duplicarRegistro =  json_decode($conex->get("SELECT * FROM modelo_p where nombreM='$nombre' and version='$version'"));
		if (count($duplicarRegistro) > 0) {
			$_SESSION["msj"] = "Error!. Ya existe este Modelo con esta versión.";
			header("location: inicio_admin.php");
			return;
		}

		//$conex = new Conexion;
		

		$query  = "insert into modelo_p(nombreM,descripcion,version) values ('$nombre','$descripcion','$version')";
		$_SESSION['pag_act'] = 'modelos'; /// crear sesion de modelos
		if ($conex->insert($query)) {
			$serv = $_SERVER['DOCUMENT_ROOT'] . '/base/archivos/';
			if(!file_exists($serv))
			{
			mkdir ($serv);
			} 
			$ruta = $serv . $nombre;
			if(!file_exists($ruta))
			{
			mkdir ($ruta);
			} 
			$_SESSION["msj"] = "Modelo Agregado Satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Modelo No Agregado";
		}
		$_SESSION["modelos"] = $conex->get("SELECT * FROM modelo_p");
		header("location: inicio_admin.php");
	}elseif (isset($_GET['type'])) {
		# obtendremos en forma de combo los modelos dados de alta
		//$conex = new Conexion;
		
		$query  = "SELECT idModelo_P, nombreM FROM modelo_p";

		echo $conex->get($query);
	}elseif(isset($_GET['eliminar'])) {
		$idd = $_GET['idEliminar'];
		$_SESSION['pag_act'] = 'modelos'; /// crear sesion de modelos
		// Eliminammos en cascada
		if ($conex->deleteOnCascadeModel($idd)) {
			$_SESSION["msj"] = "Modelo Eliminado";
		}else{
			$_SESSION["msj"] = "No se elimino el modelo";
		}
		header("location: inicio_admin.php");
	}

 ?>