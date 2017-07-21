<?
session_start();
ini_set("display_errors","On");
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

$p_arreglo_registros=$_POST['arreglo_registros'];
$p_action=$_POST['action'];
if($p_action=="send"):
	date_default_timezone_set('Mexico/General');
	$fechahora=date("YmdHis");

	$p_arreglo_registros=$_POST['arreglo_registros'];
	if(count($p_arreglo_registros)>0):
	
		$arreglo_respuestas=array();
		
		for($i=0;$i<count($p_arreglo_registros);$i++):
			$registro=$p_arreglo_registros[$i];
			$servicio="servicio".$registro;
			$imagen="imagen".$registro;
			$eliminar_imagen="eliminar_imagen".$registro;			
			$enlace='enlace'.$registro;
			/*
			$imagen_original="imagen_original".$registro;
			$eliminar_imagen_original="eliminar_imagen_original".$registro;
			*/
			$orden="orden".$registro;
			$estatus="estatus".$registro;
			
			$p_servicio=cadenabd($_POST[$servicio]);
			$varname=cadenabd($_FILES[$imagen]['name']);
			$p_eliminar_imagen=$_POST[$eliminar_imagen];
			$p_enlace=cadenabd($_POST[$enlace]);
			/*
			$varname2=cadenabd($_FILES[$imagen_original]['name']);
			$p_eliminar_imagen_original=$_POST[$eliminar_imagen_original];
			*/
			$p_orden=$_POST[$orden]*1;
			$p_estatus=$_POST[$estatus];
			
			$c_se=buscar("imagen","servicios","where id_servicio=".$registro);
			while($f_se=mysql_fetch_assoc($c_se)):
				$imagen_actual=$f_se['imagen'];
				//$imagen_original_actual=$f_se['imagen_original'];
			endwhile;
			if(!empty($varname)):
				if(!empty($imagen_actual) and file_exists("../images/".$imagen_actual)):
					unlink("../images/".$imagen_actual);
				endif;
				$vartemp=$_FILES[$imagen]['tmp_name'];
				$extension=obtener_extension($varname);
				$p_imagen="im".$registro."_".$fechahora.$extension;
				$nombre_archivo="../images/".$p_imagen;
				move_uploaded_file($vartemp,$nombre_archivo);
				unset($varname);
				unset($vartemp);
				unset($extension);
				unset($nombre_archivo);
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
				
			$actualizar="servicio='".$p_servicio."'";
			if(!empty($p_imagen) or $p_eliminar_imagen=="on"):
				$actualizar.=",imagen='".$p_imagen."'";
			endif;
			/*
			if(!empty($p_imagen_original) or $p_eliminar_imagen_original=="on"):
			$actualizar.=",imagen_original='".$p_imagen_original."'";
			endif;
			*/
			$actualizar.=",enlace='".$p_enlace."'
							,orden=".$p_orden."
							,estatus='".$p_estatus."'";
			$c_id=actualizar("".$actualizar."","servicios","where id_servicio=".$registro."");
			
			if(!$c_id):
				$arreglo_respuestas[count($arreglo_respuestas)]="No fue posible actualizar este servicio ".$registro;
			else:
				$arreglo_respuestas[count($arreglo_respuestas)]="Habitacion ".$registro." actualizado exitosamente.";
			endif;
			
			unset($p_servicio);
			unset($p_imagen);
			unset($p_eliminar_imagen);
			unset($imagen_actual);
			/*
			unset($p_imagen_original);
			unset($p_eliminar_imagen_original);
			unset($imagen_original_actual);
			*/
			unset($p_enlace);
			unset($p_orden);
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
<title>servicio - ACTUALIZAR</title>
<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
<link href="../../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<? 
include("../../includes/ajuste.php");
?>
<script type="text/javascript" src="../../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
/*
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
});*/
</script>

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

<script type="text/javascript" language="javascript">
function validar(form){
	var arreglo_registros=document.getElementsByName("arreglo_registros[]");
	/*
	if(arreglo_registros.length>0){
		var identificador="";
		var contenedor="";
		for(var i=0;i<arreglo_registros.length;i++){
			identificador=new Number(arreglo_registros[i].value)*1;
			contenedor=document.getElementById("td_respuesta"+identificador);
			if (eval("form.servicio"+identificador+".value")== "") { 
				contenedor.innerHTML="Seleccione el servicio del servicio.";
				eval("form.servicio"+identificador+".focus()");
				return false;
			}
		}*/
		form.submit();
		/*
	}
	*/
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
      <div id="#menu_interno">
         <?
         include("../../includes/menu_interno.php");
         ?>
      </div>
      <div>
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
				$c_id=buscar("servicio
									,imagen
									,enlace
									,orden
									,estatus"
								,"servicios"
								,"where id_servicio=".$registro."");
									
				while($f_c=mysql_fetch_assoc($c_id)):
					$servicio=cadena($f_c['servicio']);
					$imagen=$f_c['imagen'];
					$enlace=cadena($f_c["enlace"]);
					//$imagen_original=$f_c['imagen_original'];
					$orden=$f_c['orden'];
					$estatus=$f_c['estatus'];
				endwhile;
				?>
      					<fieldset>
                     <legend>Actualizar Imagen</legend>
                      <table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral">
                        <tr>
                        	<td></td>
                          <td class="alerta" id="td_respuesta<?=$registro?>"></td>
                        </tr>
                        <tr>
                           <td width="20%">Habitacion</td>
                           <td width="80%"><input type="text" name="servicio<?=$registro?>" style="width:300px;" maxlength="255" value="<?=$servicio?>"></td>
                        </tr>
                        <?
						if(!empty($imagen) and file_exists("../images/".$imagen)):
									
                           ?>
						<tr>
                             <td class="text_gral">Imagen actual</td>
                             <td class="text_gral">
                             	<a href="../images/<?=$imagen?>" target="_blank">
                              <img src="../images/<?=$imagen?>" style="max-width:1920px;" border="0">
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
                                 <span>Le sugerimos una imagen con 370 X 374 pixeles y formato JPG</span>
                                 </td>	   
                           </tr>
                           <?
                        else:
                           ?>
                           <tr>
                             <td class="text_gral">Imagen</td>
                             <td class="text_gral"><input type="file" name="imagen<?=$registro?>"/>
                              <br />
                                <span>Le sugerimos una imagen con 370 X 374 pixeles y formato JPG</span>
                             </td>
                           </tr>
                           <?
                        endif;
						?>
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
                            <input type="button" class="link_5" onClick="validar(document.form1);" value="Registro"/>
                          </span></td>
                        </tr>
                      </table>
                      </fieldset>
                        <?
								unset($servicio);
								unset($imagen);
								//unset($imagen_original);
								unset($enlace);
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
</body>
</html>
<?
endif;
?>