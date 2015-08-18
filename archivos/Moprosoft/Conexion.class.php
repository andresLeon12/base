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
 		if(strpos($consulta, "delete")!== false || strpos($consulta, "DELETE")!== false){
 			if($this->conex->query($consulta))
 				return mysqli_affected_rows($this->conex);
 		}
 		if(strpos($consulta, "update")!== false || strpos($consulta, "UPDATE")!== false){
 			if($this->conex->query($consulta))
 				return mysqli_affected_rows($this->conex);
 		}
 		if(!$this->conex->query($consulta))
 			return false;
 		return true;
 		/*if(!$resultados = $this->conex->query($consulta)){
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
		echo $consultaII;
		if(!$this->insert($consultaII)){
 			$this->conex->rollback(); // Deshacemos la consulta en caso de error
 			return false;
		}
		//mysqli_query($this->conex, $consultaII);
		$this->conex->commit();
		return true;
 	}
 	function insertTabRelAct($query,$tabla,$campo_Tabla1,$campo_Tabla2,$idCampo,$idMedida){
		// Iniciamos una nueva transaccion
 		$this->conex->autocommit(false);
 		echo "segundo ".$query;
 		if(!$this->insert($query)){
 			$this->conex->rollback(); // Deshacemos la consulta en caso de error
 			return false;
 		}
		//mysqli_query($this->conex, $query);
		// Obtenemos el ultimo id insertado
		$last_id = $this->conex->insert_id;
		$consultaII = "insert into $tabla($campo_Tabla1,$campo_Tabla2) values ($idCampo,'$last_id')";
		echo $consultaII;
		if(!$this->insert($consultaII)){
 			$this->conex->rollback(); // Deshacemos la consulta en caso de error
 			return false;
		}
		// Insertamos relaciond de medida
		$consultaII = "insert into ActMed(Actividad_idActividad,Medida_idMedida) values ($last_id,$idMedida)";
		echo $consultaII;
		$this->insert($consultaII);
		//mysqli_query($this->conex, $consultaII);
		$this->conex->commit();
		echo "commit";
		return true;
 	}
 	function insertAct($query,$dependencia,$medida){
 		$this->conex->autocommit(false);
 		echo $query;
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
		echo "<br>".$consultaII;
		$this->insert($consultaII);
		if($this->conex->commit())
			return $last_id;
		else
			return null;
 	}
 	function addFile($archivo,$tipo,$descripcion,$descripcion2,$idActividad,$idModel){
 		// Creamos el directorio con el nombre del modelo
 		$query  = "SELECT idModelo_P, nombreM FROM modelo_p WHERE idModelo_P=$idModel";
		$consulta = json_decode($this->getById($query));
		$nname = explode(" ", $consulta->nombreM);
		$serv = $_SERVER['DOCUMENT_ROOT'] . '/base/archivos/'.$nname[0]."/";
		if(!file_exists($serv))
			mkdir ($serv);
		if ($tipo == 'guia') {
		    // ensure a safe filename
		    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $archivo["name"]);
		 	
		    // preserve file from temporary directory
		    $success = move_uploaded_file($archivo["tmp_name"],
		        $serv . $name);
		    // set proper permissions on the new file
		    chmod($serv . $name, 0644);
		    $serv = $consulta->nombreM."/".$name;
		    $query = "INSERT INTO guia(nombre,tipo) VALUES('$serv','$descripcion')";
		    if ($this->insertTabRel($query,"A_Guia","Actividad_idActividad","Guia_idGuia",$idActividad)) {
				$_SESSION["msj"] = "Guia Agregada Satisfactoriamente";
			}else{
				$_SESSION["msj"] = "Guia no Agregada ";
			}
		}
		if ($tipo == 'activo') {
		    // ensure a safe filename
		    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $archivo["name"]);
		 
		    // preserve file from temporary directory
		    $success = move_uploaded_file($archivo["tmp_name"],
		        $serv . $name);
		    // set proper permissions on the new file
		    chmod($serv . $name, 0644);
		    $serv = $consulta->nombreM."/".$name;
		    $query = "INSERT INTO activo(nombre,descripcion) VALUES('$serv','$descripcion2')";
		    if ($this->insertTabRel($query,"A_Activo","Actividad_idActividad","Activo_idActivo",$idActividad)) {
				$_SESSION["msj"] = "Activo Agregado Satisfactoriamente";
			}else{
				$_SESSION["msj"] = "Activo no Agregado ";
			}
			//echo $_SESSION['msj'];
		}
 	}
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
						$query  = "SELECT idTarea FROM tarea WHERE Actividad_idActividad=".$idActividad;
						$resultado = json_decode($this->get($query));
						if(count($resultado) > 0){
							for($k=0;$k<count($resultado);$k++){
								$query  = "SELECT Prod_T_idProd_T FROM tarea_prodt WHERE Tarea_idTarea=".$resultado[$k]->idTarea;
								$resultado2 = json_decode($this->get($query));
								for($k=0;$k<count($resultado2);$k++){
									$query  = "DELETE FROM prod_t WHERE idProd_T=".$resultado2[$k]->Prod_T_idProd_T;
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
				$query  = "SELECT idTarea FROM tarea WHERE Actividad_idActividad=".$idActividad;
				$resultado = json_decode($this->get($query));
				if(count($resultado) > 0){
					for($k=0;$k<count($resultado);$k++){
						$query  = "SELECT Prod_T_idProd_T FROM tarea_prodt WHERE Tarea_idTarea=".$resultado[$k]->idTarea;
						$resultado2 = json_decode($this->get($query));
						for($k=0;$k<count($resultado2);$k++){
							$query  = "DELETE FROM prod_t WHERE idProd_T=".$resultado2[$k]->Prod_T_idProd_T;
							if($this->insert($query)==0){
								$this->conex->rollback();
								return false;
							}
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
		$query  = "SELECT idTarea FROM tarea WHERE Actividad_idActividad=".$idActividad;
		$resultado = json_decode($this->get($query));
		if(count($resultado) > 0){
			for($k=0;$k<count($resultado);$k++){
				$query  = "SELECT Prod_T_idProd_T FROM tarea_prodt WHERE Tarea_idTarea=".$resultado[$k]->idTarea;
				$resultado2 = json_decode($this->get($query));
				for($k=0;$k<count($resultado2);$k++){
					$query  = "DELETE FROM prod_t WHERE idProd_T=".$resultado2[$k]->Prod_T_idProd_T;
					if($this->insert($query)==0){
						$this->conex->rollback();
						return false;
					}
				}
			}
		}
		$query  = "DELETE FROM actividad WHERE idActividad='$idActividad'";
		if($this->insert($query)==0){
			$this->conex->rollback();
			return false;
		}
		$this->conex->commit();
		return true;
 	}

 } 
 ?>