<script type="text/javascript" language="javascript" class="init">
	$(document).ready(function() {
		$('#example').DataTable();
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
		<blockquote><h5>Agregar un activo</h5></blockquote>		
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
	<form  action="activosMetodos.php" method="POST" id="submitactivos" enctype="multipart/form-data">
		<div class="row">
			<div class="col s6">
				<label>Modelo al que pertenece</label>
				<select tabindex="1" class="browser-default" id="models" name='idModel'><option>Selecciona un modelo</option>
				<?php
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM}</option>";
					} ?>
				</select>
		    </div>
		    <div class="input-field col s6">
	       		<textarea tabindex="4" name="descripcion" class="materialize-textarea" required></textarea>
	       		<label for="textarea1">Descripci&oacute;n</label>
	       	</div>
		    
		</div>
		<div class="row">
		    <div class="col s6">
				<label>Fase a la que pertenece</label>
				<select tabindex="2" class="browser-default" name="idFase" id="idfases" required><option>Selecciona una fase</option></select>
		    </div>
		    <div class="file-field input-file col s6">
		    	<div class="row">
			    	<div class="col s4">
			    		<input class="file-path validate" type="text" style='width: 0'>
						<div class="btn">
							<span>Subir archivo</span>
							<input tabindex="5" type="file" name="activo" id="activo" requerid />
						</div>
			    	</div>
			    	<div class="col s6">
		    			<input class="file-path validate" type="text" readonly="" >
		    		</div>
		    	
				</div>
		    </div>
		</div>
		<div class="row">
		    <div class="col s6">
				<label>Actividad a la que pertenece</label>
				<select tabindex="3" class="browser-default" name="idActividad" id="idActividades" required><option>Selecciona una Actividad</option></select>
		    </div>
		    <div class="col s3 offset-s2">
			    <input tabindex="6" type="submit" name="Agregar" class="btn wave-effect" id="entrar" value="Agregar" />
		    </div>
		</div>
	</form>
</div>	
<div class="divider"></div>
<!-- FIN Dar de alta nuevo modelo de proceso -->	

<!-- Mostrar modelos -->	
	<?php
	$_SESSION['pag_act'] = 'activos';
	$conex = new Conexion;
	$activos =  json_decode($conex->get("SELECT * FROM activo"));
	if(count($activos)==0){
		echo "<p class='yellow'>Lo sentimos <strong>no hay activos</strong></p>";
		return;
	}


	//echo "<table id='example' class='cell-border'><tr><td>Nombre</td><td>Descripción</td><td>Tipo</td><td>Fase</td><td>Modelo</td></tr>";
	echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                //echo "<th>Elegir</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Descripción</th>";
                echo "<th style='text-align:center;'>Pertenece a la actividad</th>";
                echo "<th style='text-align:center;'>Pertenece a la fase</th>";
                echo "<th style='text-align:center;'>Pertenece al modelo</th>";
                echo "<th></th><th></th>";
            echo "</tr>";
        echo "</thead>";

	for($i=0;$i<count($activos);$i++){
		//echo "<form action='' method='POST'>";
			echo "<tr>";
				$name = $activos[$i]->nombre;
				$name = explode("/", $name);
				echo "<td><a target='blank' href='"."../../archivos/".$activos[$i]->nombre."'>".$name[1]."</a></td>";
				echo "<td>".$activos[$i]->descripcion."</td>";
				$query = "SELECT Actividad_idActividad FROM A_Activo WHERE Activo_idActivo=".$activos[$i]->idActivo;
				$A_Activo = json_decode($conex->getById($query));
				$query = "SELECT nombre,Fase_idFase FROM actividad WHERE idActividad=".$A_Activo->Actividad_idActividad;
				$actividad = json_decode($conex->getById($query));
				echo "<td>".$actividad->nombre."</td>";
				$query = "SELECT Modelo_P_idModelo_P,nombre FROM fase WHERE idFase=".$actividad->Fase_idFase;
				$fase = json_decode($conex->getById($query));
				echo "<td>".$fase->nombre."</td>";
				$query = "SELECT nombreM FROM modelo_P WHERE idModelo_P=".$fase->Modelo_P_idModelo_P;
				$model = json_decode($conex->getById($query));
				echo "<td>".$model->nombreM."</td>";
				echo "<td>
				<form class='eliminarActivo' id='eliminarActivo-".$i."' method='POST'>
					<input type='hidden' id='idActivo-".$i."' value='".$activos[$i]->idActivo."'/>
					<input type='hidden'  id='nombreActivo-".$i."' value='".$activos[$i]->nombre."'/>
					<button type='submit' name='eliminar' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button>
				</form></td>";
				echo "<td><a href='#!' id='".$activos[$i]->idActivo."' class='miActivo btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-settings'>Editar</i></a></td>";
			echo "</tr>";
		//echo "</form>";
	}

	echo "</table>";
	//include ("printModelos.php");
	?>
<!-- FIN mostrar modelos -->
<div id="confirmDeleteActivo" class="modal bottom-sheet">
	<form id='eliminarActivoForm' method='POST' action="activosMetodos.php">
	<div class="modal-content">
		<div class="row">
			<div class="col s3">
				<h4 id="nomActivo" class="grey-text"></h4>
			</div>
		</div>
		<p>Toma en cuenta que si eliminas este activo puedes afectar a otras actividades.<br/>
		Se eliminar&aacute;n aquellas tareas, entradas, salidas y gu&iacute;as que contenga esta actividad.</p>
		<input type='hidden' name='idActivo' id='idActivoForm'/>
		<input type='hidden'  id='nombreActivoForm' name="nombreActivo" />
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cancelar</a>
		<input type="submit" name="eliminar" class="wavs-effects wavs-green btn-flat" value="Si deseo eliminar el activo" />
	</div>
	</form>;
</div>

<div id="editarGuia" class="modal">
	<form id='actualizarGuiaForm' method='POST' action="activosMetodos.php" enctype="multipart/form-data">
	<div class="modal-content">
		<div class="row">
			<div class="col s6">
				<label>Modelo al que pertenece</label>
				<select tabindex="1" class="browser-default" id="modelsEdit" name='idModel'><option>Selecciona un modelo</option>
				<?php
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM}</option>";
					} ?>
				</select>
		    </div>
		    <div class="input-field col s6">
	       		<textarea tabindex="4" name="descripcion" class="materialize-textarea" id="descripcion" required></textarea>
	       		<label for="textarea1">Descripci&oacute;n</label>
	       	</div>
		    
		</div>
		<div class="row">
		    <div class="col s6">
				<label>Fase a la que pertenece</label>
				<select tabindex="2" class="browser-default" name="idFase" id="idfasesEdit" required><option>Selecciona una fase</option></select>
		    </div>
		    
		    <div class="file-field input-file col s6">
		    	<div class="row">
		    		<div class="col s2">
		    			<span>Archivo existente <a href="" target="blank" id="linkFileEditActivo"></a></span>
		    		</div>
		    	
				</div>
		    </div>
		    
		</div>
		<div class="row file-field input-file ">
			<div class="col s6">
				<label>Actividad a la que pertenece</label>
				<select tabindex="3" class="browser-default" name="idActividad" id="idActividadesEdit" required><option>Selecciona una Actividad</option></select>
		    </div>
			<div class="col s6">
				<div class="col s3">
			    		<input class="file-path validate" type="text" style='width: 0'>
						<div class="btn">
							<span>Subir archivo</span>
							<input tabindex="5" type="file" name="activo" id="activo" />
						</div>
			    	</div>
			    	<div class="col s4">
		    			<input class="file-path validate" type="text" readonly="" >
		    		</div>
		    </div>
		</div>
		<div class="row">
		</div>
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cancelar</a>
		<input type="hidden" name="id" id="idActivoEdit">
		<input type="hidden" name="linkOldFile" id="linkOldFile">
		<input type="submit" tabindex="6" name="Actualizar" class="wavs-effects wavs-green btn-flat" value="Actualizar información" />
	</div> 
	</form>
</div>
<div class="row"></div>
<br>