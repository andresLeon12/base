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
		<blockquote><h5>Nuevo Producto de Trabajo</h5></blockquote>		
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
	<form  action="productosMetodos.php" method="POST" id="submitFases">
		<div class="row">
				<div class="input-field col s4">
				   	<input type="text" name="nombre" id="nombre"required/>
					<label for="icon_prefix">Nombre del producto de trabajo</label>
			    </div>
			    <div class="input-field col s4">
				   	<input type="text" name="version" id="version"  required/><br>
				   <!--	<div id="errorVersion" style="color:red;"></div>-->
					<label for="icon_prefix">Versi&oacute;n</label>
			    </div>
			    <div class="input-field col s4">
			   	<label>Tipo</label>
			   	<input tabindex="4" type="text" name="tipo" id="tipoProducto"required />
		    </div>
		</div>
		<div class="row">
		    
		    <div class="col s6">
				<label>Modelo al que pertenece</label>
				<select tabindex="1" class="browser-default" id="models" name='idModel'><option>Selecciona un modelo</option>
				<?php
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM} V {$misModelos[$i]->version}</option>";
					} ?>
				</select>
		    </div>
		    <div class="col s6">
				<label>Fase a la que pertenece</label>
				<select tabindex="2" class="browser-default" name="idFase" id="idfases" required><option>Selecciona una fase</option></select>
		    </div>
		</div>

		<div class="row">
		    <div class="col s6">
				<label>Actividad a la que pertenece</label>
				<select tabindex="3" class="browser-default" name="actividad" id="idActividades" required><option>Selecciona una Actividad</option></select>
		    </div>
		    <div class="col s6">
				<label>Tarea a la que pertenece</label>
				<select tabindex="3" class="browser-default" name="tarea" id="idTareas" required><option>Selecciona una tarea</option></select>
		    </div>
		</div>
		<div class="row">
		    
		    <div class="col s3 offset-s4">
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
$_SESSION['pag_act'] = 'productos';
$productos =  json_decode($conex->get("SELECT * FROM prod_t"));
$activity = array();
/*
for ($i=0; $i < count($productos); $i++) { 
	$idAct = $productos[$i]->Actividad_idActividad;
	//echo $idAct."<br>";
	$auxActivitys =  json_decode($conex->get("SELECT * FROM actividad where idActividad=$idAct"));
	array_push($activity, $auxActivitys[0]->nombre);
}
*/
if(count($productos)==0){
	echo "<p class='yellow'>Lo sentimos <strong>no hay Productos de Trabajo</strong></p>";
	return;
}

echo "<table id='example' class='cell-border' cellspacing='0' width='100%'>";
        echo "<thead>";
            echo "<tr>";
                //echo "<th>Elegir</th>";
                echo "<th style='text-align:center;'>Nombre</th>";
                echo "<th style='text-align:center;'>Tipo</th>";
                echo "<th style='text-align:center;'>Version</th>";
                echo "<th style='text-align:center;'>Tarea a la que pertenece</th>";
                echo "<th style='text-align:center;'>Actividad a la que pertenece</th>";
                echo "<th style='text-align:center;'>Fase a la que pertenece</th>";
                echo "<th style='text-align:center;'>Modelo al que pertenece</th>";
                echo "<th></th>";
                echo "<th></th>";
            echo "</tr>";
        echo "</thead>";

for($i=0;$i<count($productos);$i++){
	echo "<tr>";
		echo "<td>".$productos[$i]->nombre."</td>";
		echo "<td>".$productos[$i]->tipo."</td>";
		echo "<td>".$productos[$i]->version."</td>";

		$query = "SELECT Tarea_idTarea FROM tarea_prodt WHERE Prod_T_idProd_T=".$productos[$i]->idProd_T;
		$idTarea = json_decode($conex->getById($query));
		$query = "SELECT nombre,Actividad_idActividad FROM tarea WHERE idTarea=".$idTarea->Tarea_idTarea;
		$Tarea = json_decode($conex->getById($query));
		echo "<td>".$Tarea->nombre."</td>";

		$query = "SELECT nombre,Fase_idFase FROM actividad WHERE idActividad=".$Tarea->Actividad_idActividad;
		$actividad = json_decode($conex->getById($query));
		echo "<td>".$actividad->nombre."</td>";

		$query = "SELECT nombre,Modelo_P_idModelo_P FROM fase WHERE idFase=".$actividad->Fase_idFase;
		$fase = json_decode($conex->getById($query));
		echo "<td>".$fase->nombre."</td>";


	
		$query = "SELECT nombreM FROM modelo_P WHERE idModelo_P=".$fase->Modelo_P_idModelo_P;
		$model = json_decode($conex->getById($query));
		echo "<td>".$model->nombreM."</td>";
		echo "<td style='text-align:center;'><a href='#editarProducto' id='".$productos[$i]->idProd_T."' class='miProducto btn-floating btn-large waves-effect waves-green'><i class='mdi-action-settings'></i>Editar</a></td>";
		echo "<td>
				<form class='eliminarProducto' id='".$productos[$i]->idProd_T."' method='POST'>
					<input type='hidden'  id='".$productos[$i]->nombre."' value=''/>
					<button type='submit' name='eliminarProducto'  class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button>
				</form></td>";
	echo "</tr>";
}

echo "</table>";

?>
<!-- F I N Mostrar Fases -->

<!-- INICIO Modal que se muestra para editar -->
<div id="editarProducto" class="modal">
	<div class="modal-content">
		<div class="row">
			<div class="col s12">
				<h4 id="nomProducto"></h4>
			</div>			
		</div>
	<form  action="productosMetodos.php" method="POST" id="submitFases">
		<div class="row">
				<div class="input-field col s4">
				   	<input type="text" name="nombre" id="nombreProductoEdit"required/>
					<label for="icon_prefix">Nombre del producto de trabajo</label>
			    </div>
			    <div class="input-field col s4">
				   	<input type="text" name="version" id="versionProductoEdit"  required/><br>
				   <!--	<div id="errorVersion" style="color:red;"></div>-->
					<label for="icon_prefix">Versi&oacute;n</label>
			    </div>
			    <div class="input-field col s4">
			   	<label>Tipo</label>
			   	<input tabindex="4" type="text" name="tipo" id="tipoProductoEdit"required />
		    	</div>
		</div>
		<div class="row">
		    <div class="col s6">
				<label>Modelo al que pertenece</label>
				<select tabindex="1" class="browser-default" id="modelsEdit" name='idModel'><option>Selecciona un modelo</option>
				<?php
                	for($i=0;$i<count($misModelos);$i++){
						echo "<option value='{$misModelos[$i]->idModelo_P}'>{$misModelos[$i]->nombreM} V {$misModelos[$i]->version}</option>";
					} ?>
				</select>
		    </div>
		    <div class="col s6">
				<label>Fase a la que pertenece</label>
				<select tabindex="2" class="browser-default" name="idFase" id="idfasesEdit" required><option>Selecciona una fase</option></select>
		    </div>
		</div>

		<div class="row">
			<div class="col s6">
				<label>Actividad a la que pertenece</label>
				<select tabindex="3" class="browser-default" name="actividad" id="idActividadesEdit" required><option>Selecciona una Actividad</option></select>
		    </div>
		    <div class="col s6">
				<label>Tarea a la que pertenece</label>
				<select tabindex="3" class="browser-default" name="tarea" id="idTareasEdit" required><option>Selecciona una Tarea</option></select>
		    </div>
		</div>

	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat" >Cancelar</a>
		<input type="hidden" name="id" id="idProductoEdit">
		<input type="submit" name="Editar" id="editar" class="wavs-effects wavs-green btn-flat"  value="Editar" />
	</div>
		
	</form>

	</div>


	
</div>
<!-- FIN  Modal que se muestra para editar -->

<!-- INICIO Modal que se muestra para eliminar -->

<div id="confirmDeletePro" class="modal bottom-sheet">
	<form id='eliminarProductoForm' method='POST' action="productosMetodos.php">
	<div class="modal-content">
		<div class="row">
			<div class="col s3">
				<h4 id="nomProductoEliminar" class="grey-text"></h4>
			</div>
		</div>
		
		<input type='hidden' name='idProducto' id='idProductoForm'/>
		<input type='hidden'  id='nombreActForm' name="nombrePro" />
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close wavs-effects wavs-green btn-flat">Cancelar</a>
		<input type="submit" name="eliminar" class="wavs-effects wavs-green btn-flat" value="Si deseo eliminar el producto" />
	</div>
	</form>;
</div>

<!-- FIN  Modal que se muestra para eliminar -->

<div class="row"></div><br>