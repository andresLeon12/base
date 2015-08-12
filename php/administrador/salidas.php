

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

	$misModelos =  json_decode($conex->get("SELECT idModelo_P,nombreM,version FROM modelo_p"));
 ?>




<div class="container">	


<!-- Dar de alta una nueva entrada-->
<div class="row">
	<div class="col s6">
		<blockquote><h5>Nueva Salida</h5></blockquote>		
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
	<form  action="salidasMetodos.php" method="POST" id="submitEnt">
		<div class="row">
			<div class="input-field col s6">
			   	<input type="text" name="nombre" id="nombre"required />
				<label for="icon_prefix">Nombre de la salida</label>
		    </div>
		    <div class=" col s6">
			   	<label>Modelo al que pertenece</label>
				<select name='modeloN' class="browser-default" id="models">
				<?php
					echo "<option value='0'>Seleccione un Modelo de Proceso</option>";
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM} V {$misModelos[$i]->version}</option>";
					} ?>
				</select>
		    </div>
		</div>
		<div class="row">
			<div class="col s6">
				<label>Fase a la que pertenece</label>
				<select class="browser-default" name="idFase" id="idfases" required><option>Selecciona una fase</option></select>
		    </div>
		    <div class="col s6">
				<label>Actividad a la que pertenece</label>
				<select class="browser-default" name="idActividad" id="idActividades" required><option>Selecciona una actividad</option></select>
		    </div>
		</div>
		<div class="row">
	       	<div class="input-field col s10 offset-s1">
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
<!-- FIN Dar de alta una nueva salida-->	









<!-- Mostrar salidas -->	
	<?php
	$_SESSION['pag_act'] = 'salidas';
	$conex = new Conexion;
	$salidas =  json_decode($conex->get("SELECT * FROM salida"));

	if(count($salidas)==0){
		echo "<p class='yellow'>Lo sentimos <strong>no hay salidas</strong></p>";
		return;
	}


	echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
     
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Descripción</th>";
                echo "<th style='text-align:center;'>Actividad a la que pertenece</th>";
                echo "<th style='text-align:center;'>Fase</th>";
                echo "<th style='text-align:center;'>Modelo</th>";
                echo "<th></th><th></th>";
            echo "</tr>";
        echo "</thead>";

	for($i=0;$i<count($salidas);$i++){
		//echo "<form action='' method='POST'>";
	

			echo "<tr>";
				echo "<td>".$salidas[$i]->nombre."</td>";
				echo "<td>".$salidas[$i]->descripcion."</td>";
				//echo $salidas[$i]->idEntrada;
				$query = "SELECT Actividad_idActividad FROM act_sal  WHERE Salida_idSalida=".$salidas[$i]->idSalida;
				
				$idDeActividad = json_decode($conex->getById($query));

				//echo "Este   = ".$idDeActividad->Actividad_idActividad;


				$query = "SELECT nombre,idActividad,Fase_idFase FROM actividad WHERE idActividad=".$idDeActividad->Actividad_idActividad;//////////////
				$actividad = json_decode($conex->getById($query));

				echo "<td>".$actividad->nombre."</td>";

				$query = "SELECT nombre,Modelo_P_idModelo_P FROM fase WHERE idFase=".$actividad->Fase_idFase;
				$fase = json_decode($conex->getById($query));

				echo "<td>".$fase->nombre."</td>";

				$query = "SELECT nombreM FROM modelo_p WHERE idModelo_P=".$fase->Modelo_P_idModelo_P;
				$modelo = json_decode($conex->getById($query));

				echo "<td>".$modelo->nombreM."</td>";

				echo "<td><a href='#editSalida' id='".$salidas[$i]->idSalida."' class='miSalida btn-floating btn-large waves-effect waves-light blue'><i class='mdi-action-settings'>Editar</i></a></td>";
				echo "<td>
				<form class='eliminarSalida' id='eliminarSalida-".$i."' method='POST'>
					<input type='hidden' id='idSalida-".$i."' value='".$salidas[$i]->idSalida."'/>
					<input type='hidden'  id='nombreSal-".$i."' value='".$salidas[$i]->nombre."'/>
					<button type='submit' name='eliminarSalida'  class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button>
				</form></td>";
				
			echo "</tr>";
		//echo "</form>";
	}

	echo "</table>";
	//include ("printModelos.php");
	?>
<!-- FIN mostrar salidas -->
<div id="confirmDeleteSal" class="modal bottom-sheet">
	<form id='eliminarSalidaForm' method='POST' action="salidasMetodos.php">
	<div class="modal-content">
		<div class="row">
			<div class="col s3">
				<h4 id="nomSalida" class="grey-text"></h4>
			</div>
		</div>
		
		<input type='hidden' name='idSalida' id='idSalidaForm'/>
		<input type='hidden'  id='nombreActForm' name="nombreSal" />
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cancelar</a>
		<input type="submit" name="eliminar" class="wavs-effects wavs-green btn-flat" value="Si deseo eliminar la salida" />
	</div>
	</form>;
</div>

<!-- EDITAR SALIDA-->

<div id="editarSalida" class="modal">
	<form id='actualizaSalidaForm' method='POST' action="salidasMetodos.php">
	<div class="modal-content">
		<h3 id="titulo"></h3>
		<div class="row">
			<div class="input-field col s6">
			   	<input type="text" name="nombre" id="nombreSalidaEdit"required />
				<label for="icon_prefix">Nombre de la Salida</label>
		    </div>
		    <div class=" col s6">
			   	<label>Modelo al que pertenece</label>
				<select name='modeloN' class="browser-default" id="modelsEdit">
				<?php
					echo "<option value='0'>Seleccione un Modelo de Proceso</option>";
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM} V {$misModelos[$i]->version}</option>";
					}
					 ?>
				</select>
		    </div>
		</div>
		<div class="row">
			<div class="col s6">
				<label>Fase a la que pertenece</label>
				<select class="browser-default" name="idFase" id="idfasesEdit" required><option >Selecciona una fase</option></select>
		    </div>
		    <div class="col s6">
				<label>Actividad a la que pertenece</label>
				<select class="browser-default" name="idActividad" id="idActividadesEdit" required><option>Selecciona una actividad</option></select>
		    </div>
		</div>
		<div class="row">
	       	<div class="input-field col s10 offset-s1">
	       		<textarea name="descripcion" class="materialize-textarea" id="descripcionEdit" required></textarea>
	       		<label for="textarea1">Descripci&oacute;n</label>
	       	</div>
	    </div>
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cancelar</a>
		<input type="hidden" name="id" id="idActividadEdit">
		<input type="submit" name="Actualizar" class="wavs-effects wavs-green btn-flat" value="Actualizar información" />
	</div>
	</form>;
</div>
<div class="row"></div>
<br>
