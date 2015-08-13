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