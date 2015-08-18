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
          <li id="modelsLi" class="menu"><a class="tooltip" id="modelos" href="#modelos">Modelos<span><b></b>Agrega, edita o elimina Modelos de Proceso Software.</span></a></li>
          <li id="fasesLi"  class="menu"><a class="tooltip" id="fases" href="#fases">Fases<span><b></b>Agrega, edita o elimina fases de alg&uacute;n Modelos de Proceso Software.</span></a></li>
          <li id="actividadesLi" class="menu"><a class="tooltip" id="actividades" href="#actividades">Actividades<span><b></b>Agrega, edita o elimina Modelos de Proceso Software.</span></a></li>
          <li id="tareasLi" class="menu"><a class="tooltip" id="tareas" href='#tareas'>Tareas<span><b></b>Agrega, edita o elimina Modelos de Proceso Software.</span></a></li>
          <li id="entradasLi" class="menu"><a class="tooltip" id="entradas" href='#entradas'>Entradas<span><b></b>Agrega, edita o elimina Modelos de Proceso Software.</span></a></li><!--  parte actualizada-->
          <li id="salidasLi" class="menu"><a class="tooltip"  id="salidas" href='#salidas'>Salidas<span><b></b>Agrega, edita o elimina Modelos de Proceso Software.</span></a></li>
          <li class="menu" id="guiasLi"><a class="tooltip" href='#guias' id="guias">Gu&iacute;as<span><b></b>Agrega, edita o elimina Modelos de Proceso Software.</span></a></li>
          <li class="menu" id="activosLi"><a class="tooltip" href='#activos' id="activos">Activos<span><b></b>Agrega, edita o elimina Modelos de Proceso Software.</span></a></li>
          <li class="menu" id="recursosLi"><a class="tooltip" href='#recursos' id="recursos">Recursos<span><b></b>Agrega, edita o elimina Modelos de Proceso Software.</span></a></li>
          <li class="menu" id="medidasLi"><a class="tooltip" href='#medidas' id="medidas">Medidas<span><b></b>Agrega, edita o elimina Modelos de Proceso Software.</span></a></li>
          <li class="menu" id="rolLi"><a class="tooltip" href='#rol' id="rol">Roles</a></li>
          <li class="menu" id="personalLi"><a class="tooltip" href='#personal' id="personal">Personal</a></li>
          <li class="menu" id="productosLi"><a class="tooltip" href='#productos' id="productos">Producto de trabajo</a></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
          <li id="modelsLi" class="menu"><a id="modelos" href="#modelos">Modelos</a></li>
          <li id="fasesLi"  class="menu"><a id="fases" href="#fases">Fases</a></li>
          <li id="actividadesLi" class="menu"><a id="actividades" href="#actividades">Actividades</a></li>
          <li id="tareasLi" class="menu"><a id="tareas" href='#tareas'>Tareas</a></li>
          <li id="entradasLi" class="menu"><a id="entradas" href='#entradas'>Entradas</a></li><!--  parte actualizada-->
          <li id="salidasLi" class="menu"><a  id="salidas" href='#salidas'>Salidas</a></li>
          <li class="menu" id="guiasLi"><a href='#guias' id="guias">Gu&iacute;as</a></li>
          <li class="menu" id="activosLi"><a href='#activos' id="activos">Activos</a></li>
          <li class="menu" id="recursosLi"><a href='#recursos' id="recursos">Recursos</a></li>
          <li class="menu" id="medidasLi"><a href='#medidas' id="medidas">Medidas</a></li>
          <li class="menu" id="medidasLi"><a href='#medidas' id="medidas">Roles</a></li>
          <li class="menu" id="medidasLi"><a href='#medidas' id="medidas">Personal</a></li>
          <li class="menu" id="medidasLi"><a href='#medidas' id="medidas">Producto de trabajo</a></li>
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