<?php
 	if(session_id()==null)
		session_start();
	include_once("../Conexion.class.php");
	
	if (isset($_POST['Actualizar'])) {
		$conex = new Conexion;
		$id = $_POST['idRecurso'];
		$idActividad = $_POST['idActividad'];
		$idTipo = $_POST['tipo'];
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
		if($_POST['tipo_recurso'] == "fisico"){
			$ban = 0;
			$query = "SELECT * FROM recursof WHERE nombre='$nombre' and tipo='$idTipo'";
			$consulta = json_decode($conex->get($query));
			if(count($consulta) > 0){
				for($i=0;$i<count($consulta);$i++){
					$query = "SELECT * FROM actividad_rf WHERE RecursoF_idRecursoFisico=".$consulta[$i]->idRecursoFisico." and Actividad_idActividad=$idActividad";
					$consulta2 = json_decode($conex->get($query));
					if(count($consulta2) > 0){
						$ban++;
					}
				}
			}
			if($ban > 0){
				$_SESSION['msj'] = "Este recurso ya existe";
				header("location: inicio_admin.php");
				return;
			}
			$query = "UPDATE recursof SET nombre='$nombre',tipo='$idTipo',descripcion='$descripcion' WHERE idRecursoFisico=$id";
		}else{
			$ban = 0;
			$query = "SELECT * FROM recursoh WHERE nombre='$nombre' and tipo='$idTipo'";
			echo $query."<br>";
			$consulta = json_decode($conex->get($query));
			if(count($consulta) > 0){
				for($i=0;$i<count($consulta);$i++){
					$query = "SELECT * FROM actividad_rh WHERE RecursoH_idRecursoHumano=".$consulta[$i]->idRecursoHumano." and Actividad_idActividad=$idActividad";
					echo $query."<br>";
					$consulta2 = json_decode($conex->get($query));
					if(count($consulta2) > 0){
						echo "Encontrado ".$ban."<br>";
						$ban++;
					}
				}
				if($ban == count($consulta)){
					$_SESSION['msj'] = "Este recurso ya existe";
					header("location: inicio_admin.php");
					return;
				}
			}
			echo $ban."==".count($consulta);
			echo "<br>".$_SESSION['msj'];
			$query = "UPDATE recursoh SET nombre='$nombre',tipo='$idTipo' WHERE idRecursoHumano=$id";
		}
		if ($conex->insert($query)) {
			if($_POST['tipo_recurso'] == "fisico"){
				$query = "UPDATE actividad_rf SET Actividad_idActividad = $idActividad WHERE RecursoF_idRecursoFisico=$id";
			}else{
				$query = "UPDATE actividad_rh SET Actividad_idActividad = $idActividad WHERE RecursoH_idRecursoHumano=$id";
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
		if($_POST['tipo_recurso'] == "fisico"){
			$ban = 0;
			$query = "SELECT * FROM recursof WHERE nombre='$nombre' and tipo='$idTipo'";
			$consulta = json_decode($conex->get($query));
			if(count($consulta) > 0){
				for($i=0;$i<count($consulta);$i++){
					$query = "SELECT * FROM actividad_rf WHERE RecursoF_idRecursoFisico=".$consulta[$i]->idRecursoFisico." and Actividad_idActividad=$idActividad";
					$consulta2 = json_decode($conex->get($query));
					if(count($consulta2) > 0){
						$ban++;
					}
				}
			}
			if($ban > 0){
				$_SESSION['msj'] = "Este recurso ya existe";
				header("location: inicio_admin.php");
				return;
			}
			$query = "INSERT INTO recursof VALUES(null,'$nombre','$idTipo','$descripcion')";
		}else{
			$ban = 0;
			$query = "SELECT * FROM recursoh WHERE nombre='$nombre' and tipo='$idTipo'";
			$consulta = json_decode($conex->get($query));
			if(count($consulta) > 0){
				for($i=0;$i<count($consulta);$i++){
					$query = "SELECT * FROM actividad_rh WHERE RecursoH_idRecursoHumano=".$consulta[$i]->idRecursoHumano." and Actividad_idActividad=$idActividad";
					$consulta2 = json_decode($conex->get($query));
					if(count($consulta2) > 0){
						$ban++;
					}
				}
				if($ban == count($consulta)){
					$_SESSION['msj'] = "Este recurso ya existe";
					header("location: inicio_admin.php");
					return;
				}
			}
			$query = "INSERT INTO recursoh VALUES(null,'$nombre','$idTipo')";
		}
		//return;
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