<?
session_start();
ini_set("display_errors","On");
$se_id_usuario=$_SESSION["s_id_usuario"];
include("../../php/config.php");
include("../../php/func.php");
include("../../php/func_bd.php");

if(empty($se_id_usuario)):
	?>
	<script type="text/javascript" language="javascript">
   location.href="../../login/";
   </script>
   <?
else:
	$p_action=$_POST['action'];
	if($p_action=="send"):
		date_default_timezone_set('Mexico/General');
		$fechahora_actual=date("YmdHis");
	
		$p_nombre_completo=cadenabd($_POST["nombre_completo"]);
		$p_usuario=cadenabd($_POST["usuario"]);
		$p_password=cadenabd($_POST["password"]);
		$varname3=cadenabd($_FILES["imagen"]['name']);
		$p_eliminar_imagen=$_POST["eliminar_imagen"];
		$p_notas=cadenabd($_POST["notas"]);
		
		$c_c="SELECT 	COUNT(*) AS total 
					FROM 	adm_usuarios 
					WHERE usuario='".$p_usuario."' 
					AND 	password='".$p_password."'
					and	id_usuario<>".$se_id_usuario;
		
		$r_c=mysql_query($c_c,$conexion);
		while($f_c=mysql_fetch_assoc($r_c)):
			$total=$f_c['total'];
		endwhile;
		if($total>0):
			$arreglo_respuestas[count($arreglo_respuestas)]="Ya existe un administrativo con este usuario ".cadena($p_usuario);			
		else:
			$c_se=buscar("imagen","adm_usuarios","where id_usuario=".$se_id_usuario);
			while($f_se=mysql_fetch_assoc($c_se)):
				$imagen_actual=$f_se['imagen'];
			endwhile;
			
			if(!empty($varname3)):
				if(!empty($imagen_actual) and file_exists("../images/".$imagen_actual)):
					unlink("../images/".$imagen_actual);
				endif;
				$vartemp3=$_FILES["imagen"]['tmp_name'];
				$extension3=obtener_extension($varname3);
				$p_imagen="i".$se_id_usuario."_".$fechahora_actual.$extension3;
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
			
			$u_c="UPDATE 			adm_usuarios
								SET 	nombre_completo='".$p_nombre_completo."'
										,usuario='".$p_usuario."'
										,password='".$p_password."'";
			if(!empty($p_imagen) or $p_eliminar_imagen=="on"):
				$u_c.=",imagen='".$p_imagen."'";
			endif;
			$u_c.="					,notas='".$p_notas."'
								WHERE id_usuario=".$se_id_usuario."
								AND	(tipo_usuario<>'Cliente')";
			$r_u=mysql_query($u_c,$conexion);
			if(!$r_u):
				$arreglo_respuestas[count($arreglo_respuestas)]="No fue posible actualizar sus datos ".cadena($p_usuario);
			else:
				$respuesta="exito";
			endif;
		endif;
		unset($p_nombre_completo);	
		unset($p_usuario);
		unset($p_password);
		unset($varname3);
		unset($imagen_actual);
		unset($p_imagen);
		unset($p_eliminar_imagen);
		unset($p_notas);
		
		if($respuesta=="exito"):
			?>
			<script type="text/javascript" language="javascript">
				alert("Datos actualizados exitosamente");
				location.href="../../";
			</script>
			<?php
		endif;
	endif;
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>MIS DATOS</title>
     <!-- Favicon -->
  <link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">
	<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
	<link href="../../css/form.css" rel="stylesheet" type="text/css" />
	<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js">
   </script>
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
   
   
   <script type="text/javascript" language="javascript">
   function goToPage(page){
         top.location.href= page;
   }
   
   function validar(form){
      var contenedor=document.getElementById("td_respuesta");
      if(form.nombre_completo.value==""){
         contenedor.innerHTML="Capture su nombre completo.";
         form.nombre_completo.focus();
         return false;
      }
      if (form.usuario.value== "") { 
         contenedor.innerHTML="Capture su usuario";
         form.usuario.focus();
         return false;
      }
      if (form.password.value== "") { 
         contenedor.innerHTML="Capture su password";
         form.password.focus();
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
      	
			<? 
         $c_c="SELECT	nombre_completo
                        ,usuario
                        ,password
								,imagen
								,notas
                  FROM 	adm_usuarios 
                  WHERE id_usuario=".$se_id_usuario."
                  AND	(tipo_usuario<>'Cliente')";
   
         $r_c=mysql_query($c_c,$conexion);
         while($f_c=mysql_fetch_assoc($r_c)):
            $nombre_completo=cadena($f_c['nombre_completo']);
            $usuario=cadena($f_c['usuario']);
            $password=cadena($f_c['password']);
				$imagen=$f_c["imagen"];
            $notas=cadena($f_c['notas']);
         endwhile;
         ?>
			<!--
			<div id="principal">
			</div>
			<div id="secundario">
			</div>
			-->
               <?
				if(count($arreglo_respuestas)>0):
					?>
					<table cellpadding="3" cellspacing="1" width="100%">
                   <?
						foreach($arreglo_respuestas as $respuesta):
							?>
									 <tr>
										<td class="text_9"><?=$respuesta;?></td>
									 </tr>
									 <?
						endforeach;
						?>
                 </table>
               <?
			endif;
		   ?>
           <form action="./" method="post" enctype="multipart/form-data" name="form1" id="form1">
        		  <fieldset>
               <legend>Datos de usuario</legend>
             <table border="0" cellpadding="3" cellspacing="1" align="left" class="text_gral">
               <tr>
               	<td></td>
                 <td class="alerta" id="td_respuesta"></td>
               </tr>
               <tr>
                  <td width="15%">Nombre completo</td>
                  <td width="85%"><input type="text" name="nombre_completo" style="width:300px;" maxlength="255" value="<?=$nombre_completo?>">
                     * </td>
               </tr>
               <tr>
                  <td>Usuario</td>
                  <td><input type="text" name="usuario" style="width:100px;" maxlength="100" value="<?=$usuario?>">
                     * </td>
               </tr>
               <tr>
                  <td>Contraseña</td>
                  <td><input type="password" name="password" style="width:100px;" maxlength="100" value="<?=$password?>">
                     * </td>
               </tr>
               <tr>
                  <td>Notas</td>
                  <td><textarea name="notas"><?=$notas?></textarea></td>
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
                           <input type="checkbox" name="eliminar_imagen">Eliminar imagen
                       </td>
                     </tr>
                     <tr>
                       <td class="text_gral">Sustituir por:</td>
                       <td class="text_gral"><input type="file" name="imagen"/>
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
                       <td class="text_gral"><input type="file" name="imagen"/>
                        <br />
                        <span>Le sugerimos una imagen de  316 pixeles de ancho y formato JPG</span>                                      </td>
                     </tr>
                     <?
                  endif;
                  ?>
               <tr>
                 <td><span class="text_gral">
                    <input type="hidden" name="action" value="send" />
                   
                 </span></td>
                 <td><span class="text_gral">
                   <input type="button" class="link_5" onClick="validar(document.form1);" value="Actualizar datos"/>
                 </span></td>
               </tr>
               <?
               unset($nombre_completo);
               unset($usuario);
               unset($password);
					unset($imagen);
					unset($notas);
               ?>
             </table>
             </fieldset>
      	</form>		
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