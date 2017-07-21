<?
if(!isset($_SESSION)) session_start();
ini_set("display_errors","On");
$se_id_usuario=$_SESSION["s_id_usuario"];
if(empty($mysqli)):
	include("../php/config.php");
	include("../php/func.php");
	include("../php/func_bd.php");
endif;
if(!empty($_GET['registros'])):
	$RegistrosAMostrar= $_GET['registros'];
else:
	$RegistrosAMostrar=30;
endif;

if(!empty($_GET['pag'])):
	$RegistrosAEmpezar= ($_GET['pag']-1) * $RegistrosAMostrar;
	$PagAct= $_GET['pag'];
	//caso contrario los iniciamos
else:
	$RegistrosAEmpezar= 0;
  	$PagAct= 1;
endif;

if(!empty($_GET['p_nombre'])):
	$p_nombre= $_GET['p_nombre'];
endif;

$condicion="";
if(!empty($p_nombre)):
	$condicion.=" where se.titulo LIKE '%".$p_nombre."%' ";
endif;

if($RegistrosAMostrar=="todos"):
	$orden=" ORDER BY se.orden ASC";
else:
	$orden=" ORDER BY se.orden ASC LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
endif;

$condicion2=$condicion.$orden;

$campos="se.id_red
			,se.titulo
			,se.imagen
			,se.enlace
			,se.orden
			,se.estatus";
$tablas="redes_sociales se ";
$c_id=buscar("".$campos."","".$tablas."","".$condicion2."",false);

//echo $campos." from ".$tablas." ".$condicion2."<br>";
?>
<link href="../css/administrador.css" rel="stylesheet" type="text/css" />
<form id="form_contenido" name="form_contenido" method="post" action="./">
   <div id="filtro_busqueda">
      <table cellpadding="0" cellspacing="0">
      <tr>
         <td>
            No. Resultados
         </td>
         <td>
            <select name="registros" style="width:100%;">
              <option value="30" <?php if($RegistrosAMostrar==30): ?> selected="selected" <?php endif; ?>>30</option>
              <option value="50" <?php if($RegistrosAMostrar==50): ?> selected="selected" <?php endif; ?>>50</option>
              <option value="100" <?php if($RegistrosAMostrar==100): ?> selected="selected" <?php endif; ?>>100</option>
              <option value="todos" <?php if($RegistrosAMostrar=="todos"): ?> selected="selected" <?php endif; ?>>Todos</option>
            </select>
         </td>
      </tr>
      <tr>
         <td>
            Red social</td>
         <td>
            <input type="text" name="p_nombre" style="width:200px;" <?php if(!empty($p_nombre)): ?> value="<?=cadena($p_nombre); ?>" <?php endif; ?>/>
         </td>
      </tr>
      <tr>
         <td>
         </td>
         <td>
            <input type="button" class="submit" onclick="javascript:Pagina(1,document.form_contenido.registros.value,document.form_contenido.p_nombre.value)" value="Filtrar"/>
         </td>
      </tr>
   </table>
   </div>
   <div class="div_separador">&nbsp;</div>
   <div id="div_respuesta"></div>
   <div>
   <table width="100%" cellpadding="5" cellspacing="1">
   	<tr>
		<th><input type='checkbox' onclick='seleccionar_todo("form_contenido");'></th>
      <th>Red social</th>
      <th>Imagen</th>
      <th>Enlace</th> 
      <th>Orden</th>
      <th>Estatus</th>      
	   </tr>
   <?
	$contador=0;
	while($f_id=$c_id->fetch_assoc()):
		$contador++;
		$id_red=$f_id["id_red"];
		$titulo=cadena($f_id["titulo"]);
		$enlace=cadena($f_id["enlace"]);
		$imagen=$f_id["imagen"];
		$orden=$f_id["orden"];
		$estatus=$f_id["estatus"];
		?>
     <tr>
      	<td align="center"><input type="checkbox" name="arreglo_registros[]" value="<?=$id_red?>"/></td>
         <td><?=$titulo?></td>
         <td>
				<?
				if(!empty($imagen) and file_exists("images/".$imagen)):
					$size=getimagesize("images/".$imagen);
					$ancho=$size[0];
					$alto=$size[1];

					if($alto>60):
						$ancho=(int)((60/$alto)*$ancho);
						$alto=60;
					endif;
					?>
               <img src="images/<?=$imagen?>" width="<?=$ancho?>" height="<?=$alto?>" align="absmiddle" style="vertical-align:middle; border:none;"/>
               <?
					unset($size);
					unset($ancho);
					unset($alto);
				endif;
				?>
         </td>
         <td><?=$enlace?></td>
         <td align="center"><?=$orden?></td>
         <td align="center"><?=$estatus?></td>
		</tr>
      <?
		unset($id_red);
		unset($titulo);
		unset($enlace);
		unset($imagen);
		unset($orden);
		unset($estatus);
	endwhile;
	?>
	</table>
   </div>
   <div class="paginacion">
      <?
      //echo $campos." from secciones ".$condicion."<br>";
		$c_reg=buscar("".$campos."","".$tablas."","".$condicion."");
      $total_reg=$c_reg->num_rows;		
      
      $PagAnt=$PagAct-1;
      $PagSig=$PagAct+1;
      
      if($RegistrosAMostrar=="todos"):
         $RegistrosAMostrar=$total_reg;
      endif;
      
		$PagUlt=0;
      if($total_reg>0):
         $PagUlt=$total_reg/$RegistrosAMostrar;
      endif;
       
      $Res=$total_reg%$RegistrosAMostrar; 
      
      if($Res>0):
         $PagUlt=floor($PagUlt)+1;
      endif;
      
      if($PagAct > 1):
         ?>
         <a href="javascript:;" onclick="Pagina(1,document.form_contenido.registros.value,document.form_contenido.p_nombre.value)" style="text-decoration:none"><strong><<&nbsp;</strong></a>
         <a href="javascript:;" onclick="Pagina(<?php echo $PagAnt; ?>,document.form_contenido.registros.value,document.form_contenido.p_nombre.value)" style="text-decoration:none"><strong><&nbsp;</strong></a>
         <span class="txt2bldred"><?php echo $PagAct." de ".$PagUlt; ?></span>
         <?php
         if($PagAct < $PagUlt):
            ?>
            <a href="javascript:;" onclick="Pagina(<?php echo $PagSig; ?>,document.form_contenido.registros.value,document.form_contenido.p_nombre.value)" style="text-decoration:none"><strong>>&nbsp;</strong></a>	
            <a href="javascript:;" onclick="Pagina(<?php echo $PagUlt; ?>,document.form_contenido.registros.value,document.form_contenido.p_nombre.value)" style="text-decoration:none"><strong>>>&nbsp;</strong></a>
            <?php
         endif;
      else:
         if($PagUlt>0):
            ?>
            <span class="txt2bldred"><?php echo $PagAct." de ".$PagUlt; ?></span>
            <?php	 
         endif;
          
         if($PagAct < $PagUlt):
            ?>
            <a href="javascript:;" onclick="Pagina(<?php echo $PagSig; ?>,document.form_contenido.registros.value,document.form_contenido.p_nombre.value)" style="text-decoration:none"><strong>>&nbsp;</strong></a>
            <a href="javascript:;" onclick="Pagina(<?php echo $PagUlt; ?>,document.form_contenido.registros.value,document.form_contenido.p_nombre.value)" style="text-decoration:none"><strong>>>&nbsp;</strong></a>
            <?php
         endif;
      endif;
      ?>    
      <input type="hidden" name="registro" />
   </div>
</form>