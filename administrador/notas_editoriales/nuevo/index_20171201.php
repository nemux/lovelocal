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
				$nota='nota'.$con;
				$imagen='imagen'.$con;
				//$imagen_original='imagen_original'.$con;
				$orden='orden'.$con;
				$estatus='estatus'.$con;
				
				$p_id_seccion=$_POST["id_seccion".$con]*1;
				$p_nota=cadenabd($_POST[$nota]);
				$varname=$_FILES[$imagen]['name'];
				//$varname2=$_FILES[$imagen_original]['name'];
				$p_descripcion_corta=cadenabd($_POST["descripcion_corta".$con]);
				$p_descripcion_completa=cadenabd($_POST["descripcion_completa".$con]);
				$p_orden=$_POST[$orden]*1;
				$p_estatus=$_POST[$estatus];
				
				$p_categorias=$_POST["categorias".$con];
				
				$p_perfil=$_POST["perfil".$con];

				if(!empty($p_nota) and
					!empty($p_estatus)
					):
					//Buscar el ultimo id de la imagen
					$c_gr=buscar("id_nota","notas_editoriales","order by id_nota desc limit 1");
					while($f_gr=$c_gr->fetch_assoc()):
						$id_nota=$f_gr["id_nota"];
						$id_nota=$id_nota+1;
					endwhile;
					if(empty($id_nota)):
						$id_nota=1;
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
								$nombre_archivo="img_".$id_nota."_".$fechahora.$extension;
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
						$p_imagen_original="io".$id_nota.$extension2;
						$nombre_archivo2="../images/".$p_imagen_original;
						move_uploaded_file($vartemp2,$nombre_archivo2);
					endif;
					unset($varname2);
					unset($extension2);
					unset($nombre_archivo2);
					*/
					
					//Registrar imagenes en nota
					$i_c=insertar("id_seccion
										,nota
										,imagen
										,descripcion_corta
										,descripcion_completa
										,orden
										,id_perfil
										,estatus
										,fecha_hora_registro"
										,"notas_editoriales"
										,"'".$p_id_seccion."'
										,'".$p_nota."'
										,'".$p_imagen."'
										,'".$p_descripcion_corta."'
										,'".$p_descripcion_completa."'
										,".$p_orden."
										,'".$p_perfil."'
										,'".$p_estatus."'
										,'".$fecha_hora_registro."'");
					if(!$i_c):
						$arreglo_respuestas[]='<div class="error">No fue posible registrar la nota '.$con.'</div>';
					else:
						//Consultar id_nota
						$c_doc=buscar("id_nota","notas_editoriales","WHERE id_seccion='".$p_id_seccion."' AND nota='".$p_nota."' AND fecha_hora_registro='".$fecha_hora_registro."' ORDER BY id_nota DESC LIMIT 1");
						while($f_doc=$c_doc->fetch_assoc()):
							$id_nota=$f_doc["id_nota"];
						endwhile;
						if($id_nota>0):
							//CATEGORIAS
							//Borrar si es que existe alguno
							$c_cat=eliminar("categorias_notas","WHERE id_nota='".$id_nota."'");
							if(count($p_categorias)):
								foreach($p_categorias as $id_categoria):
									//Registrarlo
									$c_cat=insertar("id_categoria,id_nota","categorias_notas","'".$id_categoria."','".$id_nota."'");
								endforeach;
							endif;
							//CATEGORIAS						
							
							$arreglo_respuestas[count($arreglo_respuestas)]='<div class="exito">Nota '.$con.' registrada exitosamente.</div>';
						endif;
					endif;				
				else:
					$arreglo_respuestas[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
				endif;
				unset($p_id_seccion,$p_nota);
				unset($p_imagen);
				//unset($p_imagen_original);
				unset($p_descripcion_corta,$p_descripcion_completa,$p_orden);
				unset($p_estatus);
				unset($id_nota);					
			endfor;
		endif;
	endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NOTA EDITORIAL - NUEVO</title>
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
		<style>
      #form1{display: block; position:relative}
      #form1 .nicEdit-main{
         background-color:#FFFFFF;
      }
      </style>   
		<form action="./" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <fieldset>
      <legend>Nueva Nota</legend>
                      <table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral">
                        <tr>
                        	<td></td>
                           <td>
                              <input id="agregar_nota" name="agregar_nota" type="button" class="link_5" value="Agregar nota" style="clear:both;" />
                           </td>
                        </tr>
                        <tr>
                        	<td colspan="2" align="left">
                              <div id="div_notas" style="position:relative;">
                              	<fieldset>
                                 <legend>Nota 1</legend>
                                 <table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral">
                                    <tr>
                                       <td>Sección</td>
                                       <td>
                                       	<?
														$c_sec=buscar("id_seccion,seccion","secciones","WHERE estatus='activo' ORDER BY orden");
														?>
                                       	<select name="id_seccion1" required>
                                          	<option value="">Seleccione ...</option>
                                             <?
															if($c_sec->num_rows>0):
																while($f_sec=$c_sec->fetch_assoc()):
																	$id_seccion=$f_sec["id_seccion"];
																	$seccion=cadena($f_sec["seccion"]);
																	?>
                                                   <option value="<?=$id_seccion?>"><?=$seccion?></option>
                                                   <?
																	unset($id_seccion,$seccion);
																endwhile;
															endif;
															?>
                                          </select>
                                       	*
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Nota</td>
                                       <td><input type="text" name="nota1" style="width:300px;" maxlength="255" required>*</td>
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
                                       	<textarea name="descripcion_corta1" id="descripcion_corta1" style="width:600px;height:100px;"></textarea>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Descripción completa</td>
                                       <td>
                                       	<textarea name="descripcion_completa1" id="descripcion_completa1" style="width:600px;height:300px;"></textarea>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Orden</td>
                                       <td>
                                          <input type="number" min="0" name="orden1" step="1" style="width:50px;"/>
                                       </td>
                                    </tr>
												<?
                                    //Buscar categorías 
                                    $c_cat=buscar("id_categoria,categoria","categorias","WHERE estatus='activo' ORDER BY orden ASC");
                                    if($c_cat->num_rows>0):
                                       ?>
                                       <tr>
                                       	<td>Categorías</td>
                                          <td>
															<?
                                             while($f_cat=$c_cat->fetch_assoc()):
                                                $id_categoria=$f_cat["id_categoria"];
                                                $categoria=cadena($f_cat["categoria"]);
                                                ?>
                                                <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                                   <input type="checkbox" name="categorias1[]" value="<?=$id_categoria?>"> <?=$categoria?>
                                                </div>
                                                <?
                                                unset($id_categoria,$categoria);
                                             endwhile;
                                             ?>
                                          </td>
                                        </tr>
                                       <?
                                    endif;
                                    ?>
                                    <tr>
                                       <td>Estatus</td>
                                       <td><select name="estatus1">
                                          <option value="activo">Activo</option>
                                          <option value="inactivo">Inactivo</option>
                                       </select>
                                       </td>
                                    </tr>
                                    <tr>
                                    	<td>Perfil</td>
                                    	<td>
            <?php
             $c_per=buscar("per.id_perfil            
            ,per.local"
            ,"perfiles per
            LEFT OUTER JOIN
            estados est
            ON est.id_estado=per.id_estado"
            ," ORDER BY local ASC ",false);
            ?>
            <select name="perfil1">
            <option value="0">Aleatorio</option>
            <?php
  while($f_per=$c_per->fetch_assoc()):
  $id_perfil=$f_per["id_perfil"];  
  $local=cadena($f_per["local"]);
    ?>
    <option value="<?php echo $id_perfil; ?>"><?php echo $local; ?></option>
    <?php
  endwhile;
  ?>
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
				new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta1");
				new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa1");
            jQuery("#agregar_nota").click(function(event){
               var numero=(new Number(jQuery("#numero").val())*1)+1;
               if(numero>0 && (jQuery("#tbl_nota"+numero).length)==0){
                  url ="../agregar_nota.php";
                  var posting = jQuery.post(url,{numero:numero});
                  posting.done(function(data){
                     jQuery("#div_notas").append(data);
                     jQuery("#numero").val(numero);
							new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta"+numero);
							new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa"+numero);
                  });
               }
            });
			 	jQuery("#form1").submit(function(event){
					e.preventDefault();
					var numero=new Number(jQuery("#numero").val())*1;
					if(numero>0){
						for(var con=1;con<=numero;con++){
							nicEditors.findEditor("descripcion_corta"+con).saveContent();
							nicEditors.findEditor("descripcion_completa"+con).saveContent();							
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