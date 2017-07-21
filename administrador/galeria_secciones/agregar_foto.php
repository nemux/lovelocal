<?
include("../php/config.php");
include("../php/func.php");
include("../php/func_bd.php");
$p_numero=$_POST['numero']*1;
if(!empty($p_numero)):
	?>
	<fieldset>
	<legend>Foto <?=$p_numero?></legend>
	<table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral" id="tbl_foto<?=$p_numero?>">
   	<tr>
         <td>Sección</td>
         <td>
            <?
            $c_sec=buscar("id_seccion,seccion","secciones","WHERE estatus='activo' ORDER BY seccion");
            ?>
            <select name="id_seccion<?=$p_numero?>">
               <?
               if($c_sec->num_rows>0):
                  while($f_sec=$c_sec->fetch_assoc()):
                     $id_seccion=$f_sec["id_seccion"];
                     $seccion=cadena($f_sec["seccion"]);
                     ?>
                     <option value="<?=$id_seccion?>"><?=$seccion?></option>
                     <?
                     unset($id_seccion,$seccion);
                  endwhile;
               endif;
               ?>
               <option value="">Todas</option>
            </select>
            </td>
      </tr>
		<tr>
			<td>Foto</td>
			<td><input type="text" name="titulo<?=$p_numero?>" style="width:400px;" maxlength="255" required>*</td>
		</tr>
		<tr>
			<td>Imagen</td>
			<td><input type="file" name="imagen<?=$p_numero?>"/></td>
		</tr>
		<tr>
			<td></td>
			<td>Le sugerimos una imagen con 1170 X 780 pixeles y formato JPG</td>
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