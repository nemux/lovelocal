<?
include("../php/config.php");
include("../php/func.php");
include("../php/func_bd.php");
$p_numero=$_GET['numero']*1;
if(empty($p_numero)):
	?>
   Capture un número mayor a cero
   <?
else:
	for($con=1;$con<=$p_numero;$con++):
		$iden=$con;
		?>
      <fieldset>
      <legend>Imagen <?=$con?></legend>
		<table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral">
			<tr>
				<td>Titulo</td>
				<td><input type="text" name="servicio<?=$iden?>" style="width:300px;" maxlength="255">*</td>
			</tr>
			<tr>
				<td>Imagen</td>
				<td><input type="file" name="imagen<?=$iden?>"/>
            <span class="info">*</span>
            </td>
			</tr>
			<tr>
				<td></td>
				<td>Le sugerimos una imagen con 370 X 374 pixeles y formato JPG</td>
			</tr>
			<tr>
				<td>Orden</td>
				<td>
					<input type="text" name="orden<?=$iden?>" style="width:50px;"/>
				</td>
			</tr>
			<tr>
				<td>Estatus</td>
				<td><select name="estatus<?=$iden?>">
					<option value="activo">Activo</option>
					<option value="inactivo">Inactivo</option>
				</select>
				</td>
			</tr>
		</table>   
      </fieldset>
		<?
	endfor;
endif;
?>