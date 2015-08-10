<?php  
session_start();

if(!empty($_SESSION['usuario']))
{
	$_SESSION['usuario']='';
	session_destroy();
}
header("Location: ../index.php");

?>