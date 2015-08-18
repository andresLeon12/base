
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

$misRoles =  json_decode($conex->get("SELECT * FROM rol"));

?>
<!-- Dar de alta nuevo rol -->
<div class="row">
	<div class="col s6">
		<blockquote><h5>Nuevo Rol</h5></blockquote>		
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
	<form  action="rolMetodos.php" method="POST" id="submitFases">
		<div class="row">
			<div class="input-field col s12">
			   	<input type="text" name="nombre" id="nombre"required />
				<label for="icon_prefix">Nombre del Rol</label>
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
<!-- FIN Dar de alta nuevo Rol -->	

<div id="msg">
	<?php  
    	if (isset($_SESSION['msj'])) {
          echo $_SESSION['msj'];
        }
    ?>
</div>

<div class="divider"></div>
<!-- INICIO Mostrar Fases -->

<?php 

$_SESSION['pag_act'] = 'rol';

//$fases =  json_decode($conex->get("SELECT fase.idFase,fase.nombre,fase.descripcion,fase.orden,modelo_p.nombreM,modelo_p.version FROM fase,modelo_p where fase.Modelo_P_idModelo_P=modelo_p.idModelo_P"));
//$fases =  json_decode($conex->get("SELECT * FROM fase"));

if(count($misRoles)==0){
	echo "<p class='yellow'>Lo sentimos <strong>no hay Roles</strong></p>";
	return;
}


//echo "<table id='example' class='display' cellspacing='0' width='100%'><tr><td>Nombre</td><td>Descripción</td><td>Orden</td><td>Modelo</td></tr>";

echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                //echo "<th>Elegir</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Descripción</th>";
                echo "<th></th>";
                echo "<th></th>";
            echo "</tr>";
        echo "</thead>";

for($i=0;$i<count($misRoles);$i++){
	echo "<tr>";
		echo "<td>".$misRoles[$i]->nombre."</td>";
		echo "<td>".$misRoles[$i]->descripcion."</td>";
		echo "<td style='text-align:center;'><a href='#!' id='".$misRoles[$i]->idRol."' class='miRol btn-floating btn-large waves-effect waves-green'><i class='mdi-action-settings'></i>Editar</a></td>";
		echo "<td style='text-align:center;'><form class='eliminarRol' id='eliminarRol-".$i."' method='POST'>";
			echo "<input type='hidden' value='".$misRoles[$i]->idRol."' name='idR' id='idR-".$i."'/>";
			echo "<input type='hidden' value='".$misRoles[$i]->nombre."' name='nomR' id='nomR-".$i."'/>";
			echo "<button type='submit' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button>";
		echo "</form></td>";
	echo "</tr>";
}

echo "</table>";

?>

<!-- F I N Mostrar Fases -->


<!-- INICIO Modal que se muestra para editar -->
<div id="modalRol" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h5 id="nomRol"></h5>
			</div>			
		</div>
		<form action="rolMetodos.php" method="POST">
			<input type="hidden" name="idRol" id="idRol"/>
			<div class="row">
				<div class="input-field col s6">
				   	<input type="text" name="nombre2" id="nombre2"required />
					<label for="icon_prefix">Nombre del Rol</label>
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
				<a class="modal-action modal-close wavs-effects wavs-green btn-flat" >Cerrar</a>
				<input type="submit" name="Editar" class="wavs-effects wavs-green btn-flat" value="Actualizar informacion"  />
			</div>
		</form>
	</div>
</div>
<!-- FIN  Modal que se muestra para editar -->


<!-- INICIO Modal que se muestra para eliminar -->
<div id="confirmDeleteRol" class="modal bottom-sheet">
	<form action="rolMetodos.php" method="POST">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h4 id="nombreRol"></h4>
			</div>			
		</div>
			<p>Toma en cuenta que si eliminas este Rol puedes afectar otros datos.<br/>
			Se eliminar&aacute;n todo el <b>personal</b> ligada a este <b>rol</b>.</p>
			<input type="hidden" id="idRolForm" name="idRolForm" />
			<input type="hidden" id="nombreRolForm" name="nombreRolForm" />
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat" >Cancelar</a>
		<input type="submit" name="Eliminar" class="wavs-effects wavs-green btn-flat"  value="Si deseo eliminar la fase" />
	</div>
	</form>
</div>
<!-- FIN  Modal que se muestra para eliminar -->


<div class="row"></div>
<br><br>
