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
<body class="grey">
<?php include("../header.php") ?>
<div class="row z-depth-1 white container" style="margin-bottom: 0;">
<div class="col s12" style="text-align: center">
  <h4 class="">Bienvenido <i class="mdi-action-account-box"></i><strong class='grey-text'> <?php echo $_SESSION['usuario'];?></strong></h4>
</div>   
</div>
  <nav class="blue-grey z-depth-3" id="tablero-control">
      <div class="nav-wrapper" style="overflow-y: auto;" id="tab-scroll" >
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
        <ul class="center hide-on-med-and-down" >
          <li id="modelsLi" class=""><a id="modelos" href="#modelos">Modelos</a></li>
          <li id="fasesLi"  class=""><a id="fases" href="#fases">Fases</a></li>
          <li id="actividadesLi" class=""><a id="actividades" href="#actividades">Actividades</a></li>
          <li id="tareasLi" class=""><a id="tareas" href='#tareas'>Tareas</a></li>
          <li id="entradasLi" class=""><a id="entradas" href='#entradas'>Entradas</a></li><!--  parte actualizada-->
          <li id="salidasLi" class=""><a  id="salidas" href='#salidas'>Salidas</a></li>
          <li class="" id="guiasLi"><a href='#guias' id="guias">Gu&iacute;as</a></li>
          <li class="" id="activosLi"><a href='#activos' id="activos">Activos</a></li>
          <li class="" id="recursosLi"><a href='#recursos' id="recursos">Recursos</a></li>
          <li class="" id="medidasLi"><a href='#medidas' id="medidas">Medidas</a></li>
          <li class="" id="rolLi"><a href='#rol' id="rol">Roles</a></li>
          <li class="" id="personalLi"><a href='#personal' id="personal">Personal</a></li>
          <li class="" id="productosLi"><a href='#productos' id="productos">Producto de trabajo</a></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
          <li id="modelsLi" class=""><a id="modelos" href="#modelos">Modelos</a></li>
          <li id="fasesLi"  class=""><a id="fases" href="#fases">Fases</a></li>
          <li id="actividadesLi" class=""><a id="actividades" href="#actividades">Actividades</a></li>
          <li id="tareasLi" class=""><a id="tareas" href='#tareas'>Tareas</a></li>
          <li id="entradasLi" class=""><a id="entradas" href='#entradas'>Entradas</a></li><!--  parte actualizada-->
          <li id="salidasLi" class=""><a  id="salidas" href='#salidas'>Salidas</a></li>
          <li class="" id="guiasLi"><a href='#guias' id="guias">Gu&iacute;as</a></li>
          <li class="" id="activosLi"><a href='#activos' id="activos">Activos</a></li>
          <li class="" id="recursosLi"><a href='#recursos' id="recursos">Recursos</a></li>
          <li class="" id="medidasLi"><a href='#medidas' id="medidas">Medidas</a></li>
          <li class="" id="medidasLi"><a href='#medidas' id="medidas">Roles</a></li>
          <li class="" id="medidasLi"><a href='#medidas' id="medidas">Personal</a></li>
          <li class="" id="medidasLi"><a href='#medidas' id="medidas">Producto de trabajo</a></li>
        </ul>
      </div>
    </nav>
    <div id="content" class="container white">
      <input type="hidden" id="pag_act" value="<?php echo $_SESSION['pag_act'] ?>">
      <input type="hidden" id="seccion_act" value="<?php echo $_SESSION['seccion_act'] ?>">
      <?php 
        if(isset($_SESSION['pag_act'])){
          if($_SESSION['pag_act']=='actividades'){
            include('actividades.php');
          }else if($_SESSION['pag_act']=='modelos'){
            include 'administrador.php';
          }elseif ($_SESSION['pag_act'] == 'fases') {
            include 'fases.php';
          }elseif ($_SESSION['pag_act'] == 'tareas') {
            include 'tareas.php';
          }elseif ($_SESSION['pag_act'] == 'guias') {
            include 'guias.php';
          }elseif ($_SESSION['pag_act'] == 'activos') {
            include 'activos.php';
          }elseif ($_SESSION['pag_act'] == 'recursos') {
            include 'recursos.php';
          }elseif ($_SESSION['pag_act'] == 'entradas') {
            include 'entradas.php';
          }elseif ($_SESSION['pag_act'] == 'salidas') {
            include 'salidas.php';
          }elseif ($_SESSION['pag_act'] == 'medidas') {
            include 'medidas.php';
          }elseif ($_SESSION['pag_act'] == 'productos') {
            include 'productosTrabajo.php';
          }elseif ($_SESSION['pag_act'] == 'rol') {
            include 'rol.php';
          }elseif ($_SESSION['pag_act'] == 'personal') {
            include 'personal.php';
          }

        }
      ?>
    </div>
</body>
</html>