<?php 

session_start();

if(empty($_SESSION['usuario']))
{
  header('Location: ../../index.php');
}elseif(!empty($_SESSION['usuario']))
{
	if ($_SESSION['usuario'] == 'Administrador') {
		header('Location: ../administrador/inicio_admin.php');
	}//elseif ($_SESSION['usuario'] == 'Jefe de Proyecto') {
	//	header('Location: jefe.php');
	//}
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Base de Conociemiento - Jefe de Proyecto - </title>
</head>
<body>

<h3>Bienvenido <?php echo $_SESSION['usuario'];?></h3>

<a href="../logout.php">Salir</a>
<?php 



?>

</body>
</html>