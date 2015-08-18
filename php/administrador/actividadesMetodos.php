 <?php
 	if(session_id()==null)
		session_start();
	include_once("../Conexion.class.php");
	
	$conex = new Conexion;
	$_SESSION['pag_act'] = 'actividades';
	//cuando se edita algun dato de actividades
	if (isset($_POST['Actualizar'])) {
		
		$id = $_POST["id"];
		$nombre = $_POST["nombre"];
		$descripcion = $_POST["descripcion"];
		$tipo = $_POST["tipo"];
		$fase = $_POST["idFase"];
		if(isset($_POST['idModel']))
			$idMedida = $_POST["idMedida"];
		else
			$idMedida = 0;
		$identificador = $_POST["identificador"];


		/* ------ */
		$oldData = json_decode($conex->get("SELECT * FROM actividad where idActividad=$id"));
		$oldName = $oldData[0]->nombre;
		//$oldOrden = $oldData[0]->orden;
		$oldFase = $oldData[0]->Fase_idFase;
		$oldIdentificador = $oldData[0]->identificador;

		if($idMedida==0){
			$query = "DELETE FROM actmed WHERE Actividad_idActividad=$id";
			$conex->insert($query);
		}else{
			$query = "update actmed set Medida_idMedida=$idMedida where Actividad_idActividad=$id";
			if($conex->insert($query)==0){
				$query = "INSERT INTO actmed(Actividad_idActividad,Medida_idMedida) VALUES($id,$idMedida)";
				echo "<br>".$query;
				$conex->insert($query);
			}
		}

		//if($oldName == $nombre && $oldFase == $id && $oldIdentificador == $identificador){//Si es el mismo nombre y la misma fase
		if($oldName == $nombre && $oldFase == $id){//Si es el mismo nombre y la misma fase
			echo "Iguales<br>";
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
			$duplicarRegistro =  json_decode($conex->get("SELECT * FROM actividad where identificador='$identificador'"));
			if (count($duplicarRegistro) > 0) {
				$_SESSION["msj"] = "Error!. Ya existe esta actividad.";
				header("location: inicio_admin.php");
				return;
			}
			$query = "";

			$query = "update actividad set nombre='$nombre',descripcion='$descripcion',tipo='$tipo', Fase_idFase=$fase, identificador='$identificador' where idActividad=$id";
			if ($conex->insert($query)) {
				$_SESSION["msj"] = "Actividad ".$nombre." editada satisfactoriamente";
			}else{
				$_SESSION["msj"] = "Actividad ".$nombre." no editada";
			}
		}else{
			$band = 0;
			if ($oldName != $nombre || $oldFase != $fase || $oldIdentificador != $identificador) {
				echo $oldIdentificador."!=".$identificador;
				$duplicarRegistro =  json_decode($conex->get("SELECT * FROM actividad where nombre='$nombre' and Fase_idFase=$fase and identificador=$identificador"));			
				echo "<br>".$query;
				if (count($duplicarRegistro) > 0) {//el nombre no existe en la bd	
					$band++;
				}
				$duplicarRegistro =  json_decode($conex->get("SELECT * FROM actividad where identificador='$identificador' and idActividad!=$id"));
				if (count($duplicarRegistro) > 0) {
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

				$query = "update actividad set nombre='$nombre',descripcion='$descripcion',tipo='$tipo', Fase_idFase=$fase, identificador='$identificador' where idActividad=$id";
				echo $conex->insert($query);
				$_SESSION["msj"] = "Actividad Editada Satisfactoriamente";
			}else{
				$_SESSION["msj"] = "Actividad No Editada";
			}
		}
		$_SESSION['seccion_act'] = 'resultados';
		header("location: inicio_admin.php");

	}elseif(isset($_POST['Agregar'])){//cuando se agrega una nueva actividad

		$nombre = $_POST["nombre"];
		$descripcion = $_POST["descripcion"];
		$tipo = $_POST["tipo"];
		$fase = $_POST["idFase"];
		$idMedida = $_POST['idMedida'];
		$identificador = $_POST['identificador'];
		$descripcionGuia = $_POST['descripcionGuia'];
		$descripcionActivo = $_POST['descripcionActivo'];
		$idModel = $_POST['idModel'];
		$_SESSION['seccion_act'] = 'Formulario';
		//Verificar que la actividad no exista
		$duplicarRegistro =  json_decode($conex->get("SELECT * FROM actividad where nombre='$nombre' and Fase_idFase=$fase"));
		if (count($duplicarRegistro) > 0) {
			$_SESSION["msj"] = "Error!. Ya existe esta actividad.";
			header("location: inicio_admin.php");
			return;
		}
		$duplicarRegistro =  json_decode($conex->get("SELECT * FROM actividad where identificador='$identificador'"));
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
		
		$query  = "insert into actividad(nombre,descripcion,tipo,Fase_idFase,identificador) values ('$nombre','$descripcion','$tipo',$fase,'$identificador')";
		if ($idDependencia == 0) {//la actividad no depende de otra, es independiente
			$last_id = $conex->insertAct($query,null,$idMedida);
			if ($last_id != null) {
				if(!empty($_FILES["guia"]) && $_FILES["guia"]!=null)
					$conex->addFile($_FILES['guia'],'guia',$descripcionGuia,$descripcionActivo,$last_id,$idModel);
				if(!empty($_FILES["activo"]) && $_FILES['activo']!=null)
					$conex->addFile($_FILES['activo'],'activo',$descripcionGuia,$descripcionActivo,$last_id,$idModel);
				$_SESSION["msj"] = "Actividad agregada Satisfactoriamente";
			}else{
				$_SESSION["msj"] = "Actividad no agregada";
			}
			
		}else{
			
			$tabla = "dependencia";
			$campo_tabla1 = "depende_De";
			$campo_tabla2 = "Actividad_idActividad";
			$booleano = $conex->insertTabRelAct($query,$tabla,$campo_tabla1,$campo_tabla2,$idDependencia,$idMedida);
			//$booleano = $conex->insertAct($query,$idDependencia);

			if($booleano != null){
				if(!empty($_FILES["guia"]) && $_FILES["guia"]!=null)
					$conex->addFile($_FILES['guia'],'guia',$descripcionGuia,$descripcionActivo,$booleano,$idModel);
				if(!empty($_FILES["activo"]) && $_FILES['activo']!=null)
					$conex->addFile($_FILES['activo'],'activo',$descripcionGuia,$descripcionActivo,$booleano,$idModel);
				//$conex->addFile($_FILES['activo'],'activo',$descripcionGuia,$descripcionActivo,$booleano,$idModel);
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
		$_SESSION['seccion_act'] = 'resultados';
		header("location: inicio_admin.php");
		
	}elseif (isset($_GET['getByFase'])) {
		# Obtenemos fases de un modelo
		//$conex = new Conexion;
		
		$query  = "SELECT idActividad, nombre FROM actividad WHERE Fase_idFase=".$_GET['getByFase'];
		echo $conex->get($query);
	}elseif (isset($_GET['getCountAct'])) {
		//SELECT COUNT(genero) AS cantidad FROM prueba WHERE genero = 'F';
		$query  = "SELECT count(*) as cantidad FROM actividad WHERE Fase_idFase=".$_GET['getCountAct'];
		echo $conex->get($query);
		//return;
	}

 ?>