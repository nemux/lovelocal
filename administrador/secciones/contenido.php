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
	$condicion.=" where (se.seccion LIKE '%".$p_nombre."%' OR se.subtitulo LIKE '%".$p_nombre."%' or se.descripcion_corta LIKE '%".$p_nombre."%' or se.descripcion_completa LIKE '%".$p_nombre."%' OR sa.seccion LIKE '%".$p_nombre."%' OR sa.descripcion_corta LIKE '%".$p_nombre."%' OR sa.descripcion_completa LIKE '%".$p_nombre."%') ";
endif;

if($RegistrosAMostrar=="todos"):
	$orden=" ORDER BY sa.orden ASC,se.orden ASC";
else:
	$orden=" ORDER BY sa.orden ASC,se.orden ASC LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
endif;

$condicion2=$condicion.$orden;

$campos="se.id_seccion
			,sa.seccion AS seccion_anterior
			,se.tipo_seccion
			,se.menu
			,se.seccion
			,se.subtitulo
			,se.enlace_activo
			,se.enlace
			,se.adjunto
			,se.descripcion_corta
			,se.icono
			,se.imagen
			,se.orden
			,se.estatus";
$tablas="secciones se 
			left outer join
			secciones sa
			on	sa.id_seccion=se.id_seccion_anterior
			";
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
            Sección</td>
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
      <th>Sección</th>
      <th>Subtítulo</th>
      <th>Enlace activo</th>
      <th>Tipo</th>
      <th>Imagen</th>
      <th>Orden</th>
      <th>Estatus</th>      
	   </tr>
   <?
	$contador=0;
	$seccion_anterior_anterior="";
	while($f_id=$c_id->fetch_assoc()):
		$contador++;
		$id_seccion=$f_id["id_seccion"];
		$seccion_anterior=cadena($f_id["seccion_anterior"]);
		$tipo_seccion=cadena($f_id["tipo_seccion"]);
		$menu=cadena($f_id["menu"]);
		$seccion=cadena($f_id["seccion"]);
		$subtitulo=cadena($f_id["subtitulo"]);		
		$enlace_activo=$f_id["enlace_activo"];
		$enlace=cadena($f_id["enlace"]);
		$adjunto=cadena($f_id["adjunto"]);
		$descripcion_corta=cadena($f_id["descripcion_corta"]);
		$icono=$f_id["icono"];
		$imagen=$f_id["imagen"];
		$orden=$f_id["orden"];
		$estatus=$f_id["estatus"];
		
		if($seccion_anterior_anterior!=$seccion_anterior):
			$seccion_anterior_anterior=$seccion_anterior;
		else:
			$seccion_anterior="";
		endif;
		
		if(empty($orden)):
			$orden="";
		endif;
		
		if(!empty($seccion_anterior)):
			?>
         <tr>
         	<td colspan="8" class="titulo"><?=$seccion_anterior?></td>
         </tr>
         <?
		endif;
		?>
     <tr>
      	<td align="center"><input type="checkbox" name="arreglo_registros[]" value="<?=$id_seccion?>"/></td>
         <td><?=$seccion?></td>
         <td><?=$subtitulo?></td>         
         <td align="center"><?=$enlace_activo?></td>
         <td><?=strtoupper(substr($tipo_seccion,0,1)).str_replace("_"," ",substr($tipo_seccion,1));?></td>
         <td>
				<?
				if(!empty($imagen) and file_exists("images/".$imagen)):
					$size=getimagesize("images/".$imagen);
					$ancho=$size[0];
					$alto=$size[1];

					if($alto>59):
						$ancho=(int)((59/$alto)*$ancho);
						$alto=59;
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
         <td align="center"><?=$orden?></td>
         <td align="center"><?=$estatus?></td>
		</tr>
      <?
		unset($id_seccion);
		unset($seccion_anterior);
		unset($tipo_seccion);
		unset($menu);
		unset($seccion,$subtitulo);
		unset($enlace_activo);
		unset($descripcion_corta);
		unset($icono);
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
		$c_re=buscar("".$campos."","".$tablas."","".$condicion."");
      $total_reg=$c_re->num_rows;
      
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