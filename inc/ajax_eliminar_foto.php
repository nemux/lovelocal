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
$p_id_foto=$_POST["id_foto"]*1;
if(empty($p_id_foto)
	):
	$errors[]='<div class="error">No se recibió el parámetro de la foto.</div>';
endif;
if(!empty($se_id_perfil) and  !empty($p_id_foto) and empty($errors)):
	date_default_timezone_set('Mexico/General');
	$fechahora_actual=date("YmdHis");
	$fecha_hora_registro=date("Y-m-d H:i:s");

	$arreglo_respuestas=array();

	$c_se=buscar("foto","fotos_perfiles","where id_foto='".$p_id_foto."' AND id_perfil=".$se_id_perfil);
	while($f_se=$c_se->fetch_assoc()):
		$imagen_actual=$f_se['foto'];
	endwhile; unset($f_se,$c_se);

	$c_id=eliminar("fotos_perfiles","WHERE id_foto='".$p_id_foto."' AND id_perfil='".$se_id_perfil."'");
	if(!$c_id):
		$arreglo_respuestas[count($arreglo_respuestas)]='<div class="error">No fue posible eliminar tu foto.</span>';
	else:
		if(!empty($imagen_actual) and file_exists("../administrador/galeria_fotos/images/".$imagen_actual)):
			unlink("../administrador/galeria_fotos/images/".$imagen_actual);
		endif;
		$arreglo_respuestas[count($arreglo_respuestas)]='<div class="exito">Tu foto ha sido eliminada exitosamente.</span>';
		$c_art=autonumerico("id_foto","fotos_perfiles"); unset($c_art);
	endif;
	unset($p_id_foto,$imagen_actual);
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