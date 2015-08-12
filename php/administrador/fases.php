
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
?>
<!-- Dar de alta nueva fase del modelo -->
<div class="row">
	<div class="col s6">
		<blockquote><h5>Nueva Fase</h5></blockquote>		
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
	<form  action="fasesMetodos.php" method="POST" id="submitFases">
			<div class="row">
				<div class="input-field col s12">
				   	<input type="text" name="nombre" id="nombre"required />
					<label for="icon_prefix">Nombre de la fase</label>
			    </div>
			</div>
			<div class="row">
	        	<div class=" col s10">
	          		<label>Modelo a la que pertenece:</label>
	          		<?php
                	echo "<select name='modeloN' id='modeloOptions' class='browser-default' required>";
                		echo "<option value='0'>Seleccione un Modelo de Proceso</option>";
                		for($i=0;$i<count($misModelos);$i++){
							echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM} V {$misModelos[$i]->version}</option>";
						}
                	echo "</select>";
            		?>
	        	</div>
	      	</div>
	      	<div class="row">
			    <div class="input-field col s12">
				   	<input type="number" name="orden" id="orden" min='1'  required/><br>
					<label for="icon_prefix">Orden</label>
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
<!-- FIN Dar de alta nueva fase del modelo -->	

<div id="msg">
	<?php  
    	if (isset($_SESSION['msj'])) {
          echo $_SESSION['msj'];
        }
        //echo "<br><br>{$misModelos[0]->nombreM}";
    ?>
</div>
<div class="divider"></div>
<!-- INICIO Mostrar Fases -->

<?php 
$_SESSION['pag_act'] = 'fases';
$fases =  json_decode($conex->get("SELECT fase.idFase,fase.nombre,fase.descripcion,fase.orden,modelo_p.nombreM,modelo_p.version FROM fase,modelo_p where fase.Modelo_P_idModelo_P=modelo_p.idModelo_P"));
//$fases =  json_decode($conex->get("SELECT * FROM fase"));

if(count($fases)==0){
	echo "<p class='yellow'>Lo sentimos <strong>no hay Fases</strong></p>";
	return;
}


//echo "<table id='example' class='display' cellspacing='0' width='100%'><tr><td>Nombre</td><td>Descripción</td><td>Orden</td><td>Modelo</td></tr>";

echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                //echo "<th>Elegir</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Descripción</th>";
                echo "<th style='text-align:center;'>Orden</th>";
                echo "<th style='text-align:center;'>Modelo</th>";
                echo "<th></th>";
                echo "<th></th>";
            echo "</tr>";
        echo "</thead>";

for($i=0;$i<count($fases);$i++){
	echo "<tr>";
		echo "<td>".$fases[$i]->nombre."</td>";
		echo "<td>".$fases[$i]->descripcion."</td>";
		echo "<td style='text-align:center;'>".$fases[$i]->orden."</td>";
		echo "<td style='text-align:center;'>".$fases[$i]->nombreM." V ".$fases[$i]->version."</td>";
		echo "<td style='text-align:center;'><a href='#!' id='".$fases[$i]->idFase."' class='miFase btn-floating btn-large waves-effect waves-light blue'><i class='mdi-action-settings'></i>Editar</a></td>";
		echo "<td style='text-align:center;'><form class='eliminarFase' id='eliminarFase-".$i."' method='POST'>";
			echo "<input type='hidden' value='".$fases[$i]->idFase."' name='idF' id='idF-".$i."'/>";
			echo "<input type='hidden' value='".$fases[$i]->nombre."' name='nomF' id='nomF-".$i."'/>";
			echo "<button type='submit' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button>";
		echo "</form></td>";
	echo "</tr>";
}

echo "</table>";

?>

<!-- F I N Mostrar Fases -->


<!-- INICIO Modal que se muestra para editar -->
<div id="modelFase" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h5 id="nomFase"></h5>
			</div>			
		</div>
		<form action="fasesMetodos.php" method="POST">
			<input type="hidden" name="idFase" id="idFase"/>
			<div class="row">
				<div class="input-field col s6">
				   	<input type="text" name="nombre2" id="nombre2"required />
					<label for="icon_prefix">Nombre de la fase</label>
			    </div>
			    <div class="input-field col s6">
				   	<input type="number" name="orden2" id="orden2" min='1' required/><br>
					<label for="icon_prefix">Orden</label>
			    </div>
			</div>
			<div class="row">
	        	<div class=" col s10">
	          		<label>Modelo a la que pertenece:</label>
	          		<?php
                	echo "<select name='modeloN2' id='modeloEdit' class='browser-default' required>";
                		echo "<option value='0'>Seleccione un Modelo de Proceso</option>";
                		for($i=0;$i<count($misModelos);$i++){
							echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM} V {$misModelos[$i]->version}</option>";
						}
                	echo "</select>";
            		?>
	        	</div>
	      	</div>
			<div class="row">
	        	<div class="input-field col s12">
	          		<textarea name="descripcion2" id="descripcion2" class="materialize-textarea" required></textarea>
	          		<label for="textarea1">Descripci&oacute;n</label>
	        	</div>
	      	</div>
			<div class="row">
				<div class="input-field col s7 offset-s4">
				    <!--input type="submit" name="Editar" class="btn wave-effect" id="editar" value="Editar" /-->
			    </div>
			</div>
			<div class="modal-footer">
				<a class="modal-action modal-close wavs-effects wavs-green btn-flat" style="color:red;">Cerrar</a>
				<input type="submit" name="Editar" class="wavs-effects wavs-green btn-flat" value="Actualizar informacion" style="color:blue;" />
			</div>
		</form>
	</div>
</div>
<!-- FIN  Modal que se muestra para editar -->


<!-- INICIO Modal que se muestra para eliminar -->
<div id="confirmDeleteFase" class="modal bottom-sheet">
	<form action="fasesMetodos.php" method="POST">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h4 id="nombreFase"></h4>
			</div>			
		</div>
			<p>Toma en cuenta que si eliminas esta Fase puedes afectar otros datos.<br/>
			Se eliminar&aacute;n aquellas <b>actividades</b> que contenga esta fase.</p>
			<input type="hidden" id="idFaseForm" name="idFaseForm" />
			<input type="hidden" id="nombreFaseForm" name="nombreFaseForm" />
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat" style="color:blue;">Cancelar</a>
		<input type="submit" name="eliminar" class="wavs-effects wavs-green btn-flat" style="color:red;" value="Si deseo eliminar la fase" />
	</div>
	</form>
</div>
<!-- FIN  Modal que se muestra para eliminar -->


<div class="row"></div>
<br><br>
