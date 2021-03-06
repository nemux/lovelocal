<?
session_start();
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
		
		$p_id_estado=$_POST["id_estado"]*1;
		$p_perfil=cadenabd($_POST["perfil"]);
		$p_titulo=cadenabd($_POST["titulo"]);
		$p_nombres=cadenabd($_POST["nombres"]);
		$p_apellidos=cadenabd($_POST["apellidos"]);
		$p_usuario=cadenabd($_POST["usuario"]);
		$p_password=cadenabd($_POST["password"]);
		$p_calle=cadenabd($_POST["calle"]);
		$p_no_exterior=cadenabd($_POST["no_exterior"]);
		$p_no_interior=cadenabd($_POST["no_interior"]);
		$p_colonia=cadenabd($_POST["colonia"]);
		$p_codigo_postal=cadenabd($_POST["codigo_postal"]);
		$p_municipio=cadenabd($_POST["municipio"]);
		
		$p_email=cadenabd($_POST["email"]);
		$p_sitio_web=cadenabd($_POST["sitio_web"]);
		
		$p_telefono=cadenabd($_POST["telefono"]);
		$p_celular=cadenabd($_POST["celular"]);
		
		$p_estatus=$_POST["estatus"];
		
		if(!empty($p_perfil) and 
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
			!empty($p_estatus)
			):
			$r_c=buscar("COUNT(*) AS total","duenos","WHERE usuario='".$p_usuario."' AND 	password='".$p_password."'");
			while($f_c=$r_c->fetch_assoc()):
				$total=$f_c['total'];
			endwhile;
			if($total>0):
				$arreglo_respuestas[]='<div class="error">Ya existe un dueño registrado con este usuario.</div>';
			else:
				$c_p=buscar("id_dueno","duenos","ORDER BY id_dueno DESC LIMIT 1");
				while($f_p=$c_p->fetch_assoc()):
					$id_dueno=$f_p['id_dueno'];
				endwhile;
				$id_dueno=$id_dueno+1;
				
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
							$extension=obtener_extension($_FILES["imagen"]["name"]);
							$nombre_archivo="img_".$id_dueno."_".$count."_".$fechahora_actual.$extension;
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
									,titulo
									,nombres
									,apellidos
									,usuario
									,password
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
									,estatus
									,fecha_hora_registro"
									,"duenos"
									,"'".$p_id_estado."'
									,'".$p_perfil."'
									,'".$p_titulo."'
									,'".$p_nombres."'
									,'".$p_apellidos."'
									,'".$p_usuario."'
									,'".$p_password."'
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
									,'".$p_estatus."'
									,'".$fecha_hora_registro."'");
				if($i_c):
					//Consultar doctor
					$c_doc=buscar("id_dueno","duenos","WHERE id_estado='".$p_id_estado."' AND perfil='".$p_perfil."' AND titulo='".$p_titulo."' AND nombres='".$p_nombres."' AND apellidos='".$p_apellidos."' AND usuario='".$p_usuario."' AND password='".$p_password."' ORDER BY id_dueno DESC LIMIT 1");
					while($f_doc=$c_doc->fetch_assoc()):
						$id_dueno=$f_doc["id_dueno"];
					endwhile;
					if($id_dueno>0):
						$arreglo_respuestas[]='<div class="exito">Dueño registrado exitosamente.</div>';
					endif;
				else:
					$arreglo_respuestas[]='<div class="error">No fue posible registrar al dueño. Intente de nuevo.</div>';
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
<title>DUEÑOS DE LOCALES O SERVICIOS - NUEVO</title>
<!-- Favicon -->
<link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">
<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
<link href="../../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
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
   	<p>Los campos con <strong>*</strong> son requeridos.</p>
      <fieldset>
      <legend>Datos Del Dueño</legend>
      <table border="0" cellpadding="3" cellspacing="1" align="left">
         <tr>
            <td>Perfil</td>
            <td>
               <select name="perfil">
                  <option value="Perfil 1">Perfil 1</option>
                  <option value="Perfil 2">Perfil 2</option>
                  <option value="Perfil 3">Perfil 3</option>
               </select>
            </td>
         </tr>
         <tr>
            <td>Título</td>
            <td>
            	<input type="text" name="titulo" style="width:100px;" maxlength="255">
            </td>
         </tr>
         <tr>
            <td width="15%">Nombre(s)</td>
            <td width="85%"><input type="text" name="nombres" style="width:400px;" maxlength="255" required="required"> *</td>
         </tr>
         <tr>
            <td>Apellidos</td>
            <td><input type="text" name="apellidos" style="width:400px;" maxlength="255" required="required"> *</td>
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
            <td class="text_gral">Imagen</td>
            <td class="text_gral">
               <input type="file" name="imagen"/>
               <br />
               <span>Le sugerimos una imagen de 225 x 225 pixeles y formato JPG</span>
           	</td>
         </tr>
         <tr>
            <td>Calle</td>
            <td><input type="text" name="calle" style="width:400px;" maxlength="255" required="required"> *</td>
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
            <td><input type="text" name="colonia" style="width:400px;" maxlength="255" required="required"> *</td>
         </tr>
         <tr>
            <td>Código Postal</td>
            <td><input type="text" name="codigo_postal" style="width:100px;" maxlength="100" required="required"> *</td>
         </tr>
         <tr>
            <td>Delegación o Municipio</td>
            <td><input type="text" name="municipio" style="width:400px;" maxlength="255" required="required"> *</td>
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
            <td><input type="email" name="email" style="width:400px;" maxlength="255" required/> *</td>
         </tr>
         <tr>
            <td>Sitio web</td>
            <td><textarea name="sitio_web" style="width:400px; height:50px;"></textarea></td>
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
            <td>Estatus</td>
            <td><select name="estatus">
               <option value="activo">Activo</option>
               <option value="inactivo">Inactivo</option>
            </select>
            </td>
         </tr>
         <tr>
            <td><input type="hidden" name="action" value="send"></td>
            <td><input type="submit" value="Registrar"></td>
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