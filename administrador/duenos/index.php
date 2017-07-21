<?
session_start();
ini_set("display_errors","On");
$se_id_usuario=$_SESSION["s_id_usuario"];
$se_tipo_usuario=$_SESSION["s_tipo_usuario"];
$se_altas=$_SESSION['s_altas'];
$se_bajas=$_SESSION['s_bajas'];
$se_actualizaciones=$_SESSION['s_actualizaciones'];
$se_reportes=$_SESSION['s_reportes'];

$p_se=isset($_GET['se'])?$_GET['se']:"";
if(!empty($p_se)):
	$_SESSION['s_seccion']=$p_se;
endif;
$se_seccion=$_SESSION['s_seccion'];

if(empty($se_id_usuario)):
	?>
	<script type="text/javascript" language="javascript">
   location.href="../login/";
   </script>
   <?
else:
	include("../php/config.php");
	include("../php/func.php");
	include("../php/func_bd.php");
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>DUEÑOS DE LOCALES O SERVICIOS</title>
	 <!-- Favicon -->
  <link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">    
	<link href="../css/etiquetas.css" rel="stylesheet" type="text/css" />
	<link href="../css/form.css" rel="stylesheet" type="text/css" />
	<link href="../css/administrador.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
	<? include("../includes/ajuste.php");?>
   
   <script src="ajax.js"></script>
	</head>
	<body>
	<div id="contenedor">
		<div id="cabecera">
			<?
			include("../includes/encabezado.php");
			?>
		</div>
      <div id="separador">&nbsp;</div>
      <div class="div_separador">&nbsp;</div>
		<div id="menu">
			<?
			include("../includes/menu.php");
			?>
		</div>
		<div id="contenido">
         <div class="titulo_paginacion">Consulta de Dueños de Locales o Servicios</div>
			<div class="div_separador">&nbsp;</div>	
         <div id="menu_paginacion">
				<?
            include("menu.php");
            ?>
         </div>
			<div class="div_separador">&nbsp;</div>	         <div id="div_contenido">
				<? include("contenido.php");?>
         </div>
		</div>
		<div id="pie">
			<?
			include("../includes/pie.php");
			?>
		</div>
	</div>
   <script src="../js/main.js"></script>
	</body>
	</html>
	<?
endif;
?>