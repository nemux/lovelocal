<?
include("../php/config.php");
include("../php/func.php");			
include("../php/func_bd.php");

$p_id_division=$_GET['id_division'];
$p_id_idioma=$_GET['id_idioma'];
$p_identificador=$_GET['identificador'];
$c_se=buscar("id_seccion,seccion","secciones","where id_division=".$p_id_division." and id_idioma=".$p_id_idioma."");
if($p_identificador>0):
	echo '
	<select name="id_seccion_anterior'.$p_identificador.'">	
	';
else:
	echo '
	<select name="id_seccion_anterior">	
	';
endif;
?>
	<option value="">Ninguna</option>   
	<?
   $fise=mysql_num_rows($c_se);
   if($fise>0):
		while($f_se=mysql_fetch_assoc($c_se)):
			$id_seccion=$f_se['id_seccion'];
			$seccion=cadena($f_se['seccion']);
			?>
			<option value="<?=$id_seccion?>"><?=$seccion?></option>
			<?
			unset($id_seccion);
			unset($seccion);
		endwhile;
   endif;
   ?>
</select>