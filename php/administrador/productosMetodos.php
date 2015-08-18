<?php 
	if (session_id()==null)
 		session_start();
	include_once("../Conexion.class.php");

	if(isset($_POST['Agregar'])){
		$nombre = $_POST["nombre"];
		$version= $_POST["version"];
		$tipo  = $_POST['tipo'];
		$tarea  = $_POST['tarea'];
		$actividad  =  $_POST['actividad'];

		

		if($actividad == 0){
			$_SESSION["msj"] = "Es necesario seleccionar un Modelo de Proceso. Asegurate de que existan Modelos de Proceso.";
			header("location: inicio_admin.php");
			return;
		}
		
	
		if($actividad == "Selecciona una actividad" || $actividad == "Lo sentimos aun no hay actividades" ){
			$_SESSION["msj"] = "Es necesario seleccionar una Actividad. Asegurate de que existan Actividades en esa fase";
			header("location: inicio_admin.php");
			return;
		}
		$conex = new Conexion;

		$query  ="SELECT idProd_T FROM prod_t WHERE version='$version' and nombre='$nombre'";
		
		$valida  =json_decode($conex->get($query));
		if (count($valida)>0) {
			
			$query = "SELECT * FROM tarea_prodt WHERE Prod_T_idProd_T=".$valida[0]->idProd_T;

			//echo $query;
			//return;
			$aux  = json_decode($conex->get($query));
			/*if (count($aux)>0) {
				echo "Visate";
				return;
			}*/

			//echo $aux[0]->Tarea_idTarea."Tarea que llego = ".$tarea; return;
			if ($tarea==$aux[0]->Tarea_idTarea) {
				$_SESSION['msj']="No pueden existir dos Producto de Trabajo con el mismo nombre y la misma version";
				header("location: inicio_admin.php");
				return;
			}
		
			
		}

	




	
		$query = "INSERT INTO prod_t(nombre,tipo,version) values ('$nombre','$tipo','$version')";
		echo $query;


		if ($conex->insert($query)) {

			$query = "SELECT idProd_T FROM prod_t";
			$consulta = json_decode($conex->get($query));
			$idAux = $consulta[count($consulta)-1]->idProd_T;

			$query =  "INSERT INTO tarea_prodt(Prod_T_idProd_T,Tarea_idTarea) VALUES ($idAux,$tarea)";

			$conex->insert($query);

			$_SESSION["msj"] = "Producto de Trabajo Agregado Satisfactoriamente";

		}else{
			$_SESSION["msj"] = "Producto de Trabajo NO Agregado";
		}
	

	

		header("location: inicio_admin.php");
	}elseif (isset($_GET['getNombreProducto'])) {
		$idProducto  = $_GET['id'];

		$conex = new Conexion;

		$query  ="SELECT * FROM prod_t WHERE idProd_T =".$idProducto;

		echo $conex->getById($query);
	}elseif (isset($_GET['getByActividad'])){//-*-*-*-*-*-*-*-**-*-*-*-*-*-*-*-**-*-**
		$idActividad = $_GET['getByActividad'];


		$conex = new Conexion;

		$query  = "SELECT * FROM tarea WHERE Actividad_idActividad =".$idActividad;
		
		
		echo $conex->get($query);

		
	}elseif (isset($_GET['getTareaByProducto'])){///////////////////////////////
		$idProducto = $_GET['id'];


		$conex = new Conexion;

		$query  = "SELECT Tarea_idTarea FROM tarea_prodt WHERE Prod_T_idProd_T=".$idProducto;
		

		//echo $conex->getById($query);
		$idTarea  = json_decode($conex->getById($query));

		$query  = "SELECT nombre,idTarea,Actividad_idActividad FROM tarea WHERE idTarea=".$idTarea->Tarea_idTarea;

		//echo $query;
		//return;
		echo $conex->getById($query);
		
	}elseif (isset($_GET['getAllTareas'])){///////////////////////////////
	


		$conex = new Conexion;

		$query  = "SELECT * FROM tarea ";
		
		echo $conex->get($query);
		
	}elseif (isset($_GET['getActividadByTarea'])){//-----------------------------------------------------------------------------------------------------------------------
		# Obtenemos fases de un modelo
		$conex = new Conexion;
		
		$query  = "SELECT  nombre,Fase_idFase FROM actividad WHERE idActividad=".$_GET['id'];
		echo $conex->getById($query);
	}elseif(isset($_GET['getAllActividades'])){///////////////////////////////
	

		$conex = new Conexion;

		$query  = "SELECT * FROM actividad ";
		
		echo $conex->get($query);
		
	}elseif(isset($_GET['getAllFases'])){///////////////////////////////
	

		$conex = new Conexion;

		$query  = "SELECT * FROM fase ";
		
		echo $conex->get($query);
		
	}elseif (isset($_GET['getModeloByFase']) ){//-----------------------------------------------------------------------------------------------------------------------
		# Obtenemos modelo de una fase
		$conex = new Conexion;
		
		$query  = "SELECT  nombre,Modelo_P_idModelo_P FROM fase WHERE idFase=".$_GET['id'];
		
		echo $conex->getById($query);

	}elseif(isset($_GET['getAllModelos'])){///////////////////////////////
	

		$conex = new Conexion;

		$query  = "SELECT * FROM modelo_p ";
		
		echo $conex->get($query);
		
	}elseif(isset($_POST['Editar'])){///////////////////////////////
		$nombre = $_POST["nombre"];
		$version= $_POST["version"];
		$tipo  = $_POST['tipo'];
		$tarea  = $_POST['tarea'];
		$actividad  =  $_POST['actividad'];
		$idd  = $_POST['id'];
		$conex = new Conexion;

		if($actividad == 0){
			$_SESSION["msj"] = "Es necesario seleccionar un Modelo de Proceso. Asegurate de que existan Modelos de Proceso.";
			header("location: inicio_admin.php");
			return;
		}
		
	
		if($actividad == "Selecciona una actividad" || $actividad == "Lo sentimos aun no hay actividades" ){
			$_SESSION["msj"] = "Es necesario seleccionar una Actividad. Asegurate de que existan Actividades en esa fase";
			header("location: inicio_admin.php");
			return;
		}



		$query  ="SELECT * FROM prod_t WHERE version='$version' and nombre='$nombre'";
		
		
		$valida  =json_decode($conex->get($query));

		
		if (count($valida)>0) {
			
			$query = "SELECT * FROM tarea_prodt WHERE Prod_T_idProd_T=".$valida[0]->idProd_T;

			//echo $query;
			//return;
			$aux  = json_decode($conex->get($query));
			/*if (count($aux)>0) {
				echo "Visate";
				return;
			}*/

			//echo $aux[0]->Tarea_idTarea."Tarea que llego = ".$tarea; return;
			if ($tarea==$aux[0]->Tarea_idTarea) {
				$_SESSION['msj']="No pueden existir dos Producto de Trabajo con el mismo nombre y la misma version";
				header("location: inicio_admin.php");
				return;
			}
		
			
		}


		$query  = "UPDATE prod_t SET nombre='$nombre',tipo='$tipo',version='$version' WHERE idProd_T='$idd'";

		if ($conex->insert($query)) {
			$query = "UPDATE tarea_prodt SET Tarea_idTarea='$tarea' WHERE Prod_T_idProd_T='$idd'";
			$conex->insert($query);
			$_SESSION["msj"] = "Producto actualizado Satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Producto  no actualizada";
		}

		header("location: inicio_admin.php");
	
		
	}elseif(isset($_POST['eliminar'])){///////////////////////////////

		$nombre = $_POST["nombrePro"];
		$idProducto = $_POST["idProducto"];
		
		$conex = new Conexion;


		$query  = "DELETE FROM prod_t WHERE idProd_T = '$idProducto'";

	


		if ($conex->insert($query)) {
			
			$_SESSION["msj"] = "Se Borro Producto ".$nombre;
		}else{
			$_SESSION["msj"] = "No se pudo borrar el Producto";
		}

		header("location: inicio_admin.php");
	
		
	}




	


	
	
	

 ?>