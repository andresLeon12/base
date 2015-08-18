
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

$miPersonal =  json_decode($conex->get("SELECT * FROM personal"));
$misRoles =  json_decode($conex->get("SELECT * FROM rol"));

$roles_personal = array();

if (count($miPersonal) > 0) {
	for ($i=0; $i < count($miPersonal); $i++) { 
		$idR =  json_decode($conex->get("SELECT * FROM personal_rol where Personal_idPersonal={$miPersonal[$i]->idPersonal}"));
		if(count($idR) > 0) 
		{
			$rol =  json_decode($conex->get("SELECT * FROM rol where idRol={$idR[0]->Rol_idRol}"));			
			array_push($roles_personal, $rol[0]->nombre);
		}else{
			array_push($roles_personal, "Este personal no tiene asignado un rol.");
		}
	}
}

?>
<!-- Dar de alta nuevo rol -->
<div class="row">
	<div class="col s6">
		<blockquote><h5>Personal Nuevo</h5></blockquote>		
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
	<form  action="personalMetodos.php" method="POST" id="submitFases">
		<div class="row">
			<div class="input-field col s12">
			   	<input type="text" name="nombre" id="nombre"required />
				<label for="icon_prefix">Nombre</label>
		    </div>
		</div>
		<div class="row">
			<div class="input-field col s12">
			   	<input type="text" name="aP" id="aP"required />
				<label for="icon_prefix">Apellido Paterno</label>
		    </div>
		</div>
		<div class="row">
			<div class="input-field col s12">
			   	<input type="text" name="aM" id="aM"required />
				<label for="icon_prefix">Apellido Materno</label>
		    </div>
		</div>
		<div class="row">
			<div class="input-field col s12">
			   	<input type="email" name="email" id="email" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$" required />
				<label for="icon_prefix">Correo Electronico (example@gmail.com)</label>
		    </div>
		</div>

		<div class="row">
	    	<div class=" col s10">
	       		<label>Rol:</label>
	       		<?php
               	echo "<select name='rol' id='rolOptions' class='browser-default' required>";
               		echo "<option value='0'>Seleccione un Rol</option>";
               		for($i=0;$i<count($misRoles);$i++){
						echo "<option value='{$misRoles[$i]->idRol}'>{$misRoles[$i]->nombre}</option>";
					}
               	echo "</select>";
           		?>
	       	</div>
	    </div>

		<div class="row">
	       	<div class="input-field col s12">
	       		<textarea name="habilidades" class="materialize-textarea" required></textarea>
	       		<label for="textarea1">Habilidades</label>
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

$_SESSION['pag_act'] = 'personal';

//$fases =  json_decode($conex->get("SELECT fase.idFase,fase.nombre,fase.descripcion,fase.orden,modelo_p.nombreM,modelo_p.version FROM fase,modelo_p where fase.Modelo_P_idModelo_P=modelo_p.idModelo_P"));
//$fases =  json_decode($conex->get("SELECT * FROM fase"));

if(count($miPersonal)==0){
	echo "<p class='yellow'>Lo sentimos <strong>no hay Personal</strong></p>";
	return;
}


//echo "<table id='example' class='display' cellspacing='0' width='100%'><tr><td>Nombre</td><td>Descripción</td><td>Orden</td><td>Modelo</td></tr>";

echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                //echo "<th>Elegir</th>";
            	echo "<th style='text-align:center;'>Rol</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Apellido Paterno</th>";
                echo "<th style='text-align:center;'>Apellido Materno</th>";
                echo "<th style='text-align:center;'>Correo Electronico</th>";
                echo "<th style='text-align:center;'>Habilidades</th>";
                echo "<th></th>";
                echo "<th></th>";
            echo "</tr>";
        echo "</thead>";

for($i=0;$i<count($miPersonal);$i++){
	echo "<tr>";
		echo "<td>".$roles_personal[$i]."</td>";
		echo "<td>".$miPersonal[$i]->nombre."</td>";
		echo "<td>".$miPersonal[$i]->apellidoP."</td>";
		echo "<td>".$miPersonal[$i]->apellidoM."</td>";
		echo "<td>".$miPersonal[$i]->correo_electronico."</td>";
		echo "<td>".$miPersonal[$i]->habilidades."</td>";
		echo "<td style='text-align:center;'><a href='#!' id='".$miPersonal[$i]->idPersonal."' class='miPersonal btn-floating btn-large waves-effect waves-green'><i class='mdi-action-settings'></i>Editar</a></td>";
		echo "<td style='text-align:center;'><form class='eliminarPersonal' id='eliminarPersonal-".$i."' method='POST'>";
			echo "<input type='hidden' value='".$miPersonal[$i]->idPersonal."' name='idPer' id='idPer-".$i."'/>";
			echo "<input type='hidden' value='".$miPersonal[$i]->nombre."' name='nomPer' id='nomPer-".$i."'/>";
			echo "<input type='hidden' value='".$miPersonal[$i]->apellidoP."' name='aPPer' id='aPPer-".$i."'/>";
			echo "<input type='hidden' value='".$miPersonal[$i]->apellidoM."' name='aMPer' id='aMPer-".$i."'/>";
			echo "<button type='submit' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button>";
		echo "</form></td>";
	echo "</tr>";
}

echo "</table>";

?>

<!-- F I N Mostrar Fases -->


<!-- INICIO Modal que se muestra para editar -->
<div id="modalPersonal" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h5 id="nomPersonal"></h5>
			</div>			
		</div>
		<form action="personalMetodos.php" method="POST">
			<input type="hidden" name="idPersonal" id="idPersonal"/>
			<div class="row">
				<div class="input-field col s6">
				   	<input type="text" name="nombre2" id="nombre2"required />
					<label for="icon_prefix">Nombre</label>
			    </div>
			    <div class="input-field col s6">
				   	<input type="text" name="aP2" id="aP2"required />
					<label for="icon_prefix">Apellido Paterno</label>
			    </div>
			</div>
			<div class="row">
				<div class="input-field col s6">
				   	<input type="text" name="aM2" id="aM2"required />
					<label for="icon_prefix">Apellido Materno</label>
			    </div>
			    <div class="input-field col s6">
				   	<input type="email" name="email2" id="email2"required />
					<label for="icon_prefix">Correo Electronico</label>
			    </div>
			</div>
			<div class="row">
	    		<div class=" col s10">
	       			<label>Rol:</label>
	       			<?php
               		echo "<select name='rol2' id='rolOptions2' class='browser-default' required>";
               			echo "<option value='0'>Seleccione un Rol</option>";
               			/*for($i=0;$i<count($misRoles);$i++){
							echo "<option value='{$misRoles[$i]->idRol}'>{$misRoles[$i]->nombre}</option>";
						}*/
               		echo "</select>";
           			?>
	       		</div>
	    	</div>
			<div class="row">
		       	<div class="input-field col s12">
		       		<textarea name="habilidades2" id="habilidades2" class="materialize-textarea" required></textarea>
		       		<label for="textarea1">Habilidades</label>
		       	</div>
		    </div>
			<div class="modal-footer">
				<a class="modal-action modal-close wavs-effects wavs-green btn-flat" s>Cerrar</a>
				<input type="submit" name="Editar" class="wavs-effects wavs-green btn-flat" value="Actualizar informacion" />
			</div>
		</form>
	</div>
</div>
<!-- FIN  Modal que se muestra para editar -->


<!-- INICIO Modal que se muestra para eliminar -->
<div id="confirmDeletePersonal" class="modal bottom-sheet">
	<form action="PersonalMetodos.php" method="POST">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h4 id="nombrePersonal"></h4>
			</div>			
		</div>
			<p>Toma en cuenta que si eliminas este Personal puedes afectar otros datos.<br/>
			Se eliminar&aacute;n todo lo relacionado a este <b>personal</b>.</p>
			<input type="hidden" id="idPersonalForm" name="idPersonalForm" />
			<input type="hidden" id="nombrePersonalForm" name="nombrePersonalForm" />
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat" >Cancelar</a>
		<input type="submit" name="Eliminar" class="wavs-effects wavs-green btn-flat"  value="Si deseo eliminar al Personal" />
	</div>
	</form>
</div>
<!-- FIN  Modal que se muestra para eliminar -->


<div class="row"></div>
<br><br>
