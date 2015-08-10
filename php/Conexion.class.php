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

 } 
 ?>