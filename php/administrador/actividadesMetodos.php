 <?php
 	if(session_id()==null)
		session_start();
	include_once("../Conexion.class.php");
	
	$conex = new Conexion;

	//cuando se edita algun dato de actividades
	if (isset($_POST['Actualizar'])) {
		
		$id = $_POST["id"];
		$nombre = $_POST["nombre"];
		$descripcion = $_POST["descripcion"];
		$tipo = $_POST["tipo"];
		$fase = $_POST["idFase"];


		/* ------ */
		$oldData = json_decode($conex->get("SELECT * FROM actividad where idActividad=$id"));
		$oldName = $oldData[0]->nombre;
		//$oldOrden = $oldData[0]->orden;
		$oldFase = $oldData[0]->Fase_idFase;

		if($oldName == $nombre && $oldFase == $id){//Si es el mismo nombre y la misma fase

			$queryVer = "select * from dependencia where Actividad_idActividad=$id";
			$band =  json_decode($conex->get($queryVer));

			if (isset($_POST['dependencia']) && $_POST['dependencia'] > 0) {
				$idDependencia = $_POST['dependencia'];
				if (count($band) == 0) {
					$query  = "insert into dependencia(depende_De,Actividad_idActividad) values ($idDependencia,$id)";
					$conex->insert($query);	
				}else{
					//$idDependencia = $_POST['dependencia'];
					$query = "update dependencia set depende_De=$idDependencia where Actividad_idActividad=$id";
					$conex->insert($query);			
				}
			}else{
				$idDependencia = 0;
				$query  = "DELETE FROM dependencia WHERE Actividad_idActividad = $id";
				$booleano = $conex->insert($query);
			}


			if($fase == "Selecciona una fase" || $fase == "Lo sentimos aun no hay fases"){
				$_SESSION["msj"] = "Es necesario seleccionar una fase. Asegurate de que existan fases en este modelo.";
				header("location: inicio_admin.php");
				return;
			}

			$query = "";

			$query = "update actividad set nombre='$nombre',descripcion='$descripcion',tipo='$tipo', Fase_idFase=$fase where idActividad=$id";

			if ($conex->insert($query)) {
				$_SESSION["msj"] = "Actividad ".$nombre." editada satisfactoriamente";
			}else{
				$_SESSION["msj"] = "Actividad ".$nombre." no editada";
			}

		}else{
			$band = 0;
			if ($oldName != $nombre || $oldFase != $fase) {
				$duplicarRegistro =  json_decode($conex->get("SELECT * FROM actividad where nombre='$nombre' and Fase_idFase=$fase"));			
				if (count($duplicarRegistro) > 0) {//el nombre no existe en la bd	
					$band++;
				}		
			}

			if ($band == 0) {

				$queryVer = "select * from dependencia where Actividad_idActividad=$id";
				$band =  json_decode($conex->get($queryVer));

				if (isset($_POST['dependencia']) && $_POST['dependencia'] > 0) {
					$idDependencia = $_POST['dependencia'];
					if (count($band) == 0) {
						$query  = "insert into dependencia(depende_De,Actividad_idActividad) values ($idDependencia,$id)";
						$conex->insert($query);	
					}else{
						//$idDependencia = $_POST['dependencia'];
						$query = "update dependencia set depende_De=$idDependencia where Actividad_idActividad=$id";
						$conex->insert($query);			
					}
				}else{
					$idDependencia = 0;
					$query  = "DELETE FROM dependencia WHERE Actividad_idActividad = $id";
					$booleano = $conex->insert($query);
				}


				if($fase == "Selecciona una fase" || $fase == "Lo sentimos aun no hay fases"){
					$_SESSION["msj"] = "Es necesario seleccionar una fase. Asegurate de que existan fases en este modelo.";
					header("location: inicio_admin.php");
					return;
				}

				$query = "";

				$query = "update actividad set nombre='$nombre',descripcion='$descripcion',tipo='$tipo', Fase_idFase=$fase where idActividad=$id";

				if ($conex->insert($query)) {
					$_SESSION["msj"] = "Actividad ".$nombre." editada satisfactoriamente";
				}else{
					$_SESSION["msj"] = "Actividad ".$nombre." no editada";
				}

			}else{
				$_SESSION["msj"] = "Actividad No Editada";
			}
		}

		/* ------ */

		header("location: inicio_admin.php");

	}elseif(isset($_POST['Agregar'])){//cuando se agrega una nueva actividad

		$nombre = $_POST["nombre"];
		$descripcion = $_POST["descripcion"];
		$tipo = $_POST["tipo"];
		$fase = $_POST["idFase"];
		$medida = $_POST['idMedida'];

		//Verificar que la actividad no exista
		$duplicarRegistro =  json_decode($conex->get("SELECT * FROM actividad where nombre='$nombre' and Fase_idFase=$fase"));
		if (count($duplicarRegistro) > 0) {
			$_SESSION["msj"] = "Error!. Ya existe esta actividad.";
			header("location: inicio_admin.php");
			return;
		}
		
		//$idDependencia = $_POST['dependencia'];

		if (isset($_POST['dependencia'])) {
			$idDependencia = $_POST['dependencia'];			
		}else{
			$idDependencia = 0;
		}

		if($fase == "Selecciona una fase" || $fase == "Lo sentimos aun no hay fases"){
			$_SESSION["msj"] = "Es necesario seleccionar una fase. Asegurate de que existan fases en este modelo.";
			header("location: inicio_admin.php");
			return;
		}
		
		$query  = "insert into actividad(nombre,descripcion,tipo,Fase_idFase) values ('$nombre','$descripcion','$tipo',$fase)";

		if ($idDependencia == 0) {//la actividad no depende de otra, es independiente
			
			if ($conex->insert($query)) {
				$_SESSION["msj"] = "Actividad agregada Satisfactoriamente";
			}else{
				$_SESSION["msj"] = "Actividad no agregada";
			}			
		}else{

			$booleano = $conex->insertAct($query,$idDependencia);

			if($booleano){
				$_SESSION["msj"] = "Actividad agregada Satisfactoriamente";
			}else{
				$_SESSION["msj"] = "Actividad no agregada";
			}
		}
		
		header("location: inicio_admin.php");

	}elseif (isset($_GET['type'])) {
		# obtendremos en forma de combo los modelos dados de alta
		//$conex = new Conexion;
		
		$query  = "SELECT idModelo_P, nombreM FROM modelo_p";

		echo $conex->get($query);

	}elseif(isset($_POST['eliminar'])){
		
		//Checar este metodo,hacer un trigger

		$id = $_POST["idActividad"];
		$nomFase = $_POST['nombreAct'];
		// Eliminammos en cascada
		if ($conex->deleteOnCascadeActividad($id)) {
			$_SESSION["msj"] = "Se ha borrado ".$nomFase;
		}else{
			$_SESSION["msj"] = "Hubo un error al borrar ".$nomFase;
		}
		echo $_SESSION['msj'];
		header("location: inicio_admin.php");
	}elseif (isset($_GET['getByFase'])) {
		# Obtenemos fases de un modelo
		//$conex = new Conexion;
		
		$query  = "SELECT idActividad, nombre FROM actividad WHERE Fase_idFase=".$_GET['getByFase'];
		echo $conex->get($query);
	}

 ?>