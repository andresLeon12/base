

<script type="text/javascript" language="javascript" class="init">


	$(document).ready(function() {
		$('#example').DataTable();
		
	});


</script>

<div class="row"></div>
<div class="container">
<?php
if(session_id()==null)
		session_start();
?>


<!-- Dar de alta nuevo modelo de proceso -->
<div class="row">
	<div class="col s6">
		<blockquote><h5>Nuevo modelo de procesos</h5></blockquote>		
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
		<form  action="nuevoModelo.php" method="POST">
			<div class="row">
				<div class="input-field col s6">
				   	<input type="text" name="nombre" id="nombre"required />
					<label for="icon_prefix">Nombre del modelo</label>
			    </div>
			    <div class="input-field col s6">
				   	<input type="text" name="version" id="version"  required/><br>
					<label for="icon_prefix">Versi&oacute;n</label>
			    </div>
			</div>
	      	<div class="row">
				<div class="input-field col s12">
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
<!-- FIN Dar de alta nuevo modelo de proceso -->


<div class="divider"></div>
<!-- Mostrar modelos -->	
	<?php
	include "../Conexion.class.php";
	$conex = new Conexion;
	$_SESSION['pag_act'] = 'modelos';
	
	$_SESSION["modelos"] = $conex->get("SELECT * FROM modelo_p");

	$modelos = json_decode($_SESSION["modelos"]);
	//echo "Modelos ".$modelos[2]->nombreM;
	if(count($modelos)==0){
		echo "<p class='yellow'>Lo sentimos <strong>no hay modelos</strong></p>";
		return;
	}

	if(isset($_SESSION["msj"])){
            //echo $_SESSION["msj"];
            echo "<p class='yellow'> <strong>".$_SESSION['msj']."</strong></p>";
            $_SESSION['msj'] = '';
    }


	//echo "<table id='tablaModelos' class='bordered col s10 offset-s1'><tr><td>Nombre</td><td>Descripción</td><td>Versión</td><td></td></tr>";
	echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                //echo "<th>Elegir</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Descripción</th>";
               	echo "<th style='text-align:center;'>Versión</th>";
               	echo "<th></th><th></th>";
            echo "</tr>";
        echo "</thead>";

	for($i=0;$i<count($modelos);$i++){
		//echo "<form action='' method='POST'>";
			echo "<tr>";
				echo "<td>".$modelos[$i]->nombreM."</td>";
				echo "<td>".$modelos[$i]->descripcion."</td>";
				echo "<td>".$modelos[$i]->version."</td>";
				echo "<td><a href='#act' id='".$modelos[$i]->idModelo_P."' class='btn-floating btn-large waves-effect waves-light blue'><i class='mdi-action-settings'></i>Editar</a></td>";
				echo "<td><a href='#eli' id='".$modelos[$i]->idModelo_P."' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></a></td>";
				//echo "<td><a href='#!' id='".$modelos[$i]->idModelo_P."' class='btn wave-effect'>Editar</a></td>";
				//echo "<td><a href='#' id='".$modelos[$i]->idModelo_P."' class='red btn wave-effect'>Eliminar</a></td>";
			echo "</tr>";
		//echo "</form>";
	}

	echo "</table>";

	?>
<!-- FIN mostrar modelos -->





<div id="model" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col s3">
				<h4 id="nomModelo">Prueba</h4>
			</div>
			
			
		</div>
		<form  action="nuevoModelo.php" method="POST">
			<input type="hidden" name="idModelo" id="idModelo"/>
			<div class="row">
				<div class="input-field col s10 offset-s1">
				   	<input type="text" name="nombreAct" id="nombre2"required />
					<label for="icon_prefix">Nombre del modelo</label>
			    </div>
			</div>
			<div class="row">
	        	<div class="input-field col s10 offset-s1">
	          		<textarea name="descripcionAct" id="desc2" class="materialize-textarea"></textarea>
	          		<label for="textarea1">Descripci&oacute;n</label>
	        	</div>
	      	</div>
	      	<div class="row">
				<div class="input-field col s10 offset-s1">
				   	<input type="text" name="versionAct" id="version2"  required/><br>
					<label for="icon_prefix">Versi&oacute;n</label>
			    </div>
			</div>
			<div class="row">
				<div class="input-field col s7 offset-s4">
				    <input type="submit" name="actualizar" class="btn wave-effect" id="entrar" value="Actualizar" />
			    </div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cerrar</a>
	</div>
</div>

<!--modal eliminar -->
	<div id="modalx" class="modal bottom-sheet">
	<form action="nuevoModelo.php">
		<div class="modal-content">
	      <h4 id="cabecera">¿ Realmente desea eliminar el modelo ?</h4>
	      <p>Ten en cuenta que se eliminara todo lo relacionado a este modelo</p>
	    </div>
	    <div class="modal-footer">
	    	
	      	<a  class=" modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
	      	<input type="submit" name="eliminar" value="Si deseo Eliminar el modelo"  class="wavs-effects wavs-green btn-flat">
	      	<input type='text' hidden name="idEliminar" id="idEliminar" value="0">
	    </div>
	</form>
    
  </div>
<!--    fin modal eliminar -->



<div class="row"></div>
<br>