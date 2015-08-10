<?php
 	if(session_id()==null)
		session_start();
	include_once("../Conexion.class.php");
	
	if (isset($_POST['Actualizar'])) {
		
		$conex = new Conexion;
		$id = $_POST['id'];
		$idActividad = $_POST['idActividad'];
		$idModel = $_POST['idModel'];
		$descripcion = $_POST['descripcion'];
		$linkOld = $_SERVER['DOCUMENT_ROOT'] . '/base/archivos/'.$_POST['linkOldFile'];
		$nombre = explode("/",$_POST['linkOldFile']);
		$serv = $_SERVER['DOCUMENT_ROOT'] . '/base/archivos/'.$nombre[0]."/";
		$nombreFinal = "".$_POST['linkOldFile'];
		if (!empty($_FILES["activo"]) && $_FILES['activo']['size'] > 0) {
			if($_FILES["activo"]["type"]!="application/pdf"){
				$_SESSION["msj"] = "Lo sentimos solo archivos PDF";
				//header("location: inicio_admin.php");
			}
		    $archivo = $_FILES["activo"];
		    if ($archivo["error"] !== UPLOAD_ERR_OK) {
		        $_SESSION['msj'] = "Ha ocurrido un error.";
		        //header("location: inicio_admin.php");
		    }
		 
		    // ensure a safe filename
		    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $archivo["name"]);
		 	$nombreFinal = $nombre[0]."/".$name;
		 	
		    // preserve file from temporary directory
		    $success = move_uploaded_file($archivo["tmp_name"],
		        $serv . $name);
		    unlink($linkOld);
		    if (!$success) { 
		        echo "<p>No se pudo guardar.</p>";
		        exit;
		    }
		 
		    // set proper permissions on the new file
		    chmod($serv . $name, 0644);
		    
			//echo $_SESSION['msj'];
		}
		$query = "update activo set nombre='$nombreFinal', descripcion='$descripcion' where idactivo=$id";
		if ($conex->insert($query)) {
			$query = "UPDATE A_Activo SET Actividad_idActividad=$idActividad WHERE Activo_idActivo=$id";
			if ($conex->insert($query)) {
				$_SESSION["msj"] = "activo Actualizada Satisfactoriamente";
			}else{
				$_SESSION["msj"] = "activo no Actualizada ";
			}
		}else{
			$_SESSION["msj"] = "activo no Actualizada ";
		}
		header("location: inicio_admin.php");

	}elseif(isset($_POST['Agregar'])){
		$conex = new Conexion;
		$idActividad = $_POST['idActividad'];
		$idModel = $_POST['idModel'];
		$descripcion = $_POST['descripcion'];
		if($idActividad == 'Selecciona una Actividad'){
			$_SESSION["msj"] = "Por favor selecciona una actividad";
			header("location: inicio_admin.php");
			return;
		}
		$query  = "SELECT idModelo_P, nombreM FROM modelo_p WHERE idModelo_P=$idModel";
		$consulta = json_decode($conex->getById($query));
		$serv = $_SERVER['DOCUMENT_ROOT'] . '/base/archivos/'.$consulta->nombreM."/";
		if (!empty($_FILES["activo"])) {
		    $archivo = $_FILES["activo"];
		 	if($_FILES["activo"]["type"]!="application/pdf"){
				$_SESSION["msj"] = "Lo sentimos solo archivos PDF";
				header("location: inicio_admin.php");
			}
		    if ($archivo["error"] !== UPLOAD_ERR_OK) {
		        $_SESSION['msj'] = "Ha ocurrido un error.";
		        header("location: inicio_admin.php");
		    }
		 
		    // ensure a safe filename
		    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $archivo["name"]);
		 
		    // preserve file from temporary directory
		    $success = move_uploaded_file($archivo["tmp_name"],
		        $serv . $name);
		    if (!$success) { 
		        echo "<p>No se pudo guardar.</p>";
		        exit;
		    }
		 
		    // set proper permissions on the new file
		    chmod($serv . $name, 0644);
		    $serv = $consulta->nombreM."/".$name;
		    $query = "INSERT INTO activo VALUES(null,'$serv','$descripcion')";
		    if ($conex->insert($query)) {
				$query = "SELECT idActivo FROM activo";
				$consulta = json_decode($conex->get($query));
				$id = $consulta[count($consulta)-1]->idActivo;
				$query = "INSERT INTO A_Activo VALUES(null,$idActividad,$id)";
				//echo $query;
				if ($conex->insert($query)) {
					$_SESSION["msj"] = "Activo Agregado Satisfactoriamente";
				}else{
					$_SESSION["msj"] = "Activo no Agregado ";
				}
			}else{
				$_SESSION["msj"] = "Activo no Agregado";
			}
			//echo $_SESSION['msj'];
		}
		$_FILES['guia'] = null;
		header("location: inicio_admin.php");
	}elseif (isset($_GET['type'])) {
		# obtendremos en forma de combo los modelos dados de alta
		$conex = new Conexion;
		
		$query  = "SELECT idModelo_P, nombreM FROM modelo_p";

		echo $conex->get($query);
	}elseif(isset($_POST['eliminar'])){
		$id = $_POST["idActivo"];
		$nombre = $_POST['nombreActivo'];
		$conex = new Conexion;
		$query  = "DELETE FROM activo WHERE idactivo = $id";
		if ($conex->insert($query)) {
			unlink($_SERVER['DOCUMENT_ROOT'].'/base/archivos/'.$nombre);
			$nombre = explode("/", $nombre);
			$_SESSION["msj"] = "Se ha borrado ".$nombre[1];
		}else{
			$_SESSION["msj"] = "Hubo un error al borrar ".$nombre[1];
		}
		header("location: inicio_admin.php");
	}

 ?>