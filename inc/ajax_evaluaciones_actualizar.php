<?php
session_start();
$se_id_perfil=$_SESSION["s_id_perfil"];
$se_usuario_perfil=$_SESSION["s_usuario_perfil"];
$se_password_perfil=$_SESSION["s_password_perfil"];
ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
$errors=array();
if(empty($se_id_perfil) and empty($se_usuario_perfil) and empty($se_password_perfil)):
	$errors[]='<div class="error">Tu sesión ha finalizado. Es necesario que vuelvas a acceder</div>';
endif;
$p_action=$_POST['action_evaluaciones'];
$p_id_evaluacion=$_POST["id_evaluacion"]*1;
$p_estatus=cadenabd($_POST["estatus"]);
if(empty($p_action) or
	(!empty($p_action) and $p_action<>"send") or
	empty($p_id_evaluacion) or
	empty($p_estatus)
	):
	$errors[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
endif;
if(!empty($se_id_perfil) and  !empty($p_id_evaluacion) and $p_action=="send" and empty($errors)):
	date_default_timezone_set('Mexico/General');
	$fechahora_actual=date("YmdHis");
	$fecha_hora_registro=date("Y-m-d H:i:s");

	$arreglo_respuestas=array();

	$actualizar="estatus='".$p_estatus."'";
	$c_id=actualizar($actualizar,"evaluaciones_perfiles","WHERE id_evaluacion='".$p_id_evaluacion."' AND id_perfil='".$se_id_perfil."'");
	if(!$c_id):
		$arreglo_respuestas[]='<div class="error">No fue posible actualizar tu evaluación.</span>';
	else:
		$arreglo_respuestas[]='<div class="exito">Tu evaluación ha sido actualizada exitosamente.</span>';
	endif;
	
	unset($p_id_evaluacion,$p_estatus);

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