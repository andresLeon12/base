<?php 


include_once "../Conexion.class.php";
$table = $_GET['table'];
$idTable = $_GET['idTable'];
$id = $_GET['id'];
$conex = new Conexion;
if(isset($_GET['array'])){
	$comparacion = $idTable."=".$id;
	$query = "Select * From $table where $comparacion";
	echo $conex->get($query);
	return;
}
if ($id == 0) {
	$query = "Select * From $table";
	echo $conex->get($query);
	//return;
}else{
	$comparacion = $idTable."=".$id;
	$query = "Select * From $table where $comparacion";
	echo $conex->getById($query);
}

//echo $conex->getById($table,$id);



?>

