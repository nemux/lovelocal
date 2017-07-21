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
$p_action=isset($_POST['action'])?$_POST['action']:"";
$arreglo_respuestas=array();
if($p_action=="send"):
	$p_arreglo_registros=$_POST['arreglo_registros'];
	if(count($p_arreglo_registros)>0):
		date_default_timezone_set('Mexico/General');
		$fechahora_actual=date("YmdHis");
	
		for($i=0;$i<count($p_arreglo_registros);$i++):
			$registro=$p_arreglo_registros[$i];
			$tipo_usuario="tipo_usuario".$registro;
			$nombre_completo="nombre_completo".$registro;
			$cargo='cargo'.$registro;
			$email='email'.$registro;
			$telefono='telefono'.$registro;
			$mostrar_pagina='mostrar_pagina'.$registro;
			$recibir_copia='recibir_copia'.$registro;
			
			$usuario="usuario".$registro;
			$password="password".$registro;
			$imagen='imagen'.$registro;
			$eliminar_imagen='eliminar_imagen'.$registro;					
			$estatus="estatus".$registro;
			$altas="altas".$registro;
			$bajas="bajas".$registro;
			$actualizaciones="actualizaciones".$registro;
			$reportes="reportes".$registro;
			$notas="notas".$registro;
			
			$p_tipo_usuario=cadenabd($_POST[$tipo_usuario]);
			$p_nombre_completo=cadenabd($_POST[$nombre_completo]);
			$p_cargo=isset($_POST[$cargo])?cadenabd($_POST[$cargo]):"";
			$p_email=cadenabd($_POST[$email]);
			$p_telefono=cadenabd($_POST[$telefono]);
			$p_telefono2=isset($_POST["telefono2".$registro])?cadenabd($_POST["telefono2".$registro]):"";
			$p_mostrar_pagina=$_POST[$mostrar_pagina];
			$p_recibir_copia=$_POST[$recibir_copia];
			$p_usuario=cadenabd($_POST[$usuario]);
			$p_password=cadenabd($_POST[$password]);
			$varname3=cadenabd($_FILES[$imagen]['name']);
			$p_eliminar_imagen=$_POST[$eliminar_imagen];			
			$p_estatus=$_POST[$estatus];
			$p_altas=$_POST[$altas];
			$p_bajas=$_POST[$bajas];
			$p_actualizaciones=$_POST[$actualizaciones];
			$p_reportes=$_POST[$reportes];
			$p_notas=cadenabd($_POST[$notas]);
			
			if($p_mostrar_pagina=="on"):
				$p_mostrar_pagina="si";
			else:
				$p_mostrar_pagina="no";
			endif;
			
			if($p_recibir_copia=="on"):
				$p_recibir_copia="si";
			else:
				$p_recibir_copia="no";
			endif;
			
			$altas="";
			if(count($p_altas)>0):
				for($cont=0;$cont<count($p_altas);$cont++):
					$altas.=",".$p_altas[$cont];
				endfor;
			endif;
			$altas=substr($altas,1);
		
			$bajas="";
			if(count($p_bajas)>0):
				for($cont=0;$cont<count($p_bajas);$cont++):
					$bajas.=",".$p_bajas[$cont];
				endfor;
			endif;
			$bajas=substr($bajas,1);
		
			$actualizaciones="";
			if(count($p_actualizaciones)>0):
				for($cont=0;$cont<count($p_actualizaciones);$cont++):
					$actualizaciones.=",".$p_actualizaciones[$cont];
				endfor;
			endif;
			$actualizaciones=substr($actualizaciones,1);
		
			$reportes="";
			if(count($p_reportes)>0):
				for($cont=0;$cont<count($p_reportes);$cont++):
					$reportes.=",".$p_reportes[$cont];
				endfor;
			endif;
			$reportes=substr($reportes,1);
			
			$r_c=buscar("COUNT(*) AS total","adm_usuarios","WHERE usuario='".$p_usuario."' 
						AND 	password='".$p_password."'
						and	id_usuario<>".$registro."");
			while($f_c=$r_c->fetch_assoc()):
				$total=$f_c['total'];
			endwhile;
			if($total>0):
				$arreglo_respuestas[count($arreglo_respuestas)]="Ya existe un administrativo con este usuario ".cadena($p_usuario);			
			else:
				$c_se=buscar("imagen","adm_usuarios","where id_usuario=".$registro);
				while($f_se=$c_se->fetch_assoc()):
					$imagen_actual=$f_se['imagen'];
				endwhile;
				
				if(!empty($varname3)):
					if(!empty($imagen_actual) and file_exists("../images/".$imagen_actual)):
						unlink("../images/".$imagen_actual);
					endif;
					$vartemp3=$_FILES[$imagen]['tmp_name'];
					$extension3=obtener_extension($varname3);
					$p_imagen="i".$registro."_".$fechahora_actual.$extension3;
					$nombre_archivo3="../images/".$p_imagen;
					move_uploaded_file($vartemp3,$nombre_archivo3);
					unset($vartemp3);
					unset($extension3);
					unset($nombre_archivo3);
				elseif($p_eliminar_imagen=="on"):
					if(!empty($imagen_actual) and file_exists("../images/".$imagen_actual)):
						unlink("../images/".$imagen_actual);
					endif;
					$p_imagen="";
				endif;
				
				$actualizar="tipo_usuario='".$p_tipo_usuario."'
								,nombre_completo='".$p_nombre_completo."'
								,cargo='".$p_cargo."'
								,email='".$p_email."'
								,telefono='".$p_telefono."'
								,telefono2='".$p_telefono2."'
								,mostrar_pagina='".$p_mostrar_pagina."'
								,recibir_copia='".$p_recibir_copia."'
								,usuario='".$p_usuario."'
								,password='".$p_password."'";
				if(!empty($p_imagen) or $p_eliminar_imagen=="on"):
					$actualizar.=",imagen='".$p_imagen."'";
				endif;
				$actualizar.=",estatus='".$p_estatus."'
								,altas_secciones='".$altas."'
								,bajas_secciones='".$bajas."'
								,actualizaciones_secciones='".$actualizaciones."'
								,reportes_secciones='".$reportes."'
								,notas='".$p_notas."'";
				$c_id=actualizar("".$actualizar."","adm_usuarios","where id_usuario=".$registro." and (tipo_usuario<>'Cliente')");
				
				if(!$c_id):
					$arreglo_respuestas[count($arreglo_respuestas)]="No fue posible actualizar este usuario ".cadena($p_usuario);
				else:
					$arreglo_respuestas[count($arreglo_respuestas)]="Usuario ".cadena($p_usuario)." actualizado exitosamente.";
				endif;
			endif;
			unset($total);
			
			unset($p_tipo_usuario);
			unset($p_nombre_completo);
			unset($p_cargo);
			unset($p_email);
			unset($p_telefono,$p_telefono2);
			unset($p_mostrar_pagina);
			unset($p_recibir_copia);
			unset($p_usuario);
			unset($p_password);
			unset($varname3);
			unset($imagen_actual);
			unset($p_imagen);
			unset($p_eliminar_imagen);
			unset($p_estatus);
			unset($p_altas);
			unset($altas);
			unset($p_bajas);
			unset($bajas);
			unset($p_actualizaciones);
			unset($actualizaciones);
			unset($p_reportes);
			unset($reportes);
			unset($p_notas);
			
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
<title>USUARIOS Actualizar</title>
 <!-- Favicon -->
  <link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">
<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
<link href="../../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<? 
include("../../includes/ajuste.php");
?>

<script type="text/javascript" src="../../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
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
		  //content_css : "../../css/etiquetas.css",

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

<script type="text/javascript" language="javascript" src="../../js/funciones.js"></script>
<script type="text/javascript" language="javascript" src="../ajax.js"></script>
<script type="text/javascript" language="javascript">
function validar(form){
	var arreglo_registros=document.getElementsByName("arreglo_registros[]");
	if(arreglo_registros.length>0){
		var identificador="";
		var contenedor="";
		for(var i=0;i<arreglo_registros.length;i++){
			identificador=new Number(arreglo_registros[i].value)*1;
			contenedor=document.getElementById("td_respuesta"+identificador);
			
			var altas1="altas"+identificador+"[]";
			var bajas1="bajas"+identificador+"[]";
			var actualizaciones1="actualizaciones"+identificador+"[]";
			var reportes1="reportes"+identificador+"[]";
			var altas=document.getElementsByName(altas1);
			var bajas=document.getElementsByName(bajas1);
			var actualizaciones=document.getElementsByName(actualizaciones1);	
			var reportes=document.getElementsByName(reportes1);
		
			var altas_seleccionados=false;
			for (var x= 0; x<altas.length; x++){
				if(altas[x].checked){
					altas_seleccionados=true;
				}
			}
			var bajas_seleccionados=false;
			for (var x= 0; x<bajas.length; x++){
				if(bajas[x].checked){
					bajas_seleccionados=true;
				}
			}
			var actualizaciones_seleccionados=false;
			for (var x= 0; x<actualizaciones.length; x++){
				if(actualizaciones[x].checked){
					actualizaciones_seleccionados=true;
				}
			}
			var reportes_seleccionados=false;
			for (var x= 0; x<reportes.length; x++){
				if(reportes[x].checked){
					reportes_seleccionados=true;
				}
			}
			if (eval("form.nombre_completo"+identificador+".value") == "") { 
				contenedor.innerHTML="Capture el nombre completo del administrativo."
				eval("form.nombre_completo"+identificador+".focus()");
				return false;
			}
			if (eval("form.usuario"+identificador+".value")== "") { 
				contenedor.innerHTML="Capture el usuario del administrativo"
				eval("form.usuario"+identificador+".focus()");
				return false;
			}
			if (eval("form.password"+identificador+".value")== "") { 
				contenedor.innerHTML="Capture el password del administrativo"
				eval("form.password"+identificador+".focus()");
				return false;
			}
			if (eval("form.email"+identificador+".value")!= "") { 
				if(valida_correo(eval("form.email"+identificador+".value"))==false){
					contenedor.innerHTML="El correo electrónico capturado no es correcto";
					eval("form.email"+identificador+".focus()");
					return false;
				}
			}
			if(!altas_seleccionados && !bajas_seleccionados && !actualizaciones_seleccionados && !reportes_seleccionados){
				contenedor.innerHTML="Seleccione al menos una seccion para este usuario";
				return false;
			}
		}
		form.submit();
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
				$c_id=buscar("tipo_usuario
									,nombre_completo
									,cargo
									,email
									,telefono
									,telefono2
									,mostrar_pagina
									,recibir_copia
									,usuario
									,password
									,imagen
									,estatus
									,altas_secciones
									,bajas_secciones
									,actualizaciones_secciones
									,reportes_secciones
									,notas"
								,"adm_usuarios"
								,"where id_usuario=".$registro."
									and (tipo_usuario<>'Cliente')");
				while($f_c=$c_id->fetch_assoc()):
					$tipo_usuario=cadena($f_c['tipo_usuario']);
					$nombre_completo=cadena($f_c['nombre_completo']);
					$cargo=cadena($f_c['cargo']);
					$email=cadena($f_c['email']);
					$telefono=cadena($f_c['telefono']);
					$telefono2=cadena($f_c['telefono2']);
					$mostrar_pagina=$f_c['mostrar_pagina'];
					$recibir_copia=$f_c['recibir_copia'];					
					$usuario=cadena($f_c['usuario']);
					$password=cadena($f_c['password']);
					$imagen=$f_c["imagen"];
					$estatus=$f_c['estatus'];
					$altas_secciones=explode(",",$f_c['altas_secciones']);
					$bajas_secciones=explode(",",$f_c['bajas_secciones']);
					$actualizaciones_secciones=explode(",",$f_c['actualizaciones_secciones']);
					$reportes_secciones=explode(",",$f_c['reportes_secciones']);
					$notas=cadena($f_c['notas']);
				endwhile;
				?>
      	<fieldset>
         <legend>Actualizar usuario</legend>
                      <table border="0" cellpadding="3" cellspacing="1" align="left">
                        <tr>
                        	<td></td>
                          <td  class="alerta" id="td_respuesta<?=$registro?>"></td>
                        </tr>
                        <tr>
                        	<td>Tipo de usuario</td>
                           <td>
                           	<select name="tipo_usuario<?=$registro?>">
                              	<option value="Administrador" <? if($tipo_usuario=="Administrador"): ?> selected="selected" <? endif;?>>Administrador</option>
                              	<option value="Super_Administrador" <? if($tipo_usuario=="Super_Administrador"): ?> selected="selected" <? endif;?>>Super Administrador</option>
                              </select>
                           </td>
                        </tr>
                        <tr>
                           <td width="15%">Nombre completo</td>
                           <td width="85%"><input type="text" name="nombre_completo<?=$registro?>" style="width:300px;" maxlength="255" value="<?=$nombre_completo?>">
                              * </td>
                        </tr>
                        <?
						/*
                        <tr>
                        	<td>Cargo</td>
                           <td><input type="text" name="cargo<?=$registro?>" style="width:300px;" maxlength="255" value="<?=$cargo?>"/></td>
                        </tr>
                        */
						?>
                        <tr>
                        	<td>Email</td>
                           <td><input type="text" name="email<?=$registro?>" style="width:300px;" maxlength="255" value="<?=$email?>"/></td>
                        </tr>
                        <tr>
                        	<td>Teléfono</td>
                           <td><input type="text" name="telefono<?=$registro?>" style="width:200px;" maxlength="255" value="<?=$telefono?>"/></td>
                        </tr>
                        <?
						/*
                        <tr>
                        	<td>Teléfono 2</td>
                           <td><input type="text" name="telefono2<?=$registro?>" style="width:200px;" maxlength="255" value="<?=$telefono2?>"/></td>
                        </tr>
                        <tr>
                        	<td></td>
                           <td><input type="checkbox" name="mostrar_pagina<?=$registro?>" <? if($mostrar_pagina=="si"): ?> checked="checked" <? endif;?>/>Mostrar en los datos de contacto de la página
                           </td>
                        </tr>
                        <tr>
                        	<td></td>
                           <td><input type="checkbox" name="recibir_copia<?=$registro?>" <? if($recibir_copia=="si"): ?> checked="checked" <? endif;?>/>Recibir copia de contactos de la página
                           </td>
                        </tr>
						*/
						?>
                        <tr>
                           <td>Usuario</td>
                           <td><input type="text" name="usuario<?=$registro?>" style="width:100px;" maxlength="100" value="<?=$usuario?>">
                              * </td>
                        </tr>
                        <tr>
                           <td>Contraseña</td>
                           <td><input type="password" name="password<?=$registro?>" style="width:100px;" maxlength="100" value="<?=$password?>">
                              * </td>
                        </tr>
                        <?
									if(!empty($imagen) and file_exists("../images/".$imagen)):
										$size=getimagesize("../images/".$imagen);
										$ancho=$size[0];
										$alto=$size[1];
										
										if($ancho>316):
											$alto=(int)((316/$ancho)*$alto);
											$ancho=316;
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
												<span>Le sugerimos una imagen de 316 pixeles de ancho y formato JPG</span>                                      </td>	   
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
											<span>Le sugerimos una imagen de  316 pixeles de ancho y formato JPG</span>                                      </td>
										</tr>
										<?
									endif;
									?>
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
                            <td colspan="2">Asigne los permisos para este usuario</td>
                         </tr>
                         <tr>
                            <td colspan="2">
                              <table cellpadding="3" cellspacing="1">
                              <tr style="text-align:center;">
                              	<th>SECCIÓN</th>
                                 <th>ALTAS</th>
                                 <th>BAJAS</th>
                                 <th>ACTUALIZACIONES</th>
                                 <th>REPORTES</th>
                              </tr>
                              <?php
                              $c_se=buscar("se.id_seccion
														,mo.modulo
														,se.seccion 
														,se.altas
														,se.bajas
														,se.actualizaciones
														,se.reportes"
														,"adm_secciones se
												left outer join
														adm_modulos mo
												on		mo.id_modulo=se.id_modulo"
												,"ORDER BY mo.orden asc,se.orden asc");
                              while($f_se=$c_se->fetch_assoc()):
                                 $id_seccion=$f_se['id_seccion'];
											$modulo=cadena($f_se['modulo']);
                                 $seccion=cadena($f_se['seccion']);
                                 $altas=$f_se['altas'];
                                 $bajas=$f_se['bajas'];
                                 $actualizaciones=$f_se['actualizaciones'];
                                 $reportes=$f_se['reportes'];
											
											if($modulo_anterior!=$modulo):
												$modulo_anterior=$modulo;
											else:
												$modulo="";
											endif;
											if(!empty($modulo)):
												?>
                                    <tr>
                                    	<td colspan="5" class="modulo"><?=$modulo?></td>
                                    </tr>
                                    <?
											endif;
                                 ?>
                                 <tr>
                                    <td><?php echo $seccion;?></td>
                                    <td style="text-align:center;"><? if($altas=="si"):?><input type="checkbox" name="altas<?=$registro;?>[]" value="<?php echo $id_seccion;?>" <?php if(in_array($id_seccion,$altas_secciones)==true): ?> checked <?php endif;?>><? endif; ?></td>
                                    <td style="text-align:center;"><? if($bajas=="si"):?><input type="checkbox" name="bajas<?=$registro;?>[]" value="<?php echo $id_seccion;?>" <?php if(in_array($id_seccion,$bajas_secciones)==true): ?> checked <?php endif;?>><? endif; ?></td>
                                    <td style="text-align:center;"><? if($actualizaciones=="si"):?><input type="checkbox" name="actualizaciones<?=$registro;?>[]" value="<?php echo $id_seccion;?>" <?php if(in_array($id_seccion,$actualizaciones_secciones)==true): ?> checked <?php endif;?>><? endif; ?></td>
                                    <td style="text-align:center;"><? if($reportes=="si"):?><input type="checkbox" name="reportes<?=$registro;?>[]" value="<?php echo $id_seccion;?>" <?php if(in_array($id_seccion,$reportes_secciones)==true): ?> checked <?php endif;?>><? endif; ?></td>
                                 </tr>
                                 <?php
                                 unset($id_seccion);
											unset($modulo);
                                 unset($seccion);
                                 unset($altas);
                                 unset($bajas);
                                 unset($actualizaciones);
                                 unset($reportes);
                              endwhile;
										unset($modulo_anterior);
                              ?>
                              </table>
                              <br />
									</td>
                         </tr>
                        <tr>
                        	<td>Notas</td>
                           <td><textarea name="notas<?=$registro?>"><?=$notas?></textarea></td>
                        </tr>
                        <tr>
                          <td>
                            <input type="hidden" name="arreglo_registros[]" value="<?php echo $registro; ?>" />
                          </td>
                          <td>
                            <input type="button" class="link_5" onClick="validar(document.form1);" value="Guardar cambios"/>
                          </td>
                        </tr>
                      </table>
                      </fieldset>
                        <?
								unset($tipo_usuario);
								unset($nombre_completo);
								unset($cargo);
								unset($email);
								unset($telefono,$telefono2);
								unset($mostrar_pagina);
								unset($recibir_copia);
								unset($usuario);
								unset($password);
								unset($imagen);
								unset($estatus);
								unset($altas_secciones);
								unset($bajas_secciones);
								unset($actualizaciones_secciones);
								unset($reportes_secciones);
								unset($notas);
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