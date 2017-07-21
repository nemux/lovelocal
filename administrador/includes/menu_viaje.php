<?
session_start();
$se_altas=explode(",",$_SESSION['s_altas']);
$se_consultas=explode(",",$_SESSION['s_consultas']);
$se_actualizaciones=explode(",",$_SESSION['s_actualizaciones']);
$se_bajas=explode(",",$_SESSION['s_bajas']);
$se_seccion=$_SESSION['s_seccion'];
$se_viaje=$_SESSION['s_viaje'];
if(!empty($se_viaje)):
	//Buscar id_seccion antecesora
	$c_an=buscar("id_seccion_anterior","adm_secciones","where id_seccion=".$se_seccion);
	while($f_an=mysql_fetch_assoc($c_an)):
		$id_seccion_anterior=$f_an["id_seccion_anterior"];
	endwhile;
	if(!empty($id_seccion_anterior)):
		?>
      <div class="boton_menu_seccion">
      <a href="../viajes/?se=<?=$id_seccion_anterior?>">Regresar</a>
      </div>
      <?
	else:
		?>
      <div class="boton_menu_seccion">
      <a href="../">Regresar</a>
      </div>
      <?
	endif;
	?>
   <?
else:
	?>
   <div class="boton_menu_seccion">
   <a href="../">Regresar</a>
   </div>
   <?
endif;
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