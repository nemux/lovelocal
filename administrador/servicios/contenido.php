<?
session_start();
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

if(!empty($p_nombre)):
	$condicion1=" WHERE";
	
	if(!empty($p_nombre)):
		$condicion.=" AND (ga.servicio LIKE '%".$p_nombre."%') ";
	endif;
	$condicion=substr($condicion,4);
	$condicion=$condicion1.$condicion;
endif;

if($RegistrosAMostrar=="todos"):
	$orden=" ORDER BY ga.orden";
else:
	$orden=" ORDER BY ga.orden LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
endif;

$condicion2=$condicion.$orden;

$campos="ga.id_servicio,ga.servicio,ga.imagen,ga.orden,ga.estatus";
$tablas="servicios ga ";
$c_id=buscar("".$campos."","".$tablas."","".$condicion2."",false);

//echo "select ".$campos." from ".$tablas." ".$condicion2."<br>";

?>
<form id="form_contenido" name="form_contenido" method="post" action="./">
	<div id="filtro_busqueda">
   <table>
   <tr>
   <td>No. Resultados</td>
   <td>
	         <select name="registros">
	            <option value="30" <?php if($RegistrosAMostrar==30): ?> selected="selected" <?php endif; ?>>30</option>
	            <option value="50" <?php if($RegistrosAMostrar==50): ?> selected="selected" <?php endif; ?>>50</option>
	            <option value="100" <?php if($RegistrosAMostrar==100): ?> selected="selected" <?php endif; ?>>100</option>
	            <option value="todos" <?php if($RegistrosAMostrar=="todos"): ?> selected="selected" <?php endif; ?>>Todos</option>
	            </select>
		</td>
      </tr>
         <tr>
            <td>
               Servicio
            </td>
            <td>
               <input type="text" name="p_nombre" style="width:200px;" <?php if(!empty($p_nombre)): ?> value="<?=cadena($p_nombre); ?>" <?php endif; ?>/>
            </td>
         </tr>
         <tr>
         <td></td>
         <td>
	         <input type="button" onclick="javascript:Pagina(1,document.form_contenido.registros.value,document.form_contenido.p_nombre.value)" value="Filtrar" style="vertical-align:middle"/>
       </td>
       </tr>
       </table>
       </div>

<div id="div_respuesta"></div>
<div>   
<table width="100%">
   <tr>
      <th><input type='checkbox' onclick='seleccionar_todo("form_contenido");'></th>
      <th>Título</th>
      <!--
      <th>Ícono</th>
     
      <th>Imagen</th> -->
      <? /*<th>Enlace</th>*/ ?>
      <th>Orden</th>
      <th>Estatus</th>
   </tr>
   <?
	$contador=0;
	while($f_id=mysql_fetch_assoc($c_id)):
		$contador++;
		$id_servicio=$f_id["id_servicio"];
		$servicio=cadena($f_id["servicio"]);
		$imagen=cadena($f_id["imagen"]);
		$enlace=cadena($f_id["enlace"]);
		$orden=$f_id["orden"];
		$estatus=$f_id["estatus"];
		
		if(empty($orden)):
			$orden="";
		endif;
		?>
      <tr class="txt_center">
      	<td style="text-align:center"><input type="checkbox" name="arreglo_registros[]" value="<?=$id_servicio?>"/></td>
         <td><?=$servicio?></td>
         <? /* <td>
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
         </td> */ ?>
         
         <? /*<td><?=$enlace?></td>*/ ?>                                   
         <td style="text-align:center;"><?=$orden;?></td>
         <td style="text-align:center"><?=$estatus?></td>      
      </tr>
      <?
		unset($id_servicio);
		unset($servicio);
		unset($imagen);
		unset($enlace);
		unset($orden);
		unset($estatus);
	endwhile;
	?>
</table>
</div>
           <div class="paginacion">
	      <?
         $total_reg=mysql_num_rows(buscar("".$campos."","".$tablas."","".$condicion.""));
         
         $PagAnt=$PagAct-1;
         $PagSig=$PagAct+1;
			
         if($RegistrosAMostrar=="todos"):
            $RegistrosAMostrar=$total_reg;
         endif;
         
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
            ?>
	      <?php
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
            ?>
	      <?php
         endif;
         ?>      
         </div>	
	<input type="hidden" name="registro" />
</form>