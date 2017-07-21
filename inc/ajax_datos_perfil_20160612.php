<?php
session_start();
$se_id_perfil=$_SESSION["s_id_perfil"];
$se_usuario_perfil=$_SESSION["s_usuario_perfil"];
$se_password_perfil=$_SESSION["s_password_perfil"];
//ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
$errors=array();
if(empty($se_id_perfil) and empty($se_usuario_perfil) and empty($se_password_perfil)):
	$errors[]='<div class="error">Tu sesión ha finalizado. Es necesario que vuelvas a acceder</div>';
endif;
$p_action=$_POST['action_datos'];
$p_id_estado=$_POST["id_estado"]*1;
$p_nombres=cadenabd($_POST["nombres"]);
$p_apellidos=cadenabd($_POST["apellidos"]);
$p_usuario=cadenabd($_POST["usuario"]);
$p_password=cadenabd($_POST["password"]);
$p_local=cadenabd($_POST["local"]);
$p_eliminar_imagen=isset($_POST["eliminar_imagen"]) ? $_POST["eliminar_imagen"] : "";
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
$p_descripcion_corta=cadenabd($_POST["descripcion_corta"]);
$p_descripcion_completa=cadenabd($_POST["descripcion_completa"]);
$p_precio_de=eliminar_coma($_POST["precio_de"]);
$p_precio_a=eliminar_coma($_POST["precio_a"]);
$p_categorias=$_POST["categorias"];
$p_regalo1=cadenabd($_POST["regalo1"]);
if(empty($p_action) or
	(!empty($p_action) and $p_action<>"send") or
	empty($p_nombres) or
	empty($p_apellidos) or
	empty($p_usuario) or
	empty($p_password) or
	empty($p_local) or
	empty($p_calle) or
	empty($p_colonia) or
	empty($p_codigo_postal) or
	empty($p_municipio) or
	empty($p_id_estado) or
	empty($p_email) or
	empty($p_regalo1)
	):
	$errors[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
endif;
if(!empty($se_id_perfil) and $p_action=="send" and empty($errors)):
	date_default_timezone_set('Mexico/General');
	$fechahora_actual=date("YmdHis");

	$arreglo_respuestas=array();
	
	$c_c=buscar("COUNT(*) AS total","perfiles","WHERE usuario='".$p_usuario."' AND 	password='".$p_password."' and id_perfil<>".$se_id_perfil);
	while($f_c=$c_c->fetch_assoc()):
		$total=$f_c['total'];
	endwhile;
	if($total>0):
		$arreglo_respuestas[]='<div class="error">Ya existe un perfil con este usuario '.cadena($p_usuario).'</div>';
	else:
		$c_se=buscar("imagen","perfiles","where id_perfil=".$se_id_perfil);
		while($f_se=$c_se->fetch_assoc()):
			$imagen_actual=$f_se['imagen'];
		endwhile; unset($f_se,$c_se);
		
		if(!empty($_FILES["imagen"]["name"])):
			$valid_formats= array("jpg","png","gif","JPG","PNG","GIF");
			
			//$max_file_size = 1024*1024; //1000 kb
			$max_file_size= 1048576*64; //64 MB
			$path= "../administrador/perfiles/images/"; // Upload directory
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
					$nombre_archivo="img_".$se_id_perfil."_".$count."_".$fechahora_actual.$extension;
					if(move_uploaded_file($_FILES["imagen"]["tmp_name"],$path.$nombre_archivo)):
						$p_imagen=$nombre_archivo;
						$count++; // Number of successfully uploaded files
						if(!empty($imagen_actual) and file_exists("../administrador/perfiles/images/".$imagen_actual)):
							unlink("../administrador/perfiles/images/".$imagen_actual);
						endif;
					endif;
					unset($extension,$nombre_archivo);
				endif;
			endif;
			unset($valid_formats,$max_file_size,$path,$count);
		elseif($p_eliminar_imagen=="on"):
			if(!empty($imagen_actual) and file_exists("../administrador/perfiles/images/".$imagen_actual)):
				unlink("../administrador/perfiles/images/".$imagen_actual);
			endif;
			$p_imagen="";
		endif;

		$actualizar="id_estado='".$p_id_estado."'
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
						,descripcion_completa='".$p_descripcion_completa."'";
		$c_id=actualizar("".$actualizar."","perfiles","where id_perfil=".$se_id_perfil);
		if(!$c_id):
			$arreglo_respuestas[]='<div class="error">No fue posible actualizar tus datos</span>';
		else:
		
			//CATEGORIAS
			//Borrar si es que existe alguno
			$c_cat=eliminar("categorias_perfiles","WHERE id_perfil='".$se_id_perfil."'");
			if(count($p_categorias)):
				foreach($p_categorias as $id_categoria):
					//Registrarlo
					$c_cat=insertar("id_categoria,id_perfil","categorias_perfiles","'".$id_categoria."','".$se_id_perfil."'");
				endforeach;
			endif;
			//CATEGORIAS						
			
			if(!empty($p_regalo1)):
				//Buscar si ya tiene registrado alguno
				$c_reg=buscar("id_regalo","regalos_perfiles","WHERE id_perfil='".$se_id_perfil."'");
				while($f_reg=$c_reg->fetch_assoc()):
					$id_regalo=$f_reg["id_regalo"];
				endwhile;
				if(!empty($id_regalo)):
					//Actualizar
					$c_reg2=actualizar("regalo='".$p_regalo1."'","regalos_perfiles","WHERE id_regalo='".$id_regalo."' AND id_perfil='".$se_id_perfil."'");
				else:
					//Registrar
					$c_reg2=insertar("id_perfil,regalo,estatus","regalos_perfiles","'".$se_id_perfil."','".$p_regalo1."','activo'");
				endif;
			endif;
			
			$c_doc=buscar("usuario,password","perfiles","WHERE id_perfil=".$se_id_perfil." AND estatus='activo'");
			while($f_doc=$c_doc->fetch_assoc()):
				$usuario=$f_doc["usuario"];
				$password=$f_doc["password"];
			endwhile;
			if(!empty($usuario) and !empty($password)):
				$_SESSION["s_usuario_perfil"]=$usuario;
				$_SESSION["s_password_perfil"]=$password;
			endif;
			$arreglo_respuestas[]='<div class="exito">Tus datos han sido actualizados exitosamente.</span>';
		endif;
	endif;
	unset($total,$p_imagen);
	
	unset($p_id_estado
	,$p_nombres
	,$p_apellidos
	,$p_usuario
	,$p_password
	,$p_local
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
	,$p_descripcion_corta
	,$p_descripcion_completa	
	,$p_precio_de
	,$p_precio_a
	,$p_categorias
	,$p_regalo1);

	unset($actualizar);
	unset($c_id);
endif;
if(!empty($errors)):
	foreach($errors as $error):
		echo $error."<br>";
	endforeach;
else:
	if(!empty($arreglo_respuestas)):
		foreach($arreglo_respuestas as $respuesta):
			echo $respuesta."<br>";
		endforeach;
	endif;
endif;
?>