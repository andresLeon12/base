<?php
/**
 * 
 */
//session_start();
 class Conexion
 {
 	var $conex = null;
 	function Conexion()
 	{
 		$this->conex = new mysqli("localhost", "root", "", "base_conocimiento");
 		if(mysqli_connect_errno()){
 			die("Error al conectar");
 		}
 	}
 	
 	// Consulta para obtener listas de tablas
 	function get($query){
 		
 		$array_res = array();

 		if(!$resultados = $this->conex->query($query)){

 		}else{
 			if($resultados->num_rows > 0){
 				//$array_res = array();
 				while ($fila = $resultados->fetch_assoc()) {
 					array_push($array_res, $fila);
 				}
 			}
 		}
 		
 		return json_encode($array_res);
 	}

 	function insert($consulta){
 		if(!$resultados = $this->conex->query($consulta)){
 			return false;
 		}else{
 			return true;
 		}
 	}

 	function getById($query){

 		if(!$resultados = $this->conex->query($query)){

 		}else{
 			if($resultados->num_rows > 0){
 				$array_res = array();
 				while ($fila = $resultados->fetch_assoc()) {
 					/*$_SESSION['idActual'] = $fila["idModelo_P"];
 					$_SESSION['nomActual'] = $fila["nombreM"];*/
 					return json_encode($fila);
 					//array_push($array_res, $fila);
 				}
 			}
 		}

 		//return "Select * FROM $tabla where id=$id";//json_encode($array_res);	
 	}

 	function insertAct($consulta,$dependencia){
 		
 		//inicio autocommit
 		//mysqli_autocommit($this->conex, FALSE);
 		//$this->conex->autocommit(FALSE);
		// Insertar algunos valores
		mysqli_query($this->conex, $consulta);
		//$last_id = 35;
		$last_id = $this->conex->insert_id;

		//$this->conex->autocommit(FALSE);

		/*$booleano = $this->comprobarDatos($dependencia,$last_id);
		if (!$booleano) {//Es false
			//mysqli_rollback($this->conex);
			return false;
		}*/
		$consultaII = "insert into dependencia(depende_de,Actividad_idActividad) values ($dependencia,$last_id)";
		mysqli_query($this->conex, $consultaII);

		// Consignar la transación
		//if (!mysqli_commit($this->conex)) {
		/*if (!$this->conex->commit($this->conex)) {
		    //print("Falló la consignación de la transacción\n");
		    //mysqli_rollback($this->conex);
		    return false;
		    //exit();
		}
		$this->conex->autocommit(true);*/
		return true;
 		//fin autocommit
 	}

 	/*function comprobarDatos($depende_de,$idActividad){
 		$query = "select * from dependencia where depende_De=$depende_de and Actividad_idActividad=$idActividad";
 		$resultado = mysqli_query($query);

 		if($resultado->num_rows == 0){
 			return true;
 		}else{
 			return false;
 		}
 	}*/

 	//cerrando la conexion
 	function cerrarConexion(){
 		mysqli_close($this->conex);
 	}

 } 
 ?>