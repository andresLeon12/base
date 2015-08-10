<?php
session_start();
include_once ("Conexion.class.php");

$user = $_POST["user"];
$pass = $_POST["pass"];
$conex = new Conexion;

if ($user == "admin" && $pass == 'admin') {//Si es admin redirecciona a la pagina de amdin
	$_SESSION['usuario'] = 'Administrador';
	$_SESSION["modelos"] = $conex->get("SELECT * FROM modelo_p");
	header("location: administrador/inicio_admin.php");
	//header("location: inicio_admin.php");
}elseif ($user == 'jefe' && $pass == 'jefe') {//si no es admin entonces se verifica si es jefe, si es, se le muestra la pagina del jefe
	$_SESSION['usuario'] = 'Jefe de Proyecto';
	//
	header("location: jefe/jefe.php");
}else{//si no es un error de usuario
	echo "<script>$('#error').text('Error aun no estas registrado!')</script>";
	header("location: ../index.html");
}

?>