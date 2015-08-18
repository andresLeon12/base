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
			if (count($dependeDe_act) > 0) {
				array_push($nomDependencias, $dependeDe_act[0]->nombre);
			}else{
				array_push($nomDependencias, "No tiene dependencia");	
			}
		}
	}

 ?>

<div class="row"></div>
<div class="container">	

<!-- Dar de alta nuevo modelo de proceso -->
<!-- Switch para mostrar y ocultar formulario y tabla de resultados -->
<div class="row">
	<div class="col s6 offset-s3">
	<div class="switch">
		<label>
		    Mostrar formulario
		    <input type="checkbox" id="selectContent">
		    <span class="lever"></span>
		    Mostrar actividades
		</label>
	 </div>
	 </div>
</div>
<!-- Fin switch -->
	<div class="row">
		<div class="col s6">
			<blockquote><h5 id="title">Nueva actividad</h5></blockquote>		
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
	<div id="Formulario">
		<form  action="actividadesMetodos.php" method="POST" id="submitAct"  enctype="multipart/form-data">
			<div class="row">
			<div class="col s6">
				<label>Modelo al que pertenece</label>
				<select class="browser-default" id="models" name="idModel"><option>Selecciona un modelo</option>
				<?php
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM} V {$misModelos[$i]->version}</option>";
					} ?>
				</select>
		    </div>
		    <div class="col s6">
				<label>Fase a la que pertenece</label>
				<select class="fasesOptions browser-default" name="idFase" id="idfases" required disabled="true"><option>Selecciona una fase</option></select>
		    </div>
		</div>
		<div class="row">
			<div class="col s6">
			<label for="icon_prefix">Id de la actividad:</label>
				<label for="idAct" id="idAct"><b></b></label>
			   	<input type="number" min="1" name="identif" id="id_Act" required onkeyup="concatenarIdActividad()" onclick="concatenarIdActividad()" disabled="true" />
			   	<input type="hidden" name="identificador" id="idActividad" required/>
		    </div>
		    <div class="col s6">
			<label for="icon_prefix">Nombre de la actividad</label>
			   	<input type="text" name="nombre" id="nombre"required disabled="true" />
				
		    </div>
		</div>
		<div class="row">
			
		    <div class="input-field col s6">
			   	<input type="text" name="tipo" id="tipo"required disabled="true"/>
				<label for="icon_prefix">Tipo</label>
		    </div>
		    <div class="input-field col s6">
	       		<textarea name="descripcion" id="descripcion" class="materialize-textarea" required disabled="true"></textarea>
	       		<label for="textarea1">Descripci&oacute;n</label>
	       	</div>
		</div>
		<div class="row">
		<!-- Combo de dependencias. NOTA: La primera vez que se agrega una actividad esta no tiene ninguna dependencia, pero la segunda se le va a habilitar el combo de las dependencias -->
	    <?php  
	    	if (count($actividades) > 0) {
	    ?>
	    			<div class="col s6">
						<label>Depende de:</label>
						<select class="browser-default" id="dependencia" name="dependencia" disabled="true">
							<option value="0">Selecciona una dependencia</option>
							<?php
                				/*for( $i = 0 ; $i < count($actividades) ; $i++ ){
									echo "<option value='{$actividades[$i]->idActividad}'>{$actividades[$i]->nombre}</option>";
								} */
							?>
						</select>
		    		</div>	
	    		<!--/div-->		
	    <?php		
	    	}
	    ?>
	    <div class="col s6">
				    	<label>Medida</label>
							<select class="browser-default" id="idMedida" name="idMedida" disabled="true">
								<option value="0">Selecciona una medida</option>
								<?php
			                	for($i=0;$i<count($medidas);$i++){
									echo "<option value='{$medidas[$i]->idMedida}'>{$medidas[$i]->nombre}</option>";
								} ?>
							</select>
						</div>
				    </div>
	    <!-- F I N .. combo de dependencias -->
		    <!-- Agregamos guias -->
		    <div class="divider row"></div>
			    <fieldset id='ocultoGuia' style='display:none'>
			    <legend>Gu&iacute;as:</legend>
			    <div class="row">
			    	<div class="file-field input-file col s6">
			    	<span>Podr&aacute;s agregar una gu&iacute; en otro momento.</span>
				    	<div class="row">
					    	<div class="col s3">
					    		<input class="file-path validate" type="text" style='width: 0'>
								<div class="waves-effect waves-teal btn-flat">
									<span>Cargar</span>
									<input type="file" name="guia" id="guia" />
								</div>
					    	</div>
					    	<div class="col s6" style="position:relative;top:30px;">
				    			<input class="file-path validate" type="text" readonly="" id="prewievGuia" >
				    		</div>
				    	
						</div>
				    </div>
				    <div class="input-field col s6">
				    	<textarea name="descripcionGuia" id="descripcionGuia" class="materialize-textarea" length='45'></textarea>
			          	<label for="textarea1">Descripci&oacute;n</label>
				    </div>
			    </div>
			    </fieldset>
			<!-- Agregamos activos -->
			<div class="divider row"></div>
			    <fieldset id='ocultoActivo' style='display:none'>
			    <legend>Activos:</legend>
			    <div class="row">
			    	<div class="file-field input-file col s6">
			    	<span>Podr&aacute;s agregar un activo en otro momento.</span>
				    	<div class="row">
					    	<div class="col s3">
					    		<input class="file-path validate" type="text" style='width: 0'>
								<div class="waves-effect waves-teal btn-flat">
									<span>Cargar</span>
									<input type="file" name="activo" id="activo" />
								</div>
					    	</div>
					    	<div class="col s6" style="position:relative;top:30px;">
				    			<input class="file-path validate" type="text" readonly="" id="previewActivo" >
				    		</div>
				    	
						</div>
				    </div>
				    <div class="input-field col s6">
				    	<textarea name="descripcionActivo" id="descripcionActivo" class="materialize-textarea" length='45'></textarea>
			          	<label for="textarea1">Descripci&oacute;n</label>
				    </div>
			    </div>
			    </fieldset>
			<div class="row">
				<div class="input-field col s7 offset-s4">
				    <input type="submit" name="Agregar" class="btn wave-effect" id="entrar" value="Agregar" />
			    </div>
			</div>
		</form>
	</div>	
<div class="divider"></div>
</div>
<div id="resultados" style="display:none">
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
	echo "<table id='example' class='cell-border responsive-table' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                echo "<th style='text-align:center;'>Identificador</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Descripción</th>";
                echo "<th style='text-align:center;'>Tipo</th>";
                echo "<th style='text-align:center;'>Medida</th>";
                echo "<th style='text-align:center;'>Fase</th>";
                echo "<th style='text-align:center;'>Modelo</th>";
                echo "<th style='text-align:center;'>Depende de</th>";
                echo "<th style='text-align:center;'>Guías</th>";
                echo "<th style='text-align:center;'>Activos</th>";
                echo "<th></th><th></th>";
            echo "</tr>";
        echo "</thead>";

	for($i=0;$i<count($actividades);$i++){
		//echo "<form action='' method='POST'>";
			echo "<tr>";
				echo "<td>".$actividades[$i]->identificador."</td>";
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
				echo "<td style='text-align:center;'>
				<form class='showMyGuias' id='showMyGuias-".$i."' method='POST'>
					<input type='hidden' id='idActividadF2-".$i."' value='".$actividades[$i]->idActividad."'/>
					<input type='hidden'  id='nombreActF2-".$i."' value='".$actividades[$i]->nombre."'/>
					<button type='submit' class='btn-flat'>Ver</button>
				</form><button type='button' class='btn-flat' onclick='nuevaGuia({$actividades[$i]->idActividad},{$fase->Modelo_P_idModelo_P})'>Nuevo</button></td>";
				echo "<td style='text-align:center;'>
				<form class='showMyActivos' id='showMyActivos-".$i."' method='POST'>
					<input type='hidden' id='idActividadF1-".$i."' value='".$actividades[$i]->idActividad."'/>
					<input type='hidden'  id='nombreActF1-".$i."' value='".$actividades[$i]->nombre."'/>
					<button type='submit' class='btn-flat'>Ver</button>
				</form><button type='button' class='btn-flat' onclick='nuevoActivo({$actividades[$i]->idActividad},{$fase->Modelo_P_idModelo_P})'>Nuevo</button></td>";
				echo "<td style='text-align:center;'><a href='#!' id='".$actividades[$i]->idActividad."' class='miActividad btn-floating btn-large waves-effect waves-green'><i class='mdi-action-settings'></i></a></td>";
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
</div>
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
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat" >Cancelar</a>
		<input type="submit" name="eliminar" class="wavs-effects wavs-green btn-flat" value="Si deseo eliminar la actividad" />
	</div>
	</form>
</div>

<div id="editarActividad" class="modal">
	<form id='actualizarActividadForm' method='POST' action="actividadesMetodos.php">
	<div class="modal-content">
		<div class="col s12">
			<h4 id="nomActivity"></h4>
			<h5 id="idActual"></h5>
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
		<div class="row">
			<div class="col s6">
			   	<!--div class="col s6">
					<label for="icon_prefix">Id de la actividad:</label>
					<label for="idAct" id="idAct"><b></b></label>
				   	<input type="number" min="1" name="identif" id="id_Act" required onkeyup="concatenarIdActividad()" onclick="concatenarIdActividad()" disabled="true" />
				   	<input type="hidden" name="identificador" id="idActividad" required/>
			    </div-->
			    <label for="icon_prefix">Id de la actividad</label>
			    <label for="idAct2" id="idAct2"></label>
				<input type="number" min="1" name="identif2" id="id_Act2" required onkeyup="concatenarIdActividad2()" onclick="concatenarIdActividad2()"/>
			    <input type="hidden" name="identificador" id="identificadorEdit" required />
		    </div>
			<div class="input-field col s6">
			   	<input type="text" name="nombre" id="nombreEdit" required />
				<label for="icon_prefix">Nombre de la actividad</label>
		    </div>
		</div>
		<div class="row">			
		    <div class="input-field col s12">
			   	<input type="text" name="tipo" id="tipoEdit"required />
				<label for="icon_prefix">Tipo</label>
		    </div>
		</div>
		<!-- Combo de dependencias. NOTA: La primera vez que se agrega una actividad esta no tiene ninguna dependencia, pero la segunda se le va a habilitar el combo de las dependencias -->
	    <?php  
	    	if (count($actividades) > 1) {
	    ?>
	    		<div class="row">
	    			<div class="col s6">
						<label>Depende de:</label>
						<select class="browser-default" id="dependenciaEdit" name="dependencia">
						</select>
		    		</div>
		    		<div class="col s6">
				    	<label>Medida</label>
							<select class="browser-default" id="idMedidaEdit" name="idMedida">
								<option value="0">Selecciona una medida</option>
								<?php
			                	for($i=0;$i<count($medidas);$i++){
									echo "<option value='{$medidas[$i]->idMedida}'>{$medidas[$i]->nombre}</option>";
								} ?>
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
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat" >Cancelar</a>
		<input type="hidden" name="id" id="idActividadEdit">
		<input type="hidden" name="idMedidaOld" id="idMedidaOld">
		<input type="submit" name="Actualizar" class="wavs-effects wavs-green btn-flat" value="Actualizar información" />
	</div>
	</form>;
</div>
<div class="row"></div>
<br>
<!-- modals de activos -->
<?php

echo '<div id="resultadosActivos" class="modal">';
echo '<div class="modal-content">';
	//echo "<table id='example' class='cell-border'><tr><td>Nombre</td><td>Descripción</td><td>Tipo</td><td>Fase</td><td>Modelo</td></tr>";
	echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                //echo "<th>Elegir</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Descripción</th>";
                echo "<th></th><th></th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody id='resultadosTable'></tbody>";
	echo "</table>";
	echo '</div><div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat" >Cerrar</a>
	</div>';
echo '</div>';
	?>
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
<!-- modals de guias -->
<?php

echo '<div id="resultadosGuias" class="modal">';
echo '<div class="modal-content">';
	//echo "<table id='example' class='cell-border'><tr><td>Nombre</td><td>Descripción</td><td>Tipo</td><td>Fase</td><td>Modelo</td></tr>";
	echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                //echo "<th>Elegir</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Descripción</th>";
                echo "<th></th><th></th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody id='resultadosTable2'></tbody>";
	echo "</table>";
	echo '</div><div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat" >Cerrar</a>
	</div>';
echo '</div>';
	?>
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
<!-- modal editar guia -->
<div id="editarGuia" class="modal">
	<form id='actualizarGuiaForm' method='POST' action="guiasMetodos.php" enctype="multipart/form-data">
	<div class="modal-content">
		<fieldset>
			<legend>Gu&iacute;as:</legend>
			    <div class="row">
			    	<div class="file-field input-file col s6">
				    	<div class="row">
					    	<div class="col s3">
					    		<input class="file-path validate" type="text" style='width: 0'>
								<div class="waves-effect waves-teal btn-flat">
									<span>Reemplazar</span>
									<input type="file" name="guia" id="guia2" />
								</div>
					    	</div>
					    	<div class="col s6" style="position:relative;top:30px;">
				    			<input class="file-path validate" type="text" readonly="" id="prewievGuia2" >
				    		</div>
				    	
						</div>
				    </div>
				    <div class="input-field col s6">
				    	<textarea name="descripcionGuia" id="descripcionGuia2" class="materialize-textarea" length='45'></textarea>
			          	<label for="textarea1">Descripci&oacute;n</label>
				    </div>
			    </div>
		</fieldset>

	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cancelar</a>
		<input type="hidden" name="id" id="idGuiaEdit">
		<input type="hidden" name="linkOldFile" id="linkOldFile">
		<input type="submit" tabindex="6" name="Actualizar" class="wavs-effects wavs-green btn-flat" value="Actualizar información" />
	</div> 
	</form>
</div>
<!-- modal editar activo -->
<div id="editarActivo" class="modal">
	<form id='actualizarActivoForm' method='POST' action="activosMetodos.php" enctype="multipart/form-data">
	<div class="modal-content">
		<fieldset>
			<legend>Activos:</legend>
			    <div class="row">
			    	<div class="file-field input-file col s6">
				    	<div class="row">
					    	<div class="col s3">
					    		<input class="file-path validate" type="text" style='width: 0'>
								<div class="waves-effect waves-teal btn-flat">
									<span>Reemplazar</span>
									<input type="file" name="activo" id="activo2" />
								</div>
					    	</div>
					    	<div class="col s6" style="position:relative;top:30px;">
				    			<input class="file-path validate" type="text" readonly="" id="prewievActivo2" >
				    		</div>
				    	
						</div>
				    </div>
				    <div class="input-field col s6">
				    	<textarea name="descripcionActivo" id="descripcionActivo2" class="materialize-textarea" length='45'></textarea>
			          	<label for="textarea1">Descripci&oacute;n</label>
				    </div>
			    </div>
		</fieldset>

	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cancelar</a>
		<input type="hidden" name="id" id="idActivoEdit">
		<input type="hidden" name="linkOldFile" id="linkOldFile2">
		<input type="submit" tabindex="6" name="Actualizar" class="wavs-effects wavs-green btn-flat" value="Actualizar información" />
	</div> 
	</form>
</div>
<!-- modal nuevo activo -->
<div id="nuevoActivo" class="modal">
	<form id='nuevoActivoForm' method='POST' action="activosMetodos.php" enctype="multipart/form-data">
	<div class="modal-content">
		<fieldset>
			    <legend>Activos:</legend>
			    <div class="row">
			    	<div class="file-field input-file col s6">
				    	<div class="row">
					    	<div class="col s3">
					    		<input class="file-path validate" type="text" style='width: 0'>
								<div class="waves-effect waves-teal btn-flat">
									<span>Cargar</span>
									<input type="file" name="activo" id="activo3" />
								</div>
					    	</div>
					    	<div class="col s6" style="position:relative;top:30px;">
				    			<input class="file-path validate" type="text" readonly="" id="previewActivo3" >
				    		</div>
				    	
						</div>
				    </div>
				    <div class="input-field col s6">
				    	<textarea name="descripcionActivo" id="descripcionActivo3" class="materialize-textarea" length='45'></textarea>
			          	<label for="textarea1">Descripci&oacute;n</label>
				    </div>
			    </div>
			    </fieldset>

	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cancelar</a>
		<input type="hidden" name="idActividad" id="idActividadNuevoActivo" />
		<input type="hidden" name="idModel" id="idModelNuevoActivo" />
		<input type="submit" tabindex="6" name="Agregar" class="wavs-effects wavs-green btn-flat" value="Agregar" />
	</div> 
	</form>
</div>
<!-- modal nueva guia -->
<div id="nuevaGuia" class="modal">
	<form id='nuevaGuiaForm' method='POST' action="guiasMetodos.php" enctype="multipart/form-data">
	<div class="modal-content">
		<fieldset>
			    <legend>Guias:</legend>
			    <div class="row">
			    	<div class="file-field input-file col s6">
				    	<div class="row">
					    	<div class="col s3">
					    		<input class="file-path validate" type="text" style='width: 0'>
								<div class="waves-effect waves-teal btn-flat">
									<span>Cargar</span>
									<input type="file" name="guia" id="guia3" />
								</div>
					    	</div>
					    	<div class="col s6" style="position:relative;top:30px;">
				    			<input class="file-path validate" type="text" readonly="" id="previewGuia3" >
				    		</div>
				    	
						</div>
				    </div>
				    <div class="input-field col s6">
				    	<textarea name="descripcionGuia" id="descripcionGuia3" class="materialize-textarea" length='45'></textarea>
			          	<label for="textarea1">Descripci&oacute;n</label>
				    </div>
			    </div>
			    </fieldset>

	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cancelar</a>
		<input type="hidden" name="idActividad" id="idActividadNuevaGuia" />
		<input type="hidden" name="idModel" id="idModelNuevaGuia" />
		<input type="submit" tabindex="6" name="Agregar" class="wavs-effects wavs-green btn-flat" value="Agregar" />
	</div> 
	</form>
</div>
