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
$p_id_producto=$_POST["id_producto"]*1;
if(empty($p_id_producto)
	):
	$errors[]='<div class="error">No se recibió el parámetro del producto.</div>';
endif;
if(!empty($se_id_perfil) and  !empty($p_id_producto) and empty($errors)):
	date_default_timezone_set('Mexico/General');
	$fechahora_actual=date("YmdHis");
	$fecha_hora_registro=date("Y-m-d H:i:s");

	$arreglo_respuestas=array();

	$c_id=eliminar("productos_perfiles","WHERE id_producto='".$p_id_producto."' AND id_perfil='".$se_id_perfil."'");
	if(!$c_id):
		$arreglo_respuestas[count($arreglo_respuestas)]='<div class="error">No fue posible eliminar tu producto.</span>';
	else:
		$arreglo_respuestas[count($arreglo_respuestas)]='<div class="exito">Tu producto ha sido eliminado exitosamente.</span>';
		$c_rec=autonumerico("id_producto","productos_perfiles"); unset($c_rec);
	endif;
	unset($p_id_producto,$imagen_actual);
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