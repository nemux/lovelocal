<?
include("../php/config.php");
include("../php/func.php");
include("../php/func_bd.php");
$p_numero=$_POST['numero']*1;
if(!empty($p_numero)):
	?>
	<fieldset>
	<legend>Nota <?=$p_numero?></legend>
	<table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral" id="tbl_nota<?=$p_numero?>">
		<tr>
         <td>Sección</td>
         <td>
            <?
            $c_sec=buscar("id_seccion,seccion","secciones","WHERE estatus='activo' ORDER BY orden");
            ?>
            <select name="id_seccion<?=$p_numero?>" required>
               <option value="">Seleccione ...</option>
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
            </select>
            *
         </td>
      </tr>   
		<tr>
			<td>Nota</td>
			<td><input type="text" name="nota<?=$p_numero?>" style="width:400px;" maxlength="255" required>*</td>
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
			<td>Descripción corta</td>
			<td>
				<textarea name="descripcion_corta<?=$p_numero?>" id="descripcion_corta<?=$p_numero?>" style="width:600px; height:100px;"></textarea>
			</td>
		</tr>
	   <tr>
         <td>Descripción completa</td>
         <td>
            <textarea name="descripcion_completa<?=$p_numero?>" id="descripcion_completa<?=$p_numero?>" style="width:600px; height:300px;"></textarea>
         </td>
      </tr>      
		<tr>
			<td>Orden</td>
			<td>
				<input type="number" min="0" name="orden<?=$p_numero?>" step="1" style="width:50px;"/>
			</td>
		</tr>
      <?
      //Buscar categorías 
      $c_cat=buscar("id_categoria,categoria","categorias","WHERE estatus='activo' ORDER BY orden ASC");
      if($c_cat->num_rows>0):
         ?>
         <tr>
            <td>Categorías</td>
            <td>
               <?
               while($f_cat=$c_cat->fetch_assoc()):
                  $id_categoria=$f_cat["id_categoria"];
                  $categoria=cadena($f_cat["categoria"]);
                  ?>
                  <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                     <input type="checkbox" name="categorias<?=$p_numero?>[]" value="<?=$id_categoria?>"> <?=$categoria?>
                  </div>
                  <?
                  unset($id_categoria,$categoria);
               endwhile;
               ?>
            </td>
          </tr>
         <?
      endif;
      ?>
		<tr>
			<td>Estatus</td>
			<td><select name="estatus<?=$p_numero?>">
				<option value="activo">Activo</option>
				<option value="inactivo">Inactivo</option>
			</select>
			</td>
		</tr>
      <tr>
                                       <td>Perfil</td>
                                       <td>
            <?php
             $c_per=buscar("per.id_perfil            
            ,per.local"
            ,"perfiles per
            LEFT OUTER JOIN
            estados est
            ON est.id_estado=per.id_estado"
            ," ORDER BY local ASC ",false);
            ?>
            <select name="perfil<?=$p_numero?>">
            <option value="">Aleatorio</option>
            <?php
  while($f_per=$c_per->fetch_assoc()):
  $id_perfil=$f_per["id_perfil"];  
  $local=cadena($f_per["local"]);
    ?>
    <option value="<?php echo $id_perfil; ?>"><?php echo $local; ?></option>
    <?php
  endwhile;
  ?>
  </select>
                                       </td>
                                    </tr>
                                    
	</table>   
	</fieldset>
	<?
endif;
?>