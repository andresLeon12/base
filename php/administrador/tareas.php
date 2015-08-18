<script type="text/javascript" language="javascript" class="init">
	$(document).ready(function() {
		$('#example').DataTable();
	});
</script>

<div class="row"></div>
<div class="container">	
<?php  

if (session_id()==null)
	session_start();

include_once ("../Conexion.class.php");
$conex = new Conexion;
$misModelos =  json_decode($conex->get("SELECT idModelo_P,nombreM,version FROM modelo_p"));
//$misActividades =  json_decode($conex->get("SELECT idActividad,nombre FROM actividad"));
?>
<!-- Dar de alta nueva fase del modelo -->
<div class="row">
	<div class="col s6">
		<blockquote><h5>Nueva Tarea</h5></blockquote>		
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
	<form  action="tareasMetodos.php" method="POST" id="submitFases">
		<div class="row">
			<div class="input-field col s6">
				<input type="text" name="nombre" id="nombre"required />
				<label for="icon_prefix">Nombre de la fase</label>
			   </div>
			<div class="col s6">
				<label>Modelo al que pertenece</label>
				<select tabindex="1" class="browser-default" id="models" name='idModel'><option>Selecciona un modelo</option>
				<?php
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM} V {$misModelos[$i]->version}</option>";
					} ?>
				</select>
		    </div>
		</div>
		<div class="row">
			<div class="input-field col s6">
	       		<textarea name="descripcion" class="materialize-textarea" required></textarea>
	       		<label for="textarea1">Descripci&oacute;n</label>
	      	</div>
		    <div class="col s6">
				<label>Fase a la que pertenece</label>
				<select tabindex="2" class="browser-default" name="idFase" id="idfases" required><option>Selecciona una fase</option></select>
		    </div>
		    
		</div>
		<div class="row">
		    <div class="col s6">
				<label>Actividad a la que pertenece</label>
				<select tabindex="3" class="browser-default" name="actividadN" id="idActividades" required><option>Selecciona una Actividad</option></select>
		    </div>
		    <div class="col s3 offset-s2">
			    <input tabindex="7" type="submit" name="Agregar" class="btn wave-effect" id="entrar" value="Agregar" />
		    </div>
		</div>
	</form>
	</div>
<!-- FIN Dar de alta nueva fase del modelo -->	

<div id="msg">
	<?php  
    	if (isset($_SESSION['msj'])) {
          echo $_SESSION['msj'];
        }
        //echo "<br><br>{$misActividades[0]->nombreM}";
    ?>
</div>
<div class="divider"></div>
<!-- INICIO Mostrar Fases -->

<?php 
$_SESSION['pag_act'] = 'tareas';
$tareas =  json_decode($conex->get("SELECT * FROM tarea"));
$activity = array();

for ($i=0; $i < count($tareas); $i++) { 
	$idAct = $tareas[$i]->Actividad_idActividad;
	//echo $idAct."<br>";
	$auxActivitys =  json_decode($conex->get("SELECT * FROM actividad where idActividad=$idAct"));
	array_push($activity, $auxActivitys[0]->nombre);
}

if(count($tareas)==0){
	echo "<p class='yellow'>Lo sentimos <strong>no hay tareas</strong></p>";
	return;
}

echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                //echo "<th>Elegir</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Descripción</th>";
                echo "<th style='text-align:center;'>Actividad</th>";
                echo "<th style='text-align:center;'>Fase</th>";
                echo "<th style='text-align:center;'>Modelo</th>";
                echo "<th></th>";
                echo "<th></th>";
            echo "</tr>";
        echo "</thead>";

for($i=0;$i<count($tareas);$i++){
	echo "<tr>";
		echo "<td>".$tareas[$i]->nombre."</td>";
		echo "<td>".$tareas[$i]->descripcion."</td>";
		$query = "SELECT nombre,Fase_idFase FROM actividad WHERE idActividad=".$tareas[$i]->Actividad_idActividad;
		$actividad = json_decode($conex->getById($query));
		echo "<td>".$actividad->nombre."</td>";
		$query = "SELECT Modelo_P_idModelo_P,nombre FROM fase WHERE idFase=".$actividad->Fase_idFase;
		$fase = json_decode($conex->getById($query));
		echo "<td>".$fase->nombre."</td>";
		$query = "SELECT nombreM FROM modelo_P WHERE idModelo_P=".$fase->Modelo_P_idModelo_P;
		$model = json_decode($conex->getById($query));
		echo "<td>".$model->nombreM."</td>";
		echo "<td style='text-align:center;'><a href='#!' id='".$tareas[$i]->idTarea."' class='miTarea btn-floating btn-large waves-effect waves-green'><i class='mdi-action-settings'></i>Editar</a></td>";
		echo "<td style='text-align:center;'><form class='eliminarTarea' id='eliminarTarea-".$i."' method='POST'>";
			echo "<input type='hidden' value='".$tareas[$i]->idTarea."' name='idT' id='idT-".$i."'/>";
			echo "<input type='hidden' value='".$tareas[$i]->nombre."' name='nomT' id='nomT-".$i."'/>";
			echo "<button type='submit' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button>";
		echo "</form></td>";
	echo "</tr>";
}

echo "</table>";

?>
<!-- F I N Mostrar Fases -->

<!-- INICIO Modal que se muestra para editar -->
<div id="editarGuia" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h4 id="nomTarea"></h4>
			</div>			
		</div>
		<form action="tareasMetodos.php" method="POST">
		<input type="hidden" name="idTarea" id="idTarea"/>
			<div class="row">
				<div class="input-field col s6">
					<input type="text" name="nombre2" id="nombre2"required />
					<label for="icon_prefix">Nombre de la fase</label>
				   </div>
				<div class="col s6">
					<label>Modelo al que pertenece</label>
					<select tabindex="1" class="browser-default" id="modelsEdit" name='idModel'><option>Selecciona un modelo</option>
					<?php
	                	for($i=0;$i<count($misModelos);$i++){
							echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM}</option>";
						} ?>
					</select>
			    </div>
			</div>
			<div class="row">
				<div class="input-field col s6">
		       		<textarea name="descripcion2" id="descripcion2" class="materialize-textarea" required></textarea>
		       		<label for="textarea1">Descripci&oacute;n</label>
		      	</div>
			    <div class="col s6">
					<label>Fase a la que pertenece</label>
					<select tabindex="2" class="browser-default" name="idFase" id="idfasesEdit" required><option>Selecciona una fase</option></select>
			    </div>
			    
			</div>
			<div class="row">
			    <div class="col s6">
					<label>Actividad a la que pertenece</label>
					<select tabindex="3" class="browser-default" name="actividadN2" id="idActividadesEdit" required><option>Selecciona una Actividad</option></select>
			    </div>
			</div>
			<div class="modal-footer">
				<a class="modal-action modal-close wavs-effects wavs-green btn-flat" >Cancelar</a>
				<input type="submit" name="Editar" id="editar" class="wavs-effects wavs-green btn-flat"  value="Editar" />
			</div>
		</form>
	</div>
</div>
<!-- FIN  Modal que se muestra para editar -->

<!-- INICIO Modal que se muestra para eliminar -->
<div id="confirmDeleteTarea" class="modal bottom-sheet">
	<form action="tareasMetodos.php" method="POST">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h4 id="nameTarea"></h4>
			</div>			
		</div>
			<p>Toma en cuenta que si eliminas esta Tarea puedes afectar otros <b>datos</b>.<br/>
			<input type="hidden" id="idTareaForm" name="idTareaForm" />
			<input type="hidden" id="nombreTareaForm" name="nombreTareaForm" />
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cancelar</a>
		<input type="submit" name="eliminar" class="wavs-effects wavs-green btn-flat" value="Si deseo eliminar la fase" />
	</div>
	</form>
</div>
<!-- FIN  Modal que se muestra para eliminar -->

<div class="row"></div><br>