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
$p_action=$_POST['action_fotos'];
$p_id_foto=$_POST["id_foto"]*1;
$p_titulo=cadenabd($_POST["titulo"]);
$p_eliminar_imagen=$_POST["eliminar_imagen_foto"];
if(empty($p_action) or
	(!empty($p_action) and $p_action<>"send") or
	empty($p_id_foto) or
	empty($p_titulo)
	):
	$errors[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
endif;
if(!empty($se_id_perfil) and  !empty($p_id_foto) and $p_action=="send" and empty($errors)):
	date_default_timezone_set('Mexico/General');
	$fechahora_actual=date("YmdHis");
	$fecha_hora_registro=date("Y-m-d H:i:s");

	$arreglo_respuestas=array();

	$c_se=buscar("foto","fotos_perfiles","where id_foto='".$p_id_foto."' AND id_perfil=".$se_id_perfil);
	while($f_se=$c_se->fetch_assoc()):
		$imagen_actual=$f_se['foto'];
	endwhile; unset($f_se,$c_se);

	if(!empty($_FILES["imagen_foto"]["name"])):
		$valid_formats= array("jpg","png","gif","JPG","PNG","GIF");
		
		//$max_file_size = 1024*1024; //1000 kb
		$max_file_size= 1048576*64; //64 MB
		$path= "../administrador/galeria_fotos/images/"; // Upload directory
		$count= 0;
	
		if($_FILES['imagen']['error']==4):
			$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen"]["name"].' tiene un error.</div>';
		endif;
		if($_FILES['imagen']['error']==0):
			if($_FILES['imagen']['size']>$max_file_size):
				$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen_foto"]["name"].' es muy grande.</div>';
			elseif(!in_array(pathinfo($_FILES["imagen_foto"]["name"], PATHINFO_EXTENSION), $valid_formats)):
				$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen_foto"]["name"].' no es un formato válido</div>';
			else: // No error found! Move uploaded files 
				$extension=obtener_extension($_FILES["imagen_foto"]["name"]);
				$nombre_archivo="img_".$p_id_foto."_".$count."_".$fechahora_actual.$extension;
				if(move_uploaded_file($_FILES["imagen_foto"]["tmp_name"],$path.$nombre_archivo)):
					$p_imagen=$nombre_archivo;
					$count++; // Number of successfully uploaded files
					if(!empty($imagen_actual) and file_exists("../administrador/galeria_fotos/images/".$imagen_actual)):
						unlink("../administrador/galeria_fotos/images/".$imagen_actual);
					endif;
				endif;
				unset($extension,$nombre_archivo);
			endif;
		endif;
		unset($valid_formats,$max_file_size,$path,$count);
	elseif($p_eliminar_imagen=="on"):
		if(!empty($imagen_actual) and file_exists("../administrador/galeria_fotos/images/".$imagen_actual)):
			unlink("../administrador/galeria_fotos/images/".$imagen_actual);
		endif;
		$p_imagen="";
	endif;
	$actualizar="titulo='".$p_titulo."'";
	if(!empty($p_imagen) or $p_eliminar_imagen=="on"):
		$actualizar.=",foto='".$p_imagen."'";
	endif;
	$c_id=actualizar($actualizar,"fotos_perfiles","WHERE id_foto='".$p_id_foto."' AND id_perfil='".$se_id_perfil."'");
	if(!$c_id):
		$arreglo_respuestas[]='<div class="error">No fue posible actualizar tu foto.</span>';
	else:
		$arreglo_respuestas[]='<div class="exito">Tu foto ha sido actualizada exitosamente.</span>';
	endif;
	
	unset($p_imagen);
	
	unset($p_id_foto,$p_titulo);

	unset($actualizar,$c_id,$imagen_actual);
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