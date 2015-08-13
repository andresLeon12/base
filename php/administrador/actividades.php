<script type="text/javascript" language="javascript" class="init">
	$(document).ready(function() {
		$('#example').DataTable();
	});
</script>

<?php 
	if(session_id()==null)
		session_start();
	include_once("../Conexion.class.php");
	
	$conex = new Conexion;//instanciando la clase conexion

	$misModelos =  json_decode($conex->get("SELECT idModelo_P,nombreM,version FROM modelo_p"));//obteniendo los modelos que se tienen dados de alta en la bd

	$actividades =  json_decode($conex->get("SELECT * FROM actividad"));
	$medidas =  json_decode($conex->get("SELECT * FROM medida"));
	
	$nomDependencias = array();

	for ($i=0; $i < count($actividades); $i++) { 
		$idAct = $actividades[$i]->idActividad;
		$auxActivitys =  json_decode($conex->get("SELECT * FROM dependencia where Actividad_idActividad=$idAct"));
		
		if (count($auxActivitys) == 0) {
			array_push($nomDependencias, "No tiene dependencia");	
		}else{
			$dependeDe = $auxActivitys[0]->depende_De;
			$dependeDe_act =  json_decode($conex->get("SELECT * FROM actividad where idActividad=$dependeDe"));
			array_push($nomDependencias, $dependeDe_act[0]->nombre);
		}
	}

 ?>

<div class="row"></div>
<div class="container">	

<!-- Dar de alta nuevo modelo de proceso -->
<div class="row">
	<div class="col s6">
		<blockquote><h5>Nueva actividad</h5></blockquote>		
	</div>
	<div class="col s6">
		<blockquote class="blockquote-right" id="errores"><?php 
		if(isset($_SESSION['msj'])!="") {
			echo $_SESSION['msj']; 
			$_SESSION['msj'] = '';
		}
		 ?></blockquote>
	</div>
</div>
	<form  action="actividadesMetodos.php" method="POST" id="submitAct">
		<div class="row">
			<div class="input-field col s6">
			   	<input type="text" name="nombre" id="nombre"required />
				<label for="icon_prefix">Nombre de la actividad</label>
		    </div>
		    <div class="input-field col s6">
			   	<input type="text" name="tipo" id="tipo"required />
				<label for="icon_prefix">Tipo</label>
		    </div>
		</div>
		<div class="row">
			<div class="col s6">
				<label>Modelo al que pertenece</label>
				<select class="browser-default" id="models"><option>Selecciona un modelo</option>
				<?php
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM} V {$misModelos[$i]->version}</option>";
					} ?>
				</select>
		    </div>
		    <div class="col s6">
				<label>Fase a la que pertenece</label>
				<select class="fasesOptions browser-default" name="idFase" id="idfases" required><option>Selecciona una fase</option></select>
		    </div>
		</div>
		<div class="row">
	    	<div class="col s6">
		<!-- Combo de dependencias. NOTA: La primera vez que se agrega una actividad esta no tiene ninguna dependencia, pero la segunda se le va a habilitar el combo de las dependencias -->
	    <?php  
	    	if (count($actividades) > 0) {
	    ?>
				<label>Depende de:</label>
				<select class="browser-default" id="dependencia" name="dependencia">
					<option value="0">Selecciona una dependencia</option>
				</select>		
	    <?php		
	    	}
	    ?>
	    	</div>		
	    <!-- F I N .. combo de dependencias -->
	    <div class="col s6">
	    	<label>Medida</label>
				<select class="browser-default" id="idMedida" name="idMedida">
					<option value="0">Selecciona una medida</option>
					<?php
                	for($i=0;$i<count($medidas);$i++){
						echo "<option value='{$medidas[$i]->idMedida}'>{$medidas[$i]->nombre}</option>";
					} ?>
				</select>
			</div>
	    </div>

		<div class="row">
	       	<div class="input-field col s10">
	       		<textarea name="descripcion" class="materialize-textarea" required></textarea>
	       		<label for="textarea1">Descripci&oacute;n</label>
	       	</div>
	    </div>
		<div class="row">
			<div class="input-field col s7 offset-s4">
			    <input type="submit" name="Agregar" class="btn wave-effect" id="entrar" value="Agregar" />
		    </div>
		</div>
	</form>
</div>	
<div class="divider"></div>
<!-- FIN Dar de alta nuevo modelo de proceso -->	

<!-- Mostrar modelos -->	
	<?php
	$_SESSION['pag_act'] = 'actividades';
	
	//$conex = new Conexion;
	
	//$actividades =  json_decode($conex->get("SELECT * FROM actividad"));
	
	if(count($actividades)==0){
		echo "<p class='yellow'>Lo sentimos <strong>no hay actividades</strong></p>";
		return;
	}


	//echo "<table id='example' class='cell-border'><tr><td>Nombre</td><td>Descripción</td><td>Tipo</td><td>Fase</td><td>Modelo</td></tr>";
	echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                //echo "<th>Elegir</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Descripción</th>";
                echo "<th style='text-align:center;'>Tipo</th>";
                echo "<th style='text-align:center;'>Medida</th>";
                echo "<th style='text-align:center;'>Fase</th>";
                echo "<th style='text-align:center;'>Modelo</th>";
                echo "<th style='text-align:center;'>Depende de</th>";
                echo "<th></th><th></th>";
            echo "</tr>";
        echo "</thead>";

	for($i=0;$i<count($actividades);$i++){
		//echo "<form action='' method='POST'>";
			echo "<tr>";
				echo "<td>".$actividades[$i]->nombre."</td>";
				echo "<td>".$actividades[$i]->descripcion."</td>";
				echo "<td>".$actividades[$i]->tipo."</td>";
				$query = "SELECT Medida_idMedida FROM actmed WHERE Actividad_idActividad=".$actividades[$i]->idActividad;
				$consulta = json_decode($conex->getById($query));
				if($consulta!=null){
					$query = "SELECT nombre FROM medida WHERE idMedida=".$consulta->Medida_idMedida;
					$medida = json_decode($conex->getById($query));
					
					echo "<td>".$medida->nombre."</td>";
				}
				else
					echo "<td>No se ha añadido una medida</td>";
				$query = "SELECT Modelo_P_idModelo_P,nombre FROM fase WHERE idFase=".$actividades[$i]->Fase_idFase;
				$fase = json_decode($conex->getById($query));
				echo "<td>".$fase->nombre."</td>";
				$query = "SELECT nombreM,version FROM modelo_P WHERE idModelo_P=".$fase->Modelo_P_idModelo_P;
				$model = json_decode($conex->getById($query));
				echo "<td>".$model->nombreM." V ".$model->version."</td>";
				echo "<td>".$nomDependencias[$i]."</td>";
				echo "<td style='text-align:center;'><a href='#!' id='".$actividades[$i]->idActividad."' class='miActividad btn-floating btn-large waves-effect waves-light blue'><i class='mdi-action-settings'>Editar</i></a></td>";
				echo "<td style='text-align:center;'>
				<form class='eliminarActividad' id='eliminarActividad-".$i."' method='POST'>
					<input type='hidden' id='idActividad-".$i."' value='".$actividades[$i]->idActividad."'/>
					<input type='hidden'  id='nombreAct-".$i."' value='".$actividades[$i]->nombre."'/>
					<button type='submit' name='eliminar' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button>
				</form></td>";
				
			echo "</tr>";
		//echo "</form>";
	}

	echo "</table>";
	//include ("printModelos.php");
	?>
<!-- FIN mostrar modelos -->
<div id="confirmDeleteAct" class="modal bottom-sheet">
	<form id='eliminarActividadForm' method='POST' action="actividadesMetodos.php">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h4 id="nomActividad"></h4>
			</div>
		</div>
		<p>Toma en cuenta que si eliminas esta actividad puedes afectar a otros datos.<br/>
		Se eliminar&aacute;n aquellas <b>tareas</b>, <b>entradas</b>, <b>salidas</b> y <b>gu&iacute;as</b> que contenga esta actividad.</p>
		<input type='hidden' name='idActividad' id='idActividadForm'/>
		<input type='hidden'  id='nombreActForm' name="nombreAct" />
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat" style="color:blue;">Cancelar</a>
		<input type="submit" name="eliminar" class="wavs-effects wavs-green btn-flat" value="Si deseo eliminar la actividad" style="color:red;"/>
	</div>
	</form>
</div>

<div id="editarActividad" class="modal">
	<form id='actualizarActividadForm' method='POST' action="actividadesMetodos.php">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h4 id="nomActivity"></h4>
			</div>
			<div class="input-field col s6">
			   	<input type="text" name="nombre" id="nombreEdit" required />
				<label for="icon_prefix">Nombre de la actividad</label>
		    </div>
		    <div class="input-field col s6">
			   	<input type="text" name="tipo" id="tipoEdit"required />
				<label for="icon_prefix">Tipo</label>
		    </div>
		</div>
		<div class="row">
			<div class="col s6">
				<label>Modelo al que pertenece</label>
				<select class="browser-default" id="modelsEdit">
					<option value="0">Selecciona un modelo</option>
				<?php
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM} V {$misModelos[$i]->version}</option>";
					} 
				?>
				</select>
		    </div>
		    <div class="col s6">
				<label>Fase a la que pertenece</label>
				<select class="fasesEditOptions browser-default" name="idFase" id="idfasesEdit">
					<option value="0">Selecciona una fase</option>
				</select>
		    </div>
		</div>
		<!-- Combo de dependencias. NOTA: La primera vez que se agrega una actividad esta no tiene ninguna dependencia, pero la segunda se le va a habilitar el combo de las dependencias -->
	    <?php  
	    	if (count($actividades) > 1) {
	    ?>
	    		<div class="row">
	    			<div class="col s10">
						<label>Depende de:</label>
						<select class="browser-default" id="dependenciaEdit" name="dependencia">
						</select>
		    		</div>	
	    		</div>		
	    <?php		
	    	}
	    ?>
	    <!-- F I N .. combo de dependencias -->
		<div class="row">
	       	<div class="input-field col s10">
	       		<textarea name="descripcion" class="materialize-textarea" id="descripcionEdit" required></textarea>
	       		<label for="textarea1">Descripci&oacute;n</label>
	       	</div>
	    </div>
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat" style="color:red;">Cancelar</a>
		<input type="hidden" name="id" id="idActividadEdit">
		<input type="submit" name="Actualizar" class="wavs-effects wavs-green btn-flat" style="color:blue;" value="Actualizar información" />
	</div>
	</form>;
</div>
<div class="row"></div>
<br>