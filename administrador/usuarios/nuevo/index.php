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
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>USUARIOS - NUEVO</title>
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
function goToPage(page){
   	top.location.href= page;
}
	
function validar(form){
	var contenedor=document.getElementById("td_respuesta");
	
	var altas=document.getElementsByName("altas[]");
	var bajas=document.getElementsByName("bajas[]");
	var actualizaciones=document.getElementsByName("actualizaciones[]");	
	var reportes=document.getElementsByName("reportes[]");

	var altas_seleccionados=false;
	for (var i= 0; i<altas.length; i++){
		if(altas[i].checked){
			altas_seleccionados=true;
	  	}
	}
	var bajas_seleccionados=false;
	for (var i= 0; i<bajas.length; i++){
		if(bajas[i].checked){
			bajas_seleccionados=true;
	  	}
	}
	var actualizaciones_seleccionados=false;
	for (var i= 0; i<actualizaciones.length; i++){
		if(actualizaciones[i].checked){
			actualizaciones_seleccionados=true;
	  	}
	}
	var reportes_seleccionados=false;
	for (var i= 0; i<reportes.length; i++){
		if(reportes[i].checked){
			reportes_seleccionados=true;
	  	}
	}
	
   if (form.nombre_completo.value == "") { 
      contenedor.innerHTML="Capture el nombre del usuario.";
      form.nombre_completo.focus();
      return false;
   }
   if (form.usuario.value == "") { 
      contenedor.innerHTML="Capture el usuario";
      form.usuario.focus();
      return false;
   }
   if (form.password.value == "") { 
      contenedor.innerHTML="Capture el password del usuario";
      form.password.focus();
      return false;
   }
   if (form.email.value!= "") { 
		if(valida_correo(form.email.value)==false){
			contenedor.innerHTML="El correo electrónico capturado no es correcto";
			form.email.focus();
			return false;
		}
	}
	if(!altas_seleccionados && !bajas_seleccionados && !actualizaciones_seleccionados && !reportes_seleccionados){
		contenedor.innerHTML="Seleccione al menos una seccion para este usuario";
		return false;
	}
	form.submit();
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
		<form action="./" method="post" enctype="multipart/form-data" name="form1" id="form1">
   	<p>Los campos con <strong>*</strong> son requeridos.</p>            
      <fieldset>
      <legend>Datos de usuario</legend>
      <table border="0" cellpadding="3" cellspacing="1" align="left">
      <?
		$p_action=isset($_POST['action'])?$_POST['action']:"";
		if($p_action=="send"):
			date_default_timezone_set('Mexico/General');
			$fechahora_actual=date("YmdHis");
			$p_tipo_usuario=cadenabd($_POST['tipo_usuario']);
			$p_nombre_completo=cadenabd($_POST['nombre_completo']);
			$p_cargo=cadenabd($_POST['cargo']);
			$p_email=cadenabd($_POST['email']);
			$p_telefono=cadenabd($_POST['telefono']);
			$p_telefono2=cadenabd($_POST['telefono2']);
			$p_mostrar_pagina=$_POST['mostrar_pagina'];
			$p_recibir_copia=$_POST['recibir_copia'];			
			$p_usuario=cadenabd($_POST['usuario']);
			$p_password=cadenabd($_POST['password']);
			$varname3=cadenabd($_FILES['imagen']['name']);
			$p_estatus=$_POST['estatus'];
			$p_altas=$_POST['altas'];
			$p_bajas=$_POST['bajas'];
			$p_actualizaciones=$_POST['actualizaciones'];
			$p_reportes=$_POST['reportes'];
			$p_notas=cadenabd($_POST['notas']);
			
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
			
			$r_c=buscar("COUNT(*) AS total ","adm_usuarios","WHERE usuario='".$p_usuario."' AND password='".$p_password."'");
			while($f_c=$r_c->fetch_assoc()):
				$total=$f_c['total'];
			endwhile;
			if($total>0):
				?>
				<script type="text/javascript" language="javascript">
					alert("Ya existe un usuario registrado con estos datos");
					location.href="./";
				</script>
				<?php
			else:
				$c_p=buscar("id_usuario","adm_usuarios","ORDER BY id_usuario DESC LIMIT 1");
				while($f_p=$c_p->fetch_assoc()):
					$id_usuario=$f_p['id_usuario'];
				endwhile;
				$id_usuario=$id_usuario+1;
				
				if(!empty($varname3)):
					$vartemp3=$_FILES['imagen']['tmp_name'];
					$extension3=obtener_extension($varname3);
					$p_imagen="i".$id_usuario."_".$fechahora_actual.$extension3;
					$nombre_archivo3="../images/".$p_imagen;
					move_uploaded_file($vartemp3,$nombre_archivo3);
				endif;
			
				$i_c=insertar("tipo_usuario
									,nombre_completo
									,cargo
									,email
									,telefono
									,telefono2
									,mostrar_pagina
									,recibir_copia
									,usuario
									,password
									,estatus
									,altas_secciones
									,bajas_secciones
									,actualizaciones_secciones
									,reportes_secciones
									,notas
									,imagen"
									,"adm_usuarios"
									,"'".$p_tipo_usuario."'
									,'".$p_nombre_completo."'
									,'".$p_cargo."'
									,'".$p_email."'
									,'".$p_telefono."'
									,'".$p_telefono2."'
									,'".$p_mostrar_pagina."'
									,'".$p_recibir_copia."'
									,'".$p_usuario."'
									,'".$p_password."'
									,'".$p_estatus."'
									,'".$altas."'
									,'".$bajas."'
									,'".$actualizaciones."'
									,'".$reportes."'
									,'".$p_notas."'
									,'".$p_imagen."'");
				if($i_c):
					?>
   	         <script type="text/javascript" language="JavaScript">
						alert("Usuario registrado exitosamente");
						location.href="../";
				    </script>
                <?
				else:
					?>
      	      <script type="text/javascript" language="JavaScript">
						alert("No fue posible registrar el usuario. Intente de nuevo");
						location.href="./";
				    </script>
					<?
				endif;
			endif;
		endif;
		?>
                        <tr>
                        	<td></td>
                          <td class="alerta" id="td_respuesta"></td>
                        </tr>
                        <tr>
                        	<td>Tipo de usuario</td>
                           <td>
                           	<select name="tipo_usuario">
                              	<option value="Administrador">Administrador</option>
                              	<option value="Super_Administrador">Super Administrador</option>
                              </select>
                           </td>
                        </tr>
                        <tr>
                           <td width="15%">Nombre completo</td>
                           <td width="85%"><input type="text" name="nombre_completo" style="width:300px;" maxlength="255" required="required">
                              * </td>
                        </tr>
                        <!--
                        <tr>
                        	<td>Cargo</td>
                           <td><input type="text" name="cargo" style="width:300px;" maxlength="255"/></td>
                        </tr>
                        -->
                        <tr>
                        	<td>Email</td>
                           <td><input type="text" name="email" style="width:300px;" maxlength="255"/></td>
                        </tr>
                        <tr>
                        	<td>Teléfono</td>
                           <td><input type="text" name="telefono" style="width:200px;" maxlength="255"/></td>
                        </tr>
                        <? /*
                        <tr>
                        	<td>Teléfono 2</td>
                           <td><input type="text" name="telefono2" style="width:200px;" maxlength="255"/></td>
                        </tr>
                        <tr>
                        	<td></td>
                           <td><input type="checkbox" name="mostrar_pagina"/>Mostrar en los datos de contacto de la página
                           </td>
                        </tr>
                        <tr>
                        	<td></td>
                           <td><input type="checkbox" name="recibir_copia"/>Recibir copia de contactos de la página
                           </td>
                        </tr>
						*/
						?> 
                        <tr>
                           <td>Usuario</td>
                           <td><input type="text" name="usuario" style="width:100px;" maxlength="100" required="required">
                              * </td>
                        </tr>
                        <tr>
                           <td>Contraseña</td>
                           <td><input type="password" name="password" style="width:100px;" maxlength="100" required="required">
                              * </td>
                        </tr>
								<tr>
								   <td class="text_gral">Imagen</td>
								   <td class="text_gral">
								      <input type="file" name="imagen"/>
                              <br />
								      <span>Le sugerimos una imagen de 316 px de ancho y formato JPG</span></td>
								</tr>
                        <tr>
                           <td>Estatus</td>
                           <td><select name="estatus">
                              <option value="activo">Activo</option>
                              <option value="inactivo">Inactivo</option>
                           </select>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="2">Asigne los permisos para este usuario</td>
                        </tr>
                        <tr>
                           <td colspan="2">
                              <table cellpadding="3" cellspacing="1">
                                 <tr>
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
											
											$modulo_anterior="";						
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
                                    <td style="text-align:center;">
                                       <?
                                       if($altas=="si"):
                                          ?>
                                          <input type="checkbox" name="altas[]" value="<?php echo $id_seccion;?>">
                                          <?
                                       endif;
                                       ?>
                                    </td>
                                    <td style="text-align:center;"><? if($bajas=="si"):?><input type="checkbox" name="bajas[]" value="<?php echo $id_seccion;?>"><? endif; ?></td>
                                    <td style="text-align:center;"><? if($actualizaciones=="si"):?><input type="checkbox" name="actualizaciones[]" value="<?php echo $id_seccion;?>"><? endif; ?></td>
                                    <td style="text-align:center;"><? if($reportes=="si"):?><input type="checkbox" name="reportes[]" value="<?php echo $id_seccion;?>"><? endif; ?></td>
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
                                 ?>
                              </table>
                              <br />
									</td>
                        </tr>
                        <tr>
                        	<td>Notas</td>
                           <td><textarea name="notas"></textarea></td>
                        </tr>
                        <tr>
                           <td><input type="hidden" name="action" value="send"></td>
                           <td><input type="button" onClick="validar(document.form1);" value="Registro de Usuario"></td>
                        </tr>
                      </table>
                      </fieldset>
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