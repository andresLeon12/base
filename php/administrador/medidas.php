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
?>
<!-- Dar de alta nueva medida del modelo -->
<div class="row">
	<div class="col s6">
		<blockquote><h5>Nueva Medida</h5></blockquote>		
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
	<form  action="medidasMetodos.php" method="POST">
		<div class="row">
			<div class="input-field col s6">
				<input type="text" name="nombre" id="nombre"required />
				<label for="icon_prefix">Nombre de la medida</label>
			</div>
			<div class="input-field col s6">
				<input type="text" name="unidad_medida" id="unidad_medida"required />
				<label for="icon_prefix">Unidad de medida</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
	       		<textarea name="descripcion" class="materialize-textarea" required></textarea>
	       		<label for="textarea1">Descripci&oacute;n</label>
	      	</div>
		</div>
		<div class="row">
		    <div class="input-field col s3 offset-s2">
			    <input type="submit" name="Agregar" class="btn wave-effect" id="entrar" value="Agregar" />
		    </div>
		</div>
	</form>
	</div>
<!-- FIN Dar de alta nueva medida del modelo -->	

<div id="msg">
	<?php  
    	if (isset($_SESSION['msj'])) {
          echo $_SESSION['msj'];
        }
        //echo "<br><br>{$misActividades[0]->nombreM}";
    ?>
</div>
<div class="divider"></div>
<!-- INICIO Mostrar medidas -->

<?php 
$_SESSION['pag_act'] = 'medidas';
$medidas =  json_decode($conex->get("SELECT * FROM medida"));
if(count($medidas)==0){
	echo "<p class='yellow'>Lo sentimos <strong>no hay medidas</strong></p>";
	return;
}

echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                //echo "<th>Elegir</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Descripción</th>";
                echo "<th style='text-align:center;'>Unidad de medida</th>";
                echo "<th></th>";
                echo "<th></th>";
            echo "</tr>";
        echo "</thead>";

for($i=0;$i<count($medidas);$i++){
	echo "<tr>";
		echo "<td>".$medidas[$i]->nombre."</td>";
		echo "<td>".$medidas[$i]->descripcion."</td>";
		echo "<td>".$medidas[$i]->unidad_medida."</td>";
		echo "<td style='text-align:center;'><a href='#!' id='".$medidas[$i]->idMedida."' class='miMedida btn-floating btn-large waves-effect waves-light blue'><i class='mdi-action-settings'></i>Editar</a></td>";
		echo "<td style='text-align:center;'><form class='eliminarTarea' id='eliminarTarea-".$i."' method='POST'>";
			echo "<input type='hidden' value='".$medidas[$i]->idMedida."' name='idT' id='idT-".$i."'/>";
			echo "<input type='hidden' value='".$medidas[$i]->nombre."' name='nomT' id='nomT-".$i."'/>";
			echo "<button type='submit' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button>";
		echo "</form></td>";
	echo "</tr>";
}

echo "</table>";

?>
<!-- F I N Mostrar medidas -->

<!-- INICIO Modal que se muestra para editar -->
<div id="editarGuia" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h4 id="nomMedida"></h4>
			</div>			
		</div>
		<form  action="medidasMetodos.php" method="POST">
			<div class="row">
				<div class="input-field col s6">
					<input type="text" name="nombre" id="nombre2"required />
					<label for="icon_prefix">Nombre de la medida</label>
				</div>
				<div class="input-field col s6">
					<input type="text" name="unidad_medida" id="unidad_medida2"required />
					<label for="icon_prefix">Unidad de medida</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
		       		<textarea name="descripcion" id="descripcion2" class="materialize-textarea" required></textarea>
		       		<label for="textarea1">Descripci&oacute;n</label>
		      	</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="idMedida" id="idMedida">
				<a class="modal-action modal-close wavs-effects wavs-green btn-flat" style="color:red;">Cancelar</a>
				<input type="submit" name="Editar" id="editar" class="wavs-effects wavs-green btn-flat" style="color:darkblue;" value="Editar" />
			</div>
		</form>
	</div>
</div>
<!-- FIN  Modal que se muestra para editar -->

<!-- INICIO Modal que se muestra para eliminar -->
<div id="confirmDeleteTarea" class="modal bottom-sheet">
	<form action="medidasMetodos.php" method="POST">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h4 id="nameTarea"></h4>
			</div>			
		</div>
			<p>Toma en cuenta que si eliminas esta Tarea puedes afectar otros <b>datos</b>.<br/>
			<input type="hidden" id="idMedidaForm" name="idMedidaForm" />
			<input type="hidden" id="nombreMedidaForm" name="nombreMedidaForm" />
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat" style="color:blue;">Cancelar</a>
		<input type="submit" name="eliminar" class="wavs-effects wavs-green btn-flat" style="color:red;" value="Si deseo eliminar la medida" />
	</div>
	</form>
</div>
<!-- FIN  Modal que se muestra para eliminar -->

<div class="row"></div><br>