 <?php
	if (session_id()==null)
 		session_start();
	include_once("../Conexion.class.php");
	
	//$accion = $_POST['accion'];

	if(isset($_POST['Agregar'])){
		$nombre = $_POST["nombre"];
		$descripcion = $_POST["descripcion"];
		$orden = $_POST["orden"];
		$idModelo = $_POST["modeloN"];


		if($idModelo == 0){
			$_SESSION["msj"] = "Es necesario seleccionar un Modelo de Proceso. Asegurate de que existan Modelos de Proceso.";
			header("location: inicio_admin.php");
			return;
		}

		$conex = new Conexion;
		

		$query  = "insert into fase(nombre,descripcion,orden,Modelo_P_idModelo_P) values ('$nombre','$descripcion','$orden',$idModelo)";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Fase Agregada Satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Fase No Agregada";
		}

		header("location: inicio_admin.php");
	}elseif (isset($_GET['getByModel'])) {
		# Obtenemos fases de un modelo
		$conex = new Conexion;
		
		$query  = "SELECT idFase, nombre FROM fase WHERE Modelo_P_idModelo_P=".$_GET['getByModel'];

		echo $conex->get($query);
	}elseif (isset($_POST['Editar'])) {
		$nombre = $_POST["nombre2"];
		$descripcion = $_POST["descripcion2"];
		$orden = $_POST["orden2"];
		$idModelo = $_POST["modeloN2"];
		$idFase = $_POST["idFase"];//para editar esa fase en especifico

		if($idModelo == 0){
			$_SESSION["msj"] = "Es necesario seleccionar un Modelo de Proceso. Asegurate de que existan Modelos de Proceso.";
			header("location: inicio_admin.php");
			return;
		}

		$conex = new Conexion;
		

		//$query = "update modelo_p set nombreM='$nombre',descripcion='$descripcion',version='$version' where idModelo_P=$id";
		$query  = "update fase set nombre='$nombre',descripcion='$descripcion',orden='$orden',Modelo_P_idModelo_P=$idModelo where idFase=$idFase";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Fase Editada Satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Fase No Editada";
		}

		//$_SESSION["modelos"] = $conex->get("modelo_p");
		header("location: inicio_admin.php");


	}elseif (isset($_POST['eliminar'])) {
		$idFase = $_POST['idFaseForm'];
		$nomFase = $_POST['nombreFaseForm'];

		$conex = new Conexion;

		$query  = "DELETE FROM fase WHERE idFase = $idFase";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Se ha borrado ".$nomFase;
		}else{
			$_SESSION["msj"] = "Hubo un error al borrar ".$nomFase;
		}
		header("location: inicio_admin.php");

	}
 ?>