<?
session_start();
//ini_set("display_errors","On");
$se_id_usuario=$_SESSION["s_id_usuario"];
if(empty($se_id_usuario)):
	?>
	<script type="text/javascript" language="javascript">
   location.href="../../login/";
   </script>
   <?
else:
include("../../php/config.php");
include("../../php/func.php");
include("../../php/func_bd.php");
$p_arreglo_registros=$_POST['arreglo_registros'];
$arreglo_respuestas=array();
$p_action=isset($_POST['action']) ? $_POST['action'] : "";
if($p_action=="send"):
	$p_arreglo_registros=$_POST['arreglo_registros'];
	if(count($p_arreglo_registros)>0):
	
		date_default_timezone_set('Mexico/General');
		$fechahora=date("YmdHis");
		
		
		for($i=0;$i<count($p_arreglo_registros);$i++):
			$registro=$p_arreglo_registros[$i];
			$id_seccion_anterior='id_seccion_anterior'.$registro;
			$menu="menu".$registro;
			$seccion="seccion".$registro;
			$boton="boton".$registro;			
			$eliminar_boton='eliminar_boton'.$registro;		
			/*
			$boton_rollover="boton_rollover".$registro;
			$eliminar_boton_rollover='eliminar_boton_rollover'.$registro;					
			*/
			$imagen='imagen'.$registro;
			$eliminar_imagen='eliminar_imagen'.$registro;		
			/*
			$imagen_descripcion='imagen_descripcion'.$registro;
			$eliminar_imagen_descripcion='eliminar_imagen_descripcion'.$registro;		
			$banner="banner".$registro;
			$eliminar_banner="eliminar_banner".$registro;
			*/
			$adjunto="adjunto".$registro;
			$eliminar_adjunto="eliminar_adjunto".$registro;
			$descripcion_corta="descripcion_corta".$registro;
			$descripcion_completa="descripcion_completa".$registro;			
			$palabras_clave="palabras_clave".$registro;
			$enlace="enlace".$registro;
			$orden='orden'.$registro;
			$estatus="estatus".$registro;
			
			$p_id_seccion_anterior=$_POST[$id_seccion_anterior]*1;
			$p_id_categoria=$_POST["id_categoria".$registro]*1;
			$p_menu=cadenabd($_POST[$menu]);
			$p_seccion=cadenabd($_POST[$seccion]);
			$p_subtitulo=cadenabd($_POST["subtitulo".$registro]);
			$p_enlace_activo=$_POST["enlace_activo".$registro];
			$varname=cadenabd($_FILES[$boton]['name']);
			$p_eliminar_boton=$_POST[$eliminar_boton];
			/*						
			$varname2=cadenabd($_FILES[$boton_rollover]['name']);
			$p_eliminar_boton_rollover=$_POST[$eliminar_boton_rollover];									
			*/
			$varname3=cadenabd($_FILES[$imagen]['name']);
			$p_eliminar_imagen=$_POST[$eliminar_imagen];			
			/*
			$varname4=cadenabd($_FILES[$imagen_descripcion]['name']);
			$p_eliminar_imagen_descripcion=$_POST[$eliminar_imagen_descripcion];	
			$varname5=cadenabd($_FILES[$banner]['name']);
			$p_eliminar_banner=$_POST[$eliminar_banner];	
			*/
			$varname6=cadenabd($_FILES[$adjunto]['name']);
			$p_eliminar_adjunto=$_POST[$eliminar_adjunto];	
			
			$p_descripcion_corta=cadenabd($_POST[$descripcion_corta]);
			$p_descripcion_completa=cadenabd($_POST[$descripcion_completa]);
			$p_palabras_clave=cadenabd($_POST[$palabras_clave]);
			$p_enlace=cadenabd($_POST[$enlace]);
			$p_orden=$_POST[$orden]*1;
			$p_estatus=$_POST[$estatus];
			$p_calendario_google=$_POST["calendario_google".$registro];
			$p_calendario_google=str_replace("amp;","",$p_calendario_google);
			$p_calendario_google=addslashes($p_calendario_google);
			$p_calendario_google=cadenabd($p_calendario_google);
			$p_mapa=cadenabd($_POST['mapa'.$registro]);
			$p_mapa=str_replace("amp;","",$p_mapa);
			$p_mapa=addslashes($p_mapa);
			
			if($p_enlace_activo=="on"):
				$p_enlace_activo="si";
			else:
				$p_enlace_activo="no";
			endif;
			
			$c_se=buscar("imagen,adjunto","secciones","where id_seccion=".$registro);
			while($f_se=$c_se->fetch_assoc()):
				$imagen_actual=$f_se['imagen'];
				$adjunto_actual=$f_se['adjunto'];
			endwhile;
			

			if(!empty($varname3)):
				$vartemp3=$_FILES["imagen".$registro]['tmp_name'];
				$extension3=".".pathinfo($_FILES["imagen".$registro]["name"], PATHINFO_EXTENSION);
				if($extension3==".jpg"
				or $extension3==".JPG" 
				or $extension3==".jpeg"
				or $extension3==".JPEG" 
				or $extension3==".png" 
				or $extension3==".PNG" 
				or $extension3==".gif" 
				or $extension3==".GIF"
					):
					if(!empty($imagen_actual) and file_exists("../images/".$imagen_actual)):
						unlink("../images/".$imagen_actual);
					endif;
					$p_imagen="i".$registro."_".$fechahora.$extension3;
					$nombre_archivo3="../images/".$p_imagen;
					move_uploaded_file($vartemp3,$nombre_archivo3);
				endif;
			elseif($p_eliminar_imagen=="on"):
				if(!empty($imagen_actual) and file_exists("../images/".$imagen_actual)):
					unlink("../images/".$imagen_actual);
				endif;
				$p_imagen="";
			endif;
			if(!empty($varname6)):
				$vartemp6=$_FILES[$adjunto]['tmp_name'];
				$extension6=".".pathinfo($_FILES["adjunto".$registro]["name"], PATHINFO_EXTENSION);				
				if($extension6==".jpg" 
				or $extension6==".JPG" 
				or $extension6==".png" 
				or $extension6==".PNG" 
				or $extension6==".gif" 
				or $extension6==".GIF"
				or $extension6==".doc" 
				or $extension6==".DOC"
				or $extension6==".xls" 
				or $extension6==".XLS"
				or $extension6==".xlsx" 
				or $extension6==".XLSx"
				or $extension6==".docx" 
				or $extension6==".DOCX"
				or $extension6==".pdf" 
				or $extension6==".PDF"
					):
					if(!empty($adjunto_actual) and file_exists("../adjuntos/".$adjunto_actual)):
						unlink("../adjuntos/".$adjunto_actual);
					endif;
					$p_adjunto="ad_".$registro."_".$fechahora.$extension6;
					$nombre_archivo6="../adjuntos/".$p_adjunto;
					move_uploaded_file($vartemp6,$nombre_archivo6);
				endif;
			elseif($p_eliminar_adjunto=="on"):
				if(!empty($adjunto_actual) and file_exists("../adjuntos/".$adjunto_actual)):
					unlink("../adjuntos/".$adjunto_actual);
				endif;
				$p_adjunto="";
			endif;
			
			$actualizar="id_seccion_anterior=".$p_id_seccion_anterior."
						,id_categoria=".$p_id_categoria."
							,menu='".$p_menu."'
							,seccion='".$p_seccion."'
							,subtitulo='".$p_subtitulo."'
							,enlace_activo='".$p_enlace_activo."'
							,enlace='".$p_enlace."'";
			if(!empty($p_imagen) or $p_eliminar_imagen=="on"):
			$actualizar.=",imagen='".$p_imagen."'";
			endif;
			if(!empty($p_adjunto) or $p_eliminar_adjunto=="on"):
			$actualizar.=",adjunto='".$p_adjunto."'";
			endif;
			$actualizar.=",descripcion_corta='".$p_descripcion_corta."'
							  ,descripcion_completa='".$p_descripcion_completa."'
							  ,palabras_clave='".$p_palabras_clave."'
							  ,orden=".$p_orden."
							  ,estatus='".$p_estatus."'
							  ,calendario_google='".$p_calendario_google."'
							  ,mapa_google='".$p_mapa."'";
							  
			$c_id=actualizar("".$actualizar."","secciones","where id_seccion=".$registro,false);
			
			if(!$c_id):
				$arreglo_respuestas[count($arreglo_respuestas)]="No fue posible actualizar esta seccion ".cadena($p_seccion);
			else:
				$arreglo_respuestas[count($arreglo_respuestas)]="Sección ".cadena($p_seccion)." actualizada exitosamente.";
			endif;
			
			unset($p_id_seccion_anterior);
			unset($p_id_categoria);
			unset($p_menu);
			unset($p_seccion,$p_subtitulo);
			unset($p_enlace_activo);
			unset($p_enlace);
			unset($p_descripcion_corta);
			unset($p_descripcion_completa);
			unset($p_palabras_clave);
			unset($varname);
			unset($p_eliminar_boton);
			/*
			unset($varname2);
			unset($p_eliminar_boton_rollover);
			*/
			unset($varname3);
			unset($p_eliminar_imagen);
			/*
			unset($varname4);
			unset($p_eliminar_imagen_descripcion);
			unset($varname5);
			unset($p_eliminar_banner);
			*/
			unset($varname6);
			unset($p_eliminar_adjunto);
			unset($p_orden);
			unset($p_estatus);
			unset($p_calendario_google);
			unset($p_mapa);
			
			unset($c_se);
			unset($boton_actual);
			/*
			unset($boton_rollover_actual);
			unset($banner_actual);
			*/
			unset($imagen_actual);
			unset($adjunto_actual);
			//unset($imagen_descripcion_actual);
			
			unset($vartemp);
			unset($extension);
			unset($p_boton);
			unset($nombre_archivo);
			unset($size);
			unset($ancho);
			unset($alto);
			unset($cambio);
			
			/*
			unset($vartemp2);
			unset($extension2);
			unset($p_boton_rollover);
			unset($nombre_archivo2);
			unset($size2);
			unset($ancho2);
			unset($alto2);
			unset($cambio2);
			*/
		
			unset($vartemp3);
			unset($extension3);
			unset($p_imagen);
			unset($nombre_archivo3);
			unset($size3);
			unset($ancho3);
			unset($alto3);
			unset($cambio3);
			/*
			unset($vartemp4);
			unset($extension4);
			unset($p_imagen_descripcion);
			unset($nombre_archivo4);

			unset($vartemp5);
			unset($extension5);
			unset($p_banner);
			unset($nombre_archivo5);
			*/
			unset($vartemp6);
			unset($extension6);
			unset($p_adjunto);
			unset($nombre_archivo6);

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
<title>SECCIONES ACTUALIZAR</title>
<link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">
<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
<link href="../../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<? 
include("../../includes/ajuste.php");
/*
<script type="text/javascript" src="../../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
*/
?>
<script type="text/javascript" language="javascript" src="../../js/funciones.js"></script>
<script type="text/javascript" language="javascript" src="../ajax.js"></script>
<script type="text/javascript" language="javascript">
function validar_menu(menu,registro){
	if(menu=="principal"){
		document.getElementById("tr_boton"+registro).style.display="";
		//document.getElementById("tr_boton_rollover"+registro).style.display="";
	}
	else{
		document.getElementById("tr_boton"+registro).style.display="none";
		//document.getElementById("tr_boton_rollover"+registro).style.display="none";
		
	}
}
</script>
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
      <div id="menu_paginacion">
         <?
         include("../../includes/menu_interno.php");
         ?>
      </div>
      <div class="div_separador">&nbsp;</div>	      <div id="div_contenido">
      <?
      if(count($arreglo_respuestas)>0):
         ?>
<table cellpadding="3" cellspacing="1" width="100%">
                            <?
                  foreach($arreglo_respuestas as $respuesta):
                     ?>
                            <tr>
                              <td class="respuesta"><?=$respuesta;?></td>
                            </tr>
                            <?
                  endforeach;
                  ?>
                          </table>
                        <?
      endif;
		?>
      <form action="./" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <?
		if(count($p_arreglo_registros)>0):
			for($i=0;$i<count($p_arreglo_registros);$i++):
				$registro=$p_arreglo_registros[$i];
				$c_id=buscar("id_seccion_anterior
								,id_categoria
								,tipo_seccion
								,menu
								,seccion
								,subtitulo
								,enlace_activo
								,enlace
								,adjunto
								,descripcion_corta
								,descripcion_completa								
								,palabras_clave
								,icono
								,imagen
								,orden
								,estatus
								,calendario_google
								,mapa_google","secciones","where id_seccion=".$registro);
				while($f_id=$c_id->fetch_assoc()):
					$id_seccion_anterior=$f_id["id_seccion_anterior"];
					$id_categoria_seccion=$f_id["id_categoria"];
					$tipo_seccion=cadena($f_id["tipo_seccion"]);
					$menu=cadena($f_id["menu"]);
					$seccion=cadena($f_id["seccion"]);
					$subtitulo=cadena($f_id["subtitulo"]);
					$enlace_activo=$f_id["enlace_activo"];
					$enlace=cadena($f_id["enlace"]);
					$adjunto=$f_id["adjunto"];
					$descripcion_corta=cadena($f_id["descripcion_corta"]);					
					$descripcion_completa=cadena($f_id["descripcion_completa"]);
					$palabras_clave=cadena($f_id["palabras_clave"]);
					$boton=$f_id["icono"];
					//$boton_rollover=$f_id["boton_rollover"];
					//$banner=$f_id["banner"];
					$imagen=$f_id["imagen"];
					//$imagen_descripcion=$f_id["imagen_descripcion"];
					$orden=$f_id["orden"];																																													
					$estatus=$f_id["estatus"];
					$calendario_google=cadena($f_id['calendario_google']);
					$calendario_google=stripslashes($calendario_google);
					$mapa_google=cadena($f_id['mapa_google']);
					$mapa_google=stripslashes($mapa_google);
				endwhile;
				?>
      	<fieldset>
         <legend>Actualizar sección</legend>
                      <table border="0" cellpadding="3" cellspacing="1" align="left">
                        <tr>
                          <td colspan="2" class="text_9" id="td_respuesta<?=$registro?>"></td>
                        </tr>
                        <? /*
                        <tr>
                          <td class="text_gral">Sección anterior</td>
                          <td class="text_gral" id="td_secciones<?=$registro?>">
								  <?
									$c_se=buscar("id_seccion,seccion"
										,"secciones"
										,"WHERE id_seccion_anterior=0 order by seccion asc");
									?>
                            <select name="id_seccion_anterior<?=$registro?>">
                              <option value="">Ninguna</option>
                              <?
							while($f_se=$c_se->fetch_assoc()):
								$id_seccion=$f_se['id_seccion'];
								$seccion_anterior=cadena($f_se['seccion']);
								?>
                              <option value="<?=$id_seccion?>" <? if($id_seccion==$id_seccion_anterior): ?> selected="selected" <? endif;?>>
                                <?=$seccion_anterior?>
                                </option>
                              <?
								unset($id_seccion);
								unset($seccion_anterior);
							endwhile;
							?>
                            </select></td>
                        </tr>
                        <tr>
                          <td class="text_gral">Tipo</td>
                          <td class="text_gral"><?=$tipo_seccion?>
                              <div id="tr_categorias<?=$registro?>" <? if($tipo_seccion!='categorias'):?> style="display:none;" <? endif; ?>>
                              	<div class="div_separador" style="height:10px;"></div>
                                 Categoría: 
                                 <?
                                 $c_ca=buscar("id_categoria,categoria","categorias","where estatus='activo' ORDER BY orden ASC");
                                 ?>
                                 <select name="id_categoria<?=$registro?>">
                                    <option value="">Seleccione</option>
                                    <?
                                    while($f_ca=$c_ca->fetch_assoc()):
                                       $id_categoria=$f_ca["id_categoria"];
                                       $categoria=cadena($f_ca["categoria"]);
                                       ?>
                                       <option value="<?=$id_categoria?>" <? if($id_categoria==$id_categoria_seccion): ?> selected="selected" <? endif;?>><?=$categoria?></option>
                                       <?
                                       unset($id_categoria);
                                       unset($categoria);
                                    endwhile;
                                    ?>
                                 </select>
                              </div>
                              <div id="tr_calendario<?=$registro?>" <? if($tipo_seccion!='calendario_google'):?> style="display:none;" <? endif; ?>>
                                <div class="div_separador" style="height:10px;"></div>
                                 Calendario de Google: <br />
                                 <textarea name="calendario_google<?=$registro?>" style="width:300px; height:150px;"><?=$calendario_google?></textarea><br />
								<strong>Ejemplo:</strong> < iframe src="https://www.google.com/calendar/embed?src=j1tt2as76p912uesrsuivdeut4%40group.calendar.google.com&ctz=America/Mexico_City" style="border: 0" width="538" height="338" frameborder="0" scrolling="no">< /iframe>
                              </div>
                          </td>
                        </tr>
								*/
								?>
                        <?
								/*
                        <tr>
                          <td class="text_gral">Menú</td>
                          <td class="text_gral">
                          <select name="menu<?=$registro?>" onChange="validar_menu(this.value,<?=$registro?>);">
                            <option value="arriba" <? if($menu=="arriba"):?> selected="selected"<? endif;?>>Arriba</option>
                            <option value="centro" <? if($menu=="centro"):?> selected="selected"<? endif;?>>Centro</option>
                            <option value="izquierdo" <? if($menu=="izquierdo"):?> selected="selected"<? endif;?>>Izquierdo</option>
                            <option value="interno" <? if($menu=="interno"):?> selected="selected"<? endif;?>>Interno</option>
                          </select></td>
                        </tr>
								*/
								?>
                        <tr>
                          <td class="text_gral">Sección</td>
                          <td class="text_gral"><input type="text" name="seccion<?=$registro?>" style="width:400px;" maxlength="255" value="<?=$seccion?>" required="required" />
                            <span class="requerido">*</span></td>
                        </tr>
                        <tr>
                          <td class="text_gral">Subtítulo</td>
                          <td class="text_gral"><input type="text" name="subtitulo<?=$registro?>" style="width:400px;" maxlength="255" value="<?=$subtitulo?>" /></td>
                        </tr>
                        <tr>
                          <td class="text_gral"></td>
                          <td class="text_gral"><input type="checkbox" name="enlace_activo<?=$registro?>" <? if($enlace_activo=="si"): ?> checked="checked" <? endif;?>/> Enlace activo</td>
                        </tr>
                        <?
								/*
								if($menu=="principal"):
									?>
									<!--
                           <tr id="tr_boton<?=$registro?>">
                              <td colspan="2">
                                 <table class="text_gral" cellpadding="3" cellspacing="1" width="100%">
												<?
                                    if(!empty($boton) and file_exists("../botones/".$boton)):
													$size=getimagesize("../botones/".$boton);
													$ancho=$size[0];
													$alto=$size[1];
													if($alto>59):
														$ancho=(int)((59/$alto)*$ancho);
														$alto=59;
													endif;
                                       ?>
                                       <tr>
                                         <td class="text_gral" width="18%">Ícono actual</td>
                                         <td class="text_gral" width="82%">
                                          <img src="../botones/<?=$boton?>" width="<?=$ancho?>" height="<?=$alto?>">
                                         </td>
                                       </tr>
                                       <tr>
                                         <td class="text_gral"></td>
                                         <td class="text_gral">
                                             <input type="checkbox" name="eliminar_boton<?=$registro?>">Eliminar ícono
                                         </td>
                                       </tr>
                                       <tr>
                                         <td class="text_gral">Sustituir por:</td>
                                         <td class="text_gral"><input type="file" name="boton<?=$registro?>"/>
	                                         <br />
													      <span>Le sugerimos una imagen de 59 px de alto y formato GIF O PNG</span></td>	   
                                       </tr>
                                       <?
													unset($size);
													unset($ancho);
													unset($alto);
												else:
													?>
                                       <tr>
                                         <td class="text_gral" width="18%">Ícono</td>
                                         <td class="text_gral" width="82%"><input type="file" name="boton<?=$registro?>"/>
                                          <br />
                                          <span>Le sugerimos una imagen de 59 px de alto y formato GIF O PNG</span>                                         
                                         </td>
                                       </tr>
                                       <?
                                    endif;
                                    ?>
											</table>
                           	</td>
                            </tr>
									 -->
                           <?
								endif;
								*/

								if($tipo_seccion<>"enlace"):
									if(!empty($imagen) and file_exists("../images/".$imagen)):
										$size=getimagesize("../images/".$imagen);
										$ancho=$size[0];
										$alto=$size[1];
										
										if($ancho>980):
											$alto=(int)((980/$ancho)*$alto);
											$ancho=980;
										endif;
										?>
										<tr>
										  <td class="text_gral">Imagen actual</td>
										  <td class="text_gral">
											<img src="../images/<?=$imagen?>" width="<?=$ancho?>" height="<?=$alto?>">
										  </td>
										</tr>
										<tr>
										  <td class="text_gral"></td>
										  <td class="text_gral">
												<input type="checkbox" name="eliminar_imagen<?=$registro?>">Eliminar imagen
										  </td>
										</tr>
										<tr>
										  <td class="text_gral">Sustituir por:</td>
										  <td class="text_gral"><input type="file" name="imagen<?=$registro?>"/>
												<br />
                                    <span>Le sugerimos una imagen de 980 x 260 pixeles y formato JPG</span>
                                </td>	   
										</tr>
										<?
										unset($size);
										unset($ancho);
										unset($alto);
									else:
										?>
										<tr>
										  <td class="text_gral">Imagen</td>
										  <td class="text_gral"><input type="file" name="imagen<?=$registro?>"/>
											<br />
											<span>Le sugerimos una imagen de 980 x 260 pixeles y formato JPG</span>
                                 </td>
										</tr>
										<?
									endif;
								endif;
								/*
								if($tipo_seccion=="generica"):
									if(!empty($imagen_descripcion) and file_exists("../images/".$imagen_descripcion)):
										$size=getimagesize("../images/".$imagen_descripcion);
										$ancho=$size[0];
										$alto=$size[1];
										
										if($ancho>527):
											$alto=(int)((527/$ancho)*$alto);
											$ancho=527;
										endif;
										?>
										<!--
										<tr>
										  <td class="text_gral">Imagen descriptiva</td>
										  <td class="text_gral">
											<img src="../images/<?=$imagen_descripcion?>" width="<?=$ancho?>" height="<?=$alto?>">
										  </td>
										</tr>
										<tr>
										  <td class="text_gral"></td>
										  <td class="text_gral">
												<input type="checkbox" name="eliminar_imagen_descripcion<?=$registro?>">Eliminar imagen descriptiva
										  </td>
										</tr>
										<tr>
										  <td class="text_gral">Sustituir por:</td>
										  <td class="text_gral"><input type="file" name="imagen_descripcion<?=$registro?>"/>
												<br />
												<span>Le sugerimos una imagen de 527 px de ancho y formato JPG</span>                                      </td>	   
										</tr>
										<?
										unset($size);
										unset($ancho);
										unset($alto);
									else:
										?>
										<tr>
										  <td class="text_gral">Imagen descriptiva</td>
										  <td class="text_gral"><input type="file" name="imagen_descripcion<?=$registro?>"/>
											<br />
											<span>Le sugerimos una imagen de 527 px de ancho y formato JPG</span>                                 </td>
										</tr>
										-->										
										<?
									endif;
								endif;
								if($tipo_seccion=="clientes" or $tipo_seccion=="imagen"):								
									if(!empty($banner) and file_exists("../banners/".$banner)):
										$size=getimagesize("../banners/".$banner);
										$ancho=$size[0];
										$alto=$size[1];
										
										if($ancho>960):
											$alto=(int)((960/$ancho)*$alto);
											$ancho=960;
										endif;
										?>
										<!--
										<tr>
										  <td class="text_gral">Banner actual</td>
										  <td class="text_gral">
											<img src="../banners/<?=$banner?>" width="<?=$ancho?>" height="<?=$alto?>">
										  </td>
										</tr>
										<tr>
										  <td class="text_gral"></td>
										  <td class="text_gral">
												<input type="checkbox" name="eliminar_banner<?=$registro?>">Eliminar banner
										  </td>
										</tr>
										<tr>
										  <td class="text_gral">Sustituir por:</td>
										  <td class="text_gral"><input type="file" name="banner<?=$registro?>"/>
												<br />
											   <span>Le sugerimos una imagen de 960 x 355 pixeles y formato JPG </span>
                                </td>	   
										</tr>
										<?
										unset($size);
										unset($ancho);
										unset($alto);
									else:
										?>
										<tr>
										  <td class="text_gral">Banner</td>
										  <td class="text_gral"><input type="file" name="banner<?=$registro?>"/>
											<br />
											<span>Le sugerimos una imagen de 960 x 355 pixeles y formato JPG</span>                                      </td>
										</tr>
										-->
										<?
									endif;
								endif;
								*/
								if($tipo_seccion=="enlace"):
									?>
                           <tr>
                              <td>Enlace</td>
                              <td><input name="enlace<?=$registro?>" type="text" style="width:300px;" maxlength="255" value="<?=$enlace?>"/></td>
                           </tr>
                           <?
								endif;
								?>
                        <tr <? if($tipo_seccion<>"mapa_google"):?> style="display:none;"<? endif;?>>
                        	<td>Google maps</td>
                           <td><textarea name="mapa<?=$registro?>" style="width:300px; height:150px;"><?=$mapa_google?></textarea>
                           	<br />
                              <span class="mensajes">
<strong>Ejemplo:</strong> < iframe width="600" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.es/maps/ms?ie=UTF8&amp;hl=es&amp;msa=0&amp;msid=103520032951371305116.000485c816dfb962b5927&amp;ll=20.574336,-100.298513&amp;spn=0,0&amp;t=h&amp;output=embed">< / iframe>                              
                              </span>
                           </td>
                        </tr>
                        <tr <? if($tipo_seccion=="enlace"):?> style="display:none;"<? endif;?>>
                          <td>Descripción corta</td>
                          <td>
                          	<textarea name="descripcion_corta<?=$registro?>" style="width:625px; height:100px;"><?=$descripcion_corta?></textarea></td>
                        </tr>
                        <tr <? if($tipo_seccion=="enlace"):?> style="display:none;"<? endif;?>>
                          <td>Descripción completa</td>
                          <td>
                          	<textarea name="descripcion_completa<?=$registro?>" style="width:625px; height:200px;"><?=$descripcion_completa?></textarea></td>
                        </tr>
                        <tr <? if($tipo_seccion=="enlace"):?> style="display:none;"<? endif;?>>
                          <td>Palabras clave</td>
                          <td>
                          	<textarea name="palabras_clave<?=$registro?>" style="width:625px; height:100px;"><?=$palabras_clave?></textarea></td>
                        </tr>
                        <?
								if($tipo_seccion=="adjunto" or $tipo_seccion=="generica"):
									if(!empty($adjunto) and file_exists("../adjuntos/".$adjunto)):
										?>
                              <tr>
                                 <td>Adjunto actual</td>
                                 <td><a href="../adjuntos/<?=$adjunto?>" target="_blank">Adjunto</a></td>
                              </tr>
                              <tr>
                                 <td>Sustituir por:</td>
                                 <td><input type="file" name="adjunto<?=$registro?>"/></td>
                              </tr>
                              <?
									else:
										?>
                              <tr>
                                 <td>Adjunto</td>
                                 <td><input type="file" name="adjunto<?=$registro?>"/></td>
                              </tr>
                              <?
									endif;
								endif;
								?>
                        <tr>
                          <td class="text_gral">Orden</td>
                          <td class="text_gral"><input type="text" name="orden<?=$registro?>" style="width:50px;" value="<?=$orden?>" onKeyUp="this.value=validarEntero(this.value);"/></td>
                        </tr>
                        <tr>
                        	<td>Estatus</td>
                           <td>
                           	<select name="estatus<?=$registro?>">
                              	<option value="activo" <? if($estatus=="activo"): ?> selected="selected" <? endif;?>>Activo</option>
                              	<option value="inactivo" <? if($estatus=="inactivo"): ?> selected="selected" <? endif;?>>Inactivo</option>                                 
                              </select>
                           </td>
                        </tr>
                        <tr>
                          <td><input type="hidden" name="arreglo_registros[]" value="<?php echo $registro; ?>" /></td>
                          <td><input type="submit" class="link_5" value="Registro"/></td>
                        </tr>
                      </table>
                      </fieldset>
                      <?
							 /*
						<script type="text/javascript">
                        tinyMCE.init({
                                // General options
								relative_urls: false,
                                mode:"exact",
						     	elements : "descripcion_completa<?=$registro?>",
								theme : "advanced",
								plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,jbimages",
								// Theme options
								theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
								theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,jbimages,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
								theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
								theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
								theme_advanced_toolbar_location : "top",
								theme_advanced_toolbar_align : "left",
								theme_advanced_statusbar_location : "bottom",
								theme_advanced_resizing : true,
						
								// Skin options
								skin : "o2k7",
								skin_variant : "silver",
						
								// Example content CSS (should be your site CSS)
								content_css : "../../js/tinymce/examples/css/content.css",
						
								// Drop lists for link/image/media/template dialogs
								template_external_list_url : "../../js/tinymce/examples/lists/template_list.js",
								external_link_list_url : "../../js/tinymce/examples/lists/link_list.js",
								external_image_list_url : "../../js/tinymce/examples/lists/js/image_list.js",
								media_external_list_url : "../../js/tinymce/examples/lists/js/media_list.js",
						
								// Replace values for the template plugin
								template_replace_values : {
										username : "Some User",
										staffid : "991234"
								}
                        });
                        </script>
								*/
								
								unset($id_seccion_anterior);
								unset($id_categoria_seccion);
								unset($tipo_seccion);
								unset($menu);
								unset($seccion,$subtitulo);
								unset($enlace_activo);
								unset($enlace);
								unset($boton);
								//unset($boton_rollover);
								//unset($banner);
								unset($imagen);
								//unset($imagen_descripcion);
								unset($descripcion_corta);
								unset($descripcion_completa);
								unset($palabras_clave);
								unset($adjunto);
								unset($orden);
								unset($estatus);
								unset($calendario_google);
								unset($mapa_google);
							endfor;
							?>
                        <div><input type="hidden" name="action" value="send" /></div>
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
</body>
</html>
<?
endif;
?>