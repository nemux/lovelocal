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
			
			$p_id_estado=isset($_POST["id_estado".$registro]) ? $_POST["id_estado".$registro]*1 : 0;
			$p_titulo=isset($_POST["titulo".$registro]) ? cadenabd($_POST["titulo".$registro]) : "";
			$p_nombres=isset($_POST["nombres".$registro]) ? cadenabd($_POST["nombres".$registro]) : "";
			$p_apellidos=isset($_POST["apellidos".$registro]) ? cadenabd($_POST["apellidos".$registro]) : "";
			$p_usuario=isset($_POST["usuario".$registro]) ? cadenabd($_POST["usuario".$registro]) : "";
			$p_password=isset($_POST["password".$registro]) ? cadenabd($_POST["password".$registro]) : "";
			$p_eliminar_imagen=isset($_POST["eliminar_imagen".$registro])?$_POST["eliminar_imagen".$registro]:"";
			$p_calle=isset($_POST["calle".$registro]) ? cadenabd($_POST["calle".$registro]) : "";
			$p_no_exterior=cadenabd($_POST["no_exterior".$registro]);
			$p_no_interior=cadenabd($_POST["no_interior".$registro]);
			$p_colonia=cadenabd($_POST["colonia".$registro]);
			$p_codigo_postal=cadenabd($_POST["codigo_postal".$registro]);
			$p_municipio=cadenabd($_POST["municipio".$registro]);
			$p_email=cadenabd($_POST["email".$registro]);
			$p_sitio_web=cadenabd($_POST["sitio_web".$registro]);
			$p_telefono=cadenabd($_POST["telefono".$registro]);
			$p_celular=cadenabd($_POST["celular".$registro]);
			$p_estatus=$_POST["estatus".$registro];
			
			if(!empty($p_nombres) and
				!empty($p_apellidos) and
				!empty($p_usuario) and
				!empty($p_password) and
				!empty($p_calle) and
				!empty($p_colonia) and
				!empty($p_codigo_postal) and
				!empty($p_municipio) and
				!empty($p_id_estado) and
				!empty($p_email) and
				!empty($p_estatus)
				):
				$r_c=buscar("COUNT(*) AS total","clientes","WHERE usuario='".$p_usuario."' 
							AND 	password='".$p_password."'
							and	id_cliente<>".$registro."");
				while($f_c=$r_c->fetch_assoc()):
					$total=$f_c['total'];
				endwhile;
				if($total>0):
					$arreglo_respuestas[]='<div class="error">Ya existe un cliente con este usuario '.cadena($p_usuario).'</div>';
				else:
					$c_se=buscar("imagen","clientes","where id_cliente=".$registro);
					while($f_se=$c_se->fetch_assoc()):
						$imagen_actual=$f_se['imagen'];
					endwhile; unset($f_se,$c_se);
					
					if(!empty($_FILES["imagen".$registro]["name"])):
						$valid_formats= array("jpg","png","gif","JPG","PNG","GIF");
						
						//$max_file_size = 1024*1024; //1000 kb
						$max_file_size= 1048576*64; //64 MB
						$path= "../images/"; // Upload directory
						$count= 0;
					
						if($_FILES['imagen'.$registro]['error']==4):
							$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen".$registro]["name"].' tiene un error.</div>';
						endif;
						if($_FILES['imagen'.$registro]['error']==0):
							if($_FILES['imagen'.$registro]['size']>$max_file_size):
								$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen".$registro]["name"].' es muy grande.</div>';
							elseif(!in_array(pathinfo($_FILES["imagen".$registro]["name"], PATHINFO_EXTENSION), $valid_formats)):
								$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen".$registro]["name"].' no es un formato válido</div>';
							else: // No error found! Move uploaded files 
								$extension=obtener_extension($_FILES["imagen".$registro]["name"]);
								$nombre_archivo="img_".$registro."_".$count."_".$fechahora_actual.$extension;
								if(move_uploaded_file($_FILES["imagen".$registro]["tmp_name"],$path.$nombre_archivo)):
									$p_imagen=$nombre_archivo;
									$count++; // Number of successfully uploaded files
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
									,titulo='".$p_titulo."'
									,nombres='".$p_nombres."'
									,apellidos='".$p_apellidos."'
									,usuario='".$p_usuario."'
									,password='".$p_password."'
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
									,estatus='".$p_estatus."'
									";
					$c_id=actualizar("".$actualizar."","clientes","where id_cliente=".$registro);
					if(!$c_id):
						$arreglo_respuestas[]='<div class="error">No fue posible actualizar este cliente '.cadena($p_usuario).'</div>';
					else:
						$arreglo_respuestas[]='<div class="exito">Cliente '.cadena($p_usuario).' actualizado exitosamente.</div>';
					endif;
				endif;
				unset($total,$p_imagen,$p_portada);
			else:
				$arreglo_respuestas[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
			endif;
			
			unset($p_id_estado
			,$p_titulo
			,$p_nombres
			,$p_apellidos
			,$p_usuario
			,$p_password
			,$p_eliminar_imagen
			,$p_calle
			,$p_no_exterior
			,$p_no_interior
			,$p_colonia
			,$p_codigo_postal
			,$p_municipio
			,$p_email
			,$p_sitio_web
			,$p_telefono
			,$p_celular
			,$p_estatus);
			
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
<title>CLIENTES - ACTUALIZAR</title>
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
				$c_id=buscar("cli.id_estado
									,cli.titulo
									,cli.nombres
									,cli.apellidos
									,cli.usuario
									,cli.password
									,cli.imagen
									,cli.calle
									,cli.no_exterior
									,cli.no_interior
									,cli.colonia
									,cli.codigo_postal
									,cli.municipio
									,cli.email
									,cli.sitio_web
									,cli.telefono
									,cli.celular
									,cli.estatus"
								,"clientes cli"
								,"where cli.id_cliente=".$registro);
				while($f_c=$c_id->fetch_assoc()):
					$id_estado_doctor=$f_c["id_estado"];
					$titulo=cadena($f_c["titulo"]);
					$nombres=cadena($f_c["nombres"]);
					$apellidos=cadena($f_c["apellidos"]);
					$usuario=cadena($f_c["usuario"]);
					$password=cadena($f_c["password"]);
					$imagen=$f_c["imagen"];
					$calle=cadena($f_c["calle"]);
					$no_exterior=cadena($f_c["no_exterior"]);
					$no_interior=cadena($f_c["no_interior"]);		
					$colonia=cadena($f_c["colonia"]);		
					$codigo_postal=cadena($f_c["codigo_postal"]);
					$municipio=cadena($f_c["municipio"]);
					$email=cadena($f_c["email"]);
					$sitio_web=cadena($f_c["sitio_web"]);
					$telefono=cadena($f_c["telefono"]);		
					$celular=cadena($f_c["celular"]);
					$estatus=$f_c["estatus"];
				endwhile;
				?>
            <fieldset>
            <legend>Datos Del Cliente</legend>
            <table border="0" cellpadding="3" cellspacing="1" align="left">
               <tr>
                  <td>Título</td>
                  <td>
                     <select name="titulo<?=$registro?>">
                        <option value="Lic." <? if($titulo=="Lic."): ?> selected="selected" <? endif;?>>Lic.</option>
                        <option value="Dr." <? if($titulo=="Dr."): ?> selected="selected" <? endif;?>>Dr.</option>
                        <option value="Dra." <? if($titulo=="Dra."): ?> selected="selected" <? endif;?>>Dra.</option>
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
               <?
               if(!empty($imagen) and file_exists("../images/".$imagen)):
                  ?>
                  <tr>
                    <td class="text_gral">Imagen actual</td>
                    <td class="text_gral">
                     <img src="../images/<?=$imagen?>" style="max-width:160px;">
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
                        <span>Le sugerimos una imagen de 225 x 225 pixeles y formato JPG</span>                                      
                    </td>
                  </tr>
                  <?
               else:
                  ?>
                  <tr>
                     <td class="text_gral">Imagen</td>
                     <td class="text_gral"><input type="file" name="imagen<?=$registro?>"/>
                     <br />
                     <span>Le sugerimos una imagen de  225 x 225 pixeles y formato JPG</span>                                      
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
                              <option value="<?=$id_estado?>" <? if($id_estado==$id_estado_doctor): ?> selected="selected" <? endif;?>><?=$estado?></option>
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
                  <td><textarea name="sitio_web<?=$registro?>" style="width:400px; height:50px;"><?=$sitio_web?></textarea></td>
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
                  <td>Estatus</td>
                  <td>
                     <select name="estatus<?=$registro?>">
                        <option value="activo" <?php if($estatus=="activo"): ?> selected <?php endif;?>>Activo</option>
                        <option value="inactivo" <?php if($estatus=="inactivo"): ?> selected <?php endif;?>>Inactivo</option>
                     </select>
                  </td>
               </tr>
               <tr>
                 <td>
                   <input type="hidden" name="arreglo_registros[]" value="<?=$registro?>" />
                 </td>
                 <td>
                   <input type="submit" class="link_5" value="Registrar"/>
                 </td>
               </tr>
             </table>
            </fieldset>
				<?
            unset($id_estado_doctor
				,$titulo
				,$nombres
				,$apellidos
				,$usuario
				,$password
				,$imagen
				,$calle
				,$no_exterior
				,$no_interior
				,$colonia
				,$codigo_postal
				,$municipio
				,$email,$sitio_web
				,$telefono
				,$celular
				,$estatus
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
</body>
</html>
<?
endif;
?>