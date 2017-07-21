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
$condicion2="";

if(!empty($p_nombre)):
	$condicion=" where";
	if(!empty($p_nombre)):
		$condicion2.="	AND (per.perfil LIKE '%".$p_nombre."%' OR per.local LIKE '%".$p_nombre."%')";
	endif;
	$condicion2=substr($condicion2,4);
	$condicion.=$condicion2;
endif;

if($RegistrosAMostrar=="todos"):
	$orden=" ORDER BY per.local";
else:
	$orden=" ORDER BY per.local LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
endif;

$condicion2=$condicion.$orden;

$campos="per.id_perfil
			,per.perfil
			,per.local
			,per.usuario
			,per.password
			,per.imagen
			,per.calle
			,per.no_exterior
			,per.no_interior
			,per.colonia
			,per.codigo_postal
			,per.municipio
			,est.estado
			,per.email
			,per.telefono
			,per.celular
			,per.estatus
			,per.mostrar_home";
$tablas="perfiles per
			LEFT OUTER JOIN
			estados est
			ON est.id_estado=per.id_estado";
$c_id=buscar("".$campos."","".$tablas."","".$condicion2."",false);

//echo $campos." from perfiles ".$condicion2."<br>";
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
            Perfil
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
         <th>Local</th>
         <th>Perfil</th>
         <th>Categorías</th>
         <th>Foto</th>
         <th>Domicilio</th>
         <th>Email</th>
         <th>Usuario</th>
         <th>Teléfonos</th>
         <th>Mostrar en Home</th>
         <th>Estatus</th>
	   </tr>
   <?
	$contador=0;
	while($f_id=$c_id->fetch_assoc()):
		$contador++;
		$id_perfil=$f_id["id_perfil"];
		$perfil=cadena($f_id["perfil"]);
		$local=cadena($f_id["local"]);
		$usuario=cadena($f_id["usuario"]);
		$password=$f_id["password"];
		$imagen=$f_id["imagen"];
		$calle=cadena($f_id["calle"]);
		$no_exterior=cadena($f_id["no_exterior"]);
		$no_interior=cadena($f_id["no_interior"]);		
		$colonia=cadena($f_id["colonia"]);		
		$codigo_postal=cadena($f_id["codigo_postal"]);
		$municipio=cadena($f_id["municipio"]);
		$estado=cadena($f_id["estado"]);
		$email=cadena($f_id["email"]);
		$telefono=cadena($f_id["telefono"]);		
		$celular=cadena($f_id["celular"]);
		$estatus=$f_id["estatus"];
		$mostrar_home=$f_id["mostrar_home"];
		?>
     <tr class="txt_center">
      	<td><input type="checkbox" name="arreglo_registros[]" value="<?=$id_perfil?>"/></td>
         <td><?=$local?></td>
         <td><?=$perfil?></td>         
         <td>
         	<?
				$c_cat=buscar("cat.categoria"
									,"categorias_perfiles cat_per 
										LEFT OUTER JOIN categorias cat 
										ON cat.id_categoria=cat_per.id_categoria"
									,"WHERE cat_per.id_perfil='".$id_perfil."'");
				$lista_categorias="";
				while($f_cat=$c_cat->fetch_assoc()):
					$lista_categorias.=", ".cadena($f_cat["categoria"]);
				endwhile;
				if(!empty($lista_categorias)):
					echo substr($lista_categorias,2);
				endif;
				?>
         </td>
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
				if(!empty($municipio)):
					echo ", ".$municipio;
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
         <td><?=$usuario." / ".htmlspecialchars($password)?></td>
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
         <td><?=$mostrar_home?></td>
         <td><?=$estatus?></td>
		</tr>
      <?
		unset($id_perfil
		,$perfil
		,$local
		,$usuario
		,$password
		,$imagen
		,$calle
		,$no_exterior
		,$no_interior
		,$colonia
		,$codigo_postal
		,$municipio
		,$estado
		,$email
		,$telefono
		,$celular
		,$estatus,$mostrar_home,$lista_categorias);
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