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
		<blockquote><h5>Agregar gu&iacute;as</h5></blockquote>		
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
	<form  action="guiasMetodos.php" method="POST" id="submitGuias" enctype="multipart/form-data">
		<div class="row">
			<div class="col s6">
				<label>Modelo al que pertenece</label>
				<select class="browser-default" id="models" name='idModel'><option>Selecciona un modelo</option>
				<?php
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM}</option>";
					} ?>
				</select>
		    </div>
		    <div class="input-field col s6">
			   	<input type="text" name="tipo" id="tipoGuia"required />
				<label for="icon_prefix">Tipo</label>
		    </div>
		    
		</div>
		<div class="row">
		    <div class="col s6">
				<label>Fase a la que pertenece</label>
				<select class="browser-default" name="idFase" id="idfases" required><option>Selecciona una fase</option></select>
		    </div>
		    <div class="file-field input-file col s6">
		    	<div class="row">
			    	<div class="col s4">
			    		<input class="file-path validate" type="text" style='width: 0'>
						<div class="btn">
							<span>Subir archivo</span>
							<input type="file" name="guia" id="guia" requerid />
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
				<select class="browser-default" name="idActividad" id="idActividades" required><option>Selecciona una Actividad</option></select>
		    </div>
		    <div class="col s3 offset-s2">
			    <input type="submit" name="Agregar" class="btn wave-effect" id="entrar" value="Agregar" />
		    </div>
		</div>
	</form>
</div>	
<div class="divider"></div>
<!-- FIN Dar de alta nuevo modelo de proceso -->	

<!-- Mostrar modelos -->	
	<?php
	$_SESSION['pag_act'] = 'guias';
	$conex = new Conexion;
	$guias =  json_decode($conex->get("SELECT * FROM guia"));
	if(count($guias)==0){
		echo "<p class='yellow'>Lo sentimos <strong>no hay guias</strong></p>";
		return;
	}


	//echo "<table id='example' class='cell-border'><tr><td>Nombre</td><td>Descripción</td><td>Tipo</td><td>Fase</td><td>Modelo</td></tr>";
	echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                //echo "<th>Elegir</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Pertenece a la actividad</th>";
                echo "<th style='text-align:center;'>Pertenece a la fase</th>";
                echo "<th style='text-align:center;'>Pertenece al modelo</th>";
                echo "<th></th><th></th>";
            echo "</tr>";
        echo "</thead>";

	for($i=0;$i<count($guias);$i++){
		//echo "<form action='' method='POST'>";
			echo "<tr>";
				$name = $guias[$i]->nombre;
				$name = explode("/", $name);
				echo "<td><a target='blank' href='"."../../archivos/".$guias[$i]->nombre."'>".$name[1]."</a></td>";
				$query = "SELECT Actividad_idActividad FROM A_Guia WHERE Guia_idGuia=".$guias[$i]->idGuia;
				$A_Guia = json_decode($conex->getById($query));
				$query = "SELECT nombre,Fase_idFase FROM actividad WHERE idActividad=".$A_Guia->Actividad_idActividad;
				$actividad = json_decode($conex->getById($query));
				echo "<td>".$actividad->nombre."</td>";
				$query = "SELECT Modelo_P_idModelo_P,nombre FROM fase WHERE idFase=".$actividad->Fase_idFase;
				$fase = json_decode($conex->getById($query));
				echo "<td>".$fase->nombre."</td>";
				$query = "SELECT nombreM FROM modelo_P WHERE idModelo_P=".$fase->Modelo_P_idModelo_P;
				$model = json_decode($conex->getById($query));
				echo "<td>".$model->nombreM."</td>";
				echo "<td>
				<form class='eliminarGuia' id='eliminarGuia-".$i."' method='POST'>
					<input type='hidden' id='idGuia-".$i."' value='".$guias[$i]->idGuia."'/>
					<input type='hidden'  id='nombreGuia-".$i."' value='".$guias[$i]->nombre."'/>
					<button type='submit' name='eliminar' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button>
				</form></td>";
				echo "<td><a href='#!' id='".$guias[$i]->idGuia."' class='miGuia btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-settings'>Editar</i></a></td>";
			echo "</tr>";
		//echo "</form>";
	}

	echo "</table>";
	//include ("printModelos.php");
	?>
<!-- FIN mostrar modelos -->
<div id="confirmDeleteGuia" class="modal bottom-sheet">
	<form id='eliminarGuiaForm' method='POST' action="guiasMetodos.php">
	<div class="modal-content">
		<div class="row">
			<div class="col s3">
				<h4 id="nomGuia" class="grey-text"></h4>
			</div>
		</div>
		<p>Toma en cuenta que si eliminas esta actividad puedes afectar a otras actividades.<br/>
		Se eliminar&aacute;n aquellas tareas, entradas, salidas y gu&iacute;as que contenga esta actividad.</p>
		<input type='hidden' name='idGuia' id='idGuiaForm'/>
		<input type='hidden'  id='nombreGuiaForm' name="nombreGuia" />
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cancelar</a>
		<input type="submit" name="eliminar" class="wavs-effects wavs-green btn-flat" value="Si deseo eliminar la guia" />
	</div>
	</form>;
</div>

<div id="editarGuia" class="modal">
	<form id='actualizarGuiaForm' method='POST' action="guiasMetodos.php" enctype="multipart/form-data">
	<div class="modal-content">
		<div class="row">
			<div class="col s6">
				<label>Modelo al que pertenece</label>
				<select class="browser-default" id="modelsEdit" name='idModel'><option>Selecciona un modelo</option>
				<?php
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM}</option>";
					} ?>
				</select>
		    </div>
		    <div class="input-field col s6">
			   	<input type="text" name="tipo" id="tipoEdit"required />
				<label for="icon_prefix">Tipo</label>
		    </div>
		    
		</div>
		<div class="row">
		    <div class="col s6">
				<label>Fase a la que pertenece</label>
				<select class="browser-default" name="idFase" id="idfasesEdit" required><option>Selecciona una fase</option></select>
		    </div>
		    
		    <div class="col s6">
		    	<div class="row">
		    		<div class="col s6">
		    			<span>Archivo existente <a href="" target="blank" id="linkFileEditGuia"></a></span>
		    		</div>
				</div>
		    </div>
		    
		</div>
		<div class="row file-field input-file ">
			<div class="col s6">
				<label>Actividad a la que pertenece</label>
				<select class="browser-default" name="idActividad" id="idActividadesEdit" required><option>Selecciona una Actividad</option></select>
		    </div>
			<div class="col s6">
				<div class="col s3">
			    		<input class="file-path validate" type="text" style='width: 0'>
						<div class="btn">
							<span>Subir archivo</span>
							<input type="file" name="guia" id="guia" />
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
		<input type="hidden" name="id" id="idGuiaEdit">
		<input type="hidden" name="linkOldFile" id="linkOldFile">
		<input type="submit" name="Actualizar" class="wavs-effects wavs-green btn-flat" value="Actualizar información" />
	</div> 
	</form>
</div>
<div class="row"></div>
<br>