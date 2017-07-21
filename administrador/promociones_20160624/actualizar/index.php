<?
session_start();
//ini_set("display_errors","On");
$se_id_usuario=$_SESSION["s_id_usuario"];
if(empty($se_id_usuario)):
	?>
	<script type="text/javascript" language="javascript">
   location.href="../login/";
   </script>
   <?
else:
	include("../../php/config.php");
	include("../../php/func.php");
	include("../../php/func_bd.php");
	$arreglo_respuestas=array();
	$p_arreglo_registros=isset($_POST['arreglo_registros']) ? $_POST['arreglo_registros'] : "";
	$p_action=isset($_POST['action']) ? $_POST['action'] : "";
	if($p_action=="send"):
		date_default_timezone_set('Mexico/General');
		$fechahora=date("YmdHis");
	
		$p_arreglo_registros=$_POST['arreglo_registros'];
		if(count($p_arreglo_registros)>0):
			for($i=0;$i<count($p_arreglo_registros);$i++):
				$registro=$p_arreglo_registros[$i];
				$promocion="promocion".$registro;
				$eliminar_imagen="eliminar_imagen".$registro;			
				/*
				$imagen_original="imagen_original".$registro;
				$eliminar_imagen_original="eliminar_imagen_original".$registro;
				*/
				$orden="orden".$registro;
				$estatus="estatus".$registro;
				
				$p_promocion=cadenabd($_POST[$promocion]);
				
				$p_eliminar_imagen=$_POST[$eliminar_imagen];
				$p_descripcion_corta=cadenabd($_POST["descripcion_corta".$registro]);
				$p_descripcion_completa=cadenabd($_POST["descripcion_completa".$registro]);
				$p_orden=$_POST[$orden]*1;
				$p_estatus=$_POST[$estatus];
				
				if(!empty($p_promocion) and
					!empty($p_estatus)
					):
					$c_se=buscar("imagen","promociones","where id_promocion=".$registro);
					while($f_se=$c_se->fetch_assoc()):
						$imagen_actual=$f_se['imagen'];
						//$imagen_original_actual=$f_se['imagen_original'];
					endwhile;
					
					if(!empty($_FILES["imagen".$registro]["name"])):
						$valid_formats= array("jpg","png","gif","JPG","PNG","GIF");
						
						//$max_file_size = 1024*1024; //1000 kb
						$max_file_size= 1048576*64; //64 MB
						$path= "../images/"; // Upload directory
					
						if($_FILES['imagen'.$registro]['error']==4):
							$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen".$registro]["name"].' tiene un error.</div>';
						endif;
						if($_FILES['imagen'.$registro]['error']==0):
							if($_FILES['imagen'.$registro]['size']>$max_file_size):
								$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen".$registro]["name"].' es muy grande.</div>';
							elseif(!in_array(pathinfo($_FILES["imagen".$registro]["name"], PATHINFO_EXTENSION), $valid_formats)):
								$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen".$registro]["name"].' no es un formato válido</div>';
							else: // No error found! Move uploaded files 
								$extension=".".pathinfo($_FILES["imagen".$registro]["name"], PATHINFO_EXTENSION);
								$nombre_archivo="img_".$registro."_".$fechahora.$extension;
								if(move_uploaded_file($_FILES["imagen".$registro]["tmp_name"],$path.$nombre_archivo)):
									$p_imagen=$nombre_archivo;
									if(!empty($imagen_actual) and file_exists("../images/".$imagen_actual)):
										unlink("../images/".$imagen_actual);
									endif;
								endif;
								unset($extension,$nombre_archivo);
							endif;
						endif;
						unset($valid_formats,$max_file_size,$path,$count);
					elseif($p_eliminar_imagen=="on"):
						if(!empty($imagen_actual) and file_exists("../images/".$imagen_actual)):
							unlink("../images/".$imagen_actual);
						endif;
						$p_imagen="";
					endif;
					/*
					if(!empty($varname2)):
						if(!empty($imagen_original_actual) and file_exists("../images/".$imagen_original_actual)):
							unlink("../images/".$imagen_original_actual);
						endif;
						$vartemp2=$_FILES[$imagen_original]['tmp_name'];
						$extension2=obtener_extension($varname2);
						$p_imagen_original="io".$registro.$extension2;
						$nombre_archivo2="../images/".$p_imagen_original;
						move_uploaded_file($vartemp2,$nombre_archivo2);
					elseif($p_eliminar_imagen_original=="on"):
						if(!empty($imagen_original_actual) and file_exists("../images/".$imagen_original_actual)):
							unlink("../images/".$imagen_original_actual);
						endif;
						$p_imagen_original="";
					endif;
					unset($varname2);
					unset($vartemp2);
					unset($extension2);
					unset($nombre_archivo2);
					*/
						
					$actualizar="promocion='".$p_promocion."'";
					if(!empty($p_imagen) or $p_eliminar_imagen=="on"):
						$actualizar.=",imagen='".$p_imagen."'";
					endif;
					/*
					if(!empty($p_imagen_original) or $p_eliminar_imagen_original=="on"):
					$actualizar.=",imagen_original='".$p_imagen_original."'";
					endif;
					*/
					$actualizar.=",descripcion_corta='".$p_descripcion_corta."'
									,descripcion_completa='".$p_descripcion_completa."'
									,orden=".$p_orden."
									,estatus='".$p_estatus."'";
					$c_id=actualizar("".$actualizar."","promociones","where id_promocion=".$registro."");
					
					if(!$c_id):
						$arreglo_respuestas[]='<div class="error">No fue posible actualizar este promocion '.$registro.'</div>';
					else:
						$arreglo_respuestas[]='<div class="exito">Promoción '.$registro.' actualizada exitosamente</div>';
					endif;				
				else:
					$arreglo_respuestas[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
				endif;
				
				unset($p_promocion);
				unset($p_imagen);
				unset($p_eliminar_imagen);
				unset($imagen_actual);
				/*
				unset($p_imagen_original);
				unset($p_eliminar_imagen_original);
				unset($imagen_original_actual);
				*/
				unset($p_descripcion_corta,$p_descripcion_completa,$p_orden);
				unset($p_estatus);
				unset($grupo);
	
				unset($actualizar);
				unset($c_id);
			endfor;
		endif;
	endif;
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>PROMOCIONES - ACTUALIZAR</title>
    <!-- Favicon -->
	 <link rel="shortcut icon" href="http://www.ziikfor.com/images/favicon.png">
	<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
	<link href="../../css/form.css" rel="stylesheet" type="text/css" />
	<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script type="text/javascript" language="javascript" src="../../js/funciones.js"></script>
	<script type="text/javascript" language="javascript" src="../../js/fmt-money.js"></script>
	<script type="text/javascript" language="javascript" src="../ajax.js"></script>
	<!--CALENDARIO-->
	<link href="../../js/addons/jscalendar-1.0/calendar-tas.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../../js/formatdate.js"></script>
	<script type="text/javascript" src="../../js/addons/jscalendar-1.0/calendar.js"></script>
	<script type="text/javascript" src="../../js/addons/jscalendar-1.0/lang/calendar-es.js"></script>
	<script type="text/javascript" src="../../js/addons/jscalendar-1.0/calendar-setup.js"></script>
	<!--CALENDARIO-->
	</head>
	<body>
	<div id="contenedor">
		<div id="cabecera">
			<?
			include("../../includes/encabezado.php");
			?>
		</div>
		 <div id="separador">&nbsp;</div>
			<div class="div_separador">&nbsp;</div>
		<div id="menu">
			<?
			include("../../includes/menu.php");
			?>
		</div>
		<div id="contenido">
			<div id="#menu_interno">
				<?
				include("../../includes/menu_interno.php");
				?>
			</div>
			<div>
			<?
			if(count($arreglo_respuestas)>0):
				foreach($arreglo_respuestas as $respuesta):
					?>
					<div class="alerta"><?=$respuesta?></div>
					<?
				endforeach;
			endif;
			?>
			<style>
         #form1{display: block; position:relative}
         #form1 .nicEdit-main{
            background-color:#FFFFFF;
         }
         </style>   
			<form action="./" method="post" enctype="multipart/form-data" name="form1" id="form1">
			<?
			if(count($p_arreglo_registros)>0):
				for($i=0;$i<count($p_arreglo_registros);$i++):
					$registro=$p_arreglo_registros[$i];
					$c_id=buscar("promocion
										,imagen
										,descripcion_corta
										,descripcion_completa
										,orden
										,estatus"
									,"promociones"
									,"where id_promocion=".$registro."");
										
					while($f_c=$c_id->fetch_assoc()):
						$promocion=cadena($f_c['promocion']);
						$imagen=$f_c['imagen'];
						//$imagen_original=$f_c['imagen_original'];
						$descripcion_corta=cadena($f_c["descripcion_corta"]);
						$descripcion_completa=cadena($f_c["descripcion_completa"]);						
						$orden=$f_c['orden'];
						$estatus=$f_c['estatus'];
					endwhile;
					?>
								<fieldset>
								<legend>Actualizar Promoción</legend>
								 <table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral">
									<tr>
										<td></td>
									  <td class="alerta" id="td_respuesta<?=$registro?>"></td>
									</tr>
									<tr>
										<td width="20%">Promoción</td>
										<td width="80%"><input type="text" name="promocion<?=$registro?>" style="width:300px;" maxlength="255" value="<?=$promocion?>"></td>
									</tr>
									<?
									if(!empty($imagen) and file_exists("../images/".$imagen)):
										?>
										<tr>
										  <td class="text_gral">Imagen actual</td>
										  <td class="text_gral">
											<a href="../images/<?=$imagen?>" target="_blank">
											<img src="../images/<?=$imagen?>" style="max-width:1170px;" border="0">
											</a>
										  </td>
										</tr>
										<tr>
											<td></td>
											<td><input type="checkbox" name="eliminar_imagen<?=$registro?>"/> Eliminar imagen</td>                              
										</tr>
										<tr>
										  <td class="text_gral">Sustituir por:</td>
										  <td class="text_gral"><input type="file" name="imagen<?=$registro?>"/>
												<br />
												<span>Le sugerimos una imagen con 1170 X 780 pixeles y formato JPG</span>
												</td>	   
										</tr>
										<?
									else:
										?>
										<tr>
										  <td class="text_gral">Imagen</td>
										  <td class="text_gral"><input type="file" name="imagen<?=$registro?>"/>
											<br />
											  <span>Le sugerimos una imagen con 1170 X 780 pixeles y formato JPG</span>
										  </td>
										</tr>
										<?
									endif;
									?>
									<tr>
										<td>Descripción corta</td>
										<td>
											<textarea name="descripcion_corta<?=$registro?>" id="descripcion_corta<?=$registro?>" style="width:600px;height:100px;"><?=$descripcion_corta?></textarea>
										</td>
									</tr>                        
									<tr>
										<td>Descripción completa</td>
										<td>
											<textarea name="descripcion_completa<?=$registro?>" id="descripcion_completa<?=$registro?>" style="width:600px;height:300px;"><?=$descripcion_completa?></textarea>
										</td>
									</tr>                        
									<tr>
										<td>Orden</td>
										<td>
											<input type="text" name="orden<?=$registro?>" style="width:50px;" value="<?=$orden?>"/>
										</td>
									</tr>
									 <tr>
										<td>Estatus</td>
										<td>
											<select name="estatus<? echo $registro; ?>">
												<option value="activo" <?php if($estatus=="activo"): ?> selected <?php endif;?>>Activo</option>
												<option value="inactivo" <?php if($estatus=="inactivo"): ?> selected <?php endif;?>>Inactivo</option>
											</select>
										</td>
									 </tr>
									<tr>
									  <td><span class="text_gral">
										 <input type="hidden" name="arreglo_registros[]" value="<?php echo $registro; ?>" />
									  </span></td>
									  <td><span class="text_gral">
										 <input type="submit" class="link_5" value="Registro"/>
									  </span></td>
									</tr>
								 </table>
								 </fieldset>
									<?
									unset($promocion);
									unset($imagen,$descripcion_corta,$descripcion_completa);
									//unset($imagen_original);
									unset($orden);
									unset($estatus);
								endfor;
								?>
								<div>
								  <input type="hidden" name="action" value="send" />
								</div>
								<?php
								endif;
								?>
							 </form>
			</div>
		</div>
		<div id="pie">
			<?
			include("../../includes/pie.php");
			?>
		</div>
	</div>
   <script src="../../../assets/nicEdit/nicEdit.js" type="text/javascript"></script>
   <script>
	jQuery(document).ready(function(){
		<?
		if(count($p_arreglo_registros)>0):
			for($con=0;$con<count($p_arreglo_registros);$con++):
				?>
				new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta<?=$p_arreglo_registros[$con]?>");
				new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa<?=$p_arreglo_registros[$con]?>");
				<?
			endfor;
			?>
			jQuery("#form1").submit(function(event){
				e.preventDefault();
				<?
				for($con=0;$con<count($p_arreglo_registros);$con++):
					?>
					nicEditors.findEditor("descripcion_corta<?=$p_arreglo_registros[$con]?>").saveContent();
					nicEditors.findEditor("descripcion_completa<?=$p_arreglo_registros[$con]?>").saveContent();
					<?
				endfor;
				?>
				jQuery("#form1").submit();
			});
			<?
		endif;
		?>
	});	
	</script>
	</body>
	</html>
	<?
endif;
?>