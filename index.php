<?php  
session_start();//iniciando sesiones
if(!empty($_SESSION['usuario']))
{
	if ($_SESSION['usuario'] == 'Administrador') {
		header('Location: php/administrador/inicio_admin.php');
	}elseif ($_SESSION['usuario'] == 'Jefe de Proyecto') {
		header('Location: php/jefe/jefe.php');
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Base de Conocimiento</title>
	<!-- Compiled and minified CSS -->
  	<link rel="stylesheet" href="css/materialize.css">

	<!-- Compiled and minified JavaScript -->
	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/materialize.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body class="grey-text">
	<div class="navbar-fixed">
    <nav class="light-blue darken-2 z-depth-2">
      <div class="nav-wrapper">
        <ul class="center hide-on-med-and-down">
          <li class="active"><a>Base de conocimientos</a></li>
        </ul>
      </div>
    </nav>
  </div>
	<!-- Inicion Login de usuario -->
	<div class="row"></div>
	<div class="container">
	    <div class="col s6">
	      <ul class="tabs">
	        <li class="tab col s2"><a id="adminLog" class="active grey-text z-depth-2" >Administrador</a></li>
	        <li class="tab col s2"><a id="jefeLog" class="grey-text">Jefe de Proyecto</a></li>
	      </ul>
	      <div id="log" class="col s12">
		    	<div class="row">
		    		<form id="login" action="php/login.php" method="POST">
		    			<div class="row">
			    			<div class="input-field col s6 offset-s2">
			    				<i class="material-icons prefix"></i>
			    				<input type="text" name="user" id="user" required />
			    				<label for="icon_prefix">Nombre de usuario</label>
		    				</div>
		    			</div>
		    			<div class="row">
			    			<div class="input-field col s6 offset-s2">
			    				<i class="material-icons prefix"></i>
			    				<input type="password" name="pass" id="pass" required/><br>
			    				<label for="icon_prefix">Ingrese Contrase&ntilde;a</label>
		    				</div>
		    			</div>
		    			<div class="row">
			    			<div class="input-field col s7 offset-s4">
			    				<input type="submit" name="entrar" class="btn wave-effect" id="entrar" value="Entrar" />
		    				</div>
		    			</div>
		    		</form>
		    		<div id="error"></div>
		    	</div>
		    </div>
	    </div>

  	</div>
  	<!-- Fin Login -->

</body>
</html>