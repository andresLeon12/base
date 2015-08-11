 <?php
	session_start();
	include_once("../Conexion.class.php");
	
	if (isset($_POST['actualizar'])) {
		
		$id = $_POST["idModelo"];
		$nombre = $_POST["nombreAct"];
		$descripcion = $_POST["descripcionAct"];
		$version = $_POST["versionAct"];

		$conex = new Conexion;

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


		$conex = new Conexion;
		

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
		$conex = new Conexion;
		
		$query  = "SELECT idModelo_P, nombreM FROM modelo_p";

		echo $conex->get($query);
	}elseif(isset($_GET['eliminar'])) {
		//echo $_GET['eliminar'];
		$idd = $_GET['idEliminar'];

		$conex = new Conexion;
		$query  = "SELECT idModelo_P, nombreM FROM modelo_p WHERE idModelo_P=$idd";
		$consulta = json_decode($conex->getById($query));
		$query  = "SELECT idFase FROM fase WHERE Modelo_P_idModelo_P=$idd";
		$consulta = json_decode($conex->getById($query));
		if(count($consulta) > 0){
			$query  = "SELECT idActividad FROM actividad WHERE Fase_idFase=".$consulta->idFase;
			$consulta = json_decode($conex->getById($query));
			if(count($consulta) > 0){
				$idActividad = $consulta->idActividad;
				$query  = "SELECT Guia_idGuia FROM a_guia WHERE Actividad_idActividad=".$idActividad;
				$consulta = json_decode($conex->getById($query));
				if(count($consulta) > 0){
					$query  = "DELETE FROM guia WHERE idGuia=".$consulta->Guia_idGuia;
					$conex->insert($query);
				}
				$query  = "SELECT Activo_idActivo FROM a_activo WHERE Actividad_idActividad=".$idActividad;
				$consulta = json_decode($conex->getById($query));
				if(count($consulta) > 0){
					$query  = "DELETE FROM activo WHERE idActivo=".$consulta->Activo_idActivo;
					$conex->insert($query);
				}
				$query  = "SELECT RecursoF_idRecursoFisico FROM actividad_rf WHERE Actividad_idActividad=".$idActividad;
				$consulta = json_decode($conex->getById($query));
				if(count($consulta) > 0){
					$query  = "DELETE FROM recursoF WHERE idRecursoFisico=".$consulta->RecursoF_idRecursoFisico;
					$conex->insert($query);
				}
				$query  = "SELECT RecursoH_idRecursoHumano FROM actividad_rh WHERE Actividad_idActividad=".$idActividad;
				$consulta = json_decode($conex->getById($query));
				if(count($consulta) > 0){
					$query  = "DELETE FROM recursoH WHERE idRecursoHumano=".$consulta->RecursoH_idRecursoHumano;
					$conex->insert($query);
				}
			}
		}
		$query  = "DELETE FROM modelo_p WHERE idModelo_P='$idd'";
		$_SESSION['pag_act'] = 'modelos'; /// crear sesion de modelos
		if ($conex->insert($query)) {

			$serv = $_SERVER['DOCUMENT_ROOT'] . '/base/archivos/'.$consulta->nombreM;
			if(file_exists($serv))
			{
			delTree ($serv);
			}
			$_SESSION["msj"] = "Modelo Eliminado";
		}else{
			$_SESSION["msj"] = "No se elimino el modelo";
		}
		$_SESSION["modelos"] = $conex->get("SELECT * FROM modelo_p");
		header("location: inicio_admin.php");
	}
    function delTree($dir) {
	    $files = array_diff(scandir($dir), array('.','..')); 
	    foreach ($files as $file) { 
	        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
	    } 
	    return rmdir($dir); 
	}
 ?>