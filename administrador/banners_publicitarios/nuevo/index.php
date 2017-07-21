<?
session_start();
//ini_set("display_errors","On");
$se_id_usuario=$_SESSION["s_id_usuario"];
$se_seccion=$_SESSION['s_seccion'];

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
	$arreglo_respuestas=array();
	$p_action=isset($_POST['action']) ? $_POST['action'] : "";
	if($p_action=="send"):
		date_default_timezone_set('Mexico/General');
		$fechahora=date("YmdHis");
		$fecha_hora_registro=date("Y-m-d H:i:s");		
		$p_numero=$_POST['numero']*1;
		if($p_numero>0):
			for($con=1;$con<=$p_numero;$con++):
				$banner='banner'.$con;
				$imagen='imagen'.$con;
				//$imagen_original='imagen_original'.$con;
				$orden='orden'.$con;
				$estatus='estatus'.$con;
				
				$p_banner=cadenabd($_POST[$banner]);
				$varname=$_FILES[$imagen]['name'];
				//$varname2=$_FILES[$imagen_original]['name'];
				$p_enlace=cadenabd($_POST["enlace".$con]);
				$p_orden=$_POST[$orden]*1;
				$p_estatus=$_POST[$estatus];
				
				if(!empty($p_banner) and
					!empty($p_estatus)
					):
					//Buscar el ultimo id de la imagen
					$c_gr=buscar("id_banner","banners_publicitarios","order by id_banner desc limit 1");
					while($f_gr=$c_gr->fetch_assoc()):
						$id_banner=$f_gr["id_banner"];
						$id_banner=$id_banner+1;
					endwhile;
					if(empty($id_banner)):
						$id_banner=1;
					endif;
					
					if(!empty($_FILES["imagen".$con]["name"])):
						$valid_formats= array("jpg","png","gif","JPG","PNG","GIF");
						
						//$max_file_size = 1024*1024; //1000 kb
						$max_file_size= 1048576*64; //64 MB
						$path= "../images/"; // Upload directory
						
						if($_FILES['imagen'.$con]['error']==4):
							$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen".$con]["name"].' tiene un error.</div>';
						endif;
						if($_FILES['imagen'.$con]['error']==0):
							if($_FILES['imagen'.$con]['size']>$max_file_size):
								$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen".$con]["name"].' es muy grande.</div>';
							elseif(!in_array(pathinfo($_FILES["imagen".$con]["name"], PATHINFO_EXTENSION), $valid_formats)):
								$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen".$con]["name"].' no es un formato válido</div>';
							else: // No error found! Move uploaded files 
								$extension=".".pathinfo($_FILES["imagen".$con]["name"], PATHINFO_EXTENSION);
								$nombre_archivo="img_".$id_banner."_".$fechahora.$extension;
								if(move_uploaded_file($_FILES["imagen".$con]["tmp_name"],$path.$nombre_archivo)):
									$p_imagen=$nombre_archivo;
								endif;
								unset($extension,$nombre_archivo);
							endif;
						endif;
						unset($max_file_size,$path);
					endif;
					
					/*
					if(!empty($varname2)):
						$vartemp2=$_FILES[$imagen_original]['tmp_name'];
						$extension2=obtener_extension($varname2);
						$p_imagen_original="io".$id_banner.$extension2;
						$nombre_archivo2="../images/".$p_imagen_original;
						move_uploaded_file($vartemp2,$nombre_archivo2);
					endif;
					unset($varname2);
					unset($extension2);
					unset($nombre_archivo2);
					*/
					
					//Registrar imagenes en banner
					$i_c=insertar("banner
										,imagen
										,enlace
										,orden
										,estatus
										,fecha_hora_registro"
										,"banners_publicitarios"
										,"'".$p_banner."'
										,'".$p_imagen."'
										,'".$p_enlace."'
										,".$p_orden."
										,'".$p_estatus."'
										,'".$fecha_hora_registro."'");
					if(!$i_c):
						$arreglo_respuestas[]='<div class="error">No fue posible registrar el banner publicitario '.$con.'</div>';
					else:
						$arreglo_respuestas[count($arreglo_respuestas)]='<div class="exito">Banner publicitario '.$con.' registrado exitosamente.</div>';
					endif;				
				else:
					$arreglo_respuestas[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
				endif;
				unset($p_banner);
				unset($p_imagen);
				//unset($p_imagen_original);
				unset($p_enlace,$p_orden);
				unset($p_estatus);
				unset($id_banner);					
			endfor;
		endif;
	endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ESPECIALIDAD - NUEVO</title>
<!-- Favicon -->
<link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">

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
      <div id="menu_paginacion">
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
      <fieldset>
      <legend>Nuevo Banner publicitario</legend>
                      <table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral">
                        <tr>
                        	<td></td>
                           <td>
                              <input id="agregar_banner" name="agregar_banner" type="button" class="link_5" value="Agregar banner publicitario" style="clear:both;" />
                           </td>
                        </tr>
                        <tr>
                        	<td colspan="2" align="left">
                              <div id="div_banners" style="position:relative;">
                              	<fieldset>
                                 <legend>Banner publicitario 1</legend>
                                 <table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral">
                                    <tr>
                                       <td>Banner publicitario</td>
                                       <td><input type="text" name="banner1" style="width:300px;" maxlength="255" required>*</td>
                                    </tr>
                                    <tr>
                                       <td>Imagen</td>
                                       <td><input type="file" name="imagen1"/></td>
                                    </tr>
                                    <tr>
                                       <td></td>
                                       <td>Le sugerimos una imagen con 1752 x 250 pixeles y formato JPG</td>
                                    </tr>
                                    <tr>
                                       <td>Enlace</td>
                                       <td>
                                       	<textarea name="enlace1" id="enlace1" style="width:600px;height:100px;"></textarea>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Orden</td>
                                       <td>
                                          <input type="number" min="0" name="orden1" step="1" style="width:50px;"/>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Estatus</td>
                                       <td><select name="estatus1">
                                          <option value="activo">Activo</option>
                                          <option value="inactivo">Inactivo</option>
                                       </select>
                                       </td>
                                    </tr>
                                 </table>   
                                 </fieldset>
                              </div>
                           </td>
                        </tr>
                        <tr>
                        	<td width="20%"><input name="numero" id="numero" type="hidden" value="1"></td>
                           <td width="80%" colspan="2" class="info">* Requerido</td>
                        </tr>
                        <tr>
                           <td><input type="hidden" name="action" value="send"></td>
                           <td colspan="2"><input type="submit" 
                                       name="button" 
                                       id="button" 
                                       value="Registro">
                           </td>
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
   <script src="../../../assets/nicEdit/nicEdit.js" type="text/javascript"></script>
   <script>
		jQuery(document).ready(function(){
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("enlace1");
			jQuery("#agregar_banner").click(function(event){
				var numero=(new Number(jQuery("#numero").val())*1)+1;
				if(numero>0 && (jQuery("#tbl_banner"+numero).length)==0){
					url ="../agregar_banner.php";
					var posting = jQuery.post(url,{numero:numero});
					posting.done(function(data){
						jQuery("#div_banners").append(data);
						jQuery("#numero").val(numero);
						new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("enlace"+numero);
					});
				}
			});
			jQuery("#form1").submit(function(event){
				//event.preventDefault();
				var numero=new Number(jQuery("#numero").val())*1;
				if(numero>0){
					for(var con=1;con<=numero;con++){
						nicEditors.findEditor("enlace"+con).saveContent();
					}
				}
				jQuery("#form1").submit();
			});
		});	
      </script>
   </body>
   </html>
   <?
endif;
?>