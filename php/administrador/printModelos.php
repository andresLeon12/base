<?php
include_once("../Conexion.class.php");

if (strpos($_SERVER["REQUEST_URI"], "fases")){
	$conex = new Conexion;
	$id = $_SESSION["idActual"];
	$fases =  json_decode($conex->get("SELECT * FROM fase where Modelo_P_idModelo_P =$id "));

	echo "<h5>".$_SESSION['nomActual']."</h5>";
	if(count($fases)==0){
		echo "No hay fases";
		return;
	}


	echo "<table><tr><td>Nombre</td><td>Descripción</td><td>Orden</td></tr>";

	for($i=0;$i<count($fases);$i++){
		//echo "<form action='' method='POST'>";
			echo "<tr>";
				echo "<td>".$fases[$i]->nombre."</td>";
				echo "<td>".$fases[$i]->descripcion."</td>";
				echo "<td>".$fases[$i]->orden."</td>";
				//echo "<td><a href='#!' id='".$fases[$i]->idModelo_P."' class='btn wave-effect'>Editar</a></td>";
				//echo "<td><a href='#' id='".$fases[$i]->idModelo_P."' class='red btn wave-effect'>Eliminar</a></td>";
			echo "</tr>";
		//echo "</form>";
	}

	echo "</table>";

	if(isset($_SESSION["msj"])){
		echo $_SESSION["msj"];
		$_SESSION['msj'] = '';
		//session_unset($_SESSION["msj"]);
	}

	return;
}

$modelos = json_decode($_SESSION["modelos"]);
//echo "Modelos ".$modelos[2]->nombreM;
if(count($modelos)==0){
	echo "No hay modelos";
}


echo "<table><tr><td>Nombre</td><td>Descripción</td><td>Versión</td></tr>";

for($i=0;$i<count($modelos);$i++){
	//echo "<form action='' method='POST'>";
		echo "<tr>";
			echo "<td>".$modelos[$i]->nombreM."</td>";
			echo "<td>".$modelos[$i]->descripcion."</td>";
			echo "<td>".$modelos[$i]->version."</td>";
			echo "<td><a href='#!' id='".$modelos[$i]->idModelo_P."' class='btn wave-effect'>Editar</a></td>";
			//echo "<td><a href='#' id='".$modelos[$i]->idModelo_P."' class='red btn wave-effect'>Eliminar</a></td>";
		echo "</tr>";
	//echo "</form>";
}

echo "</table>";

if(isset($_SESSION["msj"])){
	echo $_SESSION["msj"];
	$_SESSION['msj'] = '';
	//session_unset($_SESSION["msj"]);
}

?>
