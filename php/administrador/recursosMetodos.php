<?php
 	if(session_id()==null)
		session_start();
	include_once("../Conexion.class.php");
	
	if (isset($_POST['Actualizar'])) {
		$conex = new Conexion;
		$id = $_POST['idRecurso'];
		$idActividad = $_POST['idActividad'];
		$idTipo = $_POST['tipo'];
		$carga_trabajo = $_POST['carga_trabajo'];
		$descripcion = $_POST['descripcion'];
		$nombre = $_POST['nombre'];
		if($idActividad == 'Selecciona una Actividad'){
			$_SESSION["msj"] = "Por favor selecciona una actividad";
			header("location: inicio_admin.php");
			return;
		}
		if (strpos($idTipo,'Selecciona') !== false) {
		    $_SESSION["msj"] = "Por favor selecciona un tipo de recurso";
			header("location: inicio_admin.php");
			return;
		}
		if($_POST['tipo_recurso'] == "fisico")
			$query = "UPDATE recursof SET nombre='$nombre',tipo='$idTipo',descripcion='$descripcion',carga_trabajo='$carga_trabajo' WHERE idRecursoFisico=$id";
		else
			$query = "UPDATE recursoh SET nombre='$nombre',tipo='$idTipo',carga_trabajo='$carga_trabajo' WHERE idRecursoHumano=$id";
		if ($conex->insert($query)) {
			if($_POST['tipo_recurso'] == "fisico"){
				$query = "UPDATE actividad_rf SET Actividad_idActividad = $idActividad";
			}else{
				$query = "UPDATE actividad_rh SET Actividad_idActividad = $idActividad";
			}
			if ($conex->insert($query)) {
				$_SESSION["msj"] = "Recurso Actualizado ";
			}else{
				$_SESSION["msj"] = "Recurso no Actualizado ";
			}
			
		}else{
			$_SESSION["msj"] = "Recurso no Actualizado ";
		}
		//return;
		header("location: inicio_admin.php");

	}elseif(isset($_POST['Agregar'])){
		$conex = new Conexion;
		$idActividad = $_POST['idActividad'];
		$idTipo = $_POST['tipo'];
		$carga_trabajo = $_POST['carga_trabajo'];
		$descripcion = $_POST['descripcion'];
		$nombre = $_POST['nombre'];/*
		$fecha_ini = $_POST['fecha_ini'];
		$fecha_fin = $_POST['fecha_fin'];*/
		if($idActividad == 'Selecciona una Actividad'){
			$_SESSION["msj"] = "Por favor selecciona una actividad";
			header("location: inicio_admin.php");
			return;
		}
		if (strpos($idTipo,'Selecciona') !== false) {
		    $_SESSION["msj"] = "Por favor selecciona un tipo de recurso";
			header("location: inicio_admin.php");
			return;
		}
		if($_POST['tipo_recurso'] == "fisico")
			$query = "INSERT INTO recursof VALUES(null,'$nombre','$idTipo','$descripcion','$carga_trabajo')";
		else
			$query = "INSERT INTO recursoh VALUES(null,'$nombre','$idTipo','$carga_trabajo')";
		if ($conex->insert($query)) {
			if($_POST['tipo_recurso'] == "fisico"){
				$query = "SELECT idRecursoFisico FROM recursof";
				$consulta = json_decode($conex->get($query));
				$id = $consulta[count($consulta)-1]->idRecursoFisico;
				$query = "INSERT INTO actividad_rf VALUES(null,$id,$idActividad)";
			}else{
				$query = "SELECT idRecursoHumano FROM recursoh";
				$consulta = json_decode($conex->get($query));
				$id = $consulta[count($consulta)-1]->idRecursoHumano;
				$query = "INSERT INTO actividad_rh VALUES(null,$id,$idActividad)";
			}
			if ($conex->insert($query)) {
					$_SESSION["msj"] = "Recurso Agregado Satisfactoriamente";
				}else{
					$_SESSION["msj"] = "Recurso no Agregado ";
				}
		}else{
			$_SESSION["msj"] = "Recurso no Agregado ";
		}
		//return;
		header("location: inicio_admin.php");
	}elseif (isset($_GET['type'])) {
		# obtendremos en forma de combo los modelos dados de alta
		$conex = new Conexion;
		
		$query  = "SELECT idModelo_P, nombreM FROM modelo_p";

		echo $conex->get($query);
	}elseif(isset($_POST['eliminar'])){
		$id = $_POST["idRecurso"];
		$nombre = $_POST['nombreRecurso'];
		$conex = new Conexion;
		if($_POST['tipo_recurso'] == "fisico")
			$query  = "DELETE FROM recursof WHERE idRecursoFisico = $id";
		else
			$query  = "DELETE FROM recursoh WHERE idRecursoHumano = $id";
		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Se ha borrado ".$nombre;
		}else{
			$_SESSION["msj"] = "Hubo un error al borrar ".$nombre;
		}
		header("location: inicio_admin.php");
	}

 ?>