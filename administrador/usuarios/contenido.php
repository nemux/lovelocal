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

$condicion=" where (tipo_usuario<>'Cliente' AND tipo_usuario<>'Propietario')";
if(!empty($p_nombre)):
	$condicion.=" and (usuario LIKE '%".$p_nombre."%' or nombre_completo LIKE '%".$p_nombre."%') ";
endif;

if($RegistrosAMostrar=="todos"):
	$orden=" ORDER BY nombre_completo";
else:
	$orden=" ORDER BY nombre_completo LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
endif;

$condicion2=$condicion.$orden;

$campos="id_usuario,nombre_completo,cargo,tipo_usuario,imagen,email,telefono,telefono2,mostrar_pagina,recibir_copia,usuario,estatus";
$tablas="adm_usuarios";
$c_id=buscar("".$campos."","".$tablas."","".$condicion2."");

//echo $campos." from adm_usuarios ".$condicion2."<br>";
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
            Usuario
         </td>
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
      <th>No.</th>
      <th>Nombre completo</th>
      <th>Usuario</th>
      <th>Cargo</th>
      <th>Tipo</th>
      <th>Foto</th>
      <th>Email</th>     
      <th>Teléfonos</th>
      <th>Mostrar en página</th>
      <th>Recibir copia</th> 
      <th>Estatus</th>
	   </tr>
   <?
	$contador=0;
	while($f_id=$c_id->fetch_assoc()):
		$contador++;
		$id_usuario=$f_id["id_usuario"];
		$nombre_completo=cadena($f_id["nombre_completo"]);
		$cargo=cadena($f_id["cargo"]);
		$tipo_usuario=cadena($f_id["tipo_usuario"]);
		$imagen=$f_id["imagen"];
		$email=cadena($f_id["email"]);
		$telefono=cadena($f_id["telefono"]);
		$telefono2=cadena($f_id["telefono2"]);
		$mostrar_pagina=$f_id["mostrar_pagina"];
		$recibir_copia=$f_id["recibir_copia"];
		$usuario=cadena($f_id["usuario"]);
		$estatus=$f_id["estatus"];
		?>
     <tr class="txt_center">
      	<td><input type="checkbox" name="arreglo_registros[]" value="<?=$id_usuario?>"/></td>
         <td><?=$contador;?></td>
         <td><?=$nombre_completo?></td>
         <td><?=$usuario;?></td>
         <td><?=$cargo?></td>
         <td><?=$tipo_usuario?></td>
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
         <td><?=$email?></td>
         <td><?=$telefono; if(!empty($telefono2)): echo "<br />".$telefono2;endif;?></td>
         <td><?=$mostrar_pagina?></td>
         <td><?=$recibir_copia?></td>
         <td><?=$estatus?></td>
		</tr>
      <?
		unset($id_usuario);
		unset($nombre_completo);
		unset($cargo);
		unset($tipo_usuario);
		unset($imagen);
		unset($email);
		unset($telefono,$telefono2);
		unset($mostrar_pagina);
		unset($recibir_copia);
		unset($usuario);
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