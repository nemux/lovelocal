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
	$p_nombre=cadenabd($_GET['p_nombre']);
endif;

$condicion="";
if(!empty($p_nombre)):
	$condicion1=" WHERE";
	
	if(!empty($p_nombre)):
		$condicion.=" AND (sec.seccion LIKE '%".$p_nombre."%' OR nota.nota LIKE '%".$p_nombre."%') ";
	endif;
	$condicion=substr($condicion,4);
	$condicion=$condicion1.$condicion;
endif;

if($RegistrosAMostrar=="todos"):
	$orden=" ORDER BY nota.orden,nota.nota";
else:
	$orden=" ORDER BY nota.orden,nota.nota LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
endif;

$condicion2=$condicion.$orden;

$campos="nota.fecha_hora_registro, nota.id_nota,sec.seccion,nota.nota,nota.imagen,nota.descripcion_corta,nota.orden,nota.estatus";
$tablas="notas_editoriales nota LEFT OUTER JOIN secciones sec ON sec.id_seccion=nota.id_seccion";
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
               Nota
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
      <th>Nota</th>
      <th>Sección</th>
      <!--
      <th>Ícono</th>
     	-->
      <th>Imagen</th>
      <th>Descripción corta</th>
      <th>Orden</th>
      <th>Fecha</th>
      <th>Estatus</th>
   </tr>
   <?
	$contador=0;
	while($f_id=$c_id->fetch_assoc()):
		$contador++;
		$id_nota=$f_id["id_nota"];
		$seccion=cadena($f_id["seccion"]);
		$nota=cadena($f_id["nota"]);
		$imagen=cadena($f_id["imagen"]);
		$descripcion_corta=cadena($f_id["descripcion_corta"]);
		$orden=$f_id["orden"];
		$estatus=$f_id["estatus"];
		$fecha=$f_id["fecha_hora_registro"];
		if(empty($orden)):
			$orden="";
		endif;
		?>
      <tr class="txt_center">
      	<td style="text-align:center"><input type="checkbox" name="arreglo_registros[]" value="<?=$id_nota?>"/></td>
         <td><?=$nota?></td>
         <td><?=$seccion?></td>
         <td>
				<?
				if(!empty($imagen) and file_exists("images/".$imagen)):
					?>
               <img src="images/<?=$imagen?>" style="max-width:100px;vertical-align:middle; border:none;"/>
               <?
				endif;
				?>
         </td>
			<td><?=$descripcion_corta?></td>         
         <td style="text-align:center;"><?=$orden;?></td>
         <td style="text-align:center;"><?=$fecha;?></td>
         <td style="text-align:center"><?=$estatus?></td>      
      </tr>
      <?
		unset($id_nota,$seccion);
		unset($nota);
		unset($imagen,$descripcion_corta);
		unset($orden);
		unset($fecha);
		unset($estatus);
	endwhile;
	?>
</table>
</div>
           <div class="paginacion">
	      <?
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