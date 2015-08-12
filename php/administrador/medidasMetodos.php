 <?php
	if (session_id()==null)
 		session_start();
	include_once("../Conexion.class.php");

	if(isset($_POST['Agregar'])){
		$nombre = $_POST["nombre"];
		$descripcion = $_POST["descripcion"];
		$unidad_medida = $_POST["unidad_medida"];

		$conex = new Conexion;
		$query = "SELECT * FROM medida WHERE nombre='$nombre' and descripcion='$descripcion'";
		$consulta = json_decode($conex->get($query));
		if(count($consulta) > 0){
			$_SESSION['msj'] = "Esta medida ya existe";
			header("location: inicio_admin.php");
			return;
		}

		$query  = "insert into medida(nombre,descripcion,unidad_medida) values ('$nombre','$descripcion','$unidad_medida')";
		echo $query;
		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Medida Agregada Satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Medida No Agregada";
		}
		header("location: inicio_admin.php");
	}elseif (isset($_POST['Editar'])) {
		$nombre = $_POST["nombre"];
		$descripcion = $_POST["descripcion"];
		$unidad_medida = $_POST["unidad_medida"];
		$idMedida = $_POST['idMedida'];
		$conex = new Conexion;
		$query = "SELECT * FROM Medida WHERE nombre='$nombre' and idMedida=$idMedida";
		$consulta = json_decode($conex->get($query));
		$query = "SELECT * FROM Medida WHERE nombre='$nombre'";
		$consulta = json_decode($conex->get($query));
		if(count($consulta) > 0){
			for($i=0;$i<count($consulta);$i++){
				if($descripcion!=$consulta[$i]->descripcion || $unidad_medida != $consulta[$i]->unidad_medida){
					$query  = "update Medida set descripcion='$descripcion',unidad_medida='$unidad_medida' where idMedida=$idMedida";
					if ($conex->insert($query)) {
						$_SESSION["msj"] = "Medida Editada Satisfactoriamente";
					}else{
						$_SESSION["msj"] = "Medida No Editada";
					}
					header("location: inicio_admin.php");
					return;
				}
			}
			$_SESSION['msj'] = "Esta Medida ya existe";
			header("location: inicio_admin.php");
			return;
		}
		$query  = "update Medida set nombre='$nombre',descripcion='$descripcion',unidad_medida='$unidad_medida' where idMedida=$idMedida";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Medida Editada Satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Medida No Editada";
		}
		header("location: inicio_admin.php");
	}elseif (isset($_POST['eliminar'])) {
		$idTarea = $_POST['idTareaForm'];
		$nombreTarea = $_POST['nombreTareaForm'];

		$conex = new Conexion;

		$query  = "DELETE FROM tarea WHERE idTarea = $idTarea";

		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Se ha borrado ".$nombreTarea;
		}else{
			$_SESSION["msj"] = "Hubo un error al borrar ".$nombreTarea;
		}
		header("location: inicio_admin.php");
	}

?>