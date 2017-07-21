<?
session_start();
$se_altas=explode(",",$_SESSION['s_altas']);
$se_consultas=explode(",",$_SESSION['s_consultas']);
$se_actualizaciones=explode(",",$_SESSION['s_actualizaciones']);
$se_bajas=explode(",",$_SESSION['s_bajas']);
$se_seccion=$_SESSION['s_seccion'];

?>
<div class="boton_menu_seccion">
<a href="../">Regresar</a>
</div>
<?
if(in_array($se_seccion,$se_bajas)==true):
	?>
	 <div class="boton_menu_seccion">
		 <a href="javascript:;" onClick="javascript:eliminar();">Eliminar</a>
	 </div>
	<?
endif;
if(in_array($se_seccion,$se_actualizaciones)==true):
	?>
	<div class="boton_menu_seccion">
	<a href="javascript:;" onclick="actualizar();">Actualizar</a>
	</div>
 <?
endif;
if(in_array($se_seccion,$se_altas)==true):
	?>
	<div class="boton_menu_seccion">
		<a href="nuevo/">Nuevo</a>
	</div>
	<?
endif;
?>