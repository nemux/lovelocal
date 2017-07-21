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
$p_action=$_POST['action_videos'];
$p_id_video=$_POST["id_video"]*1;
$p_titulo=cadenabd($_POST["titulo"]);
$p_video=cadenabd($_POST["video"]);
if(empty($p_action) or
	(!empty($p_action) and $p_action<>"send") or
	empty($p_id_video) or
	empty($p_titulo) or
	empty($p_video)
	):
	$errors[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
endif;
if(!empty($se_id_perfil) and  !empty($p_id_video) and $p_action=="send" and empty($errors)):
	date_default_timezone_set('Mexico/General');
	$fechahora_actual=date("YmdHis");
	$fecha_hora_registro=date("Y-m-d H:i:s");

	$arreglo_respuestas=array();

	$actualizar="titulo='".$p_titulo."'
					,video='".$p_video."'";
	$c_id=actualizar($actualizar,"videos_perfiles","WHERE id_video='".$p_id_video."' AND id_perfil='".$se_id_perfil."'");
	if(!$c_id):
		$arreglo_respuestas[count($arreglo_respuestas)]='<div class="error">No fue posible actualizar tu video.</span>';
	else:
		$arreglo_respuestas[count($arreglo_respuestas)]='<div class="exito">Tu video ha sido actualizado exitosamente.</span>';
	endif;
	
	unset($p_id_video,$p_titulo,$p_video);

	unset($actualizar,$c_id);
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