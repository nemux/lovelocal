<?
include("../php/config.php");
include("../php/func.php");
include("../php/func_bd.php");
$p_numero=$_GET['numero']*1;
if(!empty($p_numero)):
	for($con=1;$con<=$p_numero;$con++):
		$iden=$con;
		?>
      <fieldset>
      <legend>Categoría <?=$con?></legend>
		<table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral">
			<tr>
				<td>Categoría</td>
				<td><input type="text" name="categoria<?=$iden?>" style="width:300px;" maxlength="255">*</td>
			</tr>
			<tr>
				<td>Imagen</td>
				<td><input type="file" name="imagen<?=$iden?>"/></td>
			</tr>
         <tr>
            <td></td>
            <td>Le sugerimos una imagen con 1170 X 780 pixeles y formato JPG</td>
         </tr>
         <tr>
            <td>Descripción corta</td>
            <td>
               <textarea name="descripcion_corta" style="width:400px; height:100px;"></textarea>
            </td>
         </tr>
			<tr>
				<td>Orden</td>
				<td>
	            <input type="number" min="0" name="orden<?=$iden?>" step="1" style="width:50px;"/>
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