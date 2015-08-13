<?php
 	if(session_id()==null)
		session_start();
	include_once("../Conexion.class.php");
	
	if (isset($_POST['Actualizar'])) {
		
		$conex = new Conexion;
		$id = $_POST['id'];
		$idActividad = $_POST['idActividad'];
		$idModel = $_POST['idModel'];
		$tipo = $_POST['tipo'];
		$linkOld = $_SERVER['DOCUMENT_ROOT'] . '/base/archivos/'.$_POST['linkOldFile'];
		$nombre = explode("/",$_POST['linkOldFile']);
		$serv = $_SERVER['DOCUMENT_ROOT'] . '/base/archivos/'.$nombre[0]."/";
		$nombreFinal = "".$_POST['linkOldFile'];
		if (!empty($_FILES["guia"]) && $_FILES['guia']['size'] > 0) {
			if($_FILES["guia"]["type"]!="application/pdf"){
				$_SESSION["msj"] = "Lo sentimos solo archivos PDF";
				return;
			}
		    $archivo = $_FILES["guia"];
		 	echo $id;
		    if ($archivo["error"] !== UPLOAD_ERR_OK) {
		        $_SESSION['msj'] = "Ha ocuurido un error.";
		        header("location: inicio_admin.php");
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
		$query = "update guia set nombre='$nombreFinal', tipo='$tipo' where idGuia=$id";
		if ($conex->insert($query)) {
			$query = "UPDATE A_Guia SET Actividad_idActividad=$idActividad WHERE Guia_idGuia=$id";
			if ($conex->insert($query)) {
				$_SESSION["msj"] = "Guia Actualizada Satisfactoriamente";
			}else{
				$_SESSION["msj"] = "Guia no Actualizada ";
			}
		}else{
			$_SESSION["msj"] = "Guia no Actualizada ";
		}
		header("location: inicio_admin.php");

	}elseif(isset($_POST['Agregar'])){
		$conex = new Conexion;
		$idActividad = $_POST['idActividad'];
		$idModel = $_POST['idModel'];
		$tipo = $_POST['tipo'];
		if($idActividad == 'Selecciona una Actividad'){
			$_SESSION["msj"] = "Por favor selecciona una actividad";
			header("location: inicio_admin.php");
			return;
		}
		$query  = "SELECT idModelo_P, nombreM FROM modelo_p WHERE idModelo_P=$idModel";
		$consulta = json_decode($conex->getById($query));
		$serv = $_SERVER['DOCUMENT_ROOT'] . '/base/archivos/'.$consulta->nombreM."/";
		if (!empty($_FILES["guia"])) {
		    $archivo = $_FILES["guia"];
		 	if($_FILES["guia"]["type"]!="application/pdf"){
				$_SESSION["msj"] = "Lo sentimos solo archivos PDF";
				header("location: inicio_admin.php");
			}
		    if ($archivo["error"] !== UPLOAD_ERR_OK) {
		        $_SESSION['msj'] = "Ha ocuurido un error.";
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
		    $query = "INSERT INTO guia VALUES(null,'$serv','$tipo')";
		    if ($conex->insertTabRel($query,"A_Guia","Actividad_idActividad","Guia_idGuia",$idActividad)) {
				$_SESSION["msj"] = "Guia Agregada Satisfactoriamente";
			}else{
				$_SESSION["msj"] = "Guia no Agregada ";
			}
		}
		header("location: inicio_admin.php");
	}elseif (isset($_GET['type'])) {
		# obtendremos en forma de combo los modelos dados de alta
		$conex = new Conexion;
		
		$query  = "SELECT idModelo_P, nombreM FROM modelo_p";

		echo $conex->get($query);
	}elseif(isset($_POST['eliminar'])){
		$id = $_POST["idGuia"];
		$nombre = $_POST['nombreGuia'];
		$conex = new Conexion;
		$query  = "DELETE FROM guia WHERE idGuia = $id";
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