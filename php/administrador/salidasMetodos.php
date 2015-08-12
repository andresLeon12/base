<?php 

	if (session_id()==null)
 		session_start();
	include_once("../Conexion.class.php");

	if(isset($_POST['Agregar'])){

		

		$nombre = $_POST["nombre"];
		$modelo  = $_POST["modeloN"];
		$fase = $_POST["idFase"];
		$actividad  = $_POST["idActividad"];
		$descripcion = $_POST["descripcion"];
	


		

		if($modelo == 0){
			$_SESSION["msj"] = "Es necesario seleccionar un Modelo de Proceso. Asegurate de que existan Modelos de Proceso.";
			header("location: inicio_admin.php");
			return;
		}
		
		if($fase == "Selecciona una fase" || $fase == "Lo sentimos aun no hay fases"){
			$_SESSION["msj"] = "Es necesario seleccionar una fase. Asegurate de que existan fases en este modelo.";
			header("location: inicio_admin.php");
			return;
		}

		if($actividad == "Selecciona una actividad" || $actividad == "Lo sentimos aun no hay actividades"){
			$_SESSION["msj"] = "Es necesario seleccionar una Actividad. Asegurate de que existan Actividades en esa fase";
			header("location: inicio_admin.php");
			return;
		}

		$conex = new Conexion;

	

		/*Validacion para que no se pueden agregar dos salidas con el mismo nombre a una misma actividad*/
		$ban = 0;
		$query = "SELECT * FROM salida WHERE nombre='$nombre'";
			$consulta = json_decode($conex->get($query));
			if(count($consulta) > 0){
				for($i=0;$i<count($consulta);$i++){
					$query = "SELECT * FROM act_sal WHERE Salida_idSalida=".$consulta[$i]->idSalida." and Actividad_idActividad=$actividad";
					$consulta2 = json_decode($conex->get($query));
					if(count($consulta2) > 0){
						$ban++;
					}
				}
			}
			if($ban > 0){
				$_SESSION['msj'] = "Esta salida ya existe";
				header("location: inicio_admin.php");
				return;
			}
		/*$query= "SELECT idSalida FROM salida WHERE nombre='$nombre'";


		$nombreValidar  = json_decode($conex->getById($query));
		echo "Este es nombre =".$nombre;
		echo  $nombreValidar->idSalida;
		
		if ($nombreValidar->idSalida==null) {
			
		}else{
			$_SESSION['msj']  = "No se pude Agregar 2 salidas con el mismo nombre ";
			header("location: inicio_admin.php");
			return true;

		}*/

		
		/*fin de Validacion para que no se pueden agregar dos entradas con el mismo nombre a una misma actividad*/
		
		
		
		
	
		$query  = "insert into salida(nombre,descripcion) values ('$nombre','$descripcion')";
		/*$conex->insert($query);
		$query = "SELECT @@identity AS idSalida";
		$idAux  =  json_decode($conex->getById($query));

		echo  "This id = ".$idAux->idSalida;*/
	

		if ($conex->insert($query)){
			$query = "SELECT idSalida FROM salida";
			$consulta = json_decode($conex->get($query));
			$idAux = $consulta[count($consulta)-1]->idSalida;
			/*$query  ="SELECT idSalida FROM salida WHERE nombre ='$nombre'";
			$idAux  =  json_decode($conex->getById($query));
			echo "Este es el ID del nuevo registro".$idAux->idSalida;
			echo "Esta es el id de la actividad  ".$actividad;*/
			
			$query = " insert into act_sal(idActividad_Sal,Salida_idSalida,Actividad_idActividad) values ('NULL',$idAux,'$actividad')";

			$conex->insert($query);
			$_SESSION["msj"] = "Salida agregada Satisfactoriamente";
			
		}else{
			$_SESSION["msj"] = "Salida no agregada";
		}
		header("location: inicio_admin.php");






		
	}elseif(isset($_GET['type'])){
		$conex = new Conexion;
		
		$query  = "SELECT nombre,descripcion FROM salida WHERE idSalida=".$_GET['id'];


		echo $conex->getById($query);

		
	}elseif(isset($_GET['getActividad'])){
		$conex = new Conexion;
		
		$query  = "SELECT Actividad_idActividad FROM act_sal WHERE Salida_idSalida=".$_GET['id'];


 
		$idActividad=  $conex->get($query);

		$aux   =  json_decode($idActividad);

		$query = "SELECT nombre,Fase_idFase FROM actividad WHERE idActividad=".$aux[0]->Actividad_idActividad ;

		echo $conex->getById($query);

	}elseif(isset($_GET['getFase'])){
		$conex = new Conexion;
		
		$query  = "SELECT nombre,Modelo_P_idModelo_P FROM fase WHERE idFase=".$_GET['id'];



		

		echo $conex->getById($query);

	}elseif(isset($_GET['getModelo'])){
		$conex = new Conexion;
		
		$query  = "SELECT nombreM FROM modelo_p WHERE idModelo_P=".$_GET['id'];



		

		echo $conex->getById($query);

	}elseif(isset($_GET['getModelos'])){
		$conex = new Conexion;
		
		$query  = "SELECT * FROM modelo_p ";



		

		echo $conex->get($query);

	}elseif(isset($_GET['getFaseModelo'])){
		$conex = new Conexion;
		
		$query  = "SELECT * FROM fase WHERE Modelo_P_idModelo_P  =".$_GET['id'];



		

		echo $conex->get($query);

	}elseif(isset($_GET['getActividadesFase'])){
		$conex = new Conexion;
		
		$query  = "SELECT * FROM actividad WHERE Fase_idFase=".$_GET['id'];



		

		echo $conex->get($query);

	}elseif(isset($_GET['getAct'])){
		$conex = new Conexion;
		
		$query  = "SELECT Actividad_idActividad FROM act_sal WHERE Salida_idSalida=".$_GET['id'];


		

		echo $conex->getById($query);

	}elseif(isset($_POST['Actualizar'])){
		$conex = new Conexion;
		
		$nombre  = $_POST['nombre'];
		$modelo  = $_POST['modeloN'];
		$fase  =  $_POST['idFase'];
		$actividad  =  $_POST['idActividad'];
		$descripcion = $_POST['descripcion'];
		$id  =  $_POST['id'];

		if($modelo == 0){
			$_SESSION["msj"] = "Es necesario seleccionar un Modelo de Proceso. Asegurate de que existan Modelos de Proceso.";
			header("location: inicio_admin.php");
			return;
		}
		
		if($fase == "Selecciona una fase" || $fase == "Lo sentimos aun no hay actividades"){
			$_SESSION["msj"] = "Es necesario seleccionar una fase. Asegurate de que existan fases en este modelo.";
			header("location: inicio_admin.php");
			return;
		}

		if($actividad == "Selecciona una actividad" ){
			$_SESSION["msj"] = "Es necesario seleccionar una Actividad. Asegurate de que existan Actividades en esa fase";
			header("location: inicio_admin.php");
			return;
		}

		//---------------------------------------------------------------
		$ban = 0;
		$query = "SELECT * FROM salida WHERE nombre='$nombre'";
			$consulta = json_decode($conex->get($query));
			if(count($consulta) > 0){
				for($i=0;$i<count($consulta);$i++){
					$query = "SELECT * FROM act_sal WHERE Salida_idSalida=".$consulta[$i]->idSalida." and Actividad_idActividad=$actividad";
					$consulta2 = json_decode($conex->get($query));
					if(count($consulta2) > 0){
						$ban++;
					}
				}
			}
			if($ban > 0){
				$_SESSION['msj'] = "Esta salida ya existe";
				header("location: inicio_admin.php");
				return;
			}
		/*$query= "SELECT idSalida FROM salida WHERE nombre='$nombre'";


		$nombreValidar  = json_decode($conex->getById($query));
		echo "Este es nombre =".$nombre;
		echo  $nombreValidar->idSalida;
		
		if (($nombreValidar->idSalida==null) || ($nombreValidar->idSalida==$id)) {
			
		}else{
			$_SESSION['msj']  = "No se pude Agregar 2 salidas con el mismo nombre ";
			header("location: inicio_admin.php");
			return true;

		}*/
		//---------------------------------------------------------------

		$query  = "UPDATE salida SET nombre='$nombre',descripcion='$descripcion' WHERE idSalida='$id'";

		if ($conex->insert($query)) {
			$query = "UPDATE act_sal SET Actividad_idActividad='$actividad' WHERE Salida_idSalida='$id'";
			$conex->insert($query);
			$_SESSION["msj"] = "Salida actualizada Satisfactoriamente";
		}else{
			$_SESSION["msj"] = "Salida no actualizada";
		}

		header("location: inicio_admin.php");
	
		

	


		//echo "idd  = ".$id."Nombre   = ".$nombre."Modelo   = ".$modelo."Fase= ".$fase."actividad= ".$actividad."descripcion   = ".$descripcion     ;

	}elseif(isset($_POST['eliminar'])){
		//echo "Es id llego  =  ".$_POST['idEntrada'];

		$IdEliminar   = $_POST['idSalida'];
		$nombre = $_POST['nombreSal'];
		$conex = new Conexion;
		

		$query  = "DELETE FROM salida WHERE idSalida = '$IdEliminar'";
		if ($conex->insert($query)) {
			$_SESSION["msj"] = "Se ha borrado ".$nombre;
		}else{
			$_SESSION["msj"] = "Hubo un error al borrar ".$nombre;
		}
		header("location: inicio_admin.php");
	}

 ?>