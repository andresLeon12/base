<?php 
if (session_id()==null)
  session_start();

if(empty($_SESSION['usuario']))
{
  header('Location: ../../index.php');
}elseif(!empty($_SESSION['usuario']))
{
  //if ($_SESSION['usuario'] == 'Administrador') {
    //header('Location: inicio_admin.php');
  //}else
  if ($_SESSION['usuario'] == 'Jefe de Proyecto') {
    header('Location: ../jefe/jefe.php');
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Administrador BC</title>
  <?php include("../head.php") ?>
</head>
<body>
<?php include("../header.php") ?>
<div class="row">
<div class="col s4 offset-s4">
  <h4 class="">Bienvenido <i class="mdi-action-account-box"></i><strong class='grey-text'> <?php echo $_SESSION['usuario'];?></strong></h4>
</div>   
</div>
<div class="container">
  <nav class="light-red darken-3">
      <div class="nav-wrapper">
        <ul class="center hide-on-med-and-down">
          <li id="modelsLi" class=""><a id="modelos" href="#modelos">Modelos</a></li>
          <li id="fasesLi"  class=""><a id="fases" href="#fases">Fases</a></li>
          <li id="actividadesLi" class=""><a id="actividades" href="#actividades">Actividades</a></li>
          <li class=""><a href='#'>Tareas</a></li>
          <li class=""><a href='#'>Entradas</a></li>
          <li class=""><a href='#'>Salidas</a></li>
          <li class="" id="guiasLi"><a href='#guias' id="guias">Gu&iacute;as</a></li>
          <li class="" id="activosLi"><a href='#activos' id="activos">Activos</a></li>
          <li class="" id="recursosLi"><a href='#recursos' id="recursos">Recursos</a></li>
        </ul>
      </div>
    </nav>
    <div id="content">
      <input type="hidden" id="pag_act" value="<?php echo $_SESSION['pag_act'] ?>">
      <?php 

        if(isset($_SESSION['pag_act'])){
          if($_SESSION['pag_act']=='actividades'){
            include('actividades.php');
          }else if($_SESSION['pag_act']=='modelos'){
            include 'administrador.php';
          }elseif ($_SESSION['pag_act'] == 'fases') {
            include 'fases.php';
          }elseif ($_SESSION['pag_act'] == 'guias') {
            include 'guias.php';
          }elseif ($_SESSION['pag_act'] == 'activos') {
            include 'activos.php';
          }elseif ($_SESSION['pag_act'] == 'recursos') {
            include 'recursos.php';
          }
        }

      ?>
    </div>
</div>
</body>
</html>