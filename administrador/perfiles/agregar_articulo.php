<?
include("../php/config.php");
include("../php/func.php");
include("../php/func_bd.php");
$p_numero=isset($_POST['numero']) ? $_POST['numero']*1 : "";
$p_registro=isset($_POST['registro']) ? $_POST['registro']*1 : "";
if(!empty($p_numero)):
	if(!empty($p_registro)):
		$campo=$p_registro.$p_numero;
	else:
		$campo=$p_numero;
	endif;
	?>
	<fieldset>
	<legend>Artículo <?=$p_numero?></legend>
	<table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral" id="tbl_articulo<?=$campo?>">
		<tr>
         <td>Artículo</td>
         <td><input type="text" name="articulo<?=$campo?>" style="width:90%;" maxlength="255"></td>
      </tr>   
      <tr>
         <td>Imagen</td>
         <td><input type="file" name="imagen_articulo<?=$campo?>"></td>
      </tr>
		<tr>
			<td></td>
			<td>Le sugerimos una imagen con 1170 X 780 pixeles y formato JPG</td>
		</tr>      
      <tr>
         <td>Descripción corta</td>
         <td><textarea name="descripcion_corta_articulo<?=$campo?>" id="descripcion_corta_articulo<?=$campo?>"  style="width:100%; height:100px;"></textarea></td>
         </td>
      </tr>
      <tr>
         <td>Descripción completa</td>
         <td><textarea name="descripcion_completa_articulo<?=$campo?>" id="descripcion_completa_articulo<?=$campo?>"  style="width:100%; height:200px;"></textarea></td>
         </td>
      </tr>
	</table>   
	</fieldset>
	<?
endif;
?>