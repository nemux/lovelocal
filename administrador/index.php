<?
error_reporting(0);
session_start();
ini_set("display_errors","On");
$se_id_usuario=isset($_SESSION["s_id_usuario"])?$_SESSION["s_id_usuario"]:"";
$se_tipo_usuario=isset($_SESSION["s_tipo_usuario"])?$_SESSION["s_tipo_usuario"]:"";
$se_altas=isset($_SESSION['s_altas'])?$_SESSION['s_altas']:"";
$se_bajas=isset($_SESSION['s_bajas'])?$_SESSION['s_bajas']:"";
$se_actualizaciones=isset($_SESSION['s_actualizaciones'])?$_SESSION['s_actualizaciones']:"";
$se_reportes=isset($_SESSION['s_reportes'])?$_SESSION['s_reportes']:"";
include("php/config.php");
include("php/func.php");
include("php/func_bd.php");
if(empty($se_id_usuario) and empty($se_tipo_usuario)):
	?>
	<script type="text/javascript" language="javascript">
   location.href="login/";
   </script>
   <?
else:
	//Nombre de usuario
	$c_us=buscar("notas,notas_sistema","adm_usuarios","where id_usuario=".$se_id_usuario);
	while($f_us=$c_us->fetch_assoc()):
		$notas=cadena($f_us['notas']);
		$notas_sistema=cadena($f_us['notas_sistema']);
	endwhile;
	?>
   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
   <html xmlns="http://www.w3.org/1999/xhtml"><strong></strong>
   <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>ADMINISTRADOR</title>
    <!-- Favicon -->
  <link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">
   <link href="css/etiquetas.css" rel="stylesheet" type="text/css" />
   <link href="css/form.css" rel="stylesheet" type="text/css" />
   <link href="css/administrador.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="js/jquery.min.js"></script>
   <script type="text/javascript" language="javascript" src="ajax.js"></script>
   <? 
	include("includes/ajuste.php");
	//include("includes/tiny_mce2.php");
	?>
	<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
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
           content_css : "js/tinymce/examples/css/content.css",
           //content_css : "../../css/etiquetas.css",
   
           // Drop lists for link/image/media/template dialogs
           template_external_list_url : "js/tinymce/examples/lists/template_list.js",
           external_link_list_url : "js/tinymce/examples/lists/link_list.js",
           external_image_list_url : "js/tinymce/examples/lists/js/image_list.js",
           media_external_list_url : "js/tinymce/examples/lists/js/media_list.js",
   
           // Replace values for the template plugin
           template_replace_values : {
                   username : "Some User",
                   staffid : "991234"
           }
   });
   </script>
   
   </head>
   <body>
   <div id="contenedor">
      <div id="cabecera">
         <?
         include("includes/encabezado.php");
         ?>
      </div>
      <div id="separador">&nbsp;</div>
      <div class="div_separador">&nbsp;</div>
      <div id="menu">
         <?
         include("includes/menu.php");
         ?>
      </div>
      <div id="contenido">
            <form name="form_administrador">
				<?
				if($se_tipo_usuario=="Super_Administrador"):
					?>
	            <div class="notas">
               <textarea name="notas_sistema"><?=$notas_sistema?></textarea>
               <input type="button" value="Actualizar" onClick="actualizar_notas_sistema();"/><div id="div_respuesta_notas_sistema" class="respuesta"></div>
               </div>
               <?
				else:
					//Buscar la nota del sistema del primer Super Administrador 
					$c_ns=buscar("notas_sistema","adm_usuarios","where tipo_usuario='Super_Administrador' and estatus='activo' LIMIT 1");
					while($f_ns=$c_ns->fetch_assoc()):
						$notas_sistema=cadena($f_ns['notas_sistema']);
					endwhile;
					?>
               <div class="respuesta" style="width:100%;">
               	<? echo $notas_sistema;?>
               </div>
               <?
				endif;
				?>
            <!--</fieldset>-->
            <div class="clear">&nbsp;</div>
            <!--
            <fieldset>
            <legend>Notas personales</legend>
            -->
	         <div class="notas">
               <textarea name="notas_personales"><?=$notas?></textarea>
               <input type="button" value="Actualizar" onClick="actualizar_notas_personales();"/><div id="div_respuesta_notas_personales" class="respuesta"></div>
            </div>
            <!--
            </fieldset>
            -->
            </form>
      </div>
      <div id="pie">
         <?
         include("includes/pie.php");
         ?>
      </div>
   </div>
   </body>
   </html>
   <?
endif;
?>