<?
session_start();
$se_altas=explode(",",$_SESSION['s_altas']);
$se_consultas=explode(",",$_SESSION['s_consultas']);
$se_actualizaciones=explode(",",$_SESSION['s_actualizaciones']);
$se_bajas=explode(",",$_SESSION['s_bajas']);
$se_seccion=$_SESSION['s_seccion'];
$se_viaje=$_SESSION['s_viaje'];
?>
<div class="boton_menu_seccion">
<?
if(!empty($se_viaje)):
	//Buscar seccion anterior de la sección actual
	$c_se=buscar("id_seccion_anterior","adm_secciones","where id_seccion=".$se_seccion);
	while($f_se=mysql_fetch_assoc($c_se)):
		$id_seccion_anterior=$f_se['id_seccion_anterior'];
	endwhile;
	?>
   <a href="/administrador/viajes/?se=<?=$id_seccion_anterior?>">Regresar</a>
   <?
else:
	?>
   <a href="/administrador/">Regresar</a>
   <?
endif;
?>
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