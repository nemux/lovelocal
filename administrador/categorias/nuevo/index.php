<?
session_start();
ini_set("display_errors","On");
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
		$p_numero=$_POST['numero']*1;
		if($p_numero>0):
			for($con=1;$con<=$p_numero;$con++):
				$categoria='categoria'.$con;
				$imagen='imagen'.$con;
				//$imagen_original='imagen_original'.$con;
				$orden='orden'.$con;
				$estatus='estatus'.$con;
				
				$p_categoria=cadenabd($_POST[$categoria]);
				$varname=$_FILES[$imagen]['name'];
				//$varname2=$_FILES[$imagen_original]['name'];
				$p_descripcion_corta=cadenabd($_POST["descripcion_corta".$con]);
				$p_orden=$_POST[$orden]*1;
				$p_estatus=$_POST[$estatus];
				
				if(!empty($p_categoria) and
					!empty($p_estatus)
					):
					//Buscar el ultimo id de la imagen
					$c_gr=buscar("id_categoria","categorias","order by id_categoria desc limit 1");
					while($f_gr=$c_gr->fetch_assoc()):
						$id_categoria=$f_gr["id_categoria"];
						$id_categoria=$id_categoria+1;
					endwhile;
					if(empty($id_categoria)):
						$id_categoria=1;
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
								$nombre_archivo="img_".$id_categoria."_".$fechahora.$extension;
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
						$p_imagen_original="io".$id_categoria.$extension2;
						$nombre_archivo2="../images/".$p_imagen_original;
						move_uploaded_file($vartemp2,$nombre_archivo2);
					endif;
					unset($varname2);
					unset($extension2);
					unset($nombre_archivo2);
					*/
					
					//Registrar imagenes en categoria
					$i_c=insertar("categoria
										,imagen
										,descripcion_corta
										,orden
										,estatus"
										,"categorias"
										,"'".$p_categoria."'
										,'".$p_imagen."'
										,'".$p_descripcion_corta."'
										,".$p_orden."
										,'".$p_estatus."'");
					if(!$i_c):
						$arreglo_respuestas[]='<div class="error">No fue posible registrar la categoria '.$con.'</div>';
					else:
						$arreglo_respuestas[count($arreglo_respuestas)]='<div class="exito">Categoría '.$con.' registrada exitosamente.</div>';
					endif;				
				else:
					$arreglo_respuestas[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
				endif;
				unset($p_categoria);
				unset($p_imagen);
				//unset($p_imagen_original);
				unset($p_descripcion_corta,$p_orden);
				unset($p_estatus);
				unset($id_categoria);					
			endfor;
		endif;
	endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ESPECIALIDAD - NUEVO</title>
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
		<form action="./" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <fieldset>
      <legend>Nueva Categoría</legend>
                      <table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral">
                        <tr>
                        	<td></td>
                           <td>
                              <input id="agregar_categoria" name="agregar_categoria" type="button" class="link_5" value="Agregar categoria" style="clear:both;" />
                           </td>
                        </tr>
                        <tr>
                        	<td colspan="2">
                              <div id="div_categorias">
                              	<fieldset>
                                 <legend>Categoría 1</legend>
                                 <table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral">
                                    <tr>
                                       <td>Categoría</td>
                                       <td><input type="text" name="categoria1" style="width:300px;" maxlength="255" required>*</td>
                                    </tr>
                                    <tr>
                                       <td>Imagen</td>
                                       <td><input type="file" name="imagen1"/></td>
                                    </tr>
                                    <tr>
                                       <td></td>
                                       <td>Le sugerimos una imagen con 1170 X 780 pixeles y formato JPG</td>
                                    </tr>
                                    <tr>
                                       <td>Descripción corta</td>
                                       <td>
                                       	<textarea name="descripcion_corta1" style="width:400px; height:100px;"></textarea>
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
	<script>
		jQuery(document).ready(function(){
			jQuery("#agregar_categoria").click(function(event){
				var numero=(new Number(jQuery("#numero").val())*1)+1;
				if(numero>0 && (jQuery("#tbl_categoria"+numero).length)==0){
					url ="../agregar_categoria.php";
					var posting = jQuery.post(url,{numero:numero});
					posting.done(function(data){
						jQuery("#div_categorias").append(data);
						jQuery("#numero").val(numero);
					});
				}
			});
		});	
	</script>
</body>
</html>
<?
endif;
?>