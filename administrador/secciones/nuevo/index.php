<?
session_start();
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SECCIONES - NUEVA</title>
<link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">
<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
<link href="../../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<? 
include("../../includes/ajuste.php");
/*
?>
<!-- TinyMCE -->
<script type="text/javascript" src="../../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        // General options
		relative_urls: false,
	 	mode:"exact",
	    elements : "descripcion_completa",
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
<!-- TinyMCE -->
*/
?>
<script type="text/javascript" language="javascript" src="../../js/funciones.js"></script>
<script type="text/javascript" language="javascript" src="../ajax.js"></script>
<script type="text/javascript" language="javascript">
function validar_tipo(tipo){
	if(tipo=="generica"){
		document.getElementById("tr_categorias").style.display="none";		
		document.getElementById("tr_imagen").style.display="";
		document.getElementById("tr_enlace").style.display="none";
		document.getElementById("tr_adjunto").style.display="block";
		document.getElementById("tr_calendario").style.display="none";
		/*
		document.getElementById("tr_imagen_descripcion").style.display="";
		document.getElementById("tr_banner").style.display="none";
		*/
		document.getElementById("tr_descripcion_corta").style.display="";
		document.getElementById("tr_descripcion_completa").style.display="";
		document.getElementById("tr_palabras_clave").style.display="";	
		document.getElementById("tr_mapa").style.display="none";
	}
	else if(tipo=="enlace"){
		document.getElementById("tr_categorias").style.display="none";				
		document.getElementById("tr_imagen").style.display="none";
		document.getElementById("tr_enlace").style.display="";
		document.getElementById("tr_adjunto").style.display="none";
		document.getElementById("tr_calendario").style.display="none";	
		document.getElementById("tr_descripcion_corta").style.display="none";
		document.getElementById("tr_descripcion_completa").style.display="none";
		document.getElementById("tr_palabras_clave").style.display="none";				
		document.getElementById("tr_mapa").style.display="none";		
	}
	else if(tipo=="adjunto"){
		document.getElementById("tr_categorias").style.display="none";
		document.getElementById("tr_imagen").style.display="none";
		document.getElementById("tr_enlace").style.display="none";
		document.getElementById("tr_adjunto").style.display="";
		document.getElementById("tr_calendario").style.display="none";		
		document.getElementById("tr_descripcion_corta").style.display="";
		document.getElementById("tr_descripcion_completa").style.display="";
		document.getElementById("tr_palabras_clave").style.display="";				
		document.getElementById("tr_mapa").style.display="none";		
	}
	else if(tipo=="categorias"){
		document.getElementById("tr_categorias").style.display="";
		document.getElementById("tr_imagen").style.display="";
		document.getElementById("tr_enlace").style.display="none";
		document.getElementById("tr_adjunto").style.display="none";
		document.getElementById("tr_calendario").style.display="none";		
		document.getElementById("tr_descripcion_corta").style.display="";
		document.getElementById("tr_descripcion_completa").style.display="";
		document.getElementById("tr_palabras_clave").style.display="";		
		document.getElementById("tr_mapa").style.display="none";				
	}
	else if(tipo=="calendario_google"){
		document.getElementById("tr_categorias").style.display="none";
		document.getElementById("tr_imagen").style.display="";
		document.getElementById("tr_enlace").style.display="none";
		document.getElementById("tr_adjunto").style.display="none";
		document.getElementById("tr_calendario").style.display="";
		document.getElementById("tr_descripcion_corta").style.display="";
		document.getElementById("tr_descripcion_completa").style.display="";
		document.getElementById("tr_palabras_clave").style.display="";			
		document.getElementById("tr_mapa").style.display="none";			
	}
	else if(tipo=="mapa_google"){
		document.getElementById("tr_categorias").style.display="none";
		document.getElementById("tr_imagen").style.display="";
		document.getElementById("tr_enlace").style.display="none";
		document.getElementById("tr_adjunto").style.display="none";
		document.getElementById("tr_calendario").style.display="none";
		document.getElementById("tr_descripcion_corta").style.display="";
		document.getElementById("tr_descripcion_completa").style.display="";
		document.getElementById("tr_palabras_clave").style.display="";
		document.getElementById("tr_mapa").style.display="";
	}
	else{
		document.getElementById("tr_categorias").style.display="none";		
		document.getElementById("tr_imagen").style.display="";
		document.getElementById("tr_enlace").style.display="none";
		document.getElementById("tr_adjunto").style.display="none";
		document.getElementById("tr_calendario").style.display="none";		
		document.getElementById("tr_descripcion_corta").style.display="";
		document.getElementById("tr_descripcion_completa").style.display="";
		document.getElementById("tr_palabras_clave").style.display="";		
		document.getElementById("tr_mapa").style.display="none";		
	}
}

function validar_menu(menu){
	if(menu=="principal"){
		document.getElementById("tr_boton").style.display="";
		//document.getElementById("tr_boton_rollover").style.display="";
	}
	else{
		document.getElementById("tr_boton").style.display="none";
		//document.getElementById("tr_boton_rollover").style.display="none";
		
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
      <div class="div_separador">&nbsp;</div>
      <div id="div_contenido">
		<form action="./" method="post" enctype="multipart/form-data" name="form1" id="form1">
   	<p>Los campos con <strong>*</strong> son requeridos.</p>
      <fieldset>
      <legend>Nueva sección</legend>
      <table border="0" cellpadding="3" cellspacing="1" align="left">
	      <?
			$p_action=isset($_POST['action'])?$_POST['action']:"";
			if($p_action=="send"):
				date_default_timezone_set('Mexico/General');
				$fechahora=date("YmdHis");
				
				$p_id_seccion_anterior=$_POST['id_seccion_anterior']*1;
				$p_tipo_seccion=cadenabd($_POST["tipo_seccion"]);
				$p_id_categoria=$_POST['id_categoria']*1;		
				$p_menu=cadenabd($_POST["menu"]);
				$p_seccion=cadenabd($_POST["seccion"]);
				$p_subtitulo=cadenabd($_POST["subtitulo"]);
				$p_enlace_activo=$_POST["enlace_activo"];
				$p_enlace=cadenabd($_POST["enlace"]);
				$varname=cadenabd($_FILES['boton']['name']);
				//$varname2=cadenabd($_FILES['boton_rollover']['name']);
				$varname3=cadenabd($_FILES['imagen']['name']);
				//$varname4=cadenabd($_FILES['imagen_descripcion']['name']);
				//$varname5=cadenabd($_FILES['banner']['name']);
				$varname6=cadenabd($_FILES['adjunto']['name']);
				$p_descripcion_corta=cadenabd($_POST["descripcion_corta"]);
				$p_descripcion_completa=cadenabd($_POST["descripcion_completa"]);
				$p_palabras_clave=cadenabd($_POST["palabras_clave"]);
				$p_orden=$_POST['orden']*1;
				$p_estatus=$_POST["estatus"];
				$p_calendario_google=$_POST["calendario_google"];
				$p_calendario_google=str_replace("amp;","",$p_calendario_google);
				$p_calendario_google=addslashes($p_calendario_google);
				$p_calendario_google=cadenabd($p_calendario_google);
				$p_mapa=cadenabd($_POST['mapa']);
				$p_mapa=str_replace("amp;","",$p_mapa);
				$p_mapa=addslashes($p_mapa);
				
				if($p_enlace_activo=="on"):
					$p_enlace_activo="si";
				else:
					$p_enlace_activo="no";
				endif;
				
				$c_p=buscar("id_seccion","secciones","ORDER BY id_seccion DESC LIMIT 1");
				while($f_p=$c_p->fetch_assoc()):
					$id_seccion=$f_p['id_seccion'];
				endwhile;
				$id_seccion=$id_seccion+1;
				
				if(!empty($varname3)):
					$vartemp3=$_FILES['imagen']['tmp_name'];
					$extension3=".".pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
					if($extension3==".jpg"
					or $extension3==".JPG" 
					or $extension3==".jpeg"
					or $extension3==".JPEG" 
					or $extension3==".png" 
					or $extension3==".PNG" 
					or $extension3==".gif" 
					or $extension3==".GIF"
						):
						$p_imagen="i".$id_seccion."_".$fechahora.$extension3;
						$nombre_archivo3="../images/".$p_imagen;
						move_uploaded_file($vartemp3,$nombre_archivo3);
					endif;
				endif;
				
				if(!empty($varname6)):
					$vartemp6=$_FILES['adjunto']['tmp_name'];
					$extension6=".".pathinfo($_FILES["adjunto"]["name"], PATHINFO_EXTENSION);
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
						$p_adjunto="ad_".$id_seccion."_".$fechahora.$extension6;
						$nombre_archivo6="../adjuntos/".$p_adjunto;
						move_uploaded_file($vartemp6,$nombre_archivo6);
					endif;
				endif;
				
				//Registrar
				$c_id=insertar("id_categoria,id_seccion_anterior,tipo_seccion,menu,seccion,subtitulo,enlace_activo,enlace,adjunto,descripcion_corta,descripcion_completa,palabras_clave,icono,imagen,orden,estatus,calendario_google,mapa_google","secciones","".$p_id_categoria.",".$p_id_seccion_anterior.",'".$p_tipo_seccion."','".$p_menu."','".$p_seccion."','".$p_subtitulo."','".$p_enlace_activo."','".$p_enlace."','".$p_adjunto."','".$p_descripcion_corta."','".$p_descripcion_completa."','".$p_palabras_clave."','".$p_boton."','".$p_imagen."',".$p_orden.",'".$p_estatus."','".$p_calendario_google."','".$p_mapa."'");
				
				if($c_id):
					//die("Sección registrada exitosamente");			
					?>
					<script type="text/javascript" language="JavaScript">
						alert("Seccion registrada exitosamente");
						location.href="../";
					 </script>
					<?
				else:
					//die("No fue posible registrar la seccion. Intente de nuevo");
					?>
					<script type="text/javascript" language="JavaScript">
						alert("No fue posible registrar la seccion. Intente de nuevo");
						location.href="./";
					 </script>
					<?
				endif;
			endif;
				?>
            
                        <tr>
                        	<td></td>
                          <td class="alerta" id="td_respuesta"></td>
                        </tr>
                        <? /*
                        <tr>
                          <td class="text_gral">Sección anterior</td>
                          <td class="text_gral" id="td_secciones">
                          <?
									$c_se=buscar("id_seccion,seccion"
											,"secciones"
											,"WHERE id_seccion_anterior=0 order by seccion asc");
									?>
                            <select name="id_seccion_anterior">
                              <option value="">Ninguna</option>
                              <?
							while($f_se=$c_se->fetch_assoc()):
								$id_seccion=$f_se['id_seccion'];
								$seccion_anterior=cadena($f_se['seccion']);
								?>
                              <option value="<?=$id_seccion?>">
                                <?=$seccion_anterior?>
                                </option>
                              <?
								unset($id_seccion);
								unset($seccion_anterior);
							endwhile;
							?>
                            </select>                          
                        	</td>
                        </tr>
                        <tr>
                          	<td class="text_gral">Tipo</td>
                          	<td class="text_gral">
                          		<select name="tipo_seccion" onChange="validar_tipo(this.value);">
                               	<option value="">Seleccione ...</option>
                                 <!--
                               	<option value="alianzas">Alianzas</option>
                                 <option value="articulos">Artículos</option>
                               	<option value="aviso_privacidad">Aviso de privacidad</option>
                               	<option value="adjunto">Adjunto</option>
                               	<option value="boletin">Boletín</option>
                               	<option value="chat">Chat</option>
                                 <option value="categorias">Categorías</option>
                                 <option value="calendario_google">Calendario Google</option>
                               	<option value="clientes">Clientes</option>
                               	<option value="conferencias">Conferencias</option>                               	
                                 <option value="contacto">Contacto</option>
                                -->                                 
                                 <!--
                                 <option value="cotizacion">Cotización</option>
                               	<option value="enlace">Enlace</option>
                               	<option value="eventos">Eventos</option>
                               	<option value="expositores">Expositores</option>                                 
                                 <!--
                                 <option value="descargables">Descargables</option>
                               	<option value="galeria">Galería</option>
                                 -->                                 
                                 <option value="generica" selected="selected">Genérica</option>
                                 <!--
                               	<option value="hoteles">Hoteles</option>
                                 <option value="login_doctores">Login doctores</option>
                                 <option value="mapa_google">Mapa Google</option>                               	
                                 <option value="patrocinadores">Patrocinadores</option>
                                	<option value="plano">Plano</option>
                               	<option value="ponentes">Ponentes</option>                               	
                                 <option value="preguntas">Preguntas</option>
                                 <option value="principal">Principal</option>
                               	<option value="proveedores">Proveedores</option>         
                                 <option value="registro_doctores">Registro doctores</option>
                                 <option value="servicios">Servicios</option>
								       	<option value="unidades">Unidades</option>
                                 -->
                               	<option value="videos">Videos</option>
                                 <!--
								      	<option value="viajes_proximos">Viajes próximos</option>
                               	<option value="viajes_internacionales">Viajes internacionales</option>                               
                                 -->
                             	</select>
								<span class="requerido">*</span>
                                <div id="tr_categorias" style="display:none;">
                                  <div class="div_separador" style="height:10px;"></div>
                                   Categoría: 
                                   <?
                                   $c_ca=buscar("id_categoria,categoria","categorias","where estatus='activo' ORDER BY orden ASC");
                                   ?>
                                   <select name="id_categoria">
                                      <option value="">Seleccione</option>
                                      <?
                                      while($f_ca=$c_ca->fetch_assoc()):
                                         $id_categoria=$f_ca["id_categoria"];
                                         $categoria=cadena($f_ca["categoria"]);
                                         ?>
                                         <option value="<?=$id_categoria?>"><?=$categoria?></option>
                                         <?
                                         unset($id_categoria);
                                         unset($categoria);
                                      endwhile;
                                      ?>
                                   </select>
                                </div>
                                <div id="tr_calendario" style="display:none;">
                                  <div class="div_separador" style="height:10px;"></div>
                                   Calendario de Google: <br />
                                   <textarea name="calendario_google" style="width:300px; height:150px;"></textarea><br />
                                   <strong>Ejemplo:</strong> < iframe src="https://www.google.com/calendar/embed?src=j1tt2as76p912uesrsuivdeut4%40group.calendar.google.com&ctz=America/Mexico_City" style="border: 0" width="538" height="338" frameborder="0" scrolling="no">< /iframe>
		    
                                </div>
								</td>
                        </tr>
								*/
								?>
                        <!--
                        <tr>
                          <td class="text_gral">Menú</td>
                          <td class="text_gral"><select name="menu" onChange="validar_menu(this.value);">
                            <option value="arriba">Arriba</option>
                            <option value="centro">Centro</option>
                            <option value="izquierdo">Izquierdo</option>
                            <option value="interno">Interno</option>                            
                          </select></td>
                        </tr>
                        -->
                        <tr>
                          <td class="text_gral">Sección</td>
                          <td class="text_gral"><input type="text" name="seccion" style="width:400px;" maxlength="255" required="required"/>
                            <span class="requerido">*</span></td>
                        </tr>
                        <tr>
                          <td class="text_gral">Subtítulo</td>
                          <td class="text_gral"><input type="text" name="subtitulo" style="width:400px;" maxlength="255" /></td>
                        </tr>
                        <tr>
                          <td class="text_gral"></td>
                          <td class="text_gral"><input type="checkbox" name="enlace_activo" checked="checked"/> Enlace activo</td>
                        </tr>
                        <!--
                        <tr id="tr_boton">
                          <td class="text_gral">Ícono</td>
                          <td class="text_gral">
                             <input type="file" name="boton"/>
                              <br />
								      <span>Le sugerimos una imagen de 59 px de alto y formato GIF O PNG</span></td>
                          </td>
                        </tr>
                        -->
                        <!--
                        <tr id="tr_boton_rollover">
                          <td class="text_gral">Botón rollover</td>
                          <td class="text_gral">
                             <input type="file" name="boton_rollover"/>
                             <br />
                             <span>Le sugerimos los botones con 23 pixeles de alto</span>
                           </td>
                        </tr>
                        -->
								<tr id="tr_imagen">
								   <td class="text_gral">Imagen</td>
								   <td class="text_gral">
								      <input type="file" name="imagen"/>
                              <br />
								      <span>Le sugerimos una imagen de 980 x 260 pixeles y formato JPG</span></td>
								</tr>
                        <!--
								<tr id="tr_imagen_descripcion" style="display:none;">
                           <td class="text_gral">Imagen descriptiva</td>
                           <td class="text_gral">
                              <input type="file" name="imagen_descripcion"/>
                              <br />
                              <span>Le sugerimos una imagen de 527 px de ancho y formato JPG </span></td>
                        </tr>
								<tr id="tr_banner" style="display:none;">
                           <td class="text_gral">Banner</td>
                           <td class="text_gral">
                              <input type="file" name="banner"/>
                              <br />
                              <span>Le sugerimos una imagen de 960 x 355 pixeles y formato JPG </span>
                           </td>
                        </tr>
                        -->
                        <tr id="tr_enlace" style="display:none">
                        	<td>Enlace</td>
                           <td><input name="enlace" type="text" style="width:300px;" maxlength="255"/></td>
                        </tr>
                        <tr id="tr_mapa" style="display:none">
                        	<td>Google maps</td>
                           <td><textarea name="mapa" style="width:300px; height:150px;"></textarea>
                           	<br />
                              <span class="mensajes">
<strong>Ejemplo:</strong> < iframe width="600" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.es/maps/ms?ie=UTF8&amp;hl=es&amp;msa=0&amp;msid=103520032951371305116.000485c816dfb962b5927&amp;ll=20.574336,-100.298513&amp;spn=0,0&amp;t=h&amp;output=embed">< / iframe>                              
                              </span>
                           </td>
                        </tr>
                        <tr id="tr_descripcion_corta">
                          <td class="text_gral">Descripción corta</td>
                          <td class="text_gral"><textarea name="descripcion_corta" style="width:625px; height:100px;"></textarea></td>
                        </tr>
                        <tr id="tr_descripcion_completa">
                          <td class="text_gral">Descripción completa</td>
                          <td class="text_gral"><textarea name="descripcion_completa" style="width:625px; height:200px;"></textarea></td>
                        </tr>
                        <tr id="tr_palabras_clave">
                          <td class="text_gral">Palabras Clave</td>
                          <td class="text_gral"><textarea name="palabras_clave" style="width:625px; height:100px;"></textarea></td>
                        </tr>
                        <tr id="tr_adjunto">
                        	<td>Adjunto</td>
                           <td><input type="file" name="adjunto"/></td>
                        </tr>
                        <tr>
                           <td class="text_gral">Orden</td>
                           <td class="text_gral"><input type="text" name="orden" style="width:50px;" onKeyUp="this.value=validarEntero(this.value);"/></td>
                        </tr>
                        <tr>
                        	<td>Estatus</td>
                           <td>
                           	<select name="estatus">
                              	<option value="activo">Activo</option>
                              	<option value="inactivo">Inactivo</option>                                 
                              </select>
                           </td>
                        </tr>
                        <tr>
                          <td><input type="hidden" name="action" value="send"/></td>
                          <td><input type="submit" class="link_5" value="Registro"/></td>
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