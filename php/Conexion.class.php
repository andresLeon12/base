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
 	
 	// resultado para obtener listas de tablas
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
 		if(strpos($consulta, "delete")!== false || strpos($consulta, "DELETE")!== false){
 			if($this->conex->query($consulta))
 				return mysqli_affected_rows($this->conex);
 		}
 		if(!$this->conex->query($consulta))
 			return false;
 		return true;
 		/*if(mysql_affected_rows() <= 0){
 			return false;
 		}else{
 			return true;
 		}*/
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
 	/**
 	 * query : Consulta a ejecutar
 	 * tabla : Tabla a afectar
 	 * campo_Tabla1 : Campo de llave foranea
 	 * campo_Tabla2 : Campo de llave foranea
 	 * idCampo : id del campo
 	 */
 	function insertTabRel($query,$tabla,$campo_Tabla1,$campo_Tabla2,$idCampo){
		// Iniciamos una nueva transaccion
 		$this->conex->autocommit(false);
 		if(!$this->insert($query)){
 			$this->conex->rollback(); // Deshacemos la consulta en caso de error
 			return false;
 		}
		//mysqli_query($this->conex, $query);
		// Obtenemos el ultimo id insertado
		$last_id = $this->conex->insert_id;

		$consultaII = "insert into $tabla($campo_Tabla1,$campo_Tabla2) values ($idCampo,$last_id)";
		if(!$this->insert($consultaII)){
 			$this->conex->rollback(); // Deshacemos la consulta en caso de error
 			return false;
		}
		//mysqli_query($this->conex, $consultaII);
		$this->conex->commit();
		return true;
 	}
 	function insertAct($query,$dependencia,$medida){
 		$this->conex->autocommit(false);
 		if(!$this->insert($query))
 			$this->conex->rollback(); // Deshacemos la consulta en caso de error
		// Obtenemos el ultimo id insertado
		$last_id = $this->conex->insert_id;
		echo $last_id."-".$dependencia;
		// Insertamos relaciond e dependencia
		if($dependencia!=null){
			$consultaII = "insert into dependencia(depende_de,Actividad_idActividad) values ($dependencia,$last_id)";
			if(!$this->insert($consultaII)){
	 			$this->conex->rollback(); // Deshacemos la consulta en caso de error
	 			return false;
			}
	 	}
 		// Insertamos relaciond de medida
		$consultaII = "insert into ActMed(Actividad_idActividad,Medida_idMedida) values ($last_id,$medida)";
		if(!$this->insert($consultaII)){
 			$this->conex->rollback(); // Deshacemos la consulta en caso de error
 			return false;
		}
		$this->conex->commit();
		return true;
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
 	// Eliminar de tablas relacionadas con modelos
 	function deleteOnCascadeModel($idd){
 		// Iniciar transaccion
 		$this->conex->autocommit(false);
 		// Empezamos a eliminar desde la tabla de modelos
 		$query  = "SELECT idFase FROM fase WHERE Modelo_P_idModelo_P=".$idd;
		$fases = json_decode($this->get($query));
 		// Empezamos a eliminar desde la tabla de actividades
		if(count($fases) > 0){
			for($j=0;$j<count($fases);$j++){
				$query  = "SELECT idActividad FROM actividad WHERE Fase_idFase=".$fases[$j]->idFase;
				$actividades = json_decode($this->get($query));
				if(count($actividades) > 0){
					// Eliminamos todas las relaciones de las actividades que componen esta fase
					for($i=0;$i<count($actividades);$i++){
						$idActividad = $actividades[$i]->idActividad;
						$query  = "SELECT Guia_idGuia FROM a_guia WHERE Actividad_idActividad=".$idActividad;
						$resultado = json_decode($this->get($query));
						if(count($resultado) > 0){
							for($k=0;$k<count($resultado);$k++){
								$query  = "DELETE FROM guia WHERE idGuia=".$resultado[$k]->Guia_idGuia;
								if($this->insert($query)==0){
									$this->conex->rollback();
									return false;
								}
							}
						}
						$query  = "SELECT Activo_idActivo FROM a_activo WHERE Actividad_idActividad=".$idActividad;
						$resultado = json_decode($this->get($query));
						if(count($resultado) > 0){
							for($k=0;$k<count($resultado);$k++){
								$query  = "DELETE FROM activo WHERE idActivo=".$resultado[$k]->Activo_idActivo;
								if($this->insert($query)==0){
									$this->conex->rollback();
									return false;
								}
							}
						}
						$query  = "SELECT RecursoF_idRecursoFisico FROM actividad_rf WHERE Actividad_idActividad=".$idActividad;
						$resultado = json_decode($this->get($query));
						if(count($resultado) > 0){
							for($k=0;$k<count($resultado);$k++){
								$query  = "DELETE FROM recursoF WHERE idRecursoFisico=".$resultado[$k]->RecursoF_idRecursoFisico;
								if($this->insert($query)==0){
									$this->conex->rollback();
									return false;
								}
							}
						}
						$query  = "SELECT RecursoH_idRecursoHumano FROM actividad_rh WHERE Actividad_idActividad=".$idActividad;
						$resultado = json_decode($this->get($query));
						if(count($resultado) > 0){
							for($k=0;$k<count($resultado);$k++){
								$query  = "DELETE FROM recursoH WHERE idRecursoHumano=".$resultado[$k]->RecursoH_idRecursoHumano;
								if($this->insert($query)==0){
									$this->conex->rollback();
									return false;
								}
							}
						}
						$query  = "SELECT Entrada_idEntrada FROM act_ent WHERE Actividad_idActividad=".$idActividad;
						$resultado = json_decode($this->get($query));
						if(count($resultado) > 0){
							for($k=0;$k<count($resultado);$k++){
								$query  = "DELETE FROM entrada WHERE idEntrada=".$resultado[$k]->Entrada_idEntrada;
								if($this->insert($query)==0){
									$this->conex->rollback();
									return false;
								}
							}
						}
						$query  = "SELECT Salida_idSalida FROM act_sal WHERE Actividad_idActividad=".$idActividad;
						$resultado = json_decode($this->get($query));
						if(count($resultado) > 0){
							for($k=0;$k<count($resultado);$k++){
								$query  = "DELETE FROM salida WHERE idSalida=".$resultado[$k]->Salida_idSalida;
								if($this->insert($query)==0){
									$this->conex->rollback();
									return false;
								}
							}
						}
					}
				}
			}
		}
		$query  = "DELETE FROM modelo_p WHERE idModelo_P=$idd";
		if($this->insert($query)==0){
			$this->conex->rollback();
			return false;
		}
		$this->conex->commit();
		return true;
 	}
 	// Eliminar de tablas relacionadas con modelos
 	function deleteOnCascadeFase($idd){
 		// Iniciar transaccion
 		$this->conex->autocommit(false);
 		// Empezamos a eliminar desde la tabla de fases
 		$query  = "SELECT idActividad FROM actividad WHERE Fase_idFase=".$idd;
		$actividades = json_decode($this->get($query));
		if(count($actividades) > 0){
			// Eliminamos todas las relaciones de las actividades que componen esta fase
			for($i=0;$i<count($actividades);$i++){
				$idActividad = $actividades[$i]->idActividad;
				$query  = "SELECT Guia_idGuia FROM a_guia WHERE Actividad_idActividad=".$idActividad;
				$resultado = json_decode($this->get($query));
				if(count($resultado) > 0){
					for($k=0;$k<count($resultado);$k++){
						$query  = "DELETE FROM guia WHERE idGuia=".$resultado[$k]->Guia_idGuia;
						if($this->insert($query)==0){
							$this->conex->rollback();
							return false;
						}
					}
				}
				$query  = "SELECT Activo_idActivo FROM a_activo WHERE Actividad_idActividad=".$idActividad;
				$resultado = json_decode($this->get($query));
				if(count($resultado) > 0){
					for($k=0;$k<count($resultado);$k++){
						$query  = "DELETE FROM activo WHERE idActivo=".$resultado[$k]->Activo_idActivo;
						if($this->insert($query)==0){
							$this->conex->rollback();
							return false;
						}
					}
				}
				$query  = "SELECT RecursoF_idRecursoFisico FROM actividad_rf WHERE Actividad_idActividad=".$idActividad;
				$resultado = json_decode($this->get($query));
				if(count($resultado) > 0){
					for($k=0;$k<count($resultado);$k++){
						$query  = "DELETE FROM recursoF WHERE idRecursoFisico=".$resultado[$k]->RecursoF_idRecursoFisico;
						if($this->insert($query)==0){
							$this->conex->rollback();
							return false;
						}
					}
				}
				$query  = "SELECT RecursoH_idRecursoHumano FROM actividad_rh WHERE Actividad_idActividad=".$idActividad;
				$resultado = json_decode($this->get($query));
				if(count($resultado) > 0){
					for($k=0;$k<count($resultado);$k++){
						$query  = "DELETE FROM recursoH WHERE idRecursoHumano=".$resultado[$k]->RecursoH_idRecursoHumano;
						if($this->insert($query)==0){
							$this->conex->rollback();
							return false;
						}
					}
				}
				$query  = "SELECT Entrada_idEntrada FROM act_ent WHERE Actividad_idActividad=".$idActividad;
				$resultado = json_decode($this->get($query));
				if(count($resultado) > 0){
					for($k=0;$k<count($resultado);$k++){
						$query  = "DELETE FROM entrada WHERE idEntrada=".$resultado[$k]->Entrada_idEntrada;
						if($this->insert($query)==0){
							$this->conex->rollback();
							return false;
						}
					}
				}
				$query  = "SELECT Salida_idSalida FROM act_sal WHERE Actividad_idActividad=".$idActividad;
				$resultado = json_decode($this->get($query));
				if(count($resultado) > 0){
					for($k=0;$k<count($resultado);$k++){
						$query  = "DELETE FROM salida WHERE idSalida=".$resultado[$k]->Salida_idSalida;
						if($this->insert($query)==0){
							$this->conex->rollback();
							return false;
						}
					}
				}
			}
		}
		
		$query  = "DELETE FROM fase WHERE idFase=$idd";
		if($this->insert($query)==0){
			$this->conex->rollback();
			return false;
		}
		$this->conex->commit();
		return true;
 	}
 	// Eliminar de tablas relacionadas con modelos
 	function deleteOnCascadeActividad($idActividad){
 		// Iniciar transaccion
 		$this->conex->autocommit(false);
 		// Empezamos a eliminar desde la tabla de actividades
		$query  = "SELECT Guia_idGuia FROM a_guia WHERE Actividad_idActividad=".$idActividad;
		$resultado = json_decode($this->get($query));
		if(count($resultado) > 0){
			for($k=0;$k<count($resultado);$k++){
				$query  = "DELETE FROM guia WHERE idGuia=".$resultado[$k]->Guia_idGuia;
				if($this->insert($query)==0){
					$this->conex->rollback();
					return false;
				}
			}
		}
		$query  = "SELECT Activo_idActivo FROM a_activo WHERE Actividad_idActividad=".$idActividad;
		$resultado = json_decode($this->get($query));
		if(count($resultado) > 0){
			for($k=0;$k<count($resultado);$k++){
				$query  = "DELETE FROM activo WHERE idActivo=".$resultado[$k]->Activo_idActivo;
				if($this->insert($query)==0){
					$this->conex->rollback();
					return false;
				}
			}
		}
		$query  = "SELECT RecursoF_idRecursoFisico FROM actividad_rf WHERE Actividad_idActividad=".$idActividad;
		$resultado = json_decode($this->get($query));
		if(count($resultado) > 0){
			for($k=0;$k<count($resultado);$k++){
				$query  = "DELETE FROM recursoF WHERE idRecursoFisico=".$resultado[$k]->RecursoF_idRecursoFisico;
				if($this->insert($query)==0){
					$this->conex->rollback();
					return false;
				}
			}
		}
		$query  = "SELECT RecursoH_idRecursoHumano FROM actividad_rh WHERE Actividad_idActividad=".$idActividad;
		$resultado = json_decode($this->get($query));
		if(count($resultado) > 0){
			for($k=0;$k<count($resultado);$k++){
				$query  = "DELETE FROM recursoH WHERE idRecursoHumano=".$resultado[$k]->RecursoH_idRecursoHumano;
				if($this->insert($query)==0){
					$this->conex->rollback();
					return false;
				}
			}
		}
		$query  = "SELECT Entrada_idEntrada FROM act_ent WHERE Actividad_idActividad=".$idActividad;
		$resultado = json_decode($this->get($query));
		if(count($resultado) > 0){
			for($k=0;$k<count($resultado);$k++){
				$query  = "DELETE FROM entrada WHERE idEntrada=".$resultado[$k]->Entrada_idEntrada;
				if($this->insert($query)==0){
					$this->conex->rollback();
					return false;
				}
			}
		}
		$query  = "SELECT Salida_idSalida FROM act_sal WHERE Actividad_idActividad=".$idActividad;
		$resultado = json_decode($this->get($query));
		if(count($resultado) > 0){
			for($k=0;$k<count($resultado);$k++){
				$query  = "DELETE FROM salida WHERE idSalida=".$resultado[$k]->Salida_idSalida;
				if($this->insert($query)==0){
					$this->conex->rollback();
					return false;
				}
			}
		}
		$query  = "DELETE FROM actividad WHERE idActividad=$idActividad";
		if($this->insert($query)==0){
			$this->conex->rollback();
			return false;
		}
		$this->conex->commit();
		return true;
 	}

 } 
 ?>