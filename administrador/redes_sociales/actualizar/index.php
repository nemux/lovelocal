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

$p_arreglo_registros=$_POST['arreglo_registros'];
$p_action=isset($_POST['action'])?$_POST['action']:"";
$arreglo_respuestas=array();
if($p_action=="send"):
	$p_arreglo_registros=$_POST['arreglo_registros'];
	if(count($p_arreglo_registros)>0):
	
		date_default_timezone_set('Mexico/General');
		$fechahora=date("YmdHis");
		
		
		for($i=0;$i<count($p_arreglo_registros);$i++):
			$registro=$p_arreglo_registros[$i];
			$titulo="titulo".$registro;
			$imagen='imagen'.$registro;
			$eliminar_imagen='eliminar_imagen'.$registro;		
			$enlace="enlace".$registro;
			$orden='orden'.$registro;
			$estatus="estatus".$registro;
			
			$p_titulo=cadenabd($_POST[$titulo]);
			$varname3=cadenabd($_FILES[$imagen]['name']);
			$p_eliminar_imagen=$_POST[$eliminar_imagen];			
			$p_enlace=cadenabd($_POST[$enlace]);
			$p_orden=$_POST[$orden]*1;
			$p_estatus=$_POST[$estatus];
			
			$c_se=buscar("imagen","redes_sociales","where id_red=".$registro);
			while($f_se=$c_se->fetch_assoc()):
				$imagen_actual=$f_se['imagen'];
			endwhile;
			
			if(!empty($varname3)):
				if(!empty($imagen_actual) and file_exists("../images/".$imagen_actual)):
					unlink("../images/".$imagen_actual);
				endif;
				$vartemp3=$_FILES[$imagen]['tmp_name'];
				$extension3=obtener_extension($varname3);
				$p_imagen="i".$registro."_".$fechahora.$extension3;
				$nombre_archivo3="../images/".$p_imagen;
				move_uploaded_file($vartemp3,$nombre_archivo3);
			elseif($p_eliminar_imagen=="on"):
				if(!empty($imagen_actual) and file_exists("../images/".$imagen_actual)):
					unlink("../images/".$imagen_actual);
				endif;
				$p_imagen="";
			endif;
			
			$actualizar="titulo='".$p_titulo."'
							,enlace='".$p_enlace."'";
			if(!empty($p_imagen) or $p_eliminar_imagen=="on"):
			$actualizar.=",imagen='".$p_imagen."'";
			endif;
			$actualizar.=",orden=".$p_orden."
							  ,estatus='".$p_estatus."'";
							  
			$c_id=actualizar("".$actualizar."","redes_sociales","where id_red=".$registro);
			
			if(!$c_id):
				$arreglo_respuestas[count($arreglo_respuestas)]="No fue posible actualizar esta red social ".cadena($p_titulo);
			else:
				$arreglo_respuestas[count($arreglo_respuestas)]="Red social ".cadena($p_titulo)." actualizada exitosamente.";
			endif;
			
			unset($p_titulo);
			unset($p_enlace);
			unset($varname3);
			unset($p_eliminar_imagen);
			unset($p_orden);
			unset($p_estatus);
			
			unset($c_se);
			unset($imagen_actual);
		
			unset($vartemp3);
			unset($extension3);
			unset($p_imagen);
			unset($nombre_archivo3);
			unset($size3);
			unset($ancho3);
			unset($alto3);
			unset($cambio3);

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
<title>REDES SOCIALES - ACTUALIZAR</title>
<link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png" />
<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
<link href="../../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<? 
include("../../includes/ajuste.php");
include("../../includes/tiny_mce.php");
?>
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
			if(eval("form.titulo"+identificador+".value")==""){
				contenedor.innerHTML="Capture el nombre de la red social";
				eval("form.titulo"+identificador+".focus()");
				return false;
			}
			if(eval("form.enlace"+identificador+".value")==""){
				contenedor.innerHTML="Capture el enlace de la red social";
				eval("form.enlace"+identificador+".focus()");
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
				$c_id=buscar("titulo
								,enlace
								,imagen
								,orden
								,estatus","redes_sociales","where id_red=".$registro);
				while($f_id=$c_id->fetch_assoc()):
					$titulo=cadena($f_id["titulo"]);
					$enlace=cadena($f_id["enlace"]);
					$imagen=$f_id["imagen"];
					$orden=$f_id["orden"];																																													
					$estatus=$f_id["estatus"];
				endwhile;
				?>
      	<fieldset>
         <legend>Actualizar red social</legend>
                      <table border="0" cellpadding="3" cellspacing="1" align="left">
                        <tr>
                          <td colspan="2" class="text_9" id="td_respuesta<?=$registro?>"></td>
                        </tr>
                        <tr>
                          <td class="text_gral">Red social</td>
                          <td class="text_gral"><? /*<input type="text" name="titulo<?=$registro?>" style="width:200px;" maxlength="100" value="<?=$titulo?>" />*/ ?>
                          <select name="titulo<?=$registro?>" required>
                             <option value="">Seleccione ...</option>
                             <option value="twitter" <? if($titulo=="twitter"):?> selected="selected" <? endif; ?>>Twitter</option>
                             <option value="facebook" <? if($titulo=="facebook"):?> selected="selected" <? endif; ?>>Facebook</option>
                             <option value="linkedin" <? if($titulo=="linkedin"):?> selected="selected" <? endif; ?>>Linkedin</option>
                             <option value="google" <? if($titulo=="google"):?> selected="selected" <? endif; ?>>Google</option>
                             <option value="youtube" <? if($titulo=="youtube"):?> selected="selected" <? endif; ?>>Youtube</option>
                             <option value="instagram" <? if($titulo=="instagram"):?> selected="selected" <? endif; ?>>Instagram</option>
                             <option value="flickr" <? if($titulo=="flickr"):?> selected="selected" <? endif; ?>>Flickr</option>
                             <option value="skype" <? if($titulo=="skype"):?> selected="selected" <? endif; ?>>Skype</option>
                             <option value="yahoo" <? if($titulo=="yahoo"):?> selected="selected" <? endif; ?>>Yahoo</option>
                             <option value="pinterest" <? if($titulo=="pinterest"):?> selected="selected" <? endif; ?>>Pinterest</option>                             
s                          </select>
                            <span class="requerido">* </span></td>
                        </tr>
								<? /*
                        if(!empty($imagen) and file_exists("../images/".$imagen)):
                           $size=getimagesize("../images/".$imagen);
                           $ancho=$size[0];
                           $alto=$size[1];

                           if($alto>60):
                              $ancho=(int)((60/$alto)*$ancho);
                              $alto=60;
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
                                 <span>Le sugerimos una imagen de 60 x 60 pixeles</span>                                      
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
                              <span>Le sugerimos una imagen de 60 x 60 pixeles</span>                                      </td>
                           </tr>
                           <?
                        endif;*/ ?>
                        <tr>
                        	<td>Enlace</td>
                           <td><input name="enlace<?=$registro?>" type="text" style="width:300px;" maxlength="255" value="<?=$enlace?>"/></td>
                        </tr>
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
								unset($titulo);
								unset($enlace);
								unset($imagen);
								unset($orden);
								unset($estatus);
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