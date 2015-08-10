<script type="text/javascript" language="javascript" class="init">
	$(document).ready(function() {
		$('#example').DataTable();
		$('.datepicker').pickadate({
		    selectMonths: true, // Creates a dropdown to control month
		    selectYears: 15 // Creates a dropdown of 15 years to control year
		});
	});
</script>

<?php 
	if(session_id()==null)
		session_start();
	include_once("../Conexion.class.php");
	$conex = new Conexion;

	$misModelos =  json_decode($conex->get("SELECT idModelo_P,nombreM FROM modelo_p"));
 ?>
<div class="row"></div>
<div class="container">	
<!-- Dar de alta nuevo modelo de proceso -->
<div class="row">
	<div class="col s6">
		<blockquote><h5 id="typeRecurso">Agregar un recurso f&iacute;sico</h5></blockquote>		
	</div>
	<div class="col s6">
		<blockquote class="blockquote-right" id="errores"><?php 
		if(isset($_SESSION['msj'])!="") {
			echo $_SESSION['msj']; 
			$_SESSION['msj'] = '';
		}
		 ?></blockquote>
		 <div class="switch">
		    <label>
		      Recurso F&iacute;sico
		      <input type="checkbox" id="selectRecurso">
		      <span class="lever"></span>
		      Recurso Humano
		    </label>
		  </div>
	</div>
</div>
<div id="FormRecurso">
	<form  action="recursosMetodos.php" method="POST" id="submitRecursos">
		<div class="row" id="nombreDiv">
			<div class="input-field col s12">
				<input type="text" name="nombre" id="nombre" required length='45' />
				<label for="icon_prefix">Nombre</label>
		    </div>	    
		</div>
		<div class="row">
			<div class="col s6">
				<label>Modelo al que pertenece</label>
				<select class="browser-default" id="models" name='idModel' required><option>Selecciona un modelo</option>
				<?php
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM}</option>";
					} ?>
				</select>
		    </div>	
		    <div class="input-field col s6">
			   	<input type="text" name="carga_trabajo" id="carga_trabajo" required length='45' />
				<label for="icon_prefix">Carga de trabajo</label>
		    </div>	    
		</div>
		<div class="row">
		    <div class="col s6">
				<label>Fase a la que pertenece</label>
				<select class="browser-default" name="idFase" id="idfases" required ><option>Selecciona una fase</option></select>
		    </div>
		    <div class="col s6">
		    	<label>Tipo de recurso</label>
				<select class="browser-default" name="tipo" id="tipo" required>
					<option>Selecciona una opci&oacute;n</option>
					<option>Material</option>
					<option>Instalaci&oacute;n</option>
					<option>Equipo</option>
				</select>
	       	</div>
		    <!--div class="col s6">
		    	<label for="fecha_ini">Fecha de inicio</label>
		    	<input type="date" id="fecha_ini" name="fecha_ini" class="datepicker" required >
		    	<label for="fecha_fin">Fecha final</label>
		    	<input type="date" id="fecha_fin" name="fecha_fin" class="datepicker" required >
			    
		    </div>
		    -->
		</div>
		<div class="row">
		    <div class="col s6">
				<label>Actividad a la que pertenece</label>
				<select class="browser-default" name="idActividad" id="idActividades" required><option>Selecciona una Actividad</option></select>
		    </div>
		    <div class="input-field col s6" id="descripcionDiv" >
		    	<textarea name="descripcion" id="descripcion" class="materialize-textarea" required length='45'></textarea>
	       		<label for="textarea1">Descripci&oacute;n</label>
		    </div>
		</div>
		<div class="row">
			
		    
		    <div class="col s4 ofsset-s1">
		    <input type="hidden" id="tipo_recurso" name="tipo_recurso" value="fisico">
		    <input type="submit" name="Agregar" class="btn wave-effect" id="entrar" value="Agregar" />
		    </div>
		</div>
	</form>
</div>
</div>	
<div class="divider"></div>
<!-- FIN Dar de alta nuevo modelo de proceso -->	

<!-- Mostrar modelos -->	
	<?php
	$_SESSION['pag_act'] = 'recursos';
	$conex = new Conexion;
	$recursos =  json_decode($conex->get("SELECT * FROM recursof"));
	$recursosh =  json_decode($conex->get("SELECT * FROM recursoh"));
	if(count($recursos)==0){
		echo "<p class='yellow'>Lo sentimos <strong>no hay recursos</strong></p>";
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
                echo "<th style='text-align:center;'>Carga de trabajo</th>";
                echo "<th style='text-align:center;'>Pertenece a la actividad</th>";
                echo "<th style='text-align:center;'>Pertenece a la fase</th>";
                echo "<th style='text-align:center;'>Pertenece al modelo</th>";
                echo "<th></th><th></th>";
            echo "</tr>";
        echo "</thead>";

	for($i=0;$i<count($recursos);$i++){
		//echo "<form action='' method='POST'>";
			echo "<tr>";
				echo "<td>".$recursos[$i]->nombre."</td>";
				echo "<td>".$recursos[$i]->descripcion."</td>";
				echo "<td>Físico - ".$recursos[$i]->tipo."</td>";
				echo "<td>".$recursos[$i]->carga_trabajo."</td>";
				$query = "SELECT Actividad_idActividad FROM actividad_rf WHERE recursof_idrecursofisico=".$recursos[$i]->idRecursoFisico;
				$actividad_rf = json_decode($conex->getById($query));
				$query = "SELECT nombre,Fase_idFase FROM actividad WHERE idActividad=".$actividad_rf->Actividad_idActividad;
				$actividad = json_decode($conex->getById($query));
				echo "<td>".$actividad->nombre."</td>";
				$query = "SELECT Modelo_P_idModelo_P,nombre FROM fase WHERE idFase=".$actividad->Fase_idFase;
				$fase = json_decode($conex->getById($query));
				echo "<td>".$fase->nombre."</td>";
				$query = "SELECT nombreM FROM modelo_P WHERE idModelo_P=".$fase->Modelo_P_idModelo_P;
				$model = json_decode($conex->getById($query));
				echo "<td>".$model->nombreM."</td>";
				echo "<td>
				<form class='eliminarRecurso' id='eliminarRecurso-".$i."' method='POST'>
					<input type='hidden' id='idRecurso-".$i."' value='".$recursos[$i]->idRecursoFisico."'/>
					<input type='hidden'  id='nombreRecurso-".$i."' value='".$recursos[$i]->nombre."'/>
					<input type='hidden'  id='tipoRecurso-".$i."' value='fisico'/>
					<button type='submit' name='eliminar' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button>
				</form></td>";
				echo "<td><a href='#!' id='".$recursos[$i]->idRecursoFisico."' class='miRecurso btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-settings'>Editar</i></a></td>";
			echo "</tr>";
		$j = ($i+1);
	}
	for($i=0;$i<count($recursosh);$i++){
		//echo "<form action='' method='POST'>";
			echo "<tr>";
				echo "<td>".$recursosh[$i]->nombre."</td>";
				echo "<td>***</td>";
				echo "<td>Humano - ".$recursosh[$i]->tipo."</td>";
				echo "<td>".$recursosh[$i]->carga_trabajo."</td>";
				$query = "SELECT Actividad_idActividad FROM actividad_rh WHERE recursoh_idrecursohumano=".$recursosh[$i]->idRecursoHumano;
				$actividad_rh = json_decode($conex->getById($query));
				$query = "SELECT nombre,Fase_idFase FROM actividad WHERE idActividad=".$actividad_rh->Actividad_idActividad;
				$actividad = json_decode($conex->getById($query));
				echo "<td>".$actividad->nombre."</td>";
				$query = "SELECT Modelo_P_idModelo_P,nombre FROM fase WHERE idFase=".$actividad->Fase_idFase;
				$fase = json_decode($conex->getById($query));
				echo "<td>".$fase->nombre."</td>";
				$query = "SELECT nombreM FROM modelo_P WHERE idModelo_P=".$fase->Modelo_P_idModelo_P;
				$model = json_decode($conex->getById($query));
				echo "<td>".$model->nombreM."</td>";
				echo "<td>
				<form class='eliminarRecurso' id='eliminarRecurso-".($i+$j)."' method='POST'>
					<input type='hidden' id='idRecurso-".($i+$j)."' value='".$recursosh[$i]->idRecursoHumano."'/>
					<input type='hidden'  id='nombreRecurso-".($i+$j)."' value='".$recursosh[$i]->nombre."'/>
					<input type='hidden'  id='tipoRecurso-".($i+$j)."' value='humano'/>
					<button type='submit' name='eliminar' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button>
				</form></td>";
				echo "<td><a href='#!' id='".$recursosh[$i]->idRecursoHumano."' class='mirecurso btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-settings'>Editar</i></a></td>";
			echo "</tr>";
		//echo "</form>";
	}

	echo "</table>";
	//include ("printModelos.php");
	?>
<!-- FIN mostrar modelos -->
<div id="confirmDeleteRecurso" class="modal bottom-sheet">
	<form id='eliminarRecursoForm' method='POST' action="recursosMetodos.php">
	<div class="modal-content">
		<div class="row">
			<div class="col s3">
				<h4 id="nomRecurso" class="grey-text"></h4>
			</div>
		</div>
		<p>Toma en cuenta que si eliminas este recurso puedes afectar a otras actividades.<br/>
		Se eliminar&aacute;n aquellas tareas, entradas, salidas y gu&iacute;as que contenga esta actividad.</p>
		<input type='hidden' name='idRecurso' id='idRecursoForm'/>
		<input type='hidden' name='tipo_recurso' id='tipo_recurso'/>
		<input type='hidden'  id='nombreRecursoForm' name="nombreRecurso" />
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cancelar</a>
		<input type="submit" name="eliminar" class="wavs-effects wavs-green btn-flat" value="Si deseo eliminar el recurso" />
	</div>
	</form>;
</div>

<div id="editarGuia" class="modal">
	<form  action="recursosMetodos.php" method="POST" id="submitRecursos">
		<div class="row" id="nombreDiv">
			<div class="input-field col s12">
				<input type="text" name="nombre" id="nombre" required length='45' />
				<label for="icon_prefix">Nombre</label>
		    </div>	    
		</div>
		<div class="row">
			<div class="col s6">
				<label>Modelo al que pertenece</label>
				<select class="browser-default" id="models" name='idModel' required><option>Selecciona un modelo</option>
				<?php
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM}</option>";
					} ?>
				</select>
		    </div>	
		    <div class="input-field col s6">
			   	<input type="text" name="carga_trabajo" id="carga_trabajo" required length='45' />
				<label for="icon_prefix">Carga de trabajo</label>
		    </div>	    
		</div>
		<div class="row">
		    <div class="col s6">
				<label>Fase a la que pertenece</label>
				<select class="browser-default" name="idFase" id="idfases" required ><option>Selecciona una fase</option></select>
		    </div>
		    <div class="col s6">
		    	<label>Tipo de recurso</label>
				<select class="browser-default" name="tipo" id="tipo" required>
					<option>Selecciona una opci&oacute;n</option>
					<option>Material</option>
					<option>Instalaci&oacute;n</option>
					<option>Equipo</option>
				</select>
	       	</div>
		    <!--div class="col s6">
		    	<label for="fecha_ini">Fecha de inicio</label>
		    	<input type="date" id="fecha_ini" name="fecha_ini" class="datepicker" required >
		    	<label for="fecha_fin">Fecha final</label>
		    	<input type="date" id="fecha_fin" name="fecha_fin" class="datepicker" required >
			    
		    </div>
		    -->
		</div>
		<div class="row">
		    <div class="col s6">
				<label>Actividad a la que pertenece</label>
				<select class="browser-default" name="idActividad" id="idActividades" required><option>Selecciona una Actividad</option></select>
		    </div>
		    <div class="input-field col s6" id="descripcionDiv" >
		    	<textarea name="descripcion" id="descripcion" class="materialize-textarea" required length='45'></textarea>
	       		<label for="textarea1">Descripci&oacute;n</label>
		    </div>
		</div>
		<div class="row">
			
		    
		    <div class="col s4 ofsset-s1">
		    <input type="hidden" id="tipo_recurso" name="tipo_recurso" value="fisico">
		    <input type="submit" name="Agregar" class="btn wave-effect" id="entrar" value="Agregar" />
		    </div>
		</div>
	</form>
</div>
<div class="row"></div>
<br>