<?
include("../php/config.php");
include("../php/func.php");
include("../php/func_bd.php");
$p_numero=$_POST['numero']*1;
if(!empty($p_numero)):
	?>
	<fieldset>
	<legend>Banner publicitario <?=$p_numero?></legend>
	<table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral" id="tbl_banner<?=$p_numero?>">
		<tr>
			<td>Banner publicitario</td>
			<td><input type="text" name="banner<?=$p_numero?>" style="width:400px;" maxlength="255" required>*</td>
		</tr>
		<tr>
			<td>Imagen</td>
			<td><input type="file" name="imagen<?=$p_numero?>"/></td>
		</tr>
		<tr>
			<td></td>
			<td>Le sugerimos una imagen con 1752 x 250 pixeles y formato JPG</td>
		</tr>
		<tr>
			<td>Enlace</td>
			<td>
				<textarea name="enlace<?=$p_numero?>" id="enlace<?=$p_numero?>" style="width:600px; height:100px;"></textarea>
			</td>
		</tr>
		<tr>
			<td>Orden</td>
			<td>
				<input type="number" min="0" name="orden<?=$p_numero?>" step="1" style="width:50px;"/>
			</td>
		</tr>
		<tr>
			<td>Estatus</td>
			<td><select name="estatus<?=$p_numero?>">
				<option value="activo">Activo</option>
				<option value="inactivo">Inactivo</option>
			</select>
			</td>
		</tr>
	</table>   
	</fieldset>
	<?
endif;
?>