 <?php
	if (session_id()==null)
 		session_start();
	include_once("../Conexion.class.php");
	
	//$accion = $_POST['accion'];

	$conex = new Conexion;

	if(isset($_POST['Agregar'])){
		$nombre = $_POST["nombre"];
		$descripcion = $_POST["descripcion"];
		$orden = $_POST["orden"];
		$idModelo = $_POST["modeloN"];

		$duplicarRegistro =  json_decode($conex->get("SELECT * FROM fase where (nombre='$nombre' or orden='$orden') and Modelo_P_idModelo_P=$idModelo"));
		if (count($duplicarRegistro) > 0) {
			$_SESSION["msj"] = "Error!. Ya existe esta Fase.";
			header("location: inicio_admin.php");
			return;
		}

		if($idModelo == 0){
			$_SESSION["msj"] = "Es necesario seleccionar un Modelo de Proceso. Asegurate de que existan Modelos de Proceso.";
			header("location: inicio_admin.php");
			return;
		}

		//$conex = new Conexion;
		

		$query  = "insert into fase(nombre,descripcion,orden,Modelo_P_idModelo_P) values ('$nombre','$descripcion','$orden',$idModelo)";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Fase Agregada Satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Fase No Agregada";
		}

		header("location: inicio_admin.php");

	}elseif (isset($_GET['getByModel'])) {
		# Obtenemos fases de un modelo
		//$conex = new Conexion;
		
		$query  = "SELECT idFase, nombre FROM fase WHERE Modelo_P_idModelo_P=".$_GET['getByModel'];

		echo $conex->get($query);
	}elseif (isset($_POST['Editar'])) {
		$nombre = $_POST["nombre2"];
		$descripcion = $_POST["descripcion2"];
		$orden = $_POST["orden2"];
		$idModelo = $_POST["modeloN2"];
		$idFase = $_POST["idFase"];//para editar esa fase en especifico

		//nombre,orden,idModelo
		$oldData = json_decode($conex->get("SELECT * FROM fase where idFase=$idFase"));
		$oldName = $oldData[0]->nombre;
		$oldOrden = $oldData[0]->orden;
		$oldModelo = $oldData[0]->Modelo_P_idModelo_P;

		if($oldName == $nombre && $orden == $oldOrden && $oldModelo == $idModelo){
			$query  = "update fase set nombre='$nombre',descripcion='$descripcion',orden='$orden',Modelo_P_idModelo_P=$idModelo where idFase=$idFase";

			if ($conex->insert($query)) {
				$_SESSION["msj"] = "Fase Editada Satisfactoriamente";
			}else{
				$_SESSION["msj"] = "Fase No Editada";
			}
		}else{
			$band = 0;
			if ($oldName != $nombre) {
				$duplicarRegistro =  json_decode($conex->get("SELECT * FROM fase where nombre='$nombre' and Modelo_P_idModelo_P=$idModelo"));			
				if (count($duplicarRegistro) > 0) {//el nombre no existe en la bd	
					$band++;
				}		
			}

			if ($oldOrden != $orden) {
				$duplicarRegistro =  json_decode($conex->get("SELECT * FROM fase where orden='$orden' and Modelo_P_idModelo_P=$idModelo"));			
				if (count($duplicarRegistro) > 0) {//el nombre no existe en la bd	
					$band++;
				}		
			}

			if ($oldModelo != $idModelo) {
				$duplicarRegistro =  json_decode($conex->get("SELECT * FROM fase where (nombre='$nombre' or orden='$orden' ) and Modelo_P_idModelo_P=$idModelo"));			
				if (count($duplicarRegistro) > 0) {//el nombre no existe en la bd	
					$band++;
				}	
			}

			if ($band == 0) {

				if($idModelo == 0){
					$_SESSION["msj"] = "Es necesario seleccionar un Modelo de Proceso. Asegurate de que existan Modelos de Proceso.";
					header("location: inicio_admin.php");
					return;
				}
				$query  = "update fase set nombre='$nombre',descripcion='$descripcion',orden='$orden',Modelo_P_idModelo_P=$idModelo where idFase=$idFase";
				if ($conex->insert($query)) {
					$_SESSION["msj"] = "Fase Editada Satisfactoriamente";
				}else{
					$_SESSION["msj"] = "Fase No Editada";
				}
			}else{
				$_SESSION["msj"] = "Fase No Editada";
			}
		}

		header("location: inicio_admin.php");


	}elseif (isset($_POST['eliminar'])) {
		$idFase = $_POST['idFaseForm'];
		$nomFase = $_POST['nombreFaseForm'];
		// Eliminammos en cascada
		if ($conex->deleteOnCascadeFase($idFase)) {
			$_SESSION["msj"] = "Se ha borrado ".$nomFase;
		}else{
			$_SESSION["msj"] = "Hubo un error al borrar ".$nomFase;
		}
		header("location: inicio_admin.php");
		/*$idFase = $_POST['idFaseForm'];
		$nomFase = $_POST['nombreFaseForm'];

		$query  = "SELECT idActividad FROM actividad WHERE Fase_idFase=".$idFase;
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
				$query  = "SELECT Entrada_idEntrada FROM act_ent WHERE Actividad_idActividad=".$idActividad;
				$consulta = json_decode($conex->getById($query));
				if(count($consulta) > 0){
					$query  = "DELETE FROM entrada WHERE idEntrada=".$consulta->Entrada_idEntrada;
					$conex->insert($query);
				}
				$query  = "SELECT Salida_idSalida FROM act_sal WHERE Actividad_idActividad=".$idActividad;
				$consulta = json_decode($conex->getById($query));
				if(count($consulta) > 0){
					$query  = "DELETE FROM salida WHERE idSalida=".$consulta->Salida_idSalida;
					$conex->insert($query);
				}
			}

		$query  = "DELETE FROM fase WHERE idFase = $idFase";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Se ha borrado ".$nomFase;
		}else{
			$_SESSION["msj"] = "Hubo un error al borrar ".$nomFase;
		}
		header("location: inicio_admin.php");*/

	}
 ?>