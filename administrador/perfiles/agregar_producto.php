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
	<legend>Producto <?=$p_numero?></legend>
	<table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral" id="tbl_producto<?=$campo?>">
		<tr>
         <td>Tipo</td>
         <td>
            <select name="tipo_producto<?=$campo?>">
               <option value="Producto">Producto</option>                                 
            </select>
         </td>
      </tr>
      <tr>
         <td>Título</td>
         <td><input type="text" name="titulo_producto<?=$campo?>" style="width:90%;" maxlength="255"></td>
      </tr> 
      <tr>
	       <td>Imagen</td>
	       <td><input type="file" name="imagen_producto<?=$campo?>"></td>
	    </tr>
	    <tr>
	       <td>Descripción</td>
	       <td><textarea name="descripcion_producto<?=$campo?>" id="descripcion_producto<?=$campo?>"  style="width:100%; height:100px;"></textarea></td>
	       </td>
	    </tr>  
	</table>   
	</fieldset>
	<?
endif;
?>