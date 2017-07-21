<?
$se_altas=explode(",",$_SESSION['s_altas']);
$se_consultas=isset($_SESSION['s_consultas'])?explode(",",$_SESSION['s_consultas']):"";
$se_actualizaciones=explode(",",$_SESSION['s_actualizaciones']);
$se_bajas=explode(",",$_SESSION['s_bajas']);
$se_seccion=$_SESSION['s_seccion'];
?>
<div class="modulo_menu">
   <div class="titulo_modulo_borde" id="mostrar_menu">
      >> Mostrar menú
   </div>
</div>
<?
if(in_array($se_seccion,$se_altas)==true):
	?>
	<div class="boton_menu_seccion" onclick="javascript:location.href='nuevo/';">
		Nuevo cliente
	</div>
	<?
endif;
if(in_array($se_seccion,$se_actualizaciones)==true):
	?>
	<div class="boton_menu_seccion" onclick="javascript:actualizar();">
	Actualizar cliente
	</div>
 <?
endif;
if(in_array($se_seccion,$se_bajas)==true):
	?>
	 <div class="boton_menu_seccion" onclick="javascript:eliminar();">
		 Eliminar cliente
	 </div>
	<?
endif;
?>