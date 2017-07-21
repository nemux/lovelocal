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
$arreglo_respuestas=array();
$p_action=isset($_POST['action'])?$_POST['action']:"";
if($p_action=="send"):
	$p_arreglo_registros=$_POST['arreglo_registros'];
	if(count($p_arreglo_registros)>0):
	
		date_default_timezone_set('Mexico/General');
		$fechahora_actual=date("YmdHis");
	
		for($i=0;$i<count($p_arreglo_registros);$i++):
			$registro=$p_arreglo_registros[$i];
			
			$p_perfil=isset($_POST["perfil".$registro]) ? cadenabd($_POST["perfil".$registro]) : "";
			$p_nombres=isset($_POST["nombres".$registro]) ? cadenabd($_POST["nombres".$registro]) : "";
			$p_apellidos=isset($_POST["apellidos".$registro]) ? cadenabd($_POST["apellidos".$registro]) : "";
			$p_usuario=isset($_POST["usuario".$registro]) ? cadenabd($_POST["usuario".$registro]) : "";
			$p_password=isset($_POST["password".$registro]) ? cadenabd($_POST["password".$registro]) : "";
			$p_eliminar_imagen=isset($_POST["eliminar_imagen".$registro])?$_POST["eliminar_imagen".$registro]:"";
			$p_estatus=$_POST["estatus".$registro];
			$p_mostrar_home=isset($_POST["mostrar_home".$registro]) ? $_POST["mostrar_home".$registro] : "no";
			
			$p_numero_regalos=$_POST["numero_regalos".$registro]*1;

			$p_local=isset($_POST["local".$registro])? cadenabd($_POST["local".$registro]) : "";	
			$p_calle=isset($_POST["calle".$registro]) ? cadenabd($_POST["calle".$registro]) : "";
			$p_no_exterior=cadenabd($_POST["no_exterior".$registro]);
			$p_no_interior=cadenabd($_POST["no_interior".$registro]);
			$p_colonia=cadenabd($_POST["colonia".$registro]);
			$p_codigo_postal=cadenabd($_POST["codigo_postal".$registro]);
			$p_municipio=cadenabd($_POST["municipio".$registro]);
			$p_id_estado=isset($_POST["id_estado".$registro]) ? $_POST["id_estado".$registro]*1 : 0;

			$p_email=cadenabd($_POST["email".$registro]);
			$p_sitio_web=cadenabd($_POST["sitio_web".$registro]);
			$p_telefono=cadenabd($_POST["telefono".$registro]);
			$p_celular=cadenabd($_POST["celular".$registro]);
			$p_precio_de=eliminar_coma($_POST["precio_de".$registro]);
			$p_precio_a=eliminar_coma($_POST["precio_a".$registro]);		
			$p_descripcion_corta=isset($_POST["descripcion_corta".$registro]) ? cadenabd($_POST["descripcion_corta".$registro]) : "";
			$p_descripcion_completa=isset($_POST["descripcion_completa".$registro]) ? cadenabd($_POST["descripcion_completa".$registro]) : "";
			
			$p_categorias=$_POST["categorias".$registro];
			
			if(!empty($p_perfil)and
				!empty($p_nombres) and
				!empty($p_apellidos) and
				!empty($p_usuario) and
				!empty($p_password) and
				!empty($p_calle) and
				!empty($p_colonia) and
				!empty($p_codigo_postal) and
				!empty($p_municipio) and
				!empty($p_id_estado) and
				!empty($p_email) and
				!empty($p_numero_regalos)
				):
				$r_c=buscar("COUNT(*) AS total","perfiles","WHERE usuario='".$p_usuario."' 
							AND 	password='".$p_password."'
							and	id_perfil<>".$registro."");
				while($f_c=$r_c->fetch_assoc()):
					$total=$f_c['total'];
				endwhile;
				if($total>0):
					$arreglo_respuestas[]='<div class="error">Ya existe un perfil con este usuario '.cadena($p_usuario).'</div>';
				else:
					$c_se=buscar("imagen","perfiles","where id_perfil=".$registro);
					while($f_se=$c_se->fetch_assoc()):
						$imagen_actual=$f_se['imagen'];
					endwhile; unset($f_se,$c_se);
					
					if(!empty($_FILES["imagen".$registro]["name"])):
						$valid_formats= array("jpg","png","gif","JPG","PNG","GIF");
						
						//$max_file_size = 1024*1024; //1000 kb
						$max_file_size= 1048576*64; //64 MB
						$path= "../images/"; // Upload directory
					
						if($_FILES['imagen'.$registro]['error']==4):
							$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen".$registro]["name"].' tiene un error.</div>';
						endif;
						if($_FILES['imagen'.$registro]['error']==0):
							if($_FILES['imagen'.$registro]['size']>$max_file_size):
								$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen".$registro]["name"].' es muy grande.</div>';
							elseif(!in_array(pathinfo($_FILES["imagen".$registro]["name"], PATHINFO_EXTENSION), $valid_formats)):
								$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen".$registro]["name"].' no es un formato válido</div>';
							else: // No error found! Move uploaded files 
								$extension=".".pathinfo($_FILES["imagen".$registro]["name"], PATHINFO_EXTENSION);
								$nombre_archivo="img_".$registro."_".$fechahora_actual.$extension;
								if(move_uploaded_file($_FILES["imagen".$registro]["tmp_name"],$path.$nombre_archivo)):
									$p_imagen=$nombre_archivo;
									if(!empty($imagen_actual) and file_exists("../images/".$imagen_actual)):
										unlink("../images/".$imagen_actual);
									endif;
								endif;
								unset($extension,$nombre_archivo);
							endif;
						endif;
						unset($valid_formats,$max_file_size,$path,$count);
					elseif($p_eliminar_imagen=="on"):
						if(!empty($imagen_actual) and file_exists("../images/".$imagen_actual)):
							unlink("../images/".$imagen_actual);
						endif;
						$p_imagen="";
					endif;
	
					$actualizar="id_estado='".$p_id_estado."'
									,perfil='".$p_perfil."'
									,nombres='".$p_nombres."'
									,apellidos='".$p_apellidos."'
									,usuario='".$p_usuario."'
									,password='".$p_password."'
									,local='".$p_local."'
									";
					if(!empty($p_imagen) or $p_eliminar_imagen=="on"):
						$actualizar.=",imagen='".$p_imagen."'";
					endif;
					$actualizar.=",calle='".$p_calle."'
									,no_exterior='".$p_no_exterior."'
									,no_interior='".$p_no_interior."'
									,colonia='".$p_colonia."'
									,codigo_postal='".$p_codigo_postal."'
									,municipio='".$p_municipio."'
									,email='".$p_email."'
									,sitio_web='".$p_sitio_web."'
									,telefono='".$p_telefono."'
									,celular='".$p_celular."'
									,precio_de='".$p_precio_de."'
									,precio_a='".$p_precio_a."'
									,descripcion_corta='".$p_descripcion_corta."'
									,descripcion_completa='".$p_descripcion_completa."'
									,estatus='".$p_estatus."'
									,mostrar_home='".$p_mostrar_home."'
									";
					$c_id=actualizar("".$actualizar."","perfiles","where id_perfil=".$registro);
					if(!$c_id):
						$arreglo_respuestas[]='<div class="error">No fue posible actualizar este perfil '.cadena($p_usuario).'</div>';
					else:
					
						//REGALOS
						if(!empty($p_numero_regalos)):
							for($con_reg=1;$con_reg<=$p_numero_regalos;$con_reg++):
								$p_id_regalo=$_POST["id_regalo".$con_reg];
								$p_regalo=cadenabd($_POST["regalo".$con_reg]);
								if(!empty($p_regalo)):
									if(!empty($p_id_regalo)):
										//Actualizar
										$c_reg=actualizar("regalo='".$p_regalo."'","regalos_perfiles","WHERE id_regalo='".$p_id_regalo."' AND id_perfil='".$registro."'");
									else:
										//Registrar
										$c_reg=insertar("id_perfil,regalo,estatus","regalos_perfiles","'".$id_perfil."','".$p_regalo."','activo'");
									endif;
								endif;
								unset($p_id_regalo,$p_regalo);
							endfor;
						endif;
						//REGALOS							
						
						//CATEGORIAS
						//Borrar si es que existe alguno
						$c_cat=eliminar("categorias_perfiles","WHERE id_perfil='".$registro."'");
						if(count($p_categorias)):
							foreach($p_categorias as $id_categoria):
								//Registrarlo
								$c_cat=insertar("id_categoria,id_perfil","categorias_perfiles","'".$id_categoria."','".$registro."'");
							endforeach;
						endif;
						//CATEGORIAS						
						
						$arreglo_respuestas[]='<div class="exito">Perfil '.cadena($p_usuario).' actualizado exitosamente.</div>';
					endif;
				endif;
				unset($total,$p_imagen,$p_portada);
			else:
				$arreglo_respuestas[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
			endif;
			
			unset($p_perfil
			,$p_nombres
			,$p_apellidos
			,$p_usuario
			,$p_password
			,$p_eliminar_imagen
			,$p_estatus
			,$p_mostrar_home
			
			,$p_numero_regalos
			
			,$p_local
			,$p_calle
			,$p_no_exterior
			,$p_no_interior
			,$p_colonia
			,$p_codigo_postal
			,$p_municipio
			,$p_id_estado
			
			,$p_email
			,$p_sitio_web
			,$p_telefono
			,$p_celular
			,$p_precio_de
			,$p_precio_a
			,$p_descripcion_corta
			,$p_descripcion_completa
			
			,$p_categorias
			);
			
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
<title>PERFILES - ACTUALIZAR</title>
 <!-- Favicon -->
  <link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">
<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
<link href="../../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<? 
include("../../includes/ajuste.php");
?>
<script type="text/javascript" language="javascript" src="../../js/funciones.js"></script>
<script type="text/javascript" language="javascript" src="../ajax.js"></script>
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
      <?
		if(count($p_arreglo_registros)>0):
			for($i=0;$i<count($p_arreglo_registros);$i++):
				$registro=$p_arreglo_registros[$i];
				$c_id=buscar("per.perfil
									,per.nombres
									,per.apellidos
									,per.usuario
									,per.password
									,per.imagen
									,per.local
									,per.calle
									,per.no_exterior
									,per.no_interior
									,per.colonia
									,per.codigo_postal
									,per.municipio
									,per.id_estado
									,per.email
									,per.sitio_web
									,per.telefono
									,per.celular
									,per.precio_de
									,per.precio_a
									,per.descripcion_corta
									,per.descripcion_completa
									,per.estatus
									,per.mostrar_home"
								,"perfiles per"
								,"where per.id_perfil=".$registro);
				while($f_c=$c_id->fetch_assoc()):
					$perfil=cadena($f_c["perfil"]);
					$nombres=cadena($f_c["nombres"]);
					$apellidos=cadena($f_c["apellidos"]);
					$usuario=cadena($f_c["usuario"]);
					$password=cadena($f_c["password"]);
					$imagen=$f_c["imagen"];
					$estatus=$f_c["estatus"];
					$mostrar_home=$f_c["mostrar_home"];
					
					$local=cadena($f_c["local"]);
					$calle=cadena($f_c["calle"]);
					$no_exterior=cadena($f_c["no_exterior"]);
					$no_interior=cadena($f_c["no_interior"]);		
					$colonia=cadena($f_c["colonia"]);		
					$codigo_postal=cadena($f_c["codigo_postal"]);
					$municipio=cadena($f_c["municipio"]);
					$id_estado_perfil=$f_c["id_estado"];
					
					$email=cadena($f_c["email"]);
					$sitio_web=cadena($f_c["sitio_web"]);
					$telefono=cadena($f_c["telefono"]);		
					$celular=cadena($f_c["celular"]);
					$precio_de=$f_c["precio_de"];
					$precio_a=$f_c["precio_a"];					
					$descripcion_corta=cadena($f_c["descripcion_corta"]);
					$descripcion_completa=cadena($f_c["descripcion_completa"]);
				endwhile;
				//Buscar categorias
				$c_cat=buscar("id_categoria","categorias_perfiles","WHERE id_perfil='".$registro."'");
				$arreglo_categorias=array();
				while($f_cat=$c_cat->fetch_assoc()):
					$arreglo_categorias[]=$f_cat["id_categoria"];
				endwhile;
				?>
            <div class="row" style="clear:both;">
            <!--COLUMNA 1-->
		      <div style="width:50%; float:left">
            <fieldset>
            <legend>Datos Del Perfil</legend>
            <table border="0" cellpadding="3" cellspacing="1" align="left">
               <tr>
                  <td>Perfil</td>
                  <td>
                     <select class="perfil" name="perfil<?=$registro?>" registro="<?=$registro?>">
                        <option value="Perfil 1" <? if($perfil=="Perfil 1"): ?> selected="selected" <? endif;?>>Perfil 1</option>
                        <option value="Perfil 2" <? if($perfil=="Perfil 2"): ?> selected="selected" <? endif;?>>Perfil 2</option>
                        <option value="Perfil 3" <? if($perfil=="Perfil 3"): ?> selected="selected" <? endif;?>>Perfil 3</option>
                     </select>
                  </td>
               </tr>
               <tr>
                  <td width="15%">Nombre(s)</td>
                  <td width="85%"><input type="text" name="nombres<?=$registro?>" value="<?=$nombres?>" style="width:400px;" maxlength="255" required="required"> *</td>
               </tr>
               <tr>
                  <td>Apellidos</td>
                  <td><input type="text" name="apellidos<?=$registro?>" value="<?=$apellidos?>" style="width:400px;" maxlength="255" required="required"> *</td>
               </tr>
               <tr>
                  <td>Usuario</td>
                  <td><input type="text" name="usuario<?=$registro?>" value="<?=$usuario?>" style="width:100px;" maxlength="100" required="required"> *</td>
               </tr>
               <tr>
                  <td>Contraseña</td>
                  <td><input type="password" name="password<?=$registro?>" value="<?=$password?>" style="width:100px;" maxlength="100" required="required"> *</td>
               </tr>
               <tr>
                  <td>Estatus</td>
                  <td>
                     <select name="estatus<?=$registro?>">
                        <option value="activo" <?php if($estatus=="activo"): ?> selected <?php endif;?>>Activo</option>
                        <option value="inactivo" <?php if($estatus=="inactivo"): ?> selected <?php endif;?>>Inactivo</option>
                     </select>
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td><input type="checkbox" name="mostrar_home<?=$registro?>" value="si" <? if($mostrar_home=="si"):?> checked="checked"<? endif;?>>Mostrar en Home
                  </td>
               </tr>
               </table>
            </fieldset>      	
            
            <fieldset>
            <legend>Datos del Local</legend>
               <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
               <tr>
                  <td>Local</td>
                  <td><input type="text" name="local<?=$registro?>" value="<?=$local?>" style="width:400px;" maxlength="255" required="required"> *</td>
            	</tr>
               <?
               if(!empty($imagen) and file_exists("../images/".$imagen)):
                  ?>
                  <tr>
                    <td class="text_gral">Foto actual</td>
                    <td class="text_gral">
                     <img src="../images/<?=$imagen?>" style="max-width:160px;">
                    </td>
                  </tr>
                  <tr>
                    <td class="text_gral"></td>
                    <td class="text_gral">
                        <input type="checkbox" name="eliminar_imagen<?=$registro?>">Eliminar foto
                    </td>
                  </tr>
                  <tr>
                    <td class="text_gral">Sustituir por:</td>
                    <td class="text_gral"><input type="file" name="imagen<?=$registro?>"/>
                        <br />
                        <span>Le sugerimos una imagen de 600 x 400 pixeles y formato JPG</span>                                      
                    </td>
                  </tr>
                  <?
               else:
                  ?>
                  <tr>
                     <td class="text_gral">Foto</td>
                     <td class="text_gral"><input type="file" name="imagen<?=$registro?>"/>
                     <br />
                     <span>Le sugerimos una imagen de  600 x 400 pixeles y formato JPG</span>                                      
                     </td>
                  </tr>
                  <?
               endif;
               ?>                       
               <tr>
                  <td>Calle</td>
                  <td><input type="text" name="calle<?=$registro?>" value="<?=$calle?>" style="width:400px;" maxlength="255" required="required"> *</td>
               </tr>
               <tr>
                  <td>Número exterior </td>
                  <td><input type="text" name="no_exterior<?=$registro?>" value="<?=$no_exterior?>" style="width:100px;" maxlength="100"></td>
               </tr>
               <tr>
                  <td>Número interior </td>
                  <td><input type="text" name="no_interior<?=$registro?>" value="<?=$no_interior?>" style="width:100px;" maxlength="100"></td>
               </tr>
               <tr>
                  <td>Colonia</td>
                  <td><input type="text" name="colonia<?=$registro?>" value="<?=$colonia?>" style="width:400px;" maxlength="255" required="required"> *</td>
               </tr>
               <tr>
                  <td>Código Postal</td>
                  <td><input type="text" name="codigo_postal<?=$registro?>" value="<?=$codigo_postal?>" style="width:100px;" maxlength="100" required="required"> *</td>
               </tr>
               <tr>
                  <td>Delegación o Municipio</td>
                  <td><input type="text" name="municipio<?=$registro?>" value="<?=$municipio?>" style="width:400px;" maxlength="255" required="required"> *</td>
               </tr>
               <tr>
                  <td>Estado</td>
                  <td>
                     <?
                     $c_est=buscar("id_estado,estado","estados","ORDER BY estado ASC");
                     ?>
                     <select name="id_estado<?=$registro?>" required>
                        <option value="">Seleccione ...</option>
                        <?
                        if($c_est->num_rows>0):
                           while($f_est=$c_est->fetch_assoc()):
                              $id_estado=$f_est["id_estado"];
                              $estado=cadena($f_est["estado"]);
                              ?>
                              <option value="<?=$id_estado?>" <? if($id_estado==$id_estado_perfil): ?> selected="selected" <? endif;?>><?=$estado?></option>
                              <?
                              unset($id_estado,$estado);
                           endwhile; unset($f_est);
                        endif; unset($c_est);
                        ?>
                     </select>
                   *</td>
               </tr>
               <tr>
                  <td>Email</td>
                  <td><input type="email" name="email<?=$registro?>" value="<?=$email?>" style="width:400px;" maxlength="255" required/> *</td>
               </tr>
               <tr>
                  <td>Sitio web</td>
                  <td>
                     <input type="text" name="sitio_web<?=$registro?>" value="<?=$sitio_web?>" style="width:200px;" maxlength="255"/>
                  </td>                  
               </tr>
               <tr>
                  <td>Teléfono(s):</td>
                  <td><input type="text" name="telefono<?=$registro?>" value="<?=$telefono?>" style="width:200px;" maxlength="255"/></td>
               </tr>
               <tr>
                  <td>Celular:</td>	
                  <td><input type="text" name="celular<?=$registro?>" value="<?=$celular?>" style="width:200px;" maxlength="255"/></td>
               </tr>
               <tr>
                  <td>Rango de precios</td>
                  <td>De: <input type="number" name="precio_de<?=$registro?>" value="<?=$precio_de?>" step="1.00" placeholder="100.00"> A: <input type="number" name="precio_a<?=$registro?>" value="<?=$precio_a?>" step="1.00" placeholder="100.00"></td>
               </tr>
            </table>
            </fieldset>
               
            <fieldset>
            <legend>Descripción breve del lugar</legend>
            <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
               <tr>
                  <td colspan="2">
                     <textarea name="descripcion_corta<?=$registro?>" id="descripcion_corta<?=$registro?>" style="width:600px; height:100px;"><?=$descripcion_corta?></textarea>
                  </td>
               </tr>
             </table>
            </fieldset>

            <fieldset id="seccion_descripcion_completa<?=$registro?>" <? if($perfil=="Perfil 1"): ?>style="display:none";<? endif;?>>
            <legend>Descripción completa del lugar</legend>
            <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
               <tr>
                  <td colspan="2">
                     <textarea name="descripcion_completa<?=$registro?>" id="descripcion_completa<?=$registro?>" style="width:600px; height:100px;"><?=$descripcion_completa?></textarea>
                  </td>
               </tr>
             </table>
            </fieldset>
            
            <fieldset>
            <legend>Regalo por primera visita</legend>
            <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
               <tr>
                  <td colspan="2">
							<?
                     $con_reg=0;
                     $c_reg=buscar("id_regalo,regalo","regalos_perfiles","WHERE id_perfil='".$registro."'");
							$fireg=$c_reg->num_rows;
                     if($fireg>0):
                        ?>
                        <input name="numero_regalos<?=$registro?>" id="numero_regalos<?=$registro?>" type="hidden" value="<?=$fireg?>">
                        <div id="div_regalos<?=$registro?>">
                        <?
                        while($f_reg=$c_reg->fetch_assoc()):
                           $con_reg++;
                           $id_regalo=$f_reg["id_regalo"];
                           $regalo=cadena($f_reg["regalo"]);
                           ?>
                           <table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral">
                              <tr>
                                 <td>Regalo<input type="hidden" name="id_regalo<?=$con_reg?>" value="<?=$id_regalo?>"/></td>
                                 <td><input type="text" name="regalo<?=$con_reg?>" value="<?=$regalo?>" style="width:90%;" maxlength="255" required>*</td>
                              </tr>
                           </table>   
                           <?
                           unset($id_regalo,$regalo);
                        endwhile;
								?>
	                     </div>
                        <?
							else:
								$con_reg=1;
								?>
                        <input name="numero_regalos<?=$registro?>" id="numero_regalos<?=$registro?>" type="hidden" value="<?=$con_reg?>">
                        <div id="div_regalos<?=$registro?>">
                           <table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral">
                              <tr>
                                 <td>Regalo<input type="hidden" name="id_regalo<?=$con_reg?>" value=""/></td>
                                 <td><input type="text" name="regalo<?=$con_reg?>" value="" style="width:90%;" maxlength="255" required>*</td>
                              </tr>
                           </table>   
	                     </div>
                        <?
                     endif;
							$c_reg->free();
							unset($fireg);
                     ?>
                  </td>
               </tr>
             </table>
            </fieldset>     
            
				<?
            //Buscar categorías 
            $c_cat=buscar("id_categoria,categoria","categorias","WHERE estatus='activo' ORDER BY orden ASC");
            if($c_cat->num_rows>0):
               ?>
               <fieldset>
               <legend>Categorías</legend>
               <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
                  <tr>
                     <td colspan="2">
                        <?
                        while($f_cat=$c_cat->fetch_assoc()):
                           $id_categoria=$f_cat["id_categoria"];
                           $categoria=cadena($f_cat["categoria"]);
                           ?>
                           <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                              <input type="checkbox" name="categorias<?=$registro?>[]" <? if(in_array($id_categoria,$arreglo_categorias)): ?> checked="checked" <? endif;?> value="<?=$id_categoria?>"> <?=$categoria?>
                           </div>
                           <?
                           unset($id_categoria,$categoria);
                        endwhile;
                        ?>
                     </td>
                  </tr>
               </table>
               </fieldset>
               <?
            endif;
            ?>

            <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
               <tr>
                 <td>
                   <input type="hidden" name="arreglo_registros[]" value="<?=$registro?>" />
                 </td>
                 <td>
                   <input type="submit" class="link_5" value="Registrar"/>
                 </td>
               </tr>
             </table>
             
            </div>
				<!--COLUMNA 1-->
      
            <!--COLUMNA 2-->            
            <div style="width:50%; float:left">
            </div>
            <!--COLUMNA 2-->    
            
            </div>
            
				<?
            unset($id_estado_perfil
				,$perfil
				,$nombres
				,$apellidos
				,$usuario
				,$password
				,$imagen
				,$estatus
				,$mostrar_home
				
				,$calle
				,$no_exterior
				,$no_interior
				,$colonia
				,$codigo_postal
				,$municipio
				
				,$email
				,$sitio_web
				,$telefono
				,$celular
				,$precio_de
				,$precio_a
				,$descripcion_corta
				,$descripcion_completa
				,$arreglo_categorias
				);
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
<script src="../../../assets/nicEdit/nicEdit.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function(){
	<?
	if(count($p_arreglo_registros)>0):
		foreach($p_arreglo_registros as $registro):
			?>
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta<?=$registro?>");
			if(jQuery("#descripcion_completa<?=$registro?>").length>0){
				new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa<?=$registro?>");
			}
			<?
		endforeach;
	endif;
	?>
	jQuery(".perfil").change(function(event){
		var perfil=jQuery(this).val();
		var registro=new Number(jQuery(this).attr("registro"))*1;
		if(perfil=="Perfil 1"){
			jQuery("#seccion_descripcion_completa"+registro).css("display","none");
			/*
			jQuery("#seccion_fotos").css("display","none");
			jQuery("#seccion_productos").css("display","none");
			jQuery("#seccion_videos").css("display","none");
			jQuery("#seccion_articulos").css("display","none");
			*/
		}
		else if(perfil==="Perfil 2"){
			jQuery("#seccion_descripcion_completa"+registro).css("display","block");
			/*
			jQuery("#seccion_fotos").css("display","block");
			jQuery("#seccion_productos").css("display","block");
			jQuery("#seccion_videos").css("display","none");
			jQuery("#seccion_articulos").css("display","none");
			*/
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa"+registro);
		}
		else if(perfil==="Perfil 3"){
			jQuery("#seccion_descripcion_completa"+registro).css("display","block");
			/*
			jQuery("#seccion_fotos").css("display","block");
			jQuery("#seccion_productos").css("display","block");
			jQuery("#seccion_videos").css("display","block");
			jQuery("#seccion_articulos").css("display","block");
			*/
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa"+registro);
			/*
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta_articulo1");
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa_articulo1");
			*/
		}
	});
});
</script>
</body>
</html>
<?
endif;
?>