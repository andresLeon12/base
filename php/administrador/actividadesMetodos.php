 <?php
 	if(session_id()==null)
		session_start();
	include_once("../Conexion.class.php");
	
	if (isset($_POST['Actualizar'])) {
		
		$id = $_POST["id"];
		$nombre = $_POST["nombre"];
		$descripcion = $_POST["descripcion"];
		$tipo = $_POST["tipo"];
		$fase = $_POST["idFase"];
		if($fase == "Selecciona una fase" || $fase == "Lo sentimos aun no hay fases"){
			$_SESSION["msj"] = "Es necesario seleccionar una fase. Asegurate de que existan fases en este modelo.";
			header("location: inicio_admin.php");
			return;
		}
		$conex = new Conexion;

		$query = "update actividad set nombre='$nombre',descripcion='$descripcion',tipo='$tipo', Fase_idFase=$fase where idActividad=$id";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Actividad ".$nombre." editada satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Actividad ".$nombre." no editada";
		}
		header("location: inicio_admin.php");

	}elseif(isset($_POST['Agregar'])){
		$nombre = $_POST["nombre"];
		$descripcion = $_POST["descripcion"];
		$tipo = $_POST["tipo"];
		$fase = $_POST["idFase"];
		if($fase == "Selecciona una fase" || $fase == "Lo sentimos aun no hay fases"){
			$_SESSION["msj"] = "Es necesario seleccionar una fase. Asegurate de que existan fases en este modelo.";
			header("location: inicio_admin.php");
			return;
		}
		$conex = new Conexion;
		

		$query  = "insert into actividad(nombre,descripcion,tipo,Fase_idFase) values ('$nombre','$descripcion','$tipo',$fase)";
		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Actividad agregada Satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Actividad no agregada";
		}
		header("location: inicio_admin.php");
	}elseif (isset($_GET['type'])) {
		# obtendremos en forma de combo los modelos dados de alta
		$conex = new Conexion;
		
		$query  = "SELECT idModelo_P, nombreM FROM modelo_p";

		echo $conex->get($query);
	}elseif(isset($_POST['eliminar'])){
		$id = $_POST["idActividad"];
		$nombre = $_POST['nombreAct'];
		$conex = new Conexion;
		

		$query  = "DELETE FROM actividad WHERE idActividad = $id";
		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Se ha borrado ".$nombre;
		}else{
			$_SESSION["msj"] = "Hubo un error al borrar ".$nombre;
		}
		header("location: inicio_admin.php");
	}elseif (isset($_GET['getByFase'])) {
		# Obtenemos fases de un modelo
		$conex = new Conexion;
		
		$query  = "SELECT idActividad, nombre FROM actividad WHERE Fase_idFase=".$_GET['getByFase'];

		echo $conex->get($query);
	}

 ?>