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
	$condicion=" where";
	if(!empty($p_nombre)):
		$condicion2.="	AND (nombres LIKE '%".$p_nombre."%' OR apellidos LIKE '%".$p_nombre."%')";
	endif;
	$condicion2=substr($condicion2,4);
	$condicion.=$condicion2;
endif;

if($RegistrosAMostrar=="todos"):
	$orden=" ORDER BY nombres";
else:
	$orden=" ORDER BY nombres LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
endif;

$condicion2=$condicion.$orden;

$campos="doc.id_dueno
			,doc.perfil
			,doc.titulo
			,doc.nombres
			,doc.apellidos
			,doc.usuario
			,doc.password
			,doc.imagen
			,doc.calle
			,doc.no_exterior
			,doc.no_interior
			,doc.colonia
			,doc.delegacion
			,doc.codigo_postal
			,doc.municipio
			,est.estado
			,doc.email
			,doc.telefono
			,doc.celular
			,doc.estatus";
$tablas="duenos doc
			LEFT OUTER JOIN
			estados est
			ON est.id_estado=doc.id_estado";
$c_id=buscar("".$campos."","".$tablas."","".$condicion2."",false);

//echo $campos." from duenos ".$condicion2."<br>";
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
            Dueño
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
      <th>Dueño</th>
      <th>Perfil</th>      
      <th>Foto</th>
      <th>Domicilio</th>
      <th>Email</th>
      <th>Usuario</th>      
      <th>Teléfonos</th>
      <th>Estatus</th>
	   </tr>
   <?
	$contador=0;
	while($f_id=$c_id->fetch_assoc()):
		$contador++;
		$id_dueno=$f_id["id_dueno"];
		$perfil=cadena($f_id["perfil"]);
		$titulo=cadena($f_id["titulo"]);
		$nombres=cadena($f_id["nombres"]);
		$apellidos=cadena($f_id["apellidos"]);
		$usuario=cadena($f_id["usuario"]);
		$password=cadena($f_id["password"]);		
		$imagen=$f_id["imagen"];
		$calle=cadena($f_id["calle"]);
		$no_exterior=cadena($f_id["no_exterior"]);
		$no_interior=cadena($f_id["no_interior"]);		
		$colonia=cadena($f_id["colonia"]);		
		$delegacion=cadena($f_id["delegacion"]);
		$codigo_postal=cadena($f_id["codigo_postal"]);
		$municipio=cadena($f_id["municipio"]);
		$estado=cadena($f_id["estado"]);
		$email=cadena($f_id["email"]);
		$telefono=cadena($f_id["telefono"]);		
		$celular=cadena($f_id["celular"]);
		$estatus=$f_id["estatus"];
		?>
     <tr class="txt_center">
      	<td><input type="checkbox" name="arreglo_registros[]" value="<?=$id_dueno?>"/></td>
         <td><?=$titulo." ".$nombres." ".$apellidos?></td>
         <td><?=$perfil?></td>         
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
         <td>
				<?
            if(!empty($calle)):
					echo $calle;
				endif;
				if(!empty($no_exterior)):
					echo " #".$no_exterior;
				endif;
				if(!empty($no_interior)):
					echo ", Int. ".$no_interior;
				endif;
				if(!empty($colonia)):
					echo ", Col.".$colonia;
				endif;
				if(!empty($delegacion)):
					echo ", Del.".$delegacion;
				endif;
				if(!empty($estado)):
					echo ", ".$estado;
				endif;
				if(!empty($codigo_postal)):
					echo ", C.P.".$codigo_postal;
				endif;
				?>
         </td>
         <td><?=$email?></td>
         <td><?=$usuario."_".$password?></td>
         <td>
         	<?
				if(!empty($telefono)):
					echo "Tel. ".$telefono;
				endif;
				if(!empty($celular)):
					echo "Móvil: ".$celular;
				endif;
            ?>
			</td>
         <td><?=$estatus?></td>
		</tr>
      <?
		unset($id_dueno
		,$perfil
		,$titulo,$nombres
		,$apellidos,$usuario,$password
		,$imagen
		,$calle
		,$no_exterior
		,$no_interior
		,$colonia
		,$delegacion
		,$codigo_postal
		,$municipio
		,$estado
		,$email
		,$telefono
		,$celular
		,$estatus);
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