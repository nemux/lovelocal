<?
session_start();
$se_altas=explode(",",$_SESSION['s_altas']);
$se_consultas=explode(",",$_SESSION['s_consultas']);
$se_actualizaciones=explode(",",$_SESSION['s_actualizaciones']);
$se_bajas=explode(",",$_SESSION['s_bajas']);
$se_seccion=$_SESSION['s_seccion'];
if(in_array($se_seccion,$se_altas)==true):
	?>
	<div class="boton_menu_seccion" onclick="javascript:location.href='nuevo/'">
		Nuevo padecimiento
	</div>
	<?
endif;
if(in_array($se_seccion,$se_actualizaciones)==true):
	?>
	<div class="boton_menu_seccion" onclick="javascript:actualizar();">
		Actualizar padecimiento
	</div>
 <?
endif;
if(in_array($se_seccion,$se_bajas)==true):
	?>
	 <div class="boton_menu_seccion" onClick="javascript:eliminar();">
		 Eliminar padecimiento
	 </div>
	<?
endif;
?>