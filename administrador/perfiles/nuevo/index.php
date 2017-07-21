<?
session_start();
//ini_set("display_errors","On");
$se_id_usuario=$_SESSION["s_id_usuario"];
$arreglo_respuestas=array();
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
	
	$p_action=isset($_POST['action'])?$_POST['action']:"";
	if($p_action=="send"):
	
		date_default_timezone_set('Mexico/General');
		$fechahora_actual=date("YmdHis");
		$fecha_hora_registro=date("Y-m-d H:i:s");
		
		$p_perfil=cadenabd($_POST["perfil"]);
		$p_nombres=cadenabd($_POST["nombres"]);
		$p_apellidos=cadenabd($_POST["apellidos"]);
		$p_usuario=cadenabd($_POST["usuario"]);
		$p_password=cadenabd($_POST["password"]);
		$p_estatus=$_POST["estatus"];

		$p_local=isset($_POST["local"])? cadenabd($_POST["local"]) : "";
		$p_calle=cadenabd($_POST["calle"]);
		$p_no_exterior=cadenabd($_POST["no_exterior"]);
		$p_no_interior=cadenabd($_POST["no_interior"]);
		$p_colonia=cadenabd($_POST["colonia"]);
		$p_codigo_postal=cadenabd($_POST["codigo_postal"]);
		$p_municipio=cadenabd($_POST["municipio"]);
		$p_id_estado=$_POST["id_estado"]*1;

		$p_email=cadenabd($_POST["email"]);
		$p_sitio_web=cadenabd($_POST["sitio_web"]);
		$p_telefono=cadenabd($_POST["telefono"]);
		$p_celular=cadenabd($_POST["celular"]);
		$p_precio_de=eliminar_coma($_POST["precio_de"]);
		$p_precio_a=eliminar_coma($_POST["precio_a"]);		
		$p_descripcion_corta=isset($_POST["descripcion_corta"]) ? cadenabd($_POST["descripcion_corta"]) : "";
		$p_descripcion_completa=isset($_POST["descripcion_completa"]) ? cadenabd($_POST["descripcion_completa"]) : "";
		$p_mostrar_home=isset($_POST["mostrar_home"]) ? $_POST["mostrar_home"] : "no";
		
		$p_numero_regalos=$_POST["numero_regalos"]*1;
		$p_numero_recompensas=$_POST["numero_recompensas"]*1;
		
		$p_numero_fotos=isset($_POST["numero_fotos"]) ? $_POST["numero_fotos"]*1 :"";
		$p_numero_productos=isset($_POST["numero_productos"]) ? $_POST["numero_productos"]*1 :"";
		$p_numero_videos=isset($_POST["numero_videos"]) ? $_POST["numero_videos"]*1 :"";
		$p_numero_articulos=isset($_POST["numero_articulos"]) ? $_POST["numero_articulos"]*1 :"";		
		
		$p_categorias=$_POST["categorias"];
		$p_servicios=$_POST["servicios"];
		if(!empty($p_perfil) and 
			!empty($p_nombres) and
			!empty($p_apellidos) and
			!empty($p_usuario) and
			!empty($p_password) and
			!empty($p_estatus) and			
			!empty($p_calle) and
			!empty($p_colonia) and
			!empty($p_codigo_postal) and
			!empty($p_municipio) and
			!empty($p_id_estado) and
			!empty($p_email) /*and
			!empty($p_numero_recompensas) and
			!empty($p_numero_regalos)*/
			):
			$r_c=buscar("COUNT(*) AS total","perfiles","WHERE usuario='".$p_usuario."' AND 	password='".$p_password."'");
			while($f_c=$r_c->fetch_assoc()):
				$total=$f_c['total'];
			endwhile;
			if($total>0):
				$arreglo_respuestas[]='<div class="error">Ya existe un perfil registrado con este usuario.</div>';
			else:
				$id_perfil=0;
				$c_p=buscar("id_perfil","perfiles","ORDER BY id_perfil DESC LIMIT 1");
				while($f_p=$c_p->fetch_assoc()):
					$id_perfil=$f_p['id_perfil'];
				endwhile;
				$id_perfil=$id_perfil+1;
				
				if(!empty($_FILES["imagen"]["name"])):
					$valid_formats= array("jpg","png","gif","JPG","PNG","GIF");
					
					//$max_file_size = 1024*1024; //1000 kb
					$max_file_size= 1048576*64; //64 MB
					$path= "../images/"; // Upload directory
					$count= 0;
				
					if($_FILES['imagen']['error']==4):
						$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen"]["name"].' tiene un error.</div>';
					endif;
					if($_FILES['imagen']['error']==0):
						if($_FILES['imagen']['size']>$max_file_size):
							$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen"]["name"].' es muy grande.</div>';
						elseif(!in_array(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION), $valid_formats)):
							$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen"]["name"].' no es un formato válido</div>';
						else: // No error found! Move uploaded files 
							$extension=".".pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
							$nombre_archivo="img_".$id_perfil."_".$count."_".$fechahora_actual.$extension;
							if(move_uploaded_file($_FILES["imagen"]["tmp_name"],$path.$nombre_archivo)):
								$p_imagen=$nombre_archivo;
								$count++; // Number of successfully uploaded files
							endif;
							unset($extension,$nombre_archivo);
						endif;
					endif;
					unset($max_file_size,$path,$count);
				endif;
				$i_c=insertar("id_estado
									,perfil
									,nombres
									,apellidos
									,usuario
									,password
									,local
									,imagen
									,calle
									,no_exterior
									,no_interior
									,colonia
									,codigo_postal
									,municipio
									,email
									,sitio_web
									,telefono
									,celular
									,precio_de
									,precio_a
									,descripcion_corta
									,descripcion_completa
									,estatus
									,fecha_hora_registro
									,mostrar_home"
									,"perfiles"
									,"'".$p_id_estado."'
									,'".$p_perfil."'
									,'".$p_nombres."'
									,'".$p_apellidos."'
									,'".$p_usuario."'
									,'".$p_password."'
									,'".$p_local."'
									,'".$p_imagen."'
									,'".$p_calle."'
									,'".$p_no_exterior."'
									,'".$p_no_interior."'
									,'".$p_colonia."'
									,'".$p_codigo_postal."'
									,'".$p_municipio."'
									,'".$p_email."'
									,'".$p_sitio_web."'
									,'".$p_telefono."'
									,'".$p_celular."'	
									,'".$p_precio_de."'
									,'".$p_precio_a."'
									,'".$p_descripcion_corta."'
									,'".$p_descripcion_completa."'
									,'".$p_estatus."'
									,'".$fecha_hora_registro."'
									,'".$p_mostrar_home."'",false);
				//var_dump($i_c);
				if($i_c):
					//Consultar doctor
					$c_doc=buscar("id_perfil","perfiles","WHERE id_estado='".$p_id_estado."' AND perfil='".$p_perfil."' AND nombres='".$p_nombres."' AND apellidos='".$p_apellidos."' AND usuario='".$p_usuario."' AND password='".$p_password."' AND local='".$p_local."' ORDER BY id_perfil DESC LIMIT 1");
					while($f_doc=$c_doc->fetch_assoc()):
						$id_perfil=$f_doc["id_perfil"];
					endwhile;
					if($id_perfil>0):
						//REGALOS
						if(!empty($p_numero_regalos)):
							for($con_reg=1;$con_reg<=$p_numero_regalos;$con_reg++):
								$p_regalo=cadenabd($_POST["regalo".$con_reg]);
								if(!empty($p_regalo)):
									//Registrar
									$c_reg=insertar("id_perfil,regalo,estatus","regalos_perfiles","'".$id_perfil."','".$p_regalo."','activo'");
								endif;
								unset($p_regalo);
							endfor;
						endif;
						//REGALOS							

						//RECOMPENSAS
						if(!empty($p_numero_recompensas)):
							for($con_rec=1;$con_rec<=$p_numero_recompensas;$con_rec++):
								$p_recompensa=cadenabd($_POST["recompensa".$con_rec]);
								$p_estatus_recompensa=cadenabd($_POST["estatus_recompensa".$con_rec]);
								if(!empty($p_recompensa)):
									//Registrar
									$c_rec=insertar("id_perfil,recompensa,estatus","recompensas_perfiles","'".$id_perfil."','".$p_recompensa."','".$p_estatus_recompensa."'");
								endif;
								unset($p_recompensa,$p_estatus);
							endfor;
						endif;
						//RECOMPENSAS
						
						//FOTOS
						if(($p_perfil=="Perfil 2" or $p_perfil=="Perfil 3") and !empty($p_numero_fotos)):
							$valid_formats= array("jpg","png","gif","JPG","PNG","GIF");
							$max_file_size= 1048576*64; //64 MB
							$path= "../../galeria_fotos/images/"; // Upload directory
							for($con_fot=1;$con_fot<=$p_numero_fotos;$con_fot++):
								$p_titulo_foto=cadenabd($_POST["titulo_foto".$con_fot]);
								if(!empty($_FILES["foto".$con_fot]['name'])):
									if($_FILES["foto".$con_fot]['error']==4):
										$arreglo_respuestas[] = '<div class="error">'.$_FILES["foto".$con_fot]["name"].' tiene un error.</div>';
									endif;
									if($_FILES["foto".$con_fot]['error']==0):
										if($_FILES["foto".$con_fot]['size']>$max_file_size):
											$arreglo_respuestas[] = '<div class="error">'.$_FILES["foto".$con_fot]["name"].' es muy grande.</div>';
										elseif(!in_array(pathinfo($_FILES["foto".$con_fot]["name"], PATHINFO_EXTENSION), $valid_formats)):
											$arreglo_respuestas[] = '<div class="error">'.$_FILES["foto".$con_fot]["name"].' no es un formato válido</div>';
										else: // No error found! Move uploaded files 
											$extension=".".pathinfo($_FILES["foto".$con_fot]["name"], PATHINFO_EXTENSION);
											$nombre_archivo="img_".$id_perfil."_".$con_fot."_".$fechahora_actual.$extension;
											if(move_uploaded_file($_FILES["foto".$con_fot]["tmp_name"],$path.$nombre_archivo)):
												$p_foto=$nombre_archivo;
												//Registrar
												$c_fot=insertar("id_perfil,foto,titulo","fotos_perfiles","'".$id_perfil."','".$p_foto."','".$p_titulo_foto."'");
											endif;
											unset($extension,$nombre_archivo);
										endif;
									endif;
								endif;	
								unset($p_titulo_foto,$p_foto);
							endfor;
							unset($valid_formats,$max_file_size,$path);
						endif;
						//FOTOS
						
						//PRODUCTOS							
						if(($p_perfil=="Perfil 2" or $p_perfil=="Perfil 3") and !empty($p_numero_productos)):
							//var_dump($p_numero_productos);	
							$valid_formats= array("jpg","png","gif","JPG","PNG","GIF");
							$max_file_size= 1048576*64; //64 MB
							$path= "../../productos/images/"; // Upload directory
							for($con_pro=1;$con_pro<=$p_numero_productos;$con_pro++):
								$p_tipo_producto=cadenabd($_POST["tipo_producto".$con_pro]);
								$p_titulo_producto=cadenabd($_POST["titulo_producto".$con_pro]);
								$p_imagen_producto="";
								$p_descripcion_producto=cadenabd($_POST["descripcion_producto".$con_pro]);
								if(!empty($_FILES["imagen_producto".$con_pro]['name'])):
									if($_FILES["imagen_producto".$con_pro]['error']==4):
										$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen_producto".$con_pro]["name"].' tiene un error.</div>';
									endif;
									if($_FILES["imagen_producto".$con_pro]['error']==0):
										if($_FILES["imagen_producto".$con_pro]['size']>$max_file_size):
											$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen_producto".$con_pro]["name"].' es muy grande.</div>';
										elseif(!in_array(pathinfo($_FILES["imagen_producto".$con_pro]["name"], PATHINFO_EXTENSION), $valid_formats)):
											$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen_producto".$con_pro]["name"].' no es un formato válido</div>';
										else: // No error found! Move uploaded files 
											$extension=".".pathinfo($_FILES["imagen_producto".$con_pro]["name"], PATHINFO_EXTENSION);
											$nombre_archivo="img_".$id_perfil."_".$con_pro."_".$fechahora_actual.$extension;
											if(move_uploaded_file($_FILES["imagen_producto".$con_pro]["tmp_name"],$path.$nombre_archivo)):
												$p_imagen_producto=$nombre_archivo;
											endif;
											unset($extension,$nombre_archivo);
										endif;
									endif;
								endif;	

								if(!empty($p_titulo_producto)):
									//var_dump($p_imagen_producto." ".$id_perfil." ".$p_titulo_producto." ".$p_tipo_producto." ".$p_descripcion_producto);
									//Registrar
									//$c_pro=insertar("id_perfil,tipo,producto, imagen, descripcion_corta","productos_perfiles","'".$id_perfil."','".$p_tipo_producto."','".$p_titulo_producto."','".$p_imagen_producto."','".$p_descripcion_producto."'");
									//var_dump($c_pro);
								$c_pro=insertar("id_perfil,producto,tipo, descripcion_corta, imagen","productos_perfiles","'".$id_perfil."','".$p_titulo_producto."','".$p_tipo_producto."', '".$p_descripcion_producto."', '".$p_imagen_producto."'");

								/*if(!$c_pro):
									$arreglo_respuestas[]='<div class="error">No fue posible registrar tu producto.</span>';
								endif;*/
								endif;	
								unset($p_tipo_producto,$p_titulo_producto, $p_descripcion_producto, $p_imagen_producto);
							endfor;
							unset($valid_formats,$max_file_size,$path);
						endif;
						//PRODUCTOS
						
						//VIDEOS
						if($p_perfil=="Perfil 3" and !empty($p_numero_videos)):
							for($con_vid=1;$con_vid<=$p_numero_videos;$con_vid++):
								$p_titulo_video=cadenabd($_POST["titulo_video".$con_vid]);
								$p_video=cadenabd($_POST["video".$con_vid]);									
								if(!empty($p_video)):
									//Registrar
									$c_vid=insertar("id_perfil,titulo,video","videos_perfiles","'".$id_perfil."','".$p_titulo_video."','".$p_video."'");
								endif;	
								unset($p_titulo_video,$p_video);
							endfor;
						endif;
						//VIDEOS
						
						//ARTICULOS
						if($p_perfil=="Perfil 3" and !empty($p_numero_articulos)):
							$valid_formats= array("jpg","png","gif","JPG","PNG","GIF");
							$max_file_size= 1048576*64; //64 MB
							$path= "../../articulos/images/"; // Upload directory
							for($con_art=1;$con_art<=$p_numero_articulos;$con_art++):
								$p_articulo=cadenabd($_POST["articulo".$con_art]);
								$p_imagen_articulo="";
								$p_descripcion_corta_articulo=cadenabd($_POST["descripcion_corta_articulo".$con_art]);
								$p_descripcion_completa_articulo=cadenabd($_POST["descripcion_completa_articulo".$con_art]);
								
								if(!empty($_FILES["imagen_articulo".$con_art]['name'])):
									if($_FILES["imagen_articulo".$con_art]['error']==4):
										$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen_articulo".$con_art]["name"].' tiene un error.</div>';
									endif;
									if($_FILES["imagen_articulo".$con_art]['error']==0):
										if($_FILES["imagen_articulo".$con_art]['size']>$max_file_size):
											$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen_articulo".$con_art]["name"].' es muy grande.</div>';
										elseif(!in_array(pathinfo($_FILES["imagen_articulo".$con_art]["name"], PATHINFO_EXTENSION), $valid_formats)):
											$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen_articulo".$con_art]["name"].' no es un formato válido</div>';
										else: // No error found! Move uploaded files 
											$extension=".".pathinfo($_FILES["imagen_articulo".$con_art]["name"], PATHINFO_EXTENSION);
											$nombre_archivo="img_".$id_perfil."_".$con_art."_".$fechahora_actual.$extension;
											if(move_uploaded_file($_FILES["imagen_articulo".$con_art]["tmp_name"],$path.$nombre_archivo)):
												$p_imagen_articulo=$nombre_archivo;
											endif;
											unset($extension,$nombre_archivo);
										endif;
									endif;
								endif;	
								if(!empty($p_articulo) or !empty($p_imagen_articulo)):
									//Registrar
									$c_art=insertar("id_perfil,articulo,imagen,descripcion_corta,descripcion_completa","articulos_perfiles","'".$id_perfil."','".$p_articulo."','".$p_imagen_articulo."','".$p_descripcion_corta_articulo."','".$p_descripcion_completa_articulo."'");
								endif;

								unset($p_articulo,$p_imagen_articulo,$p_descripcion_corta_articulo,$p_descripcion_completa_articulo);
							endfor;
							unset($valid_formats,$max_file_size,$path);
						endif;
						//ARTICULOS						
						//SERVICIOS
						//Borrar si es que existe alguno
						//$c_serv=eliminar("productos_perfiles","WHERE id_perfil='".$id_perfil."'");
						if(count($p_servicios)):
							foreach($p_servicios as $servicio):
								//Registrarlo
								$c_serv=insertar("tipo, producto ,id_perfil","productos_perfiles","'Servicio','".cadenabd($servicio)."','".$id_perfil."'");
							endforeach;
						endif;
						//CATEGORIAS
						//Borrar si es que existe alguno
						$c_cat=eliminar("categorias_perfiles","WHERE id_perfil='".$id_perfil."'");
						if(count($p_categorias)):
							foreach($p_categorias as $id_categoria):
								//Registrarlo
								$c_cat=insertar("id_categoria,id_perfil","categorias_perfiles","'".$id_categoria."','".$id_perfil."'");
							endforeach;
						endif;
						//CATEGORIAS						
						
						$arreglo_respuestas[]='<div class="exito">Perfil registrado exitosamente.</div>';
					endif;
				else:
					$arreglo_respuestas[]='<div class="error">No fue posible registrar al perfil. Intente de nuevo.</div>';
				endif;
			endif;			
		else:
			$arreglo_respuestas[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
		endif;
	endif;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PERFILES - NUEVO</title>
<!-- Favicon -->
<link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">
<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
<link href="../../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
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
   	<p>Los campos con <strong>*</strong> son requeridos.</p>
      <!--COLUMNA 1-->
      <div style="width:50%; float:left">
         <fieldset>
         <legend>Datos Del Perfil</legend>
         <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
            <tr>
               <td>Perfil</td>
               <td>
                  <select class="perfil" name="perfil">
                     <option value="Perfil 1">Perfil 1</option>
                     <option value="Perfil 2">Perfil 2</option>
                     <option value="Perfil 3">Perfil 3</option>
                  </select>
               </td>
            </tr>
            <tr>
               <td width="15%">Nombre(s)</td>
               <td width="85%"><input type="text" name="nombres" style="width:90%" maxlength="255" required="required"> *</td>
            </tr>
            <tr>
               <td>Apellidos</td>
               <td><input type="text" name="apellidos" style="width:90%" maxlength="255" required="required"> *</td>
            </tr>
            <tr>
               <td>Usuario</td>
               <td><input type="text" name="usuario" style="width:100px;" maxlength="100" required="required"> *</td>
            </tr>
            <tr>
               <td>Contraseña</td>
               <td><input type="password" name="password" style="width:100px;" maxlength="100" required="required"> *</td>
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
               <td></td>
               <td><input type="checkbox" name="mostrar_home" value="si">Mostrar en Home
               </td>
            </tr>
         </table>
         </fieldset>      	
         <fieldset>
         <legend>Datos del Local</legend>
         <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
            <tr>
               <td>Local</td>
               <td><input type="text" name="local" style="width:90%" maxlength="255" required="required"> *</td>
            </tr>
            <tr>
               <td class="text_gral">Foto</td>
               <td class="text_gral">
                  <input type="file" name="imagen"/>
                  <br />
                  <span>Le sugerimos una imagen de 1170 pixeles x 364px y formato JPG</span>
               </td>
            </tr>
            <tr>
               <td>Calle</td>
               <td><input type="text" name="calle" style="width:90%" maxlength="255" required="required"> *</td>
            </tr>
            <tr>
               <td>Número exterior </td>
               <td><input type="text" name="no_exterior" style="width:100px;" maxlength="100"></td>
            </tr>
            <tr>
               <td>Número interior </td>
               <td><input type="text" name="no_interior" style="width:100px;" maxlength="100"></td>
            </tr>
            <tr>
               <td>Colonia</td>
               <td><input type="text" name="colonia" style="width:90%" maxlength="255" required="required"> *</td>
            </tr>
            <tr>
               <td>Código Postal</td>
               <td><input type="text" name="codigo_postal" style="width:100px;" maxlength="100" required="required"> *</td>
            </tr>
            <tr>
               <td>Delegación o Municipio</td>
               <td><input type="text" name="municipio" style="width:90%" maxlength="255" required="required"> *</td>
            </tr>
            <tr>
               <td>Estado</td>
               <td>
                  <?
                  $c_est=buscar("id_estado,estado","estados","ORDER BY estado ASC");
                  ?>
                  <select name="id_estado" required>
                     <option value="">Seleccione ...</option>
                     <?
                     if($c_est->num_rows>0):
                        while($f_est=$c_est->fetch_assoc()):
                           $id_estado=$f_est["id_estado"];
                           $estado=cadena($f_est["estado"]);
                           ?>
                           <option value="<?=$id_estado?>"><?=$estado?></option>
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
               <td><input type="email" name="email" style="width:90%" maxlength="255" required/> *</td>
            </tr>
            <tr>
               <td>Sitio web</td>
               <td>
               	<input type="text" name="sitio_web" style="width:90%;" maxlength="255"/>
               </td>
            </tr>
            <tr>
               <td>Teléfono(s):</td>
               <td><input type="text" name="telefono" style="width:200px;" maxlength="255"/></td>
            </tr>
            <tr>
               <td>Celular</td>
               <td><input type="text" name="celular" style="width:200px;" maxlength="255"/></td>
            </tr>
            <tr>
               <td>Rango de precios</td>
               <td>De: <input type="number" name="precio_de" step="1.00" placeholder="100.00"> A: <input type="number" name="precio_a" step="1.00" placeholder="100.00"></td>
            </tr>
         </table>
         </fieldset>
         
         <fieldset>
         <legend>Descripción breve del lugar</legend>
         <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
            <tr>
               <td colspan="2">
               	<textarea name="descripcion_corta" id="descripcion_corta" style="width:100%; height:100px;"></textarea>
               </td>
            </tr>
          </table>
         </fieldset>      

         <fieldset id="seccion_descripcion_completa" style="display:none">
         <legend>Descripción completa del lugar</legend>
         <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
            <tr>
               <td colspan="2">
               	<textarea name="descripcion_completa" id="descripcion_completa" style="width:100%; height:200px;"></textarea>
               </td>
            </tr>
          </table>
         </fieldset>      

      </div>
      <!--COLUMNA 1-->
      
      <!--COLUMNA 2-->            
      <div style="width:50%; float:left">
 	      <fieldset  id="seccion_regalo">
         <legend>Regalo por primera visita</legend>
         <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
            <tr>
               <td colspan="2">
                  <input name="numero_regalos" id="numero_regalos" type="hidden" value="1">
                  <div id="div_regalos">
                     <table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral">
                        <tr>
                           <td>Regalo</td>
                           <td><input type="text" name="regalo1" style="width:90%;" maxlength="255">*</td>
                        </tr>
                     </table>   
                  </div>
               </td>
            </tr>
          </table>
         </fieldset>     
 	      <fieldset id="seccion_recompensa" style="display:none">
         <legend>Recompensas</legend>
         <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
            <tr>
               <td colspan="2">
                  <input class="agregar_recompensa" type="button" class="link_5" value="Agregar recompensa" style="clear:both;" />
                  <input name="numero_recompensas" id="numero_recompensas" type="hidden" value="1">
                  <div id="div_recompensas">
                  	<fieldset>
                     <legend>Recompensa 1</legend>
                     <table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral">
                        <tr>
                           <td>Recompensa</td>
                           <td><input type="text" name="recompensa1" style="width:90%;" maxlength="255">*</td>
                        </tr>
                        <tr>
                           <td>Estatus</td>
                           <td><select name="estatus_recompensa1">
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
          </table>
         </fieldset>      

		 <fieldset id="seccion_productos" style="display:none">
         <legend>Productos</legend>
         <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
            <tr>
               <td colspan="2">
                  <input class="agregar_producto" type="button" class="link_5" value="Agregar producto" style="clear:both;" />
                  <input name="numero_productos" id="numero_productos" type="hidden" value="1">
                  <div id="div_productos">
                  	<fieldset>
                     <legend>Producto 1</legend>
                     <table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral">
                        <tr>
                           <td>Tipo</td>
                           <td>
                           	<select name="tipo_producto1">
                              	<option value="Producto">Producto</option>
                              	                                 
                              </select>
                           </td>
                        </tr>
						<tr>
                           <td>Título</td>
                           <td><input type="text" name="titulo_producto1" style="width:90%" maxlength="255"></td>
                        </tr>
                        <tr>
                           <td>Imagen</td>
                           <td><input type="file" name="imagen_producto1"></td>
                        </tr>
                        <tr>
                           <td>Descripción</td>
                           <td><textarea name="descripcion_producto1" id="descripcion_producto1"  style="width:100%; height:100px;"></textarea></td>
                           </td>
                        </tr>                        
                     </table>   
                     </fieldset>
                  </div>
               </td>
            </tr>
          </table>
         </fieldset>
         
	     <fieldset id="seccion_articulos" style="display:none">
         <legend>Artículos</legend>
         <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
            <tr>
               <td colspan="2">
                  <input class="agregar_articulo" type="button" class="link_5" value="Agregar artículo" style="clear:both;" />
                  <input name="numero_articulos" id="numero_articulos" type="hidden" value="1">
                  <div id="div_articulos">
                  	<fieldset>
                     <legend>Artículo 1</legend>
                     <table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral">
								<tr>
                           <td>Artículo</td>
                           <td><input type="text" name="articulo1" style="width:90%;" maxlength="255"></td>
                        </tr>   
						<tr>
                           <td>Imagen</td>
                           <td><input type="file" name="imagen_articulo1"></td>
                        </tr>
                        <tr>
                           <td></td>
                           <td>Le sugerimos una imagen con 1170 X 780 pixeles y formato JPG</td>
                        </tr>      
                        <tr>
                           <td>Descripción corta</td>
                           <td><textarea name="descripcion_corta_articulo1" id="descripcion_corta_articulo1"  style="width:100%; height:100px;"></textarea></td>
                           </td>
                        </tr>
                        <tr>
                           <td>Descripción completa</td>
                           <td><textarea name="descripcion_completa_articulo1" id="descripcion_completa_articulo1"  style="width:100%; height:200px;"></textarea></td>
                           </td>
                        </tr>
                     </table>   
                     </fieldset>
                  </div>
               </td>
            </tr>
          </table>
         </fieldset>   
         
 	      <fieldset id="seccion_fotos" style="display:none">
         <legend>Fotos</legend>
         <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
            <tr>
               <td colspan="2">
                  <input class="agregar_foto" type="button" class="link_5" value="Agregar foto" style="clear:both;" />
                  <input name="numero_fotos" id="numero_fotos" type="hidden" value="1">
                  <div id="div_fotos">
                  	<fieldset>
                     <legend>Foto 1</legend>
                     <table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral">
                        <tr>
                           <td>Foto</td>
                           <td><input type="file" name="foto1"></td>
                        </tr>
                        <tr>
                           <td></td>
                           <td>Le sugerimos una imagen con 1170 X 780 pixeles y formato JPG</td>
                        </tr>      
								<tr>
                           <td>Título</td>
                           <td><input type="text" name="titulo_foto1" style="width:90%" maxlength="255"></td>
                        </tr>                        
                     </table>   
                     </fieldset>
                  </div>
               </td>
            </tr>
          </table>
         </fieldset> 
         
         <fieldset id="seccion_videos" style="display:none">
         <legend>Videos</legend>
         <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
            <tr>
               <td colspan="2">
                  <input class="agregar_video" type="button" class="link_5" value="Agregar video" style="clear:both;" />
                  <input name="numero_videos" id="numero_videos" type="hidden" value="1">
                  <div id="div_videos">
                  	<fieldset>
                     <legend>Video 1</legend>
                     <table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral">
								<tr>
                           <td>Título</td>
                           <td><input type="text" name="titulo_video1" style="width:90%;" maxlength="255"></td>
                        </tr>   
                        <tr>
                           <td>Video</td>
                           <td><input type="text" name="video1" style="width:90%;" maxlength="255"> Ej. https://www.youtube.com/watch?v=t8IO9Izi5xo</td>
                           </td>
                        </tr>
                     </table>   
                     </fieldset>
                  </div>
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
                        	<input type="checkbox" name="categorias[]" value="<?=$id_categoria?>"> <?=$categoria?>
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
			<fieldset>
			<legend>Servicios</legend>
            <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
					<tr>
						<td>
							<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Accesible para personas con discapacidad"> Accesible para personas con discapacidad
                        	</div>
							<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Wifi"> Wifi
                        	</div>
         					<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Conexión eléctrica (para cargar aparatos eléctricos)"> Enchufes
                        	</div> 
                        	<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Estacionamiento"> Estacionamiento
                        	</div>
                        	<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Valet Parking"> Valet Parking
                        	</div>
                        	<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Servicio a Domicilio"> Servicio a Domicilio
                        	</div>
                        	<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Pet Friendly"> Pet Friendlyo
                        	</div>
                        	<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Sección de Fumar"> Sección de Fumar
                        	</div>
         					<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Vinos y Cervezas"> Vinos y Cervezas
                        	</div>
         					<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Bar"> Bar
                        	</div>
                        	<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Sommelier"> Sommelier
                        	</div>
                        	<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Tarjeta de Débito y Crédito"> Tarjeta de Débito y Crédito
                        	</div>
         					<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Música"> Música
                        	</div>
         					<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Televisión"> Televisión
                        	</div>
                        	<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Entretenimiento en vivo"> Entretenimiento en vivo
                        	</div>
         					<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Terraza o jardín"> Terraza o jardín
                        	</div>
                        	<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="services[]" value="Banquete"> Banquete
                        	</div>
                        	<div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                        	<input type="checkbox" name="servicios[]" value="Bebidas y café"> Bebidas y café
                        	</div>
         	
						</td>
					</tr>
				</table>
			</fieldset>
         
         <table border="0" cellpadding="3" cellspacing="1" align="left" style="width:100%;">
         	<tr>
               <td><input type="hidden" name="action" value="send"></td>
               <td><input type="submit" value="Registrar"></td>
            </tr>
         </table>
         
      </div>      
      <!--COLUMNA 2-->       
      
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
	new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta");
	if(jQuery("#descripcion_completa").length>0){
		new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa");
	}
	if(jQuery("#numero_articulos").length>0){
		new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta_articulo1");
		new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa_articulo1");
	}
	jQuery(".perfil").change(function(event){
		var perfil=jQuery(this).val();
		if(perfil=="Perfil 1"){
			jQuery("#seccion_descripcion_completa").css("display","none");
			jQuery("#seccion_fotos").css("display","none");
			//jQuery("#seccion_productos").css("display","none");
			jQuery("#seccion_videos").css("display","none");
			jQuery("#seccion_articulos").css("display","none");

			//jQuery("#seccion_regalo").css("display","none");
			jQuery("#seccion_recompensa").css("display","none");
			jQuery("#seccion_productos").css("display","none");
		}
		else if(perfil==="Perfil 2"){
			jQuery("#seccion_recompensa").css("display","none");
			//jQuery("#seccion_regalo").css("display","block");
			jQuery("#seccion_productos").css("display","block");

			jQuery("#seccion_descripcion_completa").css("display","block");
			jQuery("#seccion_fotos").css("display","block");
			//jQuery("#seccion_productos").css("display","block");
			jQuery("#seccion_videos").css("display","none");
			//jQuery("#seccion_articulos").css("display","none");
			jQuery("#seccion_articulos").css("display","none");
			
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa");

			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta_articulo1");
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa_articulo1");
		}
		else if(perfil==="Perfil 3"){
			jQuery("#seccion_recompensa").css("display","block");
			//jQuery("#seccion_regalo").css("display","block");
			jQuery("#seccion_productos").css("display","block");

			jQuery("#seccion_descripcion_completa").css("display","block");
			jQuery("#seccion_fotos").css("display","block");
			//jQuery("#seccion_productos").css("display","block");
			jQuery("#seccion_videos").css("display","block");
			jQuery("#seccion_articulos").css("display","block");
			
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa");
			
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta_articulo1");
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa_articulo1");
		}
	});
	jQuery(".agregar_recompensa").click(function(event){
		var numero=(new Number(jQuery("#numero_recompensas").val())*1)+1;
		if(numero>0 && (jQuery("#tbl_recompensa"+numero).length)==0){
			url ="../agregar_recompensa.php";
			var posting = jQuery.post(url,{numero:numero});
			posting.done(function(data){
				jQuery("#div_recompensas").append(data);
				jQuery("#numero_recompensas").val(numero);
			});
		}
	});
	jQuery(".agregar_foto").click(function(event){
		var numero=(new Number(jQuery("#numero_fotos").val())*1)+1;
		if(numero>0 && (jQuery("#tbl_foto"+numero).length)==0){
			url ="../agregar_foto.php";
			var posting = jQuery.post(url,{numero:numero});
			posting.done(function(data){
				jQuery("#div_fotos").append(data);
				jQuery("#numero_fotos").val(numero);
			});
		}
	});
	jQuery(".agregar_producto").click(function(event){
		var numero=(new Number(jQuery("#numero_productos").val())*1)+1;
		if(numero>0 && (jQuery("#tbl_producto"+numero).length)==0){
			url ="../agregar_producto.php";
			var posting = jQuery.post(url,{numero:numero});
			posting.done(function(data){
				jQuery("#div_productos").append(data);
				jQuery("#numero_productos").val(numero);
			});
		}
	});	
	jQuery(".agregar_video").click(function(event){
		var numero=(new Number(jQuery("#numero_videos").val())*1)+1;
		if(numero>0 && (jQuery("#tbl_video"+numero).length)==0){
			url ="../agregar_video.php";
			var posting = jQuery.post(url,{numero:numero});
			posting.done(function(data){
				jQuery("#div_videos").append(data);
				jQuery("#numero_videos").val(numero);
			});
		}
	});	
	jQuery(".agregar_articulo").click(function(event){
		var numero=(new Number(jQuery("#numero_articulos").val())*1)+1;
		if(numero>0 && (jQuery("#tbl_articulo"+numero).length)==0){
			url ="../agregar_articulo.php";
			var posting = jQuery.post(url,{numero:numero});
			posting.done(function(data){
				jQuery("#div_articulos").append(data);
				jQuery("#numero_articulos").val(numero);
				new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta_articulo"+numero);
				new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa_articulo"+numero);
			});
		}
	});
	jQuery("#form1").submit(function(event){
		//event.preventDefault();
		if(jQuery("#numero_articulos").length>0){
			var numero=new Number(jQuery("#numero_articulos").val())*1;
			if(numero>0){
				for(var con=1;con<=numero;con++){
					nicEditors.findEditor("descripcion_corta_articulo"+con).saveContent();
					nicEditors.findEditor("descripcion_completa_articulo"+con).saveContent();
				}
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