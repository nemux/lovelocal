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
$p_action=$_POST['action_promociones'];
$p_promocion=cadenabd($_POST["promocion"]);
$p_descripcion_corta=cadenabd($_POST["descripcion_corta_promocion"]);
//$p_descripcion_completa=cadenabd($_POST["descripcion_completa_promocion"]);
$p_estatus=cadenabd($_POST["estatus_promocion"]);
if(empty($p_action) or
	(!empty($p_action) and $p_action<>"send") or
	empty($p_promocion) or
	empty($p_descripcion_corta) or
	/*
	empty($p_descripcion_completa)*/
	empty($p_estatus)
	):
	$errors[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
endif;
if(!empty($se_id_perfil) and $p_action=="send" and empty($errors)):
	date_default_timezone_set('Mexico/General');
	$fechahora_actual=date("YmdHis");
	$fecha_hora_registro=date("Y-m-d H:i:s");

	$arreglo_respuestas=array();

	$c_p=buscar("id_promocion","promociones_perfiles","ORDER BY id_promocion DESC LIMIT 1");
	while($f_p=$c_p->fetch_assoc()):
		$id_promocion=$f_p['id_promocion'];
	endwhile; unset($f_p,$c_p);
	$id_promocion=$id_promocion+1;

	if(!empty($_FILES["imagen_promocion"]["name"])):
		$valid_formats= array("jpg","png","gif","JPG","PNG","GIF");
		
		//$max_file_size = 1024*1024; //1000 kb
		$max_file_size= 1048576*64; //64 MB
		$path= "../administrador/promociones/images/"; // Upload directory
		$count= 0;
	
		if($_FILES['imagen']['error']==4):
			$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen"]["name"].' tiene un error.</div>';
		endif;
		if($_FILES['imagen']['error']==0):
			if($_FILES['imagen']['size']>$max_file_size):
				$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen_promocion"]["name"].' es muy grande.</div>';
			elseif(!in_array(pathinfo($_FILES["imagen_promocion"]["name"], PATHINFO_EXTENSION), $valid_formats)):
				$arreglo_respuestas[] = '<div class="error">'.$_FILES["imagen_promocion"]["name"].' no es un formato válido</div>';
			else: // No error found! Move uploaded files 
				$extension=obtener_extension($_FILES["imagen_promocion"]["name"]);
				$nombre_archivo="img_".$id_promocion."_".$count."_".$fechahora_actual.$extension;
				if(move_uploaded_file($_FILES["imagen_promocion"]["tmp_name"],$path.$nombre_archivo)):
					$p_imagen=$nombre_archivo;
					$count++; // Number of successfully uploaded files
				endif;
				unset($extension,$nombre_archivo);
			endif;
		endif;
		unset($valid_formats,$max_file_size,$path,$count);
	endif;
	//$c_id=insertar("id_perfil,promocion,imagen,descripcion_corta,descripcion_completa,fecha_hora_registro","promociones_perfiles","'".$se_id_perfil."','".$p_promocion."','".$p_imagen."','".$p_descripcion_corta."','".$p_descripcion_completa."','".$fecha_hora_registro."'");
	$c_id=insertar("id_perfil,promocion,imagen,descripcion_corta,fecha_hora_registro,estatus","promociones_perfiles","'".$se_id_perfil."','".$p_promocion."','".$p_imagen."','".$p_descripcion_corta."','".$fecha_hora_registro."','".$p_estatus."'",false);
	if(!$c_id):
		$arreglo_respuestas[]='<div class="error">No fue posible registrar tu promoción.</span>';
	else:
		$arreglo_respuestas[]='<div class="exito">Tu promoción ha sido registrada exitosamente.</span>';
	endif;
	
	unset($p_imagen);
	
	unset($p_promocion,$p_descripcion_corta,/*$p_descripcion_completa,*/$p_estatus);

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