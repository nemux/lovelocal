<?
include("../php/config.php");
include("../php/func.php");
include("../php/func_bd.php");
$p_numero=$_POST['numero']*1;
if(!empty($p_numero)):
	?>
	<fieldset>
	<legend>Recompensa <?=$p_numero?></legend>
	<table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral" id="tbl_recompensa<?=$p_numero?>">
		<tr>
			<td>Recompensa</td>
			<td><input type="text" name="recompensa<?=$p_numero?>" style="width:90%;" maxlength="255"></td>
		</tr>
		<tr>
			<td>Estatus</td>
			<td><select name="estatus_recompensa<?=$p_numero?>">
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